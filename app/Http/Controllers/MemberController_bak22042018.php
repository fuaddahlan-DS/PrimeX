<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class MemberController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function member(){
    	if(request()->has('search')){
    		$keyword = request()->input('search');
    		$members = DB::table('clients')
    			->select('clients.ID', 'clients.Name', 'clients.ContactNo', 'clients.Email', 'members.CreditBalance', 'members.Code')
    			->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
	    		->where('clients.Name', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('clients.ContactNo', 'like', '%'.$keyword.'%')
	    		->orWhere('clients.Email', 'like', '%'.strtolower($keyword).'%')
	    		->orderBy('clients.ID', 'ASC')
	    		->groupBy('clients.ID', 'clients.Name', 'clients.ContactNo', 'clients.Email', 'members.CreditBalance', 'members.Code')
	    		->paginate(10);
    	}else{
    		//DB::enableQueryLog();
    		$members = DB::table('clients')
    			->select('clients.ID', 'clients.Name', 'clients.ContactNo', 'clients.Email', 'members.CreditBalance', 'members.Code')
    			->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
    			->orderBy('clients.ID', 'ASC')
    			->groupBy('clients.ID', 'clients.Name', 'clients.ContactNo', 'clients.Email', 'members.CreditBalance', 'members.Code')
    			->paginate(10);
			//dd(DB::getQueryLog());
    	}
    	$colors = DB::table('colors')->get();
    	$paymentTypes = DB::table('payment_type')->get();
    	$vehicletypes = DB::table('vehicletypes')->get();
    	$manufacturers = DB::table('manufacturers')->get();
    	return view('member.member',compact('members','manufacturers','colors','vehicletypes','paymentTypes'));
    }

    public function memberDetails($clientid) {
    	$members = DB::table('clients')
    			->select('clients.ID', 'clients.Name', 'clients.ContactNo', 'clients.Email', 'members.CreditBalance', 'members.Code', 'members.ID AS memberID')
    			->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
	    		->where('clients.ID', '=', $clientid)
    		->first();

		$totalSales = DB::table('salesorder')
						->select('salesorder.Paid')
						->where('salesorder.ClientID', '=', $clientid)
						->where('salesorder.PaymentTypeID', '=', 5)
						->get();

		$totalAmount = 0.00;

		foreach ($totalSales as $totalSale) {
    		$totalAmount += number_format($totalSale->Paid, 2);
		}

		$creditBalance = number_format(number_format($members->CreditBalance, 2) - number_format($totalAmount, 2), 2);

    	$vehicles = DB::table('clientvehiclejoin')
    						->select('vehicles.RegistrationNo', 'vehicles.Model', 'colors.Name AS colorName', 'vehicletypes.Name', 'manufacturers.Name AS manufacturerName')
    						->leftJoin('vehicles', 'vehicles.ID', '=', 'clientvehiclejoin.VehicleID')
    						->leftJoin('vehicletypes', 'vehicletypes.ID', '=', 'vehicles.VehicleTypeID')
    						->leftJoin('manufacturers', 'manufacturers.ID', '=', 'vehicles.ManufacturerID')
    						->leftJoin('colors', 'colors.ID', '=', 'vehicles.Color')
    						->where('clientvehiclejoin.ClientID', '=', $clientid)
							->get();

		DB::statement(DB::raw('set @row:=0'));
		$servicehistories = DB::table('salesorder')
								->select(DB::raw('@row:=@row+1 as RowNum'), 'salesorder.SalesDate', 'vehicles.RegistrationNo', 'salesorder.GrossTotal', 'salesorder.Reason', 'branches.Code', 'salesorder.PaymentTypeID', 'membercreditledger.RunningBalance', 'membercreditledger.CreditUsed')
								->leftJoin('vehicles', 'vehicles.ID', '=', 'salesorder.VehicleID')
								->leftJoin('branches', 'branches.ID', '=', 'salesorder.BranchID')
								->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
								->where('salesorder.ClientID', '=', $clientid)
								->where('salesorder.Paid', '<>', 0.00)
								->get();

		DB::statement(DB::raw('set @row:=0'));
		$topuphistories = DB::table('salesorder')
							->select(DB::raw('@row:=@row+1 as RowNum'), 'salesorder.GrossTotal', 'salesorder.SalesDate', 'membercreditledger.RunningBalance', 'branches.Code')
							->leftJoin('members', 'members.ClientID', '=', 'salesorder.ClientID')
							->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
							->leftJoin('branches', 'branches.ID', '=', 'salesorder.BranchID')
							->where('members.ClientID', '=', $clientid)
							->where('salesorder.SalesType', '=', 'T')
							->get();

		$colors = DB::table('colors')->get();
    	$paymentTypes = DB::table('payment_type')->get();
    	$vehicletypes = DB::table('vehicletypes')->get();
    	$manufacturers = DB::table('manufacturers')->get();

    	return view('member.memberDetails',compact('members', 'creditBalance', 'vehicles', 'servicehistories', 'topuphistories', 'totalAmount', 'manufacturers','colors','vehicletypes','paymentTypes'));
    }

    public function getMemberCode($clientid) {
    	$returnval = '';

    	$members = DB::table('clients')
    		->select('members.Code')
			->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
    		->where('clients.ID', '=', $clientid)
    		->first();

		if ($members->Code == '') {
			$member = DB::table('clients')
				->select('members.Code')
				->leftJoin('salesorder', 'salesorder.ClientID', '=', 'clients.ID')
				->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
				->leftJoin('members', 'members.ID', '=', 'membercreditledger.MemberID')
				->where('clients.ID', '=', $clientid)
				->first();

			$returnval = $member->Code;
		}
		else {
			$returnval = $members->Code;
		}

		
		echo $returnval;
	}

	public function getMemberBalance($clientid) {
    	$returnval = '';

    	$members = DB::table('clients')
    		->select('members.CreditBalance')
			->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
    		->where('clients.ID', '=', $clientid)
    		->first();

		if ($members->CreditBalance == '') {
			$member = DB::table('clients')
				->select('members.CreditBalance')
				->leftJoin('salesorder', 'salesorder.ClientID', '=', 'clients.ID')
				->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
				->leftJoin('members', 'members.ID', '=', 'membercreditledger.MemberID')
				->where('clients.ID', '=', $clientid)
				->first();

			$returnval = number_format($member->CreditBalance, 2);
		}
		else {
			$returnval = number_format($members->CreditBalance, 2);
		}

		
		echo $returnval;
	}

    public function addMember(request $request){

    	try{
	    	$data = $request->all();
	    	$member = DB::table('clients')->where('Email', $data['email'])->count();

	    	if(!$member){
		    	$id = DB::table('clients')->insertGetId(
		                [
		                    'Name' => strtoupper($data['name']),
		                    'ContactNo' => $data['number'],
		                    'Email' => $data['email'],
		                    'BranchID' => Auth::user()->BranchID,
		                ]
		            );
		    	$memberCode = 'MB'.Auth::user()->BranchID.str_pad($id, 7, "0", STR_PAD_LEFT);

		    	//DB::table('members')->where('id', $id)->update(['Code' => $memberCode]);

		    	$id2 = DB::table('members')->insertGetId(
		                [
		                    'Discontinued' => 1,
		                    'CreditBalance' => 0.0000,
		                    'Code' => $memberCode,
		                    'ClientID' => $id,
		                ]
		            );

		    	$result = array(
	                'status' => true,
	                'message' => 'success',
	                'data' => array('memberCode'=>$memberCode, 'memberID'=>$id, 'memberID2'=>$id2),
	            );
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Email already exist!',
	            );
		    }
	    }
	    catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
        return json_encode($result);
    }

    public function updateMember(request $request){

    	try{
	    	$data = $request->all();
	    	$member = DB::table('clients')
	    		->select('clients.ID', 'clients.Name', 'clients.ContactNo', 'clients.Email')
	    		->where('clients.ID', $data['id'])
	    		->first();

	    	if($member){
	    		$checkEmail =false;
	    		if($member->Email != $data['email']){
			    	$checkEmail = DB::table('clients')->where('Email', $data['email'])->count();
			    }
			    if($checkEmail){
			    		$result = array(
			                'status' => false,
			                'message' => 'Email already exist!',
			            );
			    }else{
			    	$id = DB::table('clients')->where('ID', $data['id'])->update(
			                [
			                    'Name' => $data['name'],
			                    'ContactNo' => $data['number'],
			                    'Email' => $data['email'],
			                ]
			            );
			    	$result = array(
		                'status' => true,
		                'message' => 'Member record ('.$member->Name.') successfully updated!',
		            );
			    }
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Invalid Member!',
	            );
		    }
	    }
	    catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
        return json_encode($result);
    }


    public function addCar(request $request){

    	try{
	    	$data = $request->all();
	    	$car = DB::table('vehicles')->where('RegistrationNo', $data['number'])->count();

	    	if(!$car){
		    	$id = DB::table('vehicles')->insertGetId(
		                [
		                    'RegistrationNo' => $data['number'],
		                    //'memberID' => $data['memberID'],
		                    'Color' => $data['color'],
		                    'VehicleTypeID' => $data['type'],
		                    'ManufacturerID' => $data['manufacturer'],
		                    'Model' => '',
		                ]
		            );

		    	$member = DB::table('members')
		    				->select('members.ClientID')
		    				->where('members.ID', $data['memberID'])
		    				->first();

		    	$id2 = DB::table('clientvehiclejoin')->insertGetId(
		                [
		                    'ClientID' => $member->ClientID,
		                    'VehicleID' => $id,
		                ]
		            );
		    	$result = array(
	                'status' => true,
	                'message' => 'New car record ('.$data['number'].') successfully added!',
	                'data' => array('carNumber'=>$data['number'], 'carID'=>$id),
	            );
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Car number already exist!',
	            );
		    }
	    }
	    catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
        return json_encode($result);
    }


    public function updateCar(request $request){

	    try{
	    	$data = $request->all();
	    	$car = DB::table('vehicles')->where('ID', $data['id'])->first();

	    	if($car){
	    		$checkNo =false;
	    		if($car->RegistrationNo != $data['number']){
			    	$checkNo = DB::table('vehicles')->where('RegistrationNo', $data['number'])->count();
			    }
			    if($checkNo){
			    		$result = array(
			                'status' => false,
			                'message' => 'Car number already exist!',
			            );
			    }else{
			    	$id = DB::table('vehicles')->where('ID', $data['id'])->update(
			                [
			                    'RegistrationNo' => $data['number'],
			                    'VehicleTypeID' => $data['type'],
			                    'Color' => $data['color'],
			                    'VehicleTypeID' => $data['type'],
			                    'ManufacturerID' => $data['manufacturer'],
			                    'Model' => '',
			                ]
			            );
			    	$result = array(
		                'status' => true,
		                'message' => 'Car record ('.$data['number'].') successfully updated!',
		            );
			    }
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Invalid Member!',
	            );
		    }
	    }
	    catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
        return json_encode($result);
    }

    public function getMemberDetails(request $request){
    	try{

	    	$data = $request->all();
		    
		    $member = DB::table('clients')
		    	->leftJoin('members', 'clients.ID', '=', 'members.ClientID')
				//->leftJoin('salesorder', 'salesorder.ClientID', '=', 'clients.ID')
				//->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
				//->leftJoin('members', 'members.ID', '=', 'membercreditledger.MemberID')
		    	->where('clients.ID', $data['id'])
		    	->first();

	    	$member2 = DB::table('clients')
				->leftJoin('salesorder', 'salesorder.ClientID', '=', 'clients.ID')
				->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
				->leftJoin('members', 'members.ID', '=', 'membercreditledger.MemberID')
		    	->where('clients.ID', $data['id'])
		    	->first();
		    
		    $cars = DB::table('vehicles')
	    		->select('vehicles.ID','vehicles.RegistrationNo')
		    	->join('clientvehiclejoin', 'vehicles.ID', '=', 'clientvehiclejoin.VehicleID')
		    	->where('clientvehiclejoin.ClientID', $data['id'])->get();
		    
		    $result = array(
	                'status' => true,
	                'message' => 'success',
	                'member' => $member,
	                'member2' => $member2,
	                'cars' => $cars,
	            );
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }


    public function getCarDetails(request $request){
    	try{

	    	$data = $request->all();
		    $car = DB::table('vehicles')->where('ID', $data['id'])->first();
		    $result = array(
	                'status' => true,
	                'message' => 'success',
	                'car' => $car,
	            );
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }

    public function deleteCarDetails(request $request){
    	try{

	    	$data = $request->all();
		    $car = DB::table('clientvehiclejoin')->where('VehicleID', $data['vehicleid'])->where('ClientID', $data['clientid'])->delete();

		    $result = array(
	                'status' => true,
	                'message' => 'success'
	            );
		    
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }

    public function topup(request $request){
    	try{
	    	$data = $request->all();

	    	$member = DB::table('members')
	    		->select('members.CreditBalance', 'members.ID AS MemberID', 'members.ClientID')
	    		->where('members.Code', $data['memberCode'])
	    		->first();
			
    		/*if ($member->MemberID != "0") {
    			$memberID = $member->MemberID;
    		}
    		else {
    			$member2 = DB::table('clients')
    				->select('members.ID AS MemberID')
	    			->leftJoin('salesorder', 'salesorder.ClientID', '=', 'clients.ID')
					->leftJoin('membercreditledger', 'membercreditledger.SalesOrderID', '=', 'salesorder.ID')
					->leftJoin('members', 'members.ID', '=', 'membercreditledger.MemberID')
		    		->where('clients.ID', $data['id'])
		    		->first();

	    		$memberID = $member2->MemberID;
    		}*/

	    	$id = DB::table('salesorder')->insertGetId(
	                [
	                    'GrossTotal' => $data['amount'],
	                    'ClientID' => $member->ClientID,
	                    'GSTRate' => 0,
	                    'BranchID' => Auth::user()->BranchID,
	                    'CreatedBy' => Auth::user()->id,
	                    'ClosedBy' => Auth::user()->id,
	                    'Paid' => 0.00,
	                    'Due' => 0.00,
	                    'VehicleID' => 0,
	                    'SalesType' => 'T',
	                ]
	            );

	    	$salesCode = 'SO'.Auth::user()->BranchID.str_pad($id, 9, "0", STR_PAD_LEFT);

	    	DB::table('salesorder')
	    		->where('id', $id)
	    		->update(['SalesNo' => $salesCode]);

	    	//$totalAmount = (float)$data['amount']+$member->CreditBalance;
	    	$totalAmount = (float)$data['amount'] + (float)$member->CreditBalance;

	    	$id2 = DB::table('membercreditledger')->insertGetId(
	                [
	                    'MemberID' => $member->MemberID,
	                    'SalesOrderID' => $id,
	                    'CreditUsed' => 0.0000,
	                    'RunningBalance' => $totalAmount,
	                ]
	            );

	    	DB::table('members')
	    		->where('members.Code', $data['memberCode'])
	    		->update(['members.CreditBalance' => $totalAmount]);



	    	$result = array(
                'status' => true,
                'message' => 'Topup successfully added!',
                'data' => array('amount'=>$totalAmount, 'salesCode'=>$salesCode, 'salesID'=>$id, 'memberID'=>$data['id']),
            );
		    
	    }
	    catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
        return json_encode($result);

    }
}

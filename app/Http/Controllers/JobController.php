<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Service;
use App\Servicecategory;
use App\Salesorder;
use App\Salesorderdetail;
use App\Vehicle;
use App\Vehicletype;
use App\Manufacturers;
use DateTime;
use App\Job;
use App\Jobdetail;
use App\Clientvehiclejoin;
use App\Client;
use App\Color;
use App\Product;
use App\Productprices;
use App\User;
use App\PaymentType;
use App\Member;
use App\DealerCompany;
use App\DealerUser;
use App\Membercreditledger;
use Response;
use Carbon\Carbon;
use App\Receipt;
use App\Receiptdetail;
use App\Branch;

class JobController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function pending(Request $request) {

        //Search base on request (POST) value
        $input = $request->all();
        $data = [];

        $records_washing_pending = Job::select('jobs.*')->whereStatus(5)->where("JobQueueID", 1)
                ->join('clients', 'jobs.clientID', '=', 'clients.ID')
                ->orderBy('StartDate', 'desc')
                ->get();

        
        foreach ($records_washing_pending as $key => &$value) {

            $jobdetail = Jobdetail::select('servicecategories.Code', 'servicecategories.Description')
                            ->join('services', 'services.ID', '=', 'jobdetails.ServiceID')
                            ->join('servicecategories', 'servicecategories.ID', '=', 'services.ServiceCategoryID')
                            ->where('jobdetails.JobID', '=', $value->ID)
                            ->first();

            $data['records_washing'][] = (object) array(
                        'ID' => $value->ID,
                        'JobQueueID' => $value->JobQueueID,
                        'SalesOrderID' => $value->SalesOrderID,
                        'ClientID' => $value->ClientID,
                        'car_number' => Vehicle::getVehicleDetailsByID($value->VehicleID)->RegistrationNo,
                        'model' => Vehicle::getVehicleDetailsByID($value->VehicleID)->Model,
                        'remarks' => $value->Remarks,
                        'productCode' => $jobdetail->Code,
            );
        }

        $records_treatment_pending = Job::select('jobs.*')->whereStatus(5)->where("JobQueueID", 2)
                ->join('clients', 'jobs.clientID', '=', 'clients.ID')
                ->orderBy('StartDate', 'desc')
                ->get();

        foreach ($records_treatment_pending as $key => &$value) {

            $jobdetail = Jobdetail::select('servicecategories.Code', 'servicecategories.Description')
                            ->join('services', 'services.ID', '=', 'jobdetails.ServiceID')
                            ->join('servicecategories', 'servicecategories.ID', '=', 'services.ServiceCategoryID')
                            ->where('jobdetails.JobID', '=', $value->ID)
                            ->first();
            
            $data['records_treatment'][] = (object) array(
                        'ID' => $value->ID,
                        'JobQueueID' => $value->JobQueueID,
                        'SalesOrderID' => $value->SalesOrderID,
                        'ClientID' => $value->ClientID,
                        'car_number' => Vehicle::getVehicleDetailsByID($value->VehicleID)->RegistrationNo,
                        'model' => Vehicle::getVehicleDetailsByID($value->VehicleID)->Model,
                        'remarks' => $value->Remarks,
                        'productCode' => $jobdetail->Code,                                                
            );
        }

        $data['services'] = Servicecategory::wherein('ID', [2, 3])->get();
        $data['vehicle_manufacturers'] = Manufacturers::get();
        $data['vehicle_types'] = Vehicletype::get();
        $data['vehicle_colors'] = Color::get();
        $data['payment_types'] = DB::table('payment_type')->get();

        //throw error_log('no value');

        return view('services.pending', $data);
    }

    public function CompleteJob(Request $request) {
        $input = $request->all();

        Job::where('ID', $input['jobID'])->update(['CompleteDate' => date("Y-m-d H:i:s"), 'Status' => 6]);

        return redirect()->route('completed');
    }

    public function completed(Request $request) {

        $input = $request->all();


        $records_washing_pending = Job::select('jobs.*')->whereStatus(6)->where("JobQueueID", 1)
                ->join('clients', 'jobs.clientID', '=', 'clients.ID')
                ->orderBy('StartDate', 'desc')
                ->get();

        $data = [];
        foreach ($records_washing_pending as $key => &$value) {

            $vehicle = Vehicle::select('vehicles.RegistrationNo')
                            ->where('vehicles.ID', '=', $value->VehicleID)
                            ->first();

            $data['records_washing'][] = (object) array(
                        'ID' => $value->ID,
                        'JobQueueID' => $value->JobQueueID,
                        'SalesOrderID' => $value->SalesOrderID,
                        'ClientID' => $value->ClientID,
                        'car_number' => Vehicle::getVehicleDetailsByID($value->VehicleID)->RegistrationNo,
                        'model' => Vehicle::getVehicleDetailsByID($value->VehicleID)->Model
            );
        }

        $records_treatment_pending = Job::select('jobs.*')->whereStatus(6)->where("JobQueueID", 2)
                ->join('clients', 'jobs.clientID', '=', 'clients.ID')
                ->orderBy('StartDate', 'desc')
                ->get();

        foreach ($records_treatment_pending as $key => &$value) {

            $data['records_treatment'][] = (object) array(
                        'ID' => $value->ID,
                        'JobQueueID' => $value->JobQueueID,
                        'SalesOrderID' => $value->SalesOrderID,
                        'ClientID' => $value->ClientID,
                        'car_number' => Vehicle::getVehicleDetailsByID($value->VehicleID)->RegistrationNo,
                        'model' => Vehicle::getVehicleDetailsByID($value->VehicleID)->Model
            );
        }
        
        $data['services'] = Servicecategory::wherein('ID', [2, 3])->get();
        return view('services.completed', $data);
    }
    
    
    public function updateService(Request $request) {
        $input = $request->all();
         
        /*if($input['serviceID'] == 2)///treatment
            $jobQuery = 2;
        if($input['serviceID'] == 3)///washing
            $jobQuery = 1;*/
        
         $job = Job::where('ID', $input['jobID'])->first();
         
         $vehicle = Vehicle::where('ID', $job->VehicleID)->update(['RegistrationNo' => $input['VehicleNo'], 'Model' => $input['VehicleModel']]);
                      
        if($job->Status == 5)
            return redirect()->route('pending');
          if($job->Status == 6)
                return redirect()->route('completed');
    }
    
    public function removeService(Request $request) {
        $input = $request->all();
         
        /*if($input['serviceID'] == 2)///treatment
            $jobQuery = 2;
        if($input['serviceID'] == 3)///washing
            $jobQuery = 1;*/
        
        
        if($input['JobQueueID'] == 1){///washing
            $ProductCode = 'WSH01';
        }else{//treatment
            $ProductCode = 'TRM01';
        }
        $sod = Salesorderdetail::where('ProductCode',$ProductCode)->where('SalesOrderID',$input['SalesOrderID'])->first();
        if(!is_null($sod)){
            $dsod = Salesorderdetail::where('ID',$sod->ID)->delete();
            $djob = Job::where('ID', $input['jobID'])->delete();
        }
        
        return redirect()->route('pending');
    }

    public function removeJob(Request $request) {
        $input = $request->all();

        $job = Job::where('ID', $input['id'])->first();
         
        $dsod = Salesorderdetail::where('SalesOrderID',$job->SalesOrderID)->delete();
        $dso = Salesorder::where('ID',$job->SalesOrderID)->delete();
        $djob = Job::where('ID', $input['id'])->delete();

        $result = (object) array(
                    "status" => 'ok',
        );

        return Response::json($result);
    }
    
    
    public function PaidJob(Request $request) {
        $input = $request->all();

        Job::where('ID', $input['jobID'])->update(['CompleteDate' => date("Y-m-d H:i:s"), 'Status' => 4]);

        return redirect()->route('completed');
    }

    public function addNewMember(request $request) {

        try {
            $data = $request->all();
            $member = Client::where('Email', $data['Email'])->first();
//dd($member);
            if (is_null($member)) {
                $id = Client::insertGetId(
                                [
                                    'Name' => strtoupper($data['ClientName']),
                                    'ContactNo' => $data['ContactNo'],
                                    'Email' => $data['Email'],
                                    'BranchID' => Auth::user()->BranchID,
                                ]
                );
                $memberCode = 'MB' . Auth::user()->BranchID . str_pad($id, 7, "0", STR_PAD_LEFT);

                //DB::table('members')->where('id', $id)->update(['Code' => $memberCode]);

                $id2 = Member::insertGetId(
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
                    'data' => array('memberCode' => $memberCode, 'memberID' => $id, 'memberID2' => $id2),
                );

                $vehicle = Vehicle::insertGetId(
                                [
                                    'RegistrationNo' => $data['RegistrationNo'],
                                    'Model' => $data['Model'],
                                    'Color' => $data['VehicleColor'],
                                    'VehicleTypeID' => $data['VehicleType'],
                                    'ManufacturerID' => $data['Manufacturer'],
                                ]
                );

                $cjvid = Clientvehiclejoin::insertGetId(
                                [
                                    'ClientID' => $id,
                                    'VehicleID' => $vehicle,
                                ]
                );
            } else {
                $result = array(
                    'status' => false,
                    'message' => 'Email already exist!',
                );
                $cjv = Clientvehiclejoin::where('ClientID', $member->ID)->first();
                $cjvid = $cjv->ID;
            }
        } catch (Exception $ex) {
            $result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }


        //return json_encode($result);
        //return redirect()->route('pending');

        return redirect()->route("newjob", ['id' => $id, 'CategoryService' => 3, 'vehicleId' => $vehicle]);
    }

    public function memberSearch(Request $request) {
        $input = $request->all();

        $result = Clientvehiclejoin::select('clientvehiclejoin.*', 'vehicles.RegistrationNo', 'clients.Name', 'clients.ContactNo', 'clients.ID')
                ->join('vehicles', 'vehicles.ID', '=', 'clientvehiclejoin.VehicleID')
                ->join('clients', 'clients.ID', '=', 'clientvehiclejoin.ClientID')
                ->Where(function ($query) use($input) {
                    if (!is_null($input['RegistrationNo']))
                        $query->where('vehicles.RegistrationNo', 'like', '%' . $input['RegistrationNo'] . '%');
                    if (!is_null($input['Name']))
                        $query->where('clients.Name', 'like', '%' . $input['Name'] . '%');
                    if (!is_null($input['ContactNo']))
                        $query->where('clients.ContactNo', '=', $input['ContactNo']);
                })
                ->get();
        $data = [];
        foreach ($result as $key => &$value) {

            $data['result'][] = (object) array(
                        'ID' => $value->ID,
                        'Name' => $value->Name,
                        'RegistrationNo' => $value->RegistrationNo,
                        'ContactNo' => $value->ContactNo,
                        'VehicleID' => $value->VehicleID,
            );
        }
        $data['CategoryService'] = $input['CategoryService'];

        return view('services.member_search', $data);
    }

    public function addjobcash(Request $request) {

        //Search base on request (POST) value
        $input = $request->all();

        return view('services.cash_page');
    }

    public function findUser(Request $request) {


        $this->validate($request, [
            'RegistrationNo' => 'required',
            'VehicleModel' => 'required',
            'Name' => 'required',
            'Email' => 'required|email',
            'ContactNo' => 'required',
                ], [
            'RegistrationNo.required' => 'The Car Number field is required.',
            'VehicleModel.required' => 'The Car Model field is required.',
            'Name.required' => 'The Customer Name field is required.',
            'Email.required' => 'The Customer Email field is required.',
            'ContactNo.required' => 'The Phone Number field is required.'
        ]);

        $data = $request->all();

        $id = Client::insertGetId(
            [
                'Name' => strtoupper($data['Name']),
                'ContactNo' => $data['ContactNo'],
                'Email' => $data['Email'],
                'BranchID' => Auth::user()->BranchID,
            ]
        );

        $vehicle = Vehicle::insertGetId(
            [
                'RegistrationNo' => $data['RegistrationNo'],
                'Model' => $data['VehicleModel'],
                'Color' => 0,
                'VehicleTypeID' => 1,
                'ManufacturerID' => 1,
            ]
        );

        $cjvid = Clientvehiclejoin::insertGetId(
            [
                'ClientID' => $id,
                'VehicleID' => $vehicle,
            ]
        );

        return redirect()->route("newjobbycash", ['id' => $id, 'CategoryService' => 3, 'vehicleId' => $vehicle]);
    }
    
    public function NewJobByCash($id, $CategoryService, $vehicleId) {

        //Search base on request (POST) value

        $result = Clientvehiclejoin::find($id);
        $data['CategoryService'] = $CategoryService;
        $data['Client'] = Client::getClientDetailsByID($id);
        $data['Vehicle'] = Vehicle::getVehicleDetailsByID($vehicleId);
        $data['SalesAdvisors'] = User::getUserRoleID(2);
        $data['Technicians'] = User::getUserRoleID(3);
        $data['DealerCompanies'] =  Branch::get();
        $data['DealerUsers'] = User::where("RoleID",">=",2)->join('branches', 'branches.ID', '=', 'users.BranchID')->get();
        $data['payment_types'] = PaymentType::whereIn('id', [1, 2, 3, 4])->get();
        $data['clientList'] = Client::get();

        $Services = Servicecategory::wherein('ID', [2, 3])->get();
        foreach ($Services as $Service) {
            $data['Services'][] = (object) array(
                "ID" => $Service->ID,
                "Code" => $Service->Code, //
                "Name" => $Service->Name,
                "NormalPrice" => $Service->NormalPrice
                //"NormalPrice" => Productprices::getProductPricesByProductID($Service->ID)->NormalPrice,
            );
        }

        $servicecategory = Servicecategory::select('servicecategories.Code', 'servicecategories.Name')
                                ->where('servicecategories.ID', '=', $CategoryService)
                                ->first();

        $data['ProductsCode'] = $servicecategory->Code;
        $data['ProductsName'] = $servicecategory->Name;

        $carColor = Color::where('ID', $data['Vehicle']['Color'])->first();
        if (!is_null($carColor))
            $data['VehicleColor'] = $carColor->Name;
        else
            $data['VehicleColor'] = $data['Vehicle']['Color'];


        return view('services.new_job_by_cash', $data);
    }
    
    public function NewJob($id, $CategoryService, $vehicleId) {

        //Search base on request (POST) value

        //$result = Clientvehiclejoin::find($id);
        $result = Clientvehiclejoin::where('ClientID', $id)->where('VehicleID', $vehicleId)->first();
        $data['CategoryService'] = $CategoryService;
        $data['Client'] = Client::getClientDetailsByID($result->ClientID);
        $data['MemberID'] = Client::getMemberCodeByClientID($result->ClientID);
        $data['Vehicle'] = Vehicle::getVehicleDetailsByID($result->VehicleID);
        $data['MemberBalance'] = Client::getMemberBalanceByClientID($result->ClientID);
        $memberData = Client::getMemberByClientID($result->ClientID);
        $Membercreditledger = Membercreditledger::where('MemberID', $memberData->ID)->orderBy('ID', 'DESC')->first();
        if (is_null($Membercreditledger))
            $OpeningBalance = 0;
        else
            $OpeningBalance = $Membercreditledger->RunningBalance;
        $data['OpeningBalance'] = number_format((float) $OpeningBalance, 2, '.', '');

        $data['SalesAdvisors'] = User::getUserRoleID(2);
        $data['Technicians'] = User::getUserRoleID(3);
        $data['DealerCompanies'] =  Branch::get();
        $data['DealerUsers'] = User::where("RoleID",">=",2)->join('branches', 'branches.ID', '=', 'users.BranchID')->get();
        $data['payment_types'] = PaymentType::whereIn('id', [1, 2, 3, 4])->get();
        $data['clientList'] = Client::get();

        $data['vehicleId'] = $vehicleId;

        //$Services = Product::getProductList(5);
        $Services = Servicecategory::wherein('ID', [2, 3])->get();
        foreach ($Services as $Service) {
            $data['Services'][] = (object) array(
                    "ID" => $Service->ID,
                    "Code" => $Service->Code,
                    "Name" => $Service->Name,
                    "NormalPrice" => $Service->NormalPrice
                    //"NormalPrice" => Productprices::getProductPricesByProductID($Service->ID)->NormalPrice,
            );
        }

        $servicecategory = Servicecategory::select('servicecategories.Code', 'servicecategories.Name')
                                ->where('servicecategories.ID', '=', $CategoryService)
                                ->first();

        $data['ProductsCode'] = $servicecategory->Code;
        $data['ProductsName'] = $servicecategory->Name;

        $carColor = Color::where('ID', $data['Vehicle']['Color'])->first();
        if (!is_null($carColor))
            $data['VehicleColor'] = $carColor->Name;
        else
            $data['VehicleColor'] = $data['Vehicle']['Color'];

        if ($CategoryService == 3) {
            $data['salesorderdetails'] = DB::table('salesorderdetails')
                    ->select('salesorderdetails.ID', 'salesorderdetails.ProductName', 'salesorderdetails.UnitPrice', 'salesorderdetails.Discount')
                    ->where('salesorderdetails.ProductName', '=', 'WASHING')
                    ->first();
        }
        else {
            $data['salesorderdetails'] = DB::table('salesorderdetails')
                    ->select('salesorderdetails.ID', 'salesorderdetails.ProductName', 'salesorderdetails.UnitPrice', 'salesorderdetails.Discount')
                    ->where('salesorderdetails.ProductName', '=', 'TREATMENT')
                    ->first();
        }

        return view('services.new_job', $data);
    }


    public function EditJob($id, $CategoryService) {

        //Search base on request (POST) value

        $result = Clientvehiclejoin::where('ClientID', $id)->first();
        $data['CategoryService'] = $CategoryService;
        $data['Client'] = Client::getClientDetailsByID($result->ClientID);
        $data['MemberID'] = Client::getMemberCodeByClientID($result->ClientID);
        $data['Vehicle'] = Vehicle::getVehicleDetailsByID($result->VehicleID);
        $data['MemberBalance'] = Client::getMemberBalanceByClientID($result->ClientID);
        $memberData = Client::getMemberByClientID($result->ClientID);
        $Membercreditledger = Membercreditledger::where('MemberID', $memberData->ID)->orderBy('ID', 'DESC')->first();
        if (is_null($Membercreditledger))
            $OpeningBalance = 0;
        else
            $OpeningBalance = $Membercreditledger->RunningBalance;
        $data['OpeningBalance'] = number_format((float) $OpeningBalance, 2, '.', '');

        $data['SalesAdvisors'] = User::getUserRoleID(2);
        $data['Technicians'] = User::getUserRoleID(3);
        $data['DealerCompanies'] =  Branch::get();
        $data['DealerUsers'] = User::where("RoleID",">=",2)->join('branches', 'branches.ID', '=', 'users.BranchID')->get();
        $data['payment_types'] = PaymentType::whereIn('id', [1, 2, 3, 4])->get();
        $data['clientList'] = Client::get();

        $jobs = Job::where('ID', '=', $CategoryService)->first();

        if ($jobs->JobQueueID == 1) {
            $Services = Servicecategory::where('ID', '=', 3)->first();
        }
        else {
            $Services = Servicecategory::where('ID', '=', 2)->first();
        }

        $data['Services'][] = (object) array(
            "ID" => $Services->ID,
            "Code" => $Services->Code, //
            "Name" => $Services->Name,
            "NormalPrice" => $Services->NormalPrice
        );                

        $carColor = Color::where('ID', $data['Vehicle']['Color'])->first();
        if (!is_null($carColor))
            $data['VehicleColor'] = $carColor->Name;
        else
            $data['VehicleColor'] = $data['Vehicle']['Color'];

        $data['jobs'] = Job::where('ID', $CategoryService)->first();

        $queueid = $data['jobs']->JobQueueID;

        if ($queueid == 1) {
            $data['salesorderdetails'] = DB::table('salesorderdetails')
                    ->select('salesorderdetails.ID', 'salesorderdetails.ProductName', 'salesorderdetails.UnitPrice', 'salesorderdetails.Discount')
                    ->where('salesorderdetails.ProductName', '=', 'WASHING')
                    ->where('salesorderdetails.SalesOrderID', '=', $data['jobs']->SalesOrderID)
                    ->first();

            $data['salesorder'] = DB::table('salesorder')
                    ->select('salesorder.GST', 'salesorder.GrossTotal')
                    ->where('salesorder.ID', '=', $data['jobs']->SalesOrderID)
                    ->first();
        }
        else {
            $data['salesorderdetails'] = DB::table('salesorderdetails')
                    ->select('salesorderdetails.ID', 'salesorderdetails.ProductName', 'salesorderdetails.UnitPrice', 'salesorderdetails.Discount')
                    ->where('salesorderdetails.ProductName', '=', 'TREATMENT')
                    ->where('salesorderdetails.SalesOrderID', '=', $data['jobs']->SalesOrderID)
                    ->first();

            $data['salesorder'] = DB::table('salesorder')
                    ->select('salesorder.GST', 'salesorder.GrossTotal')
                    ->where('salesorder.ID', '=', $data['jobs']->SalesOrderID)
                    ->first();
        }

        $data['jobid'] = $CategoryService;

        $jobdetail = Jobdetail::select('ServiceID')
                        ->where('JobID', '=', $CategoryService)
                        ->first();

        $service = Service::select('ServiceCategoryID')
                        ->where('ID', '=', $jobdetail->ServiceID)
                        ->first();

        $servicecategory = Servicecategory::select('servicecategories.Code', 'servicecategories.Name')
                                ->where('servicecategories.ID', '=', $service->ServiceCategoryID)
                                ->first();

        $data['ProductsCode'] = $servicecategory->Code;
        $data['ProductsName'] = $servicecategory->Name;

        return view('services.edit_job', $data);
    }



    public function driverSearch(Request $request) {
        $input = $request->all();

        $result = Client::select('clients.*', 'clientvehiclejoin.VehicleID')
                ->join('clientvehiclejoin', 'clients.ID', '=', 'clientvehiclejoin.ClientID')
                //->where('clients.Name', 'LIKE', $input['Name'])
                ->whereRaw("clients.Name LIKE '%" . $input['Name'] . "%'")
                ->first();

        $data = [];
        if (!is_null($result)) {
            $data['Client'] = Client::getClientDetailsByID($result->ID);
            $data['MemberID'] = Client::getMemberCodeByClientID($result->ID);
            $data['Vehicle'] = Vehicle::getVehicleDetailsByID($result->VehicleID);
            $data['MemberBalance'] = Client::getMemberBalanceByClientID($result->ID);
        }

        return view('services.driver_result', $data);
    }

    public function getDriver(Request $request) {
        $input = $request->all();

        $jobdetail = Jobdetail::select('jobdetails.DriverID')
                        ->where('jobdetails.JobID', '=', $input['jobId'])
                        ->first();

        $result = Client::select('clients.*', 'clientvehiclejoin.VehicleID')
                ->join('clientvehiclejoin', 'clients.ID', '=', 'clientvehiclejoin.ClientID')
                ->where('clients.ID', '=', $jobdetail->DriverID)
                ->first();

        $data = [];
        if (!is_null($result)) {
            $data['Client'] = Client::getClientDetailsByID($result->ID);
            $data['MemberID'] = Client::getMemberCodeByClientID($result->ID);
            $data['Vehicle'] = Vehicle::getVehicleDetailsByID($result->VehicleID);
            $data['MemberBalance'] = Client::getMemberBalanceByClientID($result->ID);
        }

        return view('services.driver_result', $data);
    }

    public function getClientDetails(Request $request) {

        $input = $request->all();

        $result = Client::select('clients.*', 'clientvehiclejoin.VehicleID')
                ->join('clientvehiclejoin', 'clients.ID', '=', 'clientvehiclejoin.ClientID')
                ->where('clients.ID', $input['ClientID'])
                ->first();

        $result = (object) array(
                    "ClientID" => $result->ID,
                    "MemberID" => Client::getMemberCodeByClientID($result->ID),
                    "ClientName" => $result->Name,
                    "MemberBalance" => Client::getMemberBalanceByClientID($result->ID),
                    "PaymentTypes" => PaymentType::whereIn('id', [1, 2, 3, 4])->get(),
        );

        return Response::json($result);
    }

    public function getProductDetails(Request $request) {

        $input = $request->all();
        $data['result'] = '';
        $productArr = [];
        $data['NetTotal'] = 0.00;
        $data['GST'] = 0.00;
        if (!empty($input['productArr'])) {


            foreach ($input['productArr'] as $index => $val) {
                array_push($productArr, $val);
            }

            /* $result = Product::whereIn('products.ID', $productArr)
              ->orderby('products.Name', 'ASC')
              ->get(); */

            $result = Servicecategory::wherein('ID', $productArr)
                    ->orderby('servicecategories.Name', 'ASC')
                    ->get();

            $resultArr = $result->toArray();
            $i = 0;
            $NetTotal = 0;
            foreach ($resultArr as $key => &$value) {
                $i++;

                //$productPrices = Productprices::getProductPricesByProductID($value['ID']);
                $productPrices = (object) $value;
                $Discount = $productPrices->NormalPrice - $productPrices->MemberPrice;
                $Total = $productPrices->NormalPrice - $Discount;
                $data['result'][] = array(
                    'ID' => $value['ID'],
                    'Name' => $value['Name'],
                    'Code' => $value['Code'],
                    'NormalPrice' => $productPrices->NormalPrice,
                    'Discount' => number_format((float) $Discount, 2, '.', ''),
                    'Total' => number_format((float) $Total, 2, '.', ''),
                );

                $NetTotal = $NetTotal + $Total;
            }

            $data['NetTotal'] = number_format((float) $NetTotal, 2, '.', '');
            $data['GST'] = number_format((float) ($NetTotal * (6 / 100)), 2, '.', '');
            $GrossTotal = $data['NetTotal'] + $data['GST'];
            $data['GrossTotal'] = number_format((float) $GrossTotal, 2, '.', '');
            $data['Paid'] = number_format((float) $GrossTotal, 2, '.', '');
            $data['Due'] = number_format((float) 0, 2, '.', '');
        }


        $date = Carbon::now()->toDateTimeString();
        $data['date'] = Carbon::parse($date)->format('jS F Y');


        return view('services.bill_page', $data);
    }

    public function getProductDetailsByCash(Request $request) {

        $input = $request->all();
        $data['result'] = '';
        $productArr = [];
        $data['NetTotal'] = 0.00;
        $data['GST'] = 0.00;
        if (!empty($input['productArr'])) {


            foreach ($input['productArr'] as $index => $val) {
                array_push($productArr, $val);
            }

            /* $result = Product::whereIn('products.ID', $productArr)
              ->orderby('products.Name', 'ASC')
              ->get(); */

            $result = Servicecategory::wherein('ID', $productArr)
                    ->orderby('servicecategories.Name', 'ASC')
                    ->get();

            $resultArr = $result->toArray();
            $i = 0;
            $NetTotal = 0;
            foreach ($resultArr as $key => &$value) {
                $i++;

                //$productPrices = Productprices::getProductPricesByProductID($value['ID']);
                $productPrices = (object) $value;
                $Discount = $productPrices->NormalPrice - $productPrices->MemberPrice;
                $Total = $productPrices->NormalPrice - $Discount;
                $data['result'][] = array(
                    'ID' => $value['ID'],
                    'Name' => $value['Name'],
                    'Code' => $value['Code'],
                    'NormalPrice' => $productPrices->NormalPrice,
                    'Discount' => number_format((float) $Discount, 2, '.', ''),
                    'Total' => number_format((float) $Total, 2, '.', ''),
                );

                $NetTotal = $NetTotal + $Total;
            }

            $data['NetTotal'] = number_format((float) $NetTotal, 2, '.', '');
            $data['GST'] = number_format((float) ($NetTotal * (6 / 100)), 2, '.', '');
            $GrossTotal = $data['NetTotal'] + $data['GST'];
            $data['GrossTotal'] = number_format((float) $GrossTotal, 2, '.', '');
            $data['Paid'] = number_format((float) $GrossTotal, 2, '.', '');
            $data['Due'] = number_format((float) 0, 2, '.', '');
        }


        $date = Carbon::now()->toDateTimeString();
        $data['date'] = Carbon::parse($date)->format('jS F Y');


        return view('services.bill_page_cash', $data);
    }

    public function updateBillingInfo(request $request) {
        $input = $request->all();

        $member = Member::select('members.CreditBalance', 'members.Code', 'clients.Name')
                    ->join('clients', 'clients.ID', '=', 'members.ClientID')
                    ->where('members.ClientID', '=', $input['clientId'])
                    ->first();

        $result = (object) array(
            'MemberCode' => $member->Code,
            'MemberName' => $member->Name,
            'ClientId' => $input['clientId'],
            'MemberBalance' => $member->CreditBalance,
        );

        return Response::json($result);
    }

    public function Topup(request $request) {

        $data = $request->all();
        $result = Member::TopupCredit($data);

        return Response::json($result);
    }

    public function AddNewJob(request $request) {

        $data = $request->all();

        $member = Member::select('CreditBalance')
                    ->where('ClientID', '=', $data['ClientID'])
                    ->first();

        $driverId = 0;

        if ($data['driver_id'] != null) {
            $driverId = $data['driver_id'];
        }

        $id = Salesorder::insertGetId(
            [
                'GrossTotal' => $data['invoice_GrossTotal'],
                'PaymentTypeID' => $data['invoice_payment_type'],
                'ClientID' => $data['ClientID'],
                'GSTRate' => 6,
                'GST' => $data['invoice_GST'],
                'Paid' => $data['invoice_paid'],
                'Due' => $data['invoice_due'],
                'BranchID' => Auth::user()->BranchID,
                'CreatedBy' => Auth::user()->id,
                'ClosedBy' => Auth::user()->id,
                'VehicleID' => $data['VehicleID'],
                'VehicleRegistrationNo' => $data['RegistrationNo'],
                'TechnicianID' => $data['technician_id'],
                'SalesAdvisorID' => $data['salesAdvisor_id'],
                'DriverID' => $driverId,
            ]
        );

        $salesCode = 'SOB' . Auth::user()->BranchID . str_pad($id, 9, "0", STR_PAD_LEFT);

        Salesorder::where('id', $id)
            ->update(['SalesNo' => $salesCode]);

        if ($data['invoice_payment_type'] == 5) {//paid by membership
            $member = null;

            if ($driverId == 0) {
                $member = Member::select('members.CreditBalance', 'members.ID AS MemberID')
                        ->where('members.Code', $data['MemberCode'])
                        ->first();
            }
            else {
                $member = Member::select('members.CreditBalance', 'members.ID AS MemberID')
                        ->where('members.ClientID', $driverId)
                        ->first();
            }

            $totalAmount = (float) $member->CreditBalance - (float) $data['invoice_GrossTotal'];

            $id2 = Membercreditledger::insertGetId(
                [
                    'MemberID' => $member->MemberID,
                    'SalesOrderID' => $id,
                    'CreditUsed' => $data['invoice_GrossTotal'],
                    'RunningBalance' => $member->CreditBalance,
                ]
            );

            if ($driverId == 0) {
                Member::where('members.Code', $data['MemberCode'])
                ->update(['members.CreditBalance' => $totalAmount]);
            }
            else {
                Member::where('members.ClientID', $driverId)
                ->update(['members.CreditBalance' => $totalAmount]);
            }
            
        }

        $length = count($data['invoice_productCode']);
        for ($i = 0; $i < $length; $i++) {


            $sodid = Salesorderdetail::insertGetId(
                [
                    'SalesOrderID' => $id,
                    'ProductCode' => $data['invoice_productCode'][$i],
                    'ProductName' => $data['invoice_productName'][$i],
                    'UnitPrice' => $data['invoice_GrossTotal'],
                    'UnitPriceIncludeGST' => 0,
                    'Quantity' => $data['invoice_product_quantity'][$i],
                    'Discount' => $data['invoice_productDiscount'][$i],
                    'GSTRate' => 0,
                    'GSTExempted' => 0,
                    'GST' => 0,
                    'Total' => $data['invoice_GrossTotal'],
                ]
            );

            $seid = Service::insertGetId(
                [
                    'WarrantyPeriod' => 0,
                    'ServiceCategoryID' => $data['invoice_productID'][$i],
                    'ColorID' => NULL,
                    'MaintenanceCount' => 0,
                ]
            );

            if ($data['invoice_productID'][$i] == 2)
                $JobQueueID = 2;
            else
                $JobQueueID = 1;
            $jid = Job::insertGetId(
                [
                    'Status' => 5,
                    'StartDate' => Carbon::now()->toDateTimeString(),
                    'ETA' => Carbon::now()->toDateTimeString(),
                    'ClientID' => $data['ClientID'],
                    'VehicleID' => Vehicle::getVehicleByRegNo($data['RegistrationNo'])->ID,
                    'JobQueueID' => $JobQueueID,
                    'SalesOrderID' => $id,
                    'SalesAdvisorID' => $data['salesAdvisor_id'],
                    'Remarks' => $data['remarks'],
                ]
            );

            Jobdetail::insert(
                [
                    'ServiceID' => $seid,
                    'JobID' => $jid,
                    'SalesOrderDetailID' => $sodid,
                    'DriverID' => $data['driver_id'],
                ]
            );                
        }
       

        return redirect()->route('pending');
    }

    public function AddNewJobByCash(request $request) {

        $data = $request->all();

        $member = Member::select('CreditBalance')
                    ->where('ClientID', '=', $data['ClientID'])
                    ->first();

        $id = Salesorder::insertGetId(
            [
                'GrossTotal' => $data['invoice_GrossTotal'],
                'PaymentTypeID' => $data['invoice_payment_type'],
                'ClientID' => $data['ClientID'],
                'GSTRate' => 6,
                'GST' => $data['invoice_GST'],
                'Paid' => $data['invoice_paid'],
                'Due' => $data['invoice_due'],
                'BranchID' => Auth::user()->BranchID,
                'CreatedBy' => Auth::user()->id,
                'ClosedBy' => Auth::user()->id,
                'VehicleID' => $data['VehicleID'],
                'VehicleRegistrationNo' => $data['RegistrationNo'],
                'TechnicianID' => $data['technician_id'],
                'SalesAdvisorID' => $data['salesAdvisor_id'],

            ]
        );

        $salesCode = 'SOB' . Auth::user()->BranchID . str_pad($id, 9, "0", STR_PAD_LEFT);

        Salesorder::where('id', $id)
            ->update(['SalesNo' => $salesCode]);

        if ($data['invoice_payment_type'] == 5) {//paid by membership
            $member = Member::select('members.CreditBalance', 'members.ID AS MemberID')
                        ->where('members.Code', $data['MemberCode'])
                        ->first();

            $totalAmount = (float) $member->CreditBalance - (float) $data['invoice_GrossTotal'];

            $id2 = Membercreditledger::insertGetId(
                [
                    'MemberID' => $member->MemberID,
                    'SalesOrderID' => $id,
                    'CreditUsed' => $data['invoice_GrossTotal'],
                    'RunningBalance' => $member->CreditBalance,
                ]
            );

            Member::where('members.Code', $data['MemberCode'])
                ->update(['members.CreditBalance' => $totalAmount]);
        }

        $length = count($data['invoice_productCode']);
        for ($i = 0; $i < $length; $i++) {


            $sodid = Salesorderdetail::insertGetId(
                [
                    'SalesOrderID' => $id,
                    'ProductCode' => $data['invoice_productCode'][$i],
                    'ProductName' => $data['invoice_productName'][$i],
                    'UnitPrice' => $data['invoice_GrossTotal'],
                    'UnitPriceIncludeGST' => 0,
                    'Quantity' => $data['invoice_product_quantity'][$i],
                    'Discount' => $data['invoice_productDiscount'][$i],
                    'GSTRate' => 0,
                    'GSTExempted' => 0,
                    'GST' => 0,
                    'Total' => $data['invoice_GrossTotal'],
                ]
            );

            $seid = Service::insertGetId(
                [
                    'WarrantyPeriod' => 0,
                    'ServiceCategoryID' => $data['invoice_productID'][$i],
                    'ColorID' => NULL,
                    'MaintenanceCount' => 0,
                ]
            );

            if ($data['invoice_productID'][$i] == 2)
                $JobQueueID = 2;
            else
                $JobQueueID = 1;
            $jid = Job::insertGetId(
                [
                    'Status' => 5,
                    'StartDate' => Carbon::now()->toDateTimeString(),
                    'ETA' => Carbon::now()->toDateTimeString(),
                    'ClientID' => $data['ClientID'],
                    'VehicleID' => Vehicle::getVehicleByRegNo($data['RegistrationNo'])->ID,
                    'JobQueueID' => $JobQueueID,
                    'SalesOrderID' => $id,
                    'SalesAdvisorID' => $data['salesAdvisor_id'],
                    'Remarks' => $data['remarks'],
                ]
            );

            Jobdetail::insert(
                [
                    'ServiceID' => $seid,
                    'JobID' => $jid,
                    'SalesOrderDetailID' => $sodid,
                ]
            );                
        }
       

        return redirect()->route('pending');
    }

    public function UpdateEditJob(request $request) {

        $data = $request->all();

        $member = Member::select('CreditBalance')
                    ->where('ClientID', '=', $data['ClientID'])
                    ->first();

        $driverId = 0;

        if ($data['driver_id'] != null) {
            $driverId = $data['driver_id'];
        }

        $id = Salesorder::insertGetId(
            [
                'GrossTotal' => $data['invoice_GrossTotal'],
                'PaymentTypeID' => $data['invoice_payment_type'],
                'ClientID' => $data['ClientID'],
                'GSTRate' => 6,
                'GST' => $data['invoice_GST'],
                'Paid' => $data['invoice_paid'],
                'Due' => $data['invoice_due'],
                'BranchID' => Auth::user()->BranchID,
                'CreatedBy' => Auth::user()->id,
                'ClosedBy' => Auth::user()->id,
                'VehicleID' => $data['VehicleID'],
                'VehicleRegistrationNo' => $data['RegistrationNo'],
                'TechnicianID' => $data['technician_id'],
                'SalesAdvisorID' => $data['salesAdvisor_id'],
                'DriverID' => $driverId,
            ]
        );

        $salesCode = 'SOB' . Auth::user()->BranchID . str_pad($id, 9, "0", STR_PAD_LEFT);

        Salesorder::where('id', $id)
            ->update(['SalesNo' => $salesCode]);

        if ($data['invoice_payment_type'] == 5) {//paid by membership
            $member = null;

            if ($driverId == 0) {
                $member = Member::select('members.CreditBalance', 'members.ID AS MemberID')
                        ->where('members.Code', $data['MemberCode'])
                        ->first();
            }
            else {
                $member = Member::select('members.CreditBalance', 'members.ID AS MemberID')
                        ->where('members.ClientID', $driverId)
                        ->first();
            }

            $totalAmount = (float) $member->CreditBalance - (float) $data['invoice_GrossTotal'];

            $id2 = Membercreditledger::insertGetId(
                [
                    'MemberID' => $member->MemberID,
                    'SalesOrderID' => $id,
                    'CreditUsed' => $data['invoice_GrossTotal'],
                    'RunningBalance' => $member->CreditBalance,
                ]
            );

            if ($driverId == 0) {
                Member::where('members.Code', $data['MemberCode'])
                ->update(['members.CreditBalance' => $totalAmount]);
            }
            else {
                Member::where('members.ClientID', $driverId)
                ->update(['members.CreditBalance' => $totalAmount]);
            }
            
        }

        $length = count($data['invoice_productCode']);
        for ($i = 0; $i < $length; $i++) {


            $sodid = Salesorderdetail::insertGetId(
                [
                    'SalesOrderID' => $id,
                    'ProductCode' => $data['invoice_productCode'][$i],
                    'ProductName' => $data['invoice_productName'][$i],
                    'UnitPrice' => $data['invoice_GrossTotal'],
                    'UnitPriceIncludeGST' => 0,
                    'Quantity' => $data['invoice_product_quantity'][$i],
                    'Discount' => $data['invoice_productDiscount'][$i],
                    'GSTRate' => 0,
                    'GSTExempted' => 0,
                    'GST' => 0,
                    'Total' => $data['invoice_GrossTotal'],
                ]
            );

            $seid = Service::insertGetId(
                [
                    'WarrantyPeriod' => 0,
                    'ServiceCategoryID' => $data['invoice_productID'][$i],
                    'ColorID' => NULL,
                    'MaintenanceCount' => 0,
                ]
            );

            if ($data['invoice_productID'][$i] == 2)
                $JobQueueID = 2;
            else
                $JobQueueID = 1;
            $jid = Job::insertGetId(
                [
                    'Status' => 5,
                    'StartDate' => Carbon::now()->toDateTimeString(),
                    'ETA' => Carbon::now()->toDateTimeString(),
                    'ClientID' => $data['ClientID'],
                    'VehicleID' => Vehicle::getVehicleByRegNo($data['RegistrationNo'])->ID,
                    'JobQueueID' => $JobQueueID,
                    'SalesOrderID' => $id,
                    'SalesAdvisorID' => $data['salesAdvisor_id'],
                    'Remarks' => $data['remarks'],
                ]
            );

            Jobdetail::insert(
                [
                    'ServiceID' => $seid,
                    'JobID' => $jid,
                    'SalesOrderDetailID' => $sodid,
                    'DriverID' => $data['driver_id'],
                ]
            );                
        }
       

        return redirect()->route('pending');
    }

}

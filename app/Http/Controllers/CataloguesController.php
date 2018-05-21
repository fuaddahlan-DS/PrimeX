<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RolesAccessController;
use Auth;

class CataloguesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function merchandises() {
 		$returnView = 'catalogues.merchandises';
    	$allow = RolesAccessController::checkCataloguesViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

	 	if(request()->has('search')){
			$keyword = request()->input('search');
			$merchandises = DB::table('merchandises')
				->select('merchandises.ID', 'merchandises.Name', 'merchandises.Description', 'merchandises.NormalPrice', 'merchandises.MembersPrice')
	    		->where('merchandises.Name', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('merchandises.Description', 'like', '%'.$keyword.'%')
	    		->orderBy('merchandises.ID', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$merchandises = DB::table('merchandises')
				->select('merchandises.ID', 'merchandises.Name', 'merchandises.Description', 'merchandises.NormalPrice', 'merchandises.MembersPrice')
				->orderBy('merchandises.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

		$uoms = DB::table('units')
				->select('units.ID', 'units.Name')
	    		->orderBy('units.ID', 'ASC')
	    		->get();

     	return view($returnView,compact('merchandises', 'uoms'));
 	}

 	public function getMerchandisesDetails(request $request){
    	try{

	    	$data = $request->all();
		    
		    $merchandises = DB::table('merchandises')
		    	->select('merchandises.ID', 'merchandises.Name', 'merchandises.Description', 'merchandises.NormalPrice', 'merchandises.MembersPrice', 'merchandises.UnitID', 'merchandises.IncludeGST')
		    	->where('merchandises.ID', $data['id'])
		    	->first();

	    	if ($merchandises) {
	    		$result = array(
	                'status' => true,
	                'message' => 'success',
	                'merchandises' => $merchandises,
	            );

	    	}
	    	else {
	    		$result = array(
	                'status' => false,
	                'message' => 'Invalid Merchandise!',
	            );
	    	}
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }    

    public function addMerchandises(request $request){

    	try{
	    	$data = $request->all();

	    	$id = DB::table('merchandises')->insertGetId(
		        [
		            'Name' => strtoupper($data['add-name']),
		            'Description' => strtoupper($data['add-description']),
		            'NormalPrice' => $data['add-normalprice'],
		            'MembersPrice' => $data['add-membersprice'],
		            'UnitID' => $data['add-uomid'],
		            'IncludeGST' => (($data['add-includegst'] == 'on') ? '1' : '0'),
		        ]
            );

            $result = array(
                'status' => true,
                'message' => 'success',
                'data' => array('merchandiseName'=>strtoupper($data['add-name'])),
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

 	public function updateMerchandises(request $request){

    	try{
	    	$data = $request->all();

	    	$merchandises = DB::table('merchandises')
	    		->select('merchandises.ID')
	    		->where('merchandises.ID', $data['update-hidden-id'])
	    		->first();

    		$includeGST = 0;

    		try{
    			$includeGST = (($data['update-includegst'] == 'on') ? 1 : 0);
    		}
    		catch (\Exception $ext) {
    			$includeGST = 0;
    		}

	    	if($merchandises){
		    	$id = DB::table('merchandises')->where('ID', $data['update-hidden-id'])->update(
		                [
		                    'Name' => strtoupper($data['update-name']),
		                    'Description' => strtoupper($data['update-description']),
		                    'NormalPrice' => $data['update-normalprice'],
		                    'MembersPrice' => $data['update-membersprice'],
		                    'UnitID' => $data['update-uomid'],
		                    'IncludeGST' => $includeGST,
		                ]
		            );
		    	$result = array(
	                'status' => true,
	                'message' => 'Merchandise record (' . $data['update-name'] . ') successfully updated!',
	            );
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Invalid Merchandise!',
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




    public function services() {
 		$returnView = 'catalogues.services';
    	$allow = RolesAccessController::checkCataloguesViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

	 	if(request()->has('search')){
			$keyword = request()->input('search');
			$services = DB::table('services')
				->select('services.ID', 'services.Name AS ServName', 'servicecategories.Name', 'services.WarrantyPeriod')
				->join('servicecategories', 'services.ServiceCategoryID', '=', 'servicecategories.ID')
	    		->where('servicecategories.Name', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('services.Name', 'like', '%'.$keyword.'%')
	    		->orderBy('services.ID', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$services = DB::table('services')
				->select('services.ID', 'services.Name AS ServName', 'servicecategories.Name', 'services.WarrantyPeriod')
				->join('servicecategories', 'services.ServiceCategoryID', '=', 'servicecategories.ID')
				->orderBy('services.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

		$servicecategories = DB::table('servicecategories')
			->select('servicecategories.ID', 'servicecategories.Name')
			->orderBy('servicecategories.ID', 'ASC')
			->get();

		$colors = DB::table('colors')
			->select('colors.ID', 'colors.Name')
			->orderBy('colors.ID', 'ASC')
			->get();

		$vehicletypes = DB::table('vehicletypes')
			->select('vehicletypes.ID', 'vehicletypes.Name')
			->orderBy('vehicletypes.ID', 'ASC')
			->get();

     	return view($returnView,compact('services', 'servicecategories', 'colors', 'vehicletypes'));
 	}

 	public function servicesView($serviceid) {
 		$returnView = 'catalogues.servicesView';
    	$allow = RolesAccessController::checkCataloguesViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

		$servicesView = DB::table('services')
			->select('services.ID', 'services.Name AS ServName', 'servicecategories.Name', 'services.WarrantyPeriod', 'services.MaintenanceCount', 'colors.Name AS ColorName', 'colors.ID AS ColorID', 'services.ServiceCategoryID')
			->join('servicecategories', 'services.ServiceCategoryID', '=', 'servicecategories.ID')
			->leftJoin('colors', 'services.ColorID', '=', 'colors.ID')
    		->where('services.ID', '=', $serviceid)
    		->orderBy('services.ID', 'ASC')
    		->first();

		$servicesViewPricing = DB::table('productprices')
			->select('productprices.ID', 'productprices.MemberPrice', 'productprices.NormalPrice', 'vehicletypes.Name')
			->join('vehicletypes', 'productprices.VehicleTypeID', '=', 'vehicletypes.ID')
    		->where('productprices.ServicesID', '=', $serviceid)
    		->orderBy('productprices.ID', 'ASC')
    		->get();

		$servicecategories = DB::table('servicecategories')
			->select('servicecategories.ID', 'servicecategories.Name')
			->orderBy('servicecategories.ID', 'ASC')
			->get();

		$colors = DB::table('colors')
			->select('colors.ID', 'colors.Name')
			->orderBy('colors.ID', 'ASC')
			->get();

		$vehicletypes = DB::table('vehicletypes')
			->select('vehicletypes.ID', 'vehicletypes.Name')
			->orderBy('vehicletypes.ID', 'ASC')
			->get();

     	return view($returnView,compact('servicesView', 'servicesViewPricing', 'servicecategories', 'colors', 'vehicletypes'));
 	}

 	public function getServicesDetails(request $request){
    	try{

	    	$data = $request->all();
		    
		    $services = DB::table('services')
		    	->select('services.ID', 'services.Name', 'services.Description', 'services.WarrantyPeriod', 'services.ServiceCategoryID', 'services.ColorID', 'services.MaintenanceCount')
		    	->where('services.ID', $data['id'])
		    	->first();

	    	$productprices = DB::table('productprices')
	    		->select('productprices.ID', 'productprices.NormalPrice', 'productprices.MemberPrice', 'productprices.VehicleTypeID')
	    		->where('productprices.ServicesID', $data['id'])
	    		->get();

	    	if ($services) {
	    		$result = array(
	                'status' => true,
	                'message' => 'success',
	                'services' => $services,
	                'productprices' => $productprices,
	            );

	    	}
	    	else {
	    		$result = array(
	                'status' => false,
	                'message' => 'Invalid Service!',
	            );
	    	}
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }    

    public function addServices(request $request){

    	try{
	    	$data = $request->all();

	    	$id = DB::table('services')->insertGetId(
		        [
		            'Name' => strtoupper($data['add-name']),
		            'Description' => strtoupper($data['add-description']),
		            'WarrantyPeriod' => (($data['add-warranty'] == '') ? '0' : $data['add-warranty']),
		            'ServiceCategoryID' => $data['add-servicecategory'],
		            'ColorID' => $data['add-color'],
		            'MaintenanceCount' => (($data['add-maintenance'] == '') ? '0' : $data['add-maintenance']),
		        ]
            );

            $vehicletypes = DB::table('vehicletypes')
			->select('vehicletypes.ID', 'vehicletypes.Name')
			->orderBy('vehicletypes.ID', 'ASC')
			->get();

			foreach ($vehicletypes as $vehicletype) {
				if ($data['add-pp-np-' . $vehicletype->ID] != 00 && $data['add-pp-mp-' . $vehicletype->ID] != 00) {
					
					$id2 = DB::table('productprices')->insertGetId(
				        [
				            'NormalPrice' => $data['add-pp-np-' . $vehicletype->ID],
				            'MemberPrice' => $data['add-pp-mp-' . $vehicletype->ID],
				            'VehicleTypeID' => $vehicletype->ID,
				            'BranchID' => 1,
				            'Active' => 1,
				            'ServicesID' => $id,
				        ]
			        );					
				}            
			}

            $result = array(
                'status' => true,
                'message' => 'success',
                'data' => array('servicesName'=>strtoupper($data['add-name'])),
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

 	public function updateServices(request $request){

    	try{
	    	$data = $request->all();

	    	$merchandises = DB::table('services')
	    		->select('services.ID')
	    		->where('services.ID', $data['update-hidden-id'])
	    		->first();

	    	if($merchandises){
		    	$id = DB::table('services')->where('ID', $data['update-hidden-id'])->update(
		                [
		                    'Name' => strtoupper($data['update-name']),
		                    'Description' => strtoupper($data['update-description']),
		                    'WarrantyPeriod' => $data['update-warranty'],
		                    'ServiceCategoryID' => $data['update-servicecategory'],
		                    'ColorID' => $data['update-color'],
		                    'MaintenanceCount' =>  $data['update-maintenance'],
		                ]
		            );

		    	$vehicletypes = DB::table('vehicletypes')
					->select('vehicletypes.ID', 'vehicletypes.Name')
					->orderBy('vehicletypes.ID', 'ASC')
					->get();

				foreach ($vehicletypes as $vehicletype) {
					if ($data['update-pp-np-' . $vehicletype->ID] != 00 && $data['update-pp-mp-' . $vehicletype->ID] != 00) {
						
						$id2 = DB::table('productprices')->where('ServicesID', $data['update-hidden-id'])->where('VehicleTypeID', $vehicletype->ID)->update(
					        [
					            'NormalPrice' => $data['update-pp-np-' . $vehicletype->ID],
					            'MemberPrice' => $data['update-pp-mp-' . $vehicletype->ID],
					            'VehicleTypeID' => $vehicletype->ID,
					            'BranchID' => 1,
					            'Active' => 1,
					        ]
				        );					
					}            
				}

		    	$result = array(
	                'status' => true,
	                'message' => 'Service record (' . $data['update-name'] . ') successfully updated!',
	            );
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Invalid Service!',
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
}
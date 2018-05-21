<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RolesAccessController;
use Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

 	public function serviceCategory() {
 		$returnView = 'settings.serviceCategory';
    	$allow = RolesAccessController::checkSettingsViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

	 	if(request()->has('search')){
			$keyword = request()->input('search');
			$serviceCategories = DB::table('servicecategories')
				->select('servicecategories.ID', 'servicecategories.Name', 'servicecategories.Description', 'servicecategories.ShowInHistory')
	    		->where('servicecategories.Name', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('servicecategories.Description', 'like', '%'.$keyword.'%')
	    		->orderBy('servicecategories.ID', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$serviceCategories = DB::table('servicecategories')
				->select('servicecategories.ID', 'servicecategories.Name', 'servicecategories.Description', 'servicecategories.ShowInHistory')
				->orderBy('servicecategories.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

     	return view($returnView,compact('serviceCategories'));
 	}

 	public function getServiceCategoryDetails(request $request){
    	try{

	    	$data = $request->all();
		    
		    $servicecategories = DB::table('servicecategories')
		    	->where('servicecategories.ID', $data['id'])
		    	->first();

		    $result = array(
	                'status' => true,
	                'message' => 'success',
	                'servicecategories' => $servicecategories,
	            );
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }    

    public function addServiceCategory(request $request){

    	try{
	    	$data = $request->all();

	    	$id = DB::table('servicecategories')->insertGetId(
		        [
		            'Name' => strtoupper($data['name']),
		            'Description' => strtoupper($data['description']),
		            'ShowInHistory' => $data['showinhistory'],
		        ]
            );

            $result = array(
                'status' => true,
                'message' => 'success',
                'data' => array('serviceCategoryName'=>strtoupper($data['name'])),
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

 	public function updateServiceCategory(request $request){

    	try{
	    	$data = $request->all();
	    	$serviceCategories = DB::table('servicecategories')
	    		->select('servicecategories.ID', 'servicecategories.Name', 'servicecategories.Description', 'servicecategories.ShowInHistory')
	    		->where('servicecategories.ID', $data['id'])
	    		->first();

	    	if($serviceCategories){
		    	$id = DB::table('servicecategories')->where('ID', $data['id'])->update(
		                [
		                    'Name' => strtoupper($data['name']),
		                    'Description' => strtoupper($data['description']),
		                    'ShowInHistory' => $data['showinhistory'],
		                ]
		            );
		    	$result = array(
	                'status' => true,
	                'message' => 'Service Category record ('.$serviceCategories->ID.') successfully updated!',
	            );
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Invalid Service Category!',
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




    public function vehicleTypes() {
    	$returnView = 'settings.vehicleTypes';
    	$allow = RolesAccessController::checkSettingsViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

	 	if(request()->has('search')){
			$keyword = request()->input('search');
			$vehicleTypes = DB::table('vehicletypes')
				->select('vehicletypes.ID', 'vehicletypes.Name', 'vehicletypes.Description', 'vehicletypes.Code')
	    		->where('vehicletypes.Name', 'like', '%'.strtolower($keyword).'%')
	    		->orWhere('vehicletypes.Description', 'like', '%'.strtolower($keyword).'%')
	    		->orWhere('vehicletypes.Code', 'like', '%'.strtolower($keyword).'%')
	    		->orderBy('vehicletypes.ID', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$vehicleTypes = DB::table('vehicletypes')
				->select('vehicletypes.ID', 'vehicletypes.Name', 'vehicletypes.Description', 'vehicletypes.Code')
				->orderBy('vehicletypes.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

     	return view($returnView,compact('vehicleTypes'));
 	}

 	public function getVehicleTypesDetails(request $request){
    	try{

	    	$data = $request->all();
		    
		    $vehicletypes = DB::table('vehicletypes')
		    	->where('vehicletypes.ID', $data['id'])
		    	->first();

		    $result = array(
	                'status' => true,
	                'message' => 'success',
	                'vehicletypes' => $vehicletypes,
	            );
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }    

    public function addVehicleTypes(request $request){

    	try{
	    	$data = $request->all();

	    	$id = DB::table('vehicletypes')->insertGetId(
		        [
		            'Name' => strtoupper($data['name']),
		            'Description' => strtoupper($data['description']),
		            'Code' => strtoupper($data['code']),
		        ]
            );

            $result = array(
                'status' => true,
                'message' => 'success',
                'data' => array('vehicleTypesName'=>strtoupper($data['name'])),
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

 	public function updateVehicleTypes(request $request){

    	try{
	    	$data = $request->all();
	    	$vehicleTypes = DB::table('vehicletypes')
	    		->select('vehicletypes.ID', 'vehicletypes.Name', 'vehicletypes.Description', 'vehicletypes.Code')
	    		->where('vehicletypes.ID', $data['id'])
	    		->first();

	    	if($vehicleTypes){
		    	$id = DB::table('vehicletypes')->where('ID', $data['id'])->update(
		                [
		                    'Name' => strtoupper($data['name']),
		                    'Description' => strtoupper($data['description']),
		                    'Code' => strtoupper($data['code']),
		                ]
		            );
		    	$result = array(
	                'status' => true,
	                'message' => 'Vehicle Types record ('.$vehicleTypes->ID.') successfully updated!',
	            );
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Invalid Vehicle Types!',
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



    public function unitOfMeasurement() {
    	$returnView = 'settings.unitOfMeasurement';
    	$allow = RolesAccessController::checkSettingsViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

	 	if(request()->has('search')){
			$keyword = request()->input('search');
			$unitOfMeasurement = DB::table('units')
				->select('units.ID', 'units.Name', 'units.Description', 'units.Code')
	    		->where('units.Name', 'like', '%'.strtolower($keyword).'%')
	    		->orWhere('units.Description', 'like', '%'.strtolower($keyword).'%')
	    		->orWhere('units.Code', 'like', '%'.strtolower($keyword).'%')
	    		->orderBy('units.ID', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$unitOfMeasurement = DB::table('units')
				->select('units.ID', 'units.Name', 'units.Description', 'units.Code')
				->orderBy('units.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

     	return view($returnView,compact('unitOfMeasurement'));
 	}

 	public function getUnitOfMeasurementDetails(request $request){
    	try{

	    	$data = $request->all();
		    
		    $unitofmeasurement = DB::table('units')
		    	->where('units.ID', $data['id'])
		    	->first();

		    $result = array(
	                'status' => true,
	                'message' => 'success',
	                'unitofmeasurement' => $unitofmeasurement,
	            );
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }    

    public function addUnitOfMeasurement(request $request){

    	try{
	    	$data = $request->all();

	    	$id = DB::table('units')->insertGetId(
		        [
		            'Name' => strtoupper($data['name']),
		            'Description' => strtoupper($data['description']),
		            'Code' => strtolower($data['code']),
		        ]
            );

            $result = array(
                'status' => true,
                'message' => 'success',
                'data' => array('unitOfMeasurementName'=>strtoupper($data['name'])),
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

 	public function updateUnitOfMeasurement(request $request){

    	try{
	    	$data = $request->all();
	    	$unitOfMeasurement = DB::table('units')
	    		->select('units.ID', 'units.Name', 'units.Description', 'units.Code')
	    		->where('units.ID', $data['id'])
	    		->first();

	    	if($unitOfMeasurement){
		    	$id = DB::table('units')->where('ID', $data['id'])->update(
		                [
		                    'Name' => strtoupper($data['name']),
		                    'Description' => strtoupper($data['description']),
		                    'Code' => strtolower($data['code']),
		                ]
		            );
		    	$result = array(
	                'status' => true,
	                'message' => 'Unit Of Measurement record ('.$unitOfMeasurement->ID.') successfully updated!',
	            );
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Invalid Unit Of Measurement!',
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




    public function color() {
    	$returnView = 'settings.color';
    	$allow = RolesAccessController::checkSettingsViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

	 	if(request()->has('search')){
			$keyword = request()->input('search');
			$colors = DB::table('colors')
				->select('colors.ID', 'colors.Name', 'colors.Code', 'colors.Active')
	    		->where('colors.Name', 'like', '%'.strtolower($keyword).'%')
	    		->orWhere('colors.Code', 'like', '%'.strtolower($keyword).'%')
	    		->orderBy('colors.ID', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$colors = DB::table('colors')
				->select('colors.ID', 'colors.Name', 'colors.Code')
				->orderBy('colors.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

     	return view($returnView,compact('colors'));
 	}

 	public function getColorDetails(request $request){
    	try{

	    	$data = $request->all();
		    
		    $colors = DB::table('colors')
		    	->where('colors.ID', $data['id'])
		    	->first();

		    $result = array(
	                'status' => true,
	                'message' => 'success',
	                'colors' => $colors,
	            );
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
	    return json_encode($result);

    }    

    public function addColor(request $request){

    	try{
	    	$data = $request->all();

	    	$id = DB::table('colors')->insertGetId(
		        [
		            'Name' => strtoupper($data['name']),
		            'Code' => strtolower($data['code']),
		            'Active' => 1,
		        ]
            );

            $result = array(
                'status' => true,
                'message' => 'success',
                'data' => array('colorName'=>strtoupper($data['name'])),
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

 	public function updateColor(request $request){

    	try{
	    	$data = $request->all();
	    	$colors = DB::table('colors')
	    		->select('colors.ID', 'colors.Name', 'colors.Code')
	    		->where('colors.ID', $data['id'])
	    		->first();

	    	if($colors){
		    	$id = DB::table('colors')->where('ID', $data['id'])->update(
		                [
		                    'Name' => strtoupper($data['name']),
		                    'Code' => strtolower($data['code']),
		                ]
		            );
		    	$result = array(
	                'status' => true,
	                'message' => 'Color record ('.$colors->ID.') successfully updated!',
	            );
		    }else{
		    	$result = array(
	                'status' => false,
	                'message' => 'Invalid Color!',
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

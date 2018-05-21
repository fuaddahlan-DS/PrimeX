<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RolesAccessController;
use Auth;

class AccountSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function roles() {
    	$returnView = 'accountsettings.roles';
    	$allow = RolesAccessController::checkAccountSettingsViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

    	if(request()->has('search')){
			$keyword = request()->input('search');
			$roles = DB::table('roles')
				->select('roles.ID', 'roles.Name', 'roles.Description')
	    		->where('roles.Name', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('roles.Description', 'like', '%'.strtoupper($keyword).'%')
	    		->orderBy('roles.ID', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$roles = DB::table('roles')
				->select('roles.ID', 'roles.Name', 'roles.Description')
				->orderBy('roles.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

		$rolespermissions = DB::table('rolespermissions')
				->select('rolespermissions.ID', 'rolespermissions.Name')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

     	return view($returnView,compact('roles', 'rolespermissions'));
    }

    public function addRoles(request $request) {
    	$data = $request->all();

    	$roleName = $data['add-name'];
    	$roleDescription = $data['add-description'];

    	$rolespermissions = DB::table('rolespermissions')
			->select('rolespermissions.ID', 'rolespermissions.Name')
			->orderBy('rolespermissions.Ordering', 'ASC')
			->get();

		try{
			$id = DB::table('roles')->insertGetId(
		        [
		            'Name' => strtoupper($roleName),
		            'Description' => strtoupper($roleDescription),
		        ]
	        );

			if ($rolespermissions) {
				foreach ($rolespermissions as $rolespermission) {
					$create = 0;
					$view = 0;
					$update = 0;
					$delete = 0;

					try {
						if ($data[$rolespermission->ID]['1'] == "on") {
							$create = 1;
						}
					}
					catch (\Exception $e) {
						$create = 0;	
					}

					try {
						if ($data[$rolespermission->ID]['2'] == "on") {
							$view = 1;
						}
					}
					catch (\Exception $e) {
						$view = 0;
					}

					try {
						if ($data[$rolespermission->ID]['3'] == "on") {
							$update = 1;
						}
					}
					catch (\Exception $e) {
						$update = 0;
					}

					try {
						if ($data[$rolespermission->ID]['4'] == "on") {
							$delete = 1;
						}
					}
					catch (\Exception $e) {
						$delete = 0;
					}

					//if ($create == 0 && $view == 0 && $update == 0 && $delete == 0) {
					//
					//}
					//else {
						$id2 = DB::table('rolespermissionsjoin')->insertGetId(
					        [
					            'RolesID' => $id,
					            'RolesPermissionsID' => $rolespermission->ID,
					            'PermissionCreate' => $create,
					            'PermissionView' => $view,
					            'PermissionUpdate' => $update,
					            'PermissionDelete' => $delete,
					        ]
				        );
						
					//}

				}
			}

	        $result = array(
	            'status' => true,
	            'message' => 'success',
	            'data' => array('roleName'=>strtoupper($roleName)),
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

    public function getRolesById($id) {
    	$returnView = 'accountsettings.getRolesById';
    	$allow = RolesAccessController::checkAccountSettingsViewAllow();

    	try {
    		$roles = DB::table('roles')
				->select('roles.ID', 'roles.Name', 'roles.Description')
	    		->where('roles.ID', '=', $id)
	    		->first();

			$rolespermissionsjoin = DB::table('rolespermissionsjoin')
				->select('rolespermissionsjoin.ID', 'rolespermissionsjoin.RolesID', 'rolespermissionsjoin.RolesPermissionsID', 'rolespermissions.Name', 'rolespermissionsjoin.PermissionCreate', 'rolespermissionsjoin.PermissionView', 'rolespermissionsjoin.PermissionUpdate', 'rolespermissionsjoin.PermissionDelete')
				->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
				->where('rolespermissionsjoin.RolesID', '=', $roles->ID)
				->orderBy('rolespermissions.Ordering', 'ASC')
				->get();


			if ($roles) {
		    	if ($allow == false) {
	    			$returnView = 'errors.accessdenied';
	    		}
			}
			else {
				$returnView = 'errors.404';
			}
    	}
    	catch (Exception $ex) {
    		$returnView = 'errors.404';
    	}

		return view($returnView, compact('roles', 'rolespermissionsjoin'));
    }

    public function updateRolesById(request $request) {
    	$data = $request->all();

    	$roleId = $data['update-id-hidden'];
    	$roleName = $data['update-name'];
    	$roleDescription = $data['update-description'];

    	$roles = DB::table('roles')
			->select('roles.ID', 'roles.Name', 'roles.Description')			
	    	->where('roles.ID', $roleId)
	    	->first();

    	$rolespermissionsjoin = DB::table('rolespermissionsjoin')
			->select('rolespermissionsjoin.ID', 'rolespermissionsjoin.RolesID', 'rolespermissionsjoin.RolesPermissionsID', 'rolespermissionsjoin.PermissionCreate', 'rolespermissionsjoin.PermissionView', 'rolespermissionsjoin.PermissionUpdate', 'rolespermissionsjoin.PermissionDelete', 'rolespermissions.Name')
			->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
			->where('rolespermissionsjoin.RolesID', '=', $roleId)
			->orderBy('rolespermissions.ID', 'ASC')
			->get();

		try{
	        $id = DB::table('roles')->where('ID', $roleId)->update(
                [
                    'Name' => strtoupper($roleName),
                    'Description' => strtoupper($roleDescription),
                ]
            );

			if ($rolespermissionsjoin) {
				foreach ($rolespermissionsjoin as $rolespermission) {
					$create = 0;
					$view = 0;
					$update = 0;
					$delete = 0;

					try {
						if ($data[$rolespermission->ID]['1'] == "on") {
							$create = 1;
						}
					}
					catch (\Exception $e) {
						$create = 0;	
					}

					try {
						if ($data[$rolespermission->ID]['2'] == "on") {
							$view = 1;
						}
					}
					catch (\Exception $e) {
						$view = 0;
					}

					try {
						if ($data[$rolespermission->ID]['3'] == "on") {
							$update = 1;
						}
					}
					catch (\Exception $e) {
						$update = 0;
					}

					try {
						if ($data[$rolespermission->ID]['4'] == "on") {
							$delete = 1;
						}
					}
					catch (\Exception $e) {
						$delete = 0;
					}

					//if ($create == 0 && $view == 0 && $update == 0 && $delete == 0) {
					//
					//}
					//else {
				        $id2 = DB::table('rolespermissionsjoin')->where('ID', $rolespermission->ID)->update(
			                [
					            'PermissionCreate' => $create,
					            'PermissionView' => $view,
					            'PermissionUpdate' => $update,
					            'PermissionDelete' => $delete,
			                ]
			            );
						
					//}

				}

				$result = array(
	                'status' => true,
	                'message' => 'Roles record ('.$roles->Name.') successfully updated!',
	            );
			}
			else {
				$result = array(
	                'status' => false,
	                'message' => 'Invalid Role!',
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

    public function getRolesDetails(request $request) {
    	try{
	    	$data = $request->all();
		    
		    $roles = DB::table('roles')
		    	->select('roles.ID', 'roles.Name', 'roles.Description')
		    	->where('roles.ID', $data['id'])
		    	->first();

    		$rolespermissionsjoin = DB::table('rolespermissionsjoin')
				->select('rolespermissionsjoin.ID', 'rolespermissionsjoin.RolesID', 'rolespermissionsjoin.RolesPermissionsID', 'rolespermissionsjoin.PermissionCreate', 'rolespermissionsjoin.PermissionView', 'rolespermissionsjoin.PermissionUpdate', 'rolespermissionsjoin.PermissionDelete', 'rolespermissions.Name')
				->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
				->where('rolespermissionsjoin.RolesID', '=', $data['id'])
				->orderBy('rolespermissions.ID', 'ASC')
				->get();

		    $result = array(
	                'status' => true,
	                'message' => 'success',
	                'roles' => $roles,
	                'rolespermissionsjoin' => $rolespermissionsjoin,
	            );
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }

	    return json_encode($result);

    }

    public function users() {
    	$returnView = 'accountsettings.users';
    	$allow = RolesAccessController::checkAccountSettingsViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

    	if(request()->has('search')){
			$keyword = request()->input('search');
			$users = DB::table('users')
				->select('users.id', 'users.name', 'users.email', 'roles.Name AS RoleName')
				->leftJoin('roles', 'roles.ID', '=', 'users.roleID')
	    		->where('users.name', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('users.email', 'like', '%'.strtoupper($keyword).'%')
	    		->orderBy('users.id', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$users = DB::table('users')
				->select('users.id', 'users.name', 'users.email', 'roles.Name AS RoleName')
				->leftJoin('roles', 'roles.ID', '=', 'users.roleID')
				->orderBy('users.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

		$branches = DB::table('branches')
			->select('branches.ID', 'branches.Name')
			->orderBy('branches.ID', 'ASC')
			->get();

		$roles = DB::table('roles')
			->select('roles.ID', 'roles.Name')
			->orderBy('roles.ID', 'ASC')
			->get();

     	return view($returnView,compact('users', 'branches', 'roles'));
    }

    public function addUsers(request $request) {
    	try{
    		$data = $request->all();

    		$name = $data['add-name'];
    		$password = $data['add-password'];
    		$email = $data['add-email'];
    		$branchId = $data['add-branchid'];
    		$roleId = $data['add-roleid'];

    		$users = DB::table('users')
			->select('users.id')
			->where('users.id', '=', $email)
			->orderBy('users.ID', 'ASC')
			->first();

			if (!$users) {
				$id = DB::table('users')->insertGetId(
			        [
			            'name' => strtoupper($name),
			            'password' => bcrypt($password),
			            'email' => $email,
			            'BranchID' => $branchId,
			            'roleID' => $roleId,
			        ]
		        );

				$result = array(
	                'status' => true,
	                'message' => 'success',
	                'data' => array('usersName'=>strtoupper($name)),
	            );
			}
			else {
				$result = array(
	                'status' => false,
	                'message' => 'User (' . $email . ') already in database',
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

    public function getUsersById($id) {
    	$returnView = 'accountsettings.getUsersById';
    	$allow = RolesAccessController::checkAccountSettingsViewAllow();    	
    	$usersid = $id;

    	try {
    		$users = DB::table('users')
    			->select('users.id', 'users.name', 'users.email', 'roles.ID AS roleID', 'roles.Name AS RoleName', 'branches.ID AS branchID', 'branches.Name AS BranchName')
    			->leftJoin('roles', 'roles.ID', '=', 'users.roleID')
    			->leftJoin('branches', 'branches.ID', '=', 'users.BranchID')
    			->where('users.id', '=', $id)
    			->orderBy('users.id', 'ASC')
    			->first();

			$branches = DB::table('branches')
				->select('branches.ID', 'branches.Name')
				->orderBy('branches.ID', 'ASC')
				->get();

			$roles = DB::table('roles')
				->select('roles.ID', 'roles.Name')
				->orderBy('roles.ID', 'ASC')
				->get();

    		if ($users) {
    			if ($allow == false) {
    				$returnView = 'errors.accessdenied';
    			}
			}
			else {
				$returnView = 'errors.404';
			}
    	}
    	catch (Exception $ex) {
    		$returnView = 'errors.404';
    	}
		
		return view($returnView, compact('users', 'usersid', 'branches', 'roles'));
    }

    public function updateUsers(request $request) {
    	try {
    		$data = $request->all();

    		$id = $data['update-id'];
    		$name = $data['update-name'];
    		$email = $data['update-email'];
    		$password = $data['update-password'];
    		$branchId = $data['update-branchid'];
    		$roleId = $data['update-roleid'];

    		$users = DB::table('users')
    			->select('users.id')
    			->where('users.id', '=', $id)
    			->orderBy('users.id', 'ASC')
    			->first();

			if ($users) {
				if ($password != "******") {
					$id2 = DB::table('users')->where('id', $id)->update(
		                [
		                	'name' => $name,
				            'password' => bcrypt($password),
		                	'email' => $email,
		                	'BranchID' => $branchId,
		                	'roleID' => $roleId,
		                ]
		            );
				}
				else {
					$id2 = DB::table('users')->where('id', $id)->update(
		                [
		                	'name' => $name,
		                	'email' => $email,
		                	'BranchID' => $branchId,
		                	'roleID' => $roleId,
		                ]
		            );
				}

				$result = array(
	                'status' => true,
	                'message' => 'success',
	                'data' => array('usersName'=>strtoupper($name)),
	            );
			}
			else {
	    		$result = array(
	                'status' => false,
	                'message' => 'Invalid User!',
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

    public function branches() {
    	$returnView = 'accountsettings.branches';
    	$allow = RolesAccessController::checkAccountSettingsViewAllow();
    	
    	if ($allow == false) {
    		$returnView = 'errors.accessdenied';
    	}

    	if(request()->has('search')){
			$keyword = request()->input('search');
			$branches = DB::table('branches')
				->select('branches.ID', 'branches.Name', 'branches.PhoneNo', 'branches.FaxNo', 'branches.Email', 'branches.SEOName')
	    		->where('branches.Name', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('branches.PhoneNo', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('branches.FaxNo', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('branches.Email', 'like', '%'.strtoupper($keyword).'%')
	    		->orWhere('branches.SEOName', 'like', '%'.strtolower($keyword).'%')
	    		->orderBy('branches.ID', 'ASC')
	    		->paginate(10);
		}else{
			//DB::enableQueryLog();
			$branches = DB::table('branches')
				->select('branches.ID', 'branches.Name', 'branches.PhoneNo', 'branches.FaxNo', 'branches.Email', 'branches.SEOName')
				->orderBy('branches.ID', 'ASC')
				->paginate(10);
			//dd(DB::getQueryLog());
		}

     	return view($returnView,compact('branches'));
    }

    public function addBranches(request $request) {
    	$data = $request->all();

    	$seoName = $data['add-seoname'];
    	$code = $data['add-code'];
    	$branchName = $data['add-name'];
    	$registrationNo = $data['add-registrationno'];
    	$phoneNo = $data['add-phoneno'];
    	$faxNo = $data['add-faxno'];
    	$address = $data['add-address'];
    	$email = $data['add-email'];
    	$gstNo = $data['add-gstno'];
    	$gstRate = $data['add-gstrate'];
    	$website = $data['add-website'];
    	$minProcess = $data['add-minprocess'];

    	$branches = DB::table('branches')
			->select('branches.Code', 'branches.SEOName')
			->where('branches.Code', '=', $code)
			->orWhere('branches.SEOName', '=', $seoName)
			->orderBy('branches.ID', 'ASC')
			->first();

		if ($branches) {
			if ($branches->SEOName == $seoName) {
				$result = array(
		            'status' => false,
		            'message' => 'Branch SEO Name (' . $seoName . ') has already added before!',
		        );	
			}
			else if ($branches->Code == $code) {
				$result = array(
		            'status' => false,
		            'message' => 'Branch Code (' . $code . ') has already added before!',
		        );				
			}
		}
		else {
			try{
				$id = DB::table('branches')->insertGetId(
			        [
			            'Name' => strtoupper($branchName),
			            'SEOName' => $seoName,
			            'Code' => strtoupper($code),
			            'Address' => strtoupper($address),
			            'PhoneNo' => strtoupper($phoneNo),
			            'FaxNo' => strtoupper($faxNo),
			            'Email' => $email,
			            'MinProcess' => strtoupper($minProcess),
			            'RegistrationNo' => strtoupper($registrationNo),
			            'GSTNo' => strtoupper($gstNo),
			            'GSTRate' => strtoupper($gstRate),
			            'Website' => $website,
			        ]
		        );

		        $result = array(
		            'status' => true,
		            'message' => 'success',
		            'data' => array('branchCode'=>strtoupper($code)),
		        );
	        }
		    catch (Exception $ex) {
	           	$result = array(
	                'status' => false,
	                'message' => $e->getMessage(),
	            );
	        }	        
		}

    	return json_encode($result);
    }

    public function getBranchesById($id) {
    	$returnView = 'accountsettings.getBranchesById';
    	$allow = RolesAccessController::checkAccountSettingsViewAllow();
    	
    	try {
    		$branches = DB::table('branches')
				->select('branches.ID', 'branches.Name', 'branches.SEOName', 'branches.Code', 'branches.Address', 'branches.PhoneNo', 'branches.FaxNo', 'branches.Email', 'branches.MinProcess', 'branches.RegistrationNo', 'branches.GSTNo', 'branches.GSTRate', 'branches.Website')
	    		->where('branches.ID', '=', $id)
	    		->first();

			$servicecategories = DB::table('servicecategories')
				->select('servicecategories.ID', 'servicecategories.Name')
	    		->get();

			$papersizes = DB::table('papersizes')
				->select('papersizes.ID', 'papersizes.Name')
	    		->get();

			$jobqueues = DB::table('jobqueues')
				->select('jobqueues.ID', 'jobqueues.Title', 'papersizes.Name AS PaperName')
				->leftJoin('papersizes', 'papersizes.ID', '=', 'jobqueues.ReceiptPaperSize')
	    		->where('jobqueues.BranchID', '=', $id)
	    		->get();

			if ($branches) {
				if ($allow == false) {
	    			$returnView = 'errors.accessdenied';
	    		}
			}
			else {
				$returnView = 'errors.404';
			}
    	}
    	catch (Exception $ex) {
    		$returnView = 'errors.404';
    	}
	
		return view($returnView, compact('branches', 'servicecategories', 'papersizes', 'jobqueues'));
    }

    public function getBranchesDetails(request $request) {
    	try{
	    	$data = $request->all();
		    
		    $branches = DB::table('branches')
		    	->select('branches.ID', 'branches.Name', 'branches.SEOName', 'branches.Code', 'branches.Address', 'branches.PhoneNo', 'branches.FaxNo', 'branches.Email', 'branches.MinProcess', 'branches.RegistrationNo', 'branches.GSTNo', 'branches.GSTRate', 'branches.Website')
		    	->where('branches.ID', $data['id'])
		    	->first();

		    $result = array(
	                'status' => true,
	                'message' => 'success',
	                'branches' => $branches,
	            );
	    }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }

	    return json_encode($result);

    }

    public function updateBranchesById(request $request) {
    	$data = $request->all();

    	$branchId = $data['update-id-hidden'];
    	$branchName = $data['update-name'];
    	$branchSEOName = $data['update-seoName'];
    	$branchCode = $data['update-code'];
    	$branchAddress = $data['update-address'];
    	$branchPhoneNo = $data['update-phoneNo'];
    	$branchFaxNo = $data['update-faxNo'];
    	$branchEmail = $data['update-email'];
    	$branchMinProcess = $data['update-minProcess'];
    	$branchRegistrationNo = $data['update-registrationNo'];
    	$branchGSTNo = $data['update-gstNo'];
    	$branchGSTRate = $data['update-gstRate'];
    	$branchWebsite = $data['update-website'];

    	$branches = DB::table('branches')
	    	->select('branches.ID')
	    	->where('branches.ID', $branchId)
	    	->first();

		try{
			if ($branches) {
		        $id = DB::table('branches')->where('ID', $branchId)->update(
	                [
	                    'Name' => strtoupper($branchName),
	                    'SEOName' => $branchSEOName,
	                    'Code' => strtoupper($branchCode),
	                    'Address' => strtoupper($branchAddress),
	                    'PhoneNo' => strtoupper($branchPhoneNo),
	                    'FaxNo' => strtoupper($branchFaxNo),
	                    'Email' => $branchEmail,
	                    'MinProcess' => $branchMinProcess,
	                    'RegistrationNo' => strtoupper($branchRegistrationNo),
	                    'GSTNo' => strtoupper($branchGSTNo),
	                    'GSTRate' => $branchGSTRate,
	                    'Website' => $branchWebsite,
	                ]
	            );

				$result = array(
	                'status' => true,
	                'message' => 'Branch record ('.$branchCode.') successfully updated!',
	            );
			}
			else {
				$result = array(
	                'status' => false,
	                'message' => 'Invalid Branch!',
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

    public function addJobQueue(request $request) {
    	$data = $request->all();

    	$title = $data['add-name'];
    	$branchId = $data['add-branchid'];
    	$papersizes = $data['add-papersizes'];
    	$servicecategories = $data['add-servicecategories'];

    	try{
    		foreach($papersizes as $papersizeid) {
	    		$papersize_id = $papersizeid;
    		}

			$id = DB::table('jobqueues')->insertGetId(
		        [
		            'Title' => strtoupper($title),
		            'HasWaitingQueue' => 1,
		            'Active' => 1,
		            'BranchID' => $branchId,
		            'ReceiptPaperSize' => $papersize_id,
		        ]
	        );

	        foreach($servicecategories as $servicecategoryid) {
    			$id2 = DB::table('jobqueuecategories')->insertGetId(
			        [
			            'JobQueueID' => $id,
			            'ServiceCategoryID' => $servicecategoryid,
			        ]
		        );
    		}	        

	        $result = array(
	            'status' => true,
	            'message' => 'success',
	            'data' => array('jobQueueName'=>strtoupper($title)),
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

    public static function getServiceCategoriesByJobQueueId($id) {
    	$jobqueuecategories = DB::table('jobqueuecategories')
		    	->select('jobqueuecategories.ID', 'servicecategories.Name')
		    	->leftJoin('servicecategories', 'servicecategories.ID', '=', 'jobqueuecategories.ServiceCategoryID')
		    	->where('jobqueuecategories.JobQueueID', $id)		    	
		    	->get();

    	$categories = '';

    	if ($jobqueuecategories) {
    		foreach ($jobqueuecategories as $jobqueuecategory) {
    			$categories .= $jobqueuecategory->Name . ', ';
    		}
    	}

    	return str_replace_last(', ', '', $categories);
    }

    public function getJobQueueDetails(request $request) {
    	try{
	    	$data = $request->all();

	    	$jobQueueId = $data['id'];

	    	$jobqueues = DB::table('jobqueues')
		    	->select('jobqueues.ID','jobqueues.Title', 'papersizes.ID AS PaperSizeID')
		    	->leftJoin('papersizes', 'papersizes.ID', '=', 'ReceiptPaperSize')
		    	->where('jobqueues.ID', $jobQueueId)
		    	->first();

	    	$jobqueuescategories = DB::table('jobqueuecategories')
		    	->select('jobqueuecategories.ID', 'servicecategories.ID AS ServiceCategoryID')
		    	->leftJoin('servicecategories', 'servicecategories.ID', '=', 'jobqueuecategories.ServiceCategoryID')
		    	->where('jobqueuecategories.JobQueueID', $jobQueueId)
		    	->get();

	    	if ($jobqueues) {

	    		$result = array(
		            'status' => true,
		            'message' => 'success',
		            'jobqueues' => $jobqueues,
		            'jobqueuescategories' => $jobqueuescategories,
		        );
	    	}
	    	else {
	    		$result = array(
		            'status' => false,
		            'message' => 'Invalid Job Queue!',
		        );
	    	}

	    	//$jobQueueTitle = $data['updatejobqueue-title'];
	    	//$jobQueueCategories = $data['update-servicecategories'];
	    	//$jobQueuePaperSizes = $data['update-papersizes'];

			
        }catch (Exception $ex) {
           	$result = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }

    	return json_encode($result);

    }

    public function updateJobQueue(request $request) {
    	$data = $request->all();

    	$jobQueueId = $data['update-jobqueue-id'];
    	$title = $data['updatejobqueue-title'];
    	$servicecategories = $data['update-servicecategories'];
    	$papersizes = $data['update-papersizes'];

    	try{
    		foreach($papersizes as $papersizeid) {
	    		$papersize_id = $papersizeid;
    		}

			$id = DB::table('jobqueues')->where('ID', $jobQueueId)->update(
		        [
		            'Title' => strtoupper($title),
		            'ReceiptPaperSize' => $papersize_id,
		        ]
	        );

			DB::table('jobqueuecategories')->where('JobQueueID', '=', $jobQueueId)->delete();

	        foreach($servicecategories as $servicecategoryid) {
    			$id2 = DB::table('jobqueuecategories')->insertGetId(
			        [
			            'JobQueueID' => $jobQueueId,
			            'ServiceCategoryID' => $servicecategoryid,
			        ]
		        );
    		}	        

	        $result = array(
	            'status' => true,
	            'message' => 'success',
	            'data' => array('jobQueueName'=>strtoupper($title)),
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

    public function deleteJobQueue(request $request) {
    	$data = $request->all();

    	$jobQueueId = $data['deletejobqueue-id'];

    	try{

    		DB::table('jobqueues')->where('ID', '=', $jobQueueId)->delete();
    		DB::table('jobqueuecategories')->where('JobQueueID', '=', $jobQueueId)->delete();

    		$result = array(
	            'status' => true,
	            'message' => 'success',
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
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Auth;

class RolesAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function checkAccountSettingsView() {
    	$script = '';
    	$totalSubMenu = 0;
    	$i = 0;

    	if (Auth::user()->roleID != 1) {
    		$totalSubMenu = DB::table('rolespermissions')
	    		->select('rolespermissions.ID')
	    		->where('rolespermissions.ParentName', '=', 'accountsettings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->count();

	    	$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 0)
	    		->where('rolespermissions.ParentName', '=', 'accountsettings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		$usersResultCount = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 0)
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->count();
			//dd(DB::getQueryLog());

			if ($users) {
				foreach ($users as $user) {
					$i++;
					$script .= '$("#accountsettings-' . str_replace_array(' ', ['-'], strtolower($user->Name)) . '").remove();';
				}

				if ($totalSubMenu == $i) {
					$script .= '$("#accountsettings").remove();';
				} 
			}
    	}

    	return $script;
    }

    public static function checkAccountSettingsViewAllow() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'accountsettings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkAccountSettingsCreate() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionCreate', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'accountsettings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkAccountSettingsUpdate() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionUpdate', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'accountsettings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkAccountSettingsDelete() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionDelete', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'accountsettings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkSettingsView() {
    	$script = '';
    	$totalSubMenu = 0;
    	$i = 0;

    	if (Auth::user()->roleID != 1) {
    		$totalSubMenu = DB::table('rolespermissions')
	    		->select('rolespermissions.ID')
	    		->where('rolespermissions.ParentName', '=', 'settings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->count();

	    	$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 0)
	    		->where('rolespermissions.ParentName', '=', 'settings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		$usersResultCount = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 0)
	    		->where('rolespermissions.ParentName', '=', 'settings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->count();
			//dd(DB::getQueryLog());

			if ($users) {
				foreach ($users as $user) {
					$i++;
					$script .= '$("#settings-' . str_replace_array(' ', ['-', '-'], strtolower($user->Name)) . '").remove();';
				}

				if ($totalSubMenu == $i) {
					$script .= '$("#settings").remove();';
				} 
			}
    	}

    	return $script;
    }

    public static function checkSettingsViewAllow() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'settings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkSettingsCreate() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionCreate', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'settings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkSettingsUpdate() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionUpdate', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'settings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkSettingsDelete() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionDelete', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'settings')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }



    public static function checkCataloguesView() {
    	$script = '';
    	$totalSubMenu = 0;
    	$i = 0;

    	if (Auth::user()->roleID != 1) {
    		$totalSubMenu = DB::table('rolespermissions')
	    		->select('rolespermissions.ID')
	    		->where('rolespermissions.ParentName', '=', 'catalogues')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->count();

	    	$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 0)
	    		->where('rolespermissions.ParentName', '=', 'catalogues')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		$usersResultCount = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 0)
	    		->where('rolespermissions.ParentName', '=', 'catalogues')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->count();
			//dd(DB::getQueryLog());

			if ($users) {
				foreach ($users as $user) {
					$i++;
					$script .= '$("#catalogues-' . str_replace_array(' ', ['-', '-'], strtolower($user->Name)) . '").remove();';
				}

				if ($totalSubMenu == $i) {
					$script .= '$("#catalogues").remove();';
				} 
			}
    	}

    	return $script;
    }

    public static function checkCataloguesViewAllow() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionView', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'catalogues')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkCataloguesCreate() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionCreate', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'catalogues')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkCataloguesUpdate() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionUpdate', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'catalogues')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

    public static function checkCataloguesDelete() {
    	if (Auth::user()->roleID != 1) {
    		$allow = false;

    		$currUrl = Route::getFacadeRoot()->current()->uri();

    		$users = DB::table('users')
	    		->select('users.id', 'rolespermissions.Name')
	    		->leftJoin('rolespermissionsjoin', 'rolespermissionsjoin.RolesID', '=', 'users.roleID')
	    		->leftJoin('rolespermissions', 'rolespermissions.ID', '=', 'rolespermissionsjoin.RolesPermissionsID')
	    		->where('users.id', '=', Auth::user()->id)
	    		->where('rolespermissionsjoin.PermissionDelete', '=', 1)
	    		->where('rolespermissions.ParentName', '=', 'catalogues')
	    		->orderBy('rolespermissions.Ordering', 'ASC')
	    		->get();

    		if ($users) {
				foreach ($users as $user) {
					if (str_contains($currUrl, str_replace_array(' ', ['-', '-'], strtolower($user->Name)))) {
						$allow = true;
					}
				}

			}

			return $allow;
    	}
    	else {
    		return true;
    	}    	
    }

}
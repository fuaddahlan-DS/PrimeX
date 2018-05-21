<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public static function getUserDetails($id) {
        $result = User::find($id);
        return $result;
    }
    
    public static function getUserRoleID($id) {
        $result = User::select('users.*', 'roles.Name as RoleName')->where('RoleID', $id)
                 ->join('roles', 'users.RoleID', '=', 'roles.ID')
                ->get();
        return $result;
    }
}

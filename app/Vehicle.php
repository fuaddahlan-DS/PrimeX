<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public $timestamps = false;
    public static function getVehicleDetailsByID($id) {
        $result = Vehicle::select('vehicles.*','vehicletypes.Name as VehicleTypeName','vehicletypes.Code as VehicleTypeCode', 'manufacturers.Name as manufacturerName')->where('vehicles.ID',$id)
                 ->join('vehicletypes', 'vehicles.VehicleTypeID', '=', 'vehicletypes.ID')
                 ->join('manufacturers', 'vehicles.manufacturerID', '=', 'manufacturers.ID')
                ->first();
        return $result;
    }
    
    
    public static function getVehicleByRegNo($char) {
        $result = Vehicle::where('RegistrationNo',$char)
                 ->first();
        return $result;
    }
    
    public static function getVehicleDetailsByMemberID($id) {
        $result = Vehicle::select('vehicles.*', 'vehicletypes.Name','vehicletypes.Code', 'manufacturers.Name')->where('MemberID',$id)
                 ->join('vehicletypes', 'vehicles.VehicleTypeID', '=', 'vehicletypes.ID')
                 ->join('manufacturers', 'vehicles.manufacturerID', '=', 'manufacturers.ID')
                ->first();
        return $result;
    }
}

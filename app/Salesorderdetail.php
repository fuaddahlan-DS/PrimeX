<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesorderdetail extends Model
{
    
    public $timestamps = false;
    public static function getDetails($id){
        
        $result = Salesorderdetail::where("SalesOrderID", $id)->get();
        return $result;
        
    }
    
    public static function listServices($id){
        
        $results = Salesorderdetail::where("SalesOrderID", $id)->get();
       
       
        if($results->count() == 0){
            return "";
        }
        $result = '';
        $i=1;
        foreach($results as $value){
            
            if($i == 1){
                $PN = $value['ProductName'];
            }else{
                $PN = ", ". $value['ProductName'];
            }
            $i++;
            $result .= $PN;
        }
        return $result;
        
    }
}

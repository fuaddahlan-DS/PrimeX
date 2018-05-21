<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{ 
    /*
     "ID" => 1
    "Code" => "MB0001"
    "Name" => "NEW MEMBERSHIP"
    "Description" => "JOIN AS NEW MEMBER."
    "Obsolete" => 0
    "PriceIncludeGST" => 1
    "GSTExempted" => 0
    "NormalPrice" => "0.0000"
    "MemberPrice" => "0.0000"
    "ProductID" => 1
    "VehicleTypeID" => null
    "BranchID" => null
    "Active" => 1
     */
    public static function getProductDetailList($limit) {
        $result = Product::select('products.*', 'productprices.*')
                ->join('productprices', 'products.ID', '=', 'productprices.ProductID')
                ->orderby('products.Name','ASC')
                ->limit($limit)
                ->get();
        return $result;
    }
    
    public static function getProductList($limit) {
        $result = Product::orderby('products.Name','ASC')
                ->limit($limit)
                ->get();
        return $result;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productprices extends Model
{
    protected $hidden = [
        'ID',
    ];
    
    public static function getProductPricesByProductID($id) {
        $result = productprices::select('productprices.*')
                ->where('ProductID',$id)
                ->first();
        return $result;
    }
}

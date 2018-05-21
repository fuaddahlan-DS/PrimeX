<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public $table = "payment_type";
    
    public static function getType($id) {
        $result = PaymentType::find($id);
        return $result;
    }
}

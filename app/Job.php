<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
     public $timestamps = false;
   protected $fillable = array(
    	"Status"
    	,"StartDate"
    	,"ETA"
    	,"CompleteDate"
    	,"ClientID"
       ,"VehicleID"
       ,"JobQueueID"
       ,"SalesOrderID"
       ,"Remarks"
       ,"SalesAdvisorID"
  	);
}

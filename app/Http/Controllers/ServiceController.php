<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Service;

class ServiceController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

  

}

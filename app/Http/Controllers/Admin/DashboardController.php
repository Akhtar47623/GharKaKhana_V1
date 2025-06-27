<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin; 
use Session;
use Config;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller {

    public function dashboard() {
  		$currentMonth = date('m');
       
        
        $pageData = [
            'title' => Config::get('constants.title.dashboard'),
            'users' => Admin::all()->count(),
            ];
            
        return view("admin.dashboard.index", $pageData);
       
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function clientsReport(){
        return view('Reports.clients'); 
    }
}

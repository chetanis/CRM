<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function dashboard(){
        //get the number of clients
        $nbclients = Client::getAccessibleClients()->count();
        //get the latest 5 sales
        $sales = Sale::getAccessibleSales()->latest()->take(5)->get();

        //get today's appointments
        $appointments=Appointment::getTodayAccessibleAppointments();

        //get the products that have the most sales
        $topProducts = Product::orderBy('sold', 'desc')->take(5)->get();


        return view('index',compact('nbclients','sales','topProducts','appointments'));
    }

}

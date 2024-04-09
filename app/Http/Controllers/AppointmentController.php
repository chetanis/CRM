<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Show the form for creating a new appointment
    public function create()
    {
        //get the clients that the user can access
        $clients = Client::getAccessibleClients()->get();
        return view('appointments.create', compact('clients'));
    }
}

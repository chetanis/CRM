<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    // Show the form for creating a new appointment
    public function create()
    {
        //get the clients that the user can access
        $clients = Client::getAccessibleClients()->get();
        return view('appointments.create', compact('clients'));
    }

    //create a new appointment
    public function store(Request $request){
        $request->validate([
            'client' => 'required|exists:clients,id',
            'date' => 'required|date',
            'purpose' => 'required|string',
        ]);

        $appointment = new Appointment();
        $appointment->user_id = auth()->id(); 
        $appointment->client_id = $request->input('client');
        $appointment->date_time = $request->input('date');
        $appointment->purpose = $request->input('purpose');

        $appointment->save();

        Session::flash('success', 'Rendez-vous crée avec succès');
        return response()->json(['success' => true]);
    }
}

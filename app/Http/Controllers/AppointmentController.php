<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'client' => 'required|exists:clients,id',
                'date' => 'required|date',
                'purpose' => 'required|string',
            ]);

            $appointment = new Appointment();
            $appointment->user_id = auth()->id();
            $appointment->client_id = $request->input('client');
            // Convert date and time to the correct format
            $dateAndTime = Carbon::parse($request->input('date'))->toDateTimeString();
            $appointment->date_and_time = $dateAndTime;

            $appointment->purpose = $request->input('purpose');

            $appointment->save();

            Session::flash('success', 'Rendez-vous crée avec succès');
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Session::flash('success', $e->getMessage());
            return response()->json(['success' => true]);
        }
    }
}

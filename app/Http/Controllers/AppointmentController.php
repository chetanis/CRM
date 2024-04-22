<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Client;
use App\Models\Appointment;
use Hamcrest\Type\IsString;
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
            //create log
            Log::CreateLog("Créer rendez-vous.", "Rendez-vous n°: " . $appointment->id);
            Session::flash('success', 'Rendez-vous crée avec succès');
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Session::flash('success', $e->getMessage());
            return response()->json(['success' => true]);
        }
    }

    public function index()
    {
        $appointments = Appointment::getAccessibleAppointments()->paginate(10);
        
        return view('Appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment){
         // Store the previous URL in the session to redirect the user after the appointment is deleted
         session()->put('previous_url', url()->previous());
        return view('appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment){
        $appointment->update(['status' => 'cancelled']);
        //create log
        Log::CreateLog("Annuler rendez-vous.", "Rendez-vous n°: " . $appointment->id);
        Session::flash('success', 'Rendez-vous annulée avec succès');
        return redirect()->back();
    }

    public function confirm(Appointment $appointment){
        $appointment->update(['status' => 'done']);
        //create log
        Log::CreateLog("Confirmer rendez-vous.", "Rendez-vous n°: " . $appointment->id);
        Session::flash('success', 'Rendez-vous confirmée avec succès');
        return redirect()->back();
    }

    public function destroy(Appointment $appointment){
        $appointment->delete();
        //create log
        Log::CreateLog("Supprimer rendez-vous.", "Rendez-vous n°: " . $appointment->id);
        Session::flash('success', 'Rendez-vous supprimée avec succès');
        //rederect the user to the index page
        return redirect()->intended(session()->pull('previous_url', '/'));
    }
}

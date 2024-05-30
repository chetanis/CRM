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
        $appointments = Appointment::getAccessibleAppointments()->filter(request(['period']))->paginate(10);

        $filter = request(['period'][0]);

        return view('Appointments.index', compact('appointments','filter'));
    }
    
    public function show(Appointment $appointment)
    {
        // Store the previous URL in the session to redirect the user after the appointment is deleted
        session()->put('previous_url', url()->previous());
        return view('appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        //create log
        Log::CreateLog("Annuler rendez-vous.", "Rendez-vous n°: " . $appointment->id);
        Session::flash('success', 'Rendez-vous annulée avec succès');
        return redirect()->back();
    }

    public function confirm(Appointment $appointment,Request $request)
    {
        $appointment->update(['status' => 'done', 'result' => $request->input('result')]);
        //create log
        Log::CreateLog("Confirmer rendez-vous.", "Rendez-vous n°: " . $appointment->id);
        Session::flash('success', 'Rendez-vous confirmée avec succès');
        return redirect()->back();
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        //create log
        Log::CreateLog("Supprimer rendez-vous.", "Rendez-vous n°: " . $appointment->id);
        Session::flash('success', 'Rendez-vous supprimée avec succès');
        //rederect the user to the index page
        return redirect()->intended(session()->pull('previous_url', '/'));
    }

    public function reschedule(Request $request, Appointment $appointment)
    {
        $request->validate([
            'date_and_time' => 'required|date',
        ]);
        $dateAndTime = Carbon::parse($request->input('date_and_time'));

        //check if the new date is not in the past
        if ($dateAndTime->isPast()) {
            Session::flash('error', 'Vous ne pouvez pas programmer un rendez-vous dans le passé.');
            return redirect()->back();
        }
        //check if the date didn't change
        if ($dateAndTime == $appointment->date_and_time) {
            Session::flash('error', 'Vous n\'avez pas changé la date du rendez-vous.');
            return redirect()->back();
        }
        // update the date and time of the appointment
        $appointment->update(['date_and_time' => $dateAndTime->toDateTimeString()]);
        Session::flash('success', 'Rendez-vous reprogrammé avec succès');
        //create log
        Log::CreateLog("Reprogrammer rendez-vous.", "Rendez-vous n°: " . $appointment->id);

        return redirect()->back();
    }
}

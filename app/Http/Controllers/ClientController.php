<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Client;
use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //get the clients that the user can access
        $clients = Client::getAccessibleClients()->paginate(10);
        
        return view('Client.index', [
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'lastName' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'job' => 'nullable|string',
            'industry' => 'nullable|string',
            'address' => 'nullable|string',
            'facebook' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'x' => 'nullable|string',
            'other' => 'nullable|string',
            'lead' => 'nullable|string',
            'notes' => 'nullable|string',
            'code_fiscal' => 'nullable|string',
        ]);

        // Create a new client instance
        $client = new Client();

        // Assign form data to the client instance
        $client->last_name = $request->input('lastName');
        $client->first_name = $request->input('name');
        $client->email = $request->input('email');
        $client->phone_number = $request->input('phone');
        $client->company_name = $request->input('company');
        $client->job_title = $request->input('job');
        $client->industry = $request->input('industry');
        $client->address = $request->input('address');
        $client->social_media_profiles = [
            'facebook' => $request->input('facebook'),
            'linkedin' => $request->input('linkedin'),
            'x' => $request->input('x'),
            'other' => $request->input('other'),
        ];
        $client->lead_source = $request->input('lead');
        $client->notes = $request->input('notes');
        $client->code_fiscal = $request->input('code_fiscal');
        $client->assigned_to = Auth::id();

        // Save the client to the database
        $client->save();

        //create log
        Log::CreateLog('creer client', 'Client cree: ' . $client->first_name . ' ' . $client->last_name);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Client ajouter!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::findOrFail($id);
        $commands = $client->commands()->get();
        $appointments = $client->appointments()->get();
        $countPending = $commands->where('type', 'pending')->count();
        $countConfirmed = $commands->where('type', 'done')->count();
        $countCancelled = $commands->where('type', 'cancelled')->count();

        //if the user is admin send the user list
        if (Auth::user()->privilege == 'admin') {
            $users = User::all();
            return view('Client.show', [
                'client' => $client,
                'commands' => $commands,
                'countPending' => $countPending,
                'countConfirmed' => $countConfirmed,
                'countCancelled' => $countCancelled,
                'appointments' => $appointments,
                'users' => $users
            ]);
        }

        return view('Client.show', [
            'client' => $client,
            'commands' => $commands,
            'countPending' => $countPending,
            'countConfirmed' => $countConfirmed,
            'countCancelled' => $countCancelled,
            'appointments' => $appointments,
            'users' => [],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'lastName' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'job' => 'nullable|string',
            'industry' => 'nullable|string',
            'address' => 'nullable|string',
            'facebook' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'x' => 'nullable|string',
            'other' => 'nullable|string',
            'lead' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Update basic attributes
        $social_media_profiles = [
            'facebook' => $request->input('facebook'),
            'linkedin' => $request->input('linkedin'),
            'x' => $request->input('x'),
            'other' => $request->input('other'),
        ];
        $client->update([
            'last_name' => $request->input('lastName'),
            'first_name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone'),
            'company_name' => $request->input('company'),
            'job_title' => $request->input('job'),
            'industry' => $request->input('industry'),
            'address' => $request->input('address'),
            'lead_source' => $request->input('lead'),
            'notes' => $request->input('notes'),
            'social_media_profiles' => $social_media_profiles,
        ]);


        //create log
        Log::CreateLog('modifier client', 'Client modifie: ' . $client->first_name . ' ' . $client->last_name);

        return redirect()->back()->with('success', 'Client modifié!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        //get the clients that the user can access
        $clients = Client::getAccessibleClients();

        // Search by name, email, or phone number
        $clients->where(function ($query) use ($search) {
            $query->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone_number', 'LIKE', "%{$search}%");
        });
        $clients = $clients->paginate(10);
        return view('Client.index', [
            'clients' => $clients
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        //create log
        Log::CreateLog('supprimer client', 'Client supprime: ' . $client->first_name . ' ' . $client->last_name);
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès !');
    }

    //change the user assigned to
    public function changeUser(Request $request, Client $client)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);
        $client->changeAssignedTo($request->input('assigned_to'));

        session()->flash('success', 'user modifié avec succès');
        return redirect()->back();
    }
}

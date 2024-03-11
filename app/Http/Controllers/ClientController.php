<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::latest()->paginate(10);
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
        $client->assigned_to = Auth::id();

        // Save the client to the database
        $client->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Client ajouter!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::findOrFail($id);
        return view('Client.show', [
            'client' => $client
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


        $client->update([]);

        return redirect()->back()->with('success', 'Client modifié!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Search by name, email, or phone number
        $clients = Client::where('first_name', 'LIKE', "%{$search}%")
            ->orWhere('last_name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone_number', 'LIKE', "%{$search}%")
            ->paginate(10);

            return view('Client.index', [
                'clients' => $clients
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

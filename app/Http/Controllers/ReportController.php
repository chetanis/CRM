<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function clientsReport(){
        return view('Reports.clients'); 
    }

    public function generateClientsReport(Request $request){
        if($request->input('time_period')=='all_time'){
            // get the accessible clients
            $clients = Client::getAccessibleClients()->with(['commands', 'appointments']);

            // get the number of clients
            $nb_clients = $clients->get()->count();

            // get the clients per year
            $clientsPerYear= clone $clients;
            $clientsPerYear=$clientsPerYear->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

            // get the clients by source
            $clientsBySource = clone $clients;
            $clientsBySource = $clientsBySource->selectRaw('lead_source, COUNT(*) as count')
            ->groupBy('lead_source')
            ->orderBy('lead_source', 'asc')
            ->get();

            //get clients activity

            // Prepare the data for the table
            $clientActivity = [];

            foreach ($clients->get() as $client) {
                $totalCommands = $client->commands->count();
                $confirmedCommands = $client->commands->where('type', 'done')->count();
                $cancelledCommands = $client->commands->where('type', 'cancelled')->count();
                $totalAppointments = $client->appointments->count();
        
                // Calculate gains from confirmed commands
                $gains = $client->commands->where('type', 'done')->sum('total_price');
        
                $clientActivity[] = [
                    'client_name' => $client->first_name . ' ' . $client->last_name,
                    'total_commands' => $totalCommands,
                    'confirmed_commands' => $confirmedCommands,
                    'cancelled_commands' => $cancelledCommands,
                    'total_appointments' => $totalAppointments,
                    'gains' => $gains,
                ];
            }


        }
        // $pdf = PDF::loadView('Reports.clients', compact('clients'));
        // dd($clientActivity);
        return view('Reports-template.clients',compact('nb_clients','clientsPerYear','clientsBySource','clientActivity')); 
    }
}

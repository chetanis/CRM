<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function clientsReport()
    {
        return view('Reports.clients');
    }

    public function generateClientsReport(Request $request)
    {
        $totalNbClients = Client::getAccessibleClients()->get()->count();
        if ($request->input('time_period') == 'all_time') {
            // get the accessible clients
            $clients = Client::getAccessibleClients()->with(['commands', 'appointments']);

            // get the number of clients
            $nb_clients = $clients->get()->count();

            // get the clients per year
            $clientsPerYear = clone $clients;
            $clientsPerYear = $clientsPerYear->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
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
            $all_time=true;
            return view('Reports-template.clients', compact('nb_clients', 'clientsPerYear', 'clientsBySource', 'clientActivity','all_time'));

            // If the specified time period is 'last_year'
        } elseif ($request->input('time_period') == 'last_year') {

            // Get the start and end dates for the last year
            $endDate = Carbon::now();
            $startDate = $endDate->copy()->subYear();

            // Fetch clients within the date range
            $clients = Client::getAccessibleClients()
                ->whereBetween('created_at', [$startDate, $endDate]);

            // Get the number of clients created in the last year
            $nb_clients = $clients->count();

            // Get the clients by month within the date range
            $clientsPerMonth = clone $clients;
            $clientsPerMonth = $clientsPerMonth->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();

            // Get the clients by source within the date range
            $clientsBySource = clone $clients;
            $clientsBySource = $clientsBySource->selectRaw('lead_source, COUNT(*) as count')
                ->groupBy('lead_source')
                ->orderBy('lead_source', 'asc')
                ->get();

            // Prepare the data for the client activity table
            $clientActivity = [];

            //get all client not just in that period
            $all_clients = Client::getAccessibleClients()->with(['commands', 'appointments'])->get();
            foreach ($all_clients as $client) {
                $commands= $client->commands->whereBetween('created_at',[$startDate, $endDate]);
                $totalCommands = $commands->count();
                $confirmedCommands = $commands->where('type', 'done')->count();
                $cancelledCommands = $commands->where('type', 'cancelled')->count();
                $totalAppointments = $client->appointments->whereBetween('date',[$startDate, $endDate])->count();

                // Calculate gains from confirmed commands
                $gains = $commands->where('type', 'done')->sum('total_price');

                $clientActivity[] = [
                    'client_name' => $client->first_name . ' ' . $client->last_name,
                    'total_commands' => $totalCommands,
                    'confirmed_commands' => $confirmedCommands,
                    'cancelled_commands' => $cancelledCommands,
                    'total_appointments' => $totalAppointments,
                    'gains' => $gains,
                ];
            }
            return view('Reports-template.clients', compact('nb_clients', 'clientsPerMonth', 'clientsBySource', 'clientActivity', 'totalNbClients', 'startDate', 'endDate'));
        } elseif ($request->input('time_period') == 'last_month') {
            // Get the start and end dates for the last month
            $endDate = Carbon::now(); // Today's date
            $startDate = $endDate->copy()->subMonth(); // Start of the previous month

            // Fetch clients created within the last month
            $clients = Client::getAccessibleClients()
                ->whereBetween('created_at', [$startDate, $endDate]);

            // Get the number of clients created in the last month
            $nb_clients = $clients->count();

            // Get the clients by day within the last month
            $clientsPerDay = clone $clients;
            $clientsPerDay = $clientsPerDay->selectRaw('DAY(created_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->orderBy('day', 'asc')
                ->get();

            // Get the clients by source within the last month
            $clientsBySource = clone $clients;
            $clientsBySource = $clientsBySource->selectRaw('lead_source, COUNT(*) as count')
                ->groupBy('lead_source')
                ->orderBy('lead_source', 'asc')
                ->get();

            // Prepare the data for the client activity table for the last month
            $clientActivity = [];
            //get all client not just in that period
            $all_clients = Client::getAccessibleClients()->with(['commands', 'appointments'])->get();
            foreach ($all_clients as $client) {
                $commands= $client->commands->whereBetween('created_at',[$startDate, $endDate]);
                $totalCommands = $commands->count();
                $confirmedCommands = $commands->where('type', 'done')->count();
                $cancelledCommands = $commands->where('type', 'cancelled')->count();
                $totalAppointments = $client->appointments->whereBetween('date',[$startDate, $endDate])->count();

                // Calculate gains from confirmed commands
                $gains = $commands->where('type', 'done')->sum('total_price');

                $clientActivity[] = [
                    'client_name' => $client->first_name . ' ' . $client->last_name,
                    'total_commands' => $totalCommands,
                    'confirmed_commands' => $confirmedCommands,
                    'cancelled_commands' => $cancelledCommands,
                    'total_appointments' => $totalAppointments,
                    'gains' => $gains,
                ];
            }

            // Return the view with the generated data
            return view('Reports-template.clients', compact('nb_clients', 'clientsPerDay', 'clientsBySource', 'clientActivity', 'startDate', 'endDate','totalNbClients'));
        }else{

            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));

            // Fetch clients created within the last month
            $clients = Client::getAccessibleClients()
                ->whereBetween('created_at', [$startDate, $endDate]);

            // Get the number of clients created in the last month
            $nb_clients = $clients->count();

            // Get the clients by day within the last month
            $clientPerCustom = clone $clients;
            $clientPerCustom = $clientPerCustom->selectRaw('MONTH(created_at) as month, DAY(created_at) as day, COUNT(*) as count')
            ->groupBy('month', 'day') // Group by both month and day
            ->orderBy('month', 'asc') // Order by month first
            ->orderBy('day', 'asc')   // Then order by day
            ->get();

            // Get the clients by source within the last month
            $clientsBySource = clone $clients;
            $clientsBySource = $clientsBySource->selectRaw('lead_source, COUNT(*) as count')
                ->groupBy('lead_source')
                ->orderBy('lead_source', 'asc')
                ->get();

            // Prepare the data for the client activity table for the last month
            $clientActivity = [];
            //get all client not just in that period
            $all_clients = Client::getAccessibleClients()->with(['commands', 'appointments'])->get();
            foreach ($all_clients as $client) {
                $commands= $client->commands->whereBetween('created_at',[$startDate, $endDate]);
                $totalCommands = $commands->count();
                $confirmedCommands = $commands->where('type', 'done')->count();
                $cancelledCommands = $commands->where('type', 'cancelled')->count();
                $totalAppointments = $client->appointments->whereBetween('date',[$startDate, $endDate])->count();

                // Calculate gains from confirmed commands
                $gains = $commands->where('type', 'done')->sum('total_price');

                $clientActivity[] = [
                    'client_name' => $client->first_name . ' ' . $client->last_name,
                    'total_commands' => $totalCommands,
                    'confirmed_commands' => $confirmedCommands,
                    'cancelled_commands' => $cancelledCommands,
                    'total_appointments' => $totalAppointments,
                    'gains' => $gains,
                ];
            }

            // Return the view with the generated data
            return view('Reports-template.clients', compact('nb_clients', 'clientPerCustom', 'clientsBySource', 'clientActivity', 'startDate', 'endDate','totalNbClients'));
        }
        // $pdf = PDF::loadView('Reports.clients', compact('clients'));
    }
}

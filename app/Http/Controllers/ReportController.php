<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Command;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function clientsReport()
    {
        return view('Reports.clients');
    }

    public function generateClientsReport(Request $request)
    {
        $client_stat_checked = false;
        $lead_source_checked = false;
        $client_graph_checked = false;
        $client_activities_checked = false;
        $reportOptions = $request->input('report_options', []);
        if (in_array('client_stat', $reportOptions)) {
            $client_stat_checked = true;
        }
        if (in_array('lead_source', $reportOptions)) {
            $lead_source_checked = true;
        }
        if (in_array('client_graph', $reportOptions)) {
            $client_graph_checked = true;
        }
        if (in_array('client_activities', $reportOptions)) {
            $client_activities_checked = true;
        }
        if ($request->input('time_period') == 'all_time') {
            // get the accessible clients
            $clients = Client::getAccessibleClients()->with(['commands', 'appointments']);

            $nb_clients = 0;
            $totalNbClients = 0;
            if ($client_stat_checked) {
                // get the number of clients
                $nb_clients = $clients->get()->count();
            }

            $clientsPerYear = [];
            if ($client_graph_checked) {

                // get the clients per year
                $clientsPerYear = clone $clients;
                $clientsPerYear = $clientsPerYear->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
                    ->groupBy('year')
                    ->orderBy('year', 'asc')
                    ->get();
            }
            $clientsBySource = [];
            if ($lead_source_checked) {
                // get the clients by source
                $clientsBySource = clone $clients;
                $clientsBySource = $clientsBySource->selectRaw('lead_source, COUNT(*) as count')
                    ->groupBy('lead_source')
                    ->orderBy('lead_source', 'asc')
                    ->get();
            }

            //get clients activity

            // Prepare the data for the table
            $clientActivity = [];
            if ($client_activities_checked) {
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
            $all_time = true;
            return view('Reports-template.clients', compact('nb_clients', 'clientsPerYear', 'clientsBySource', 'clientActivity', 'all_time', 'client_stat_checked', 'lead_source_checked', 'client_graph_checked', 'client_activities_checked'));

            // If the specified time period is 'last_year'
        } elseif ($request->input('time_period') == 'last_year') {

            // Get the start and end dates for the last year
            $endDate = Carbon::now();
            $startDate = $endDate->copy()->subYear();

            // Fetch clients within the date range
            $clients = Client::getAccessibleClients()
                ->whereBetween('created_at', [$startDate, $endDate]);

            $nb_clients = 0;
            $totalNbClients = 0;
            if ($client_stat_checked) {
                // Get the number of clients created in the last year
                $nb_clients = $clients->count();
                $totalNbClients = Client::getAccessibleClients()->get()->count();
            }

            $clientsPerMonth = [];
            if ($client_graph_checked) {
                // Get the clients by month within the date range
                $clientsPerMonth = clone $clients;
                $clientsPerMonth = $clientsPerMonth->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                    ->groupBy('month')
                    ->orderBy('month', 'asc')
                    ->get();
            }
            $clientsBySource = [];
            if ($lead_source_checked) {
                // Get the clients by source within the date range
                $clientsBySource = clone $clients;
                $clientsBySource = $clientsBySource->selectRaw('lead_source, COUNT(*) as count')
                    ->groupBy('lead_source')
                    ->orderBy('lead_source', 'asc')
                    ->get();
            }

            // Prepare the data for the client activity table
            $clientActivity = [];

            if ($client_activities_checked) {
                // dd($startDate, $endDate);
                //get all client not just in that period
                $all_clients = Client::getAccessibleClients()->with(['commands', 'appointments'])->get();
                foreach ($all_clients as $client) {
                    $commands = $client->commands->whereBetween('created_at', [$startDate, $endDate]);
                    $totalCommands = $commands->count();
                    $confirmedCommands = $commands->where('type', 'done')->count();
                    $cancelledCommands = $commands->where('type', 'cancelled')->count();
                    $totalAppointments = $client->appointments->whereBetween('date_and_time', [$startDate, $endDate])->count();

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
            }
            return view('Reports-template.clients', compact('nb_clients', 'clientsPerMonth', 'clientsBySource', 'clientActivity', 'totalNbClients', 'startDate', 'endDate', 'client_stat_checked', 'lead_source_checked', 'client_graph_checked', 'client_activities_checked'));
        } elseif ($request->input('time_period') == 'last_month') {
            // Get the start and end dates for the last month
            $endDate = Carbon::now(); // Today's date
            $startDate = $endDate->copy()->subMonth(); // Start of the previous month

            // Fetch clients created within the last month
            $clients = Client::getAccessibleClients()
                ->whereBetween('created_at', [$startDate, $endDate]);

            $nb_clients = 0;
            $totalNbClients = 0;
            if ($client_stat_checked) {
                // Get the number of clients created in the last month
                $nb_clients = $clients->count();
                $totalNbClients = Client::getAccessibleClients()->get()->count();
            }

            $clientsPerDay = [];
            if ($client_graph_checked) {
                // Get the clients by day within the last month
                $clientsPerDay = clone $clients;
                $clientsPerDay = $clientsPerDay->selectRaw('DAY(created_at) as day, COUNT(*) as count')
                    ->groupBy('day')
                    ->orderBy('day', 'asc')
                    ->get();
            }

            $clientsBySource = [];
            if ($lead_source_checked) {
                // Get the clients by source within the last month
                $clientsBySource = clone $clients;
                $clientsBySource = $clientsBySource->selectRaw('lead_source, COUNT(*) as count')
                    ->groupBy('lead_source')
                    ->orderBy('lead_source', 'asc')
                    ->get();
            }

            // Prepare the data for the client activity table for the last month
            $clientActivity = [];

            if ($client_activities_checked) {
                //get all client not just in that period
                $all_clients = Client::getAccessibleClients()->with(['commands', 'appointments'])->get();
                foreach ($all_clients as $client) {
                    $commands = $client->commands->whereBetween('created_at', [$startDate, $endDate]);
                    $totalCommands = $commands->count();
                    $confirmedCommands = $commands->where('type', 'done')->count();
                    $cancelledCommands = $commands->where('type', 'cancelled')->count();
                    $totalAppointments = $client->appointments->whereBetween('date_and_time', [$startDate, $endDate])->count();

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
            }

            // Return the view with the generated data
            return view('Reports-template.clients', compact('nb_clients', 'clientsPerDay', 'clientsBySource', 'clientActivity', 'startDate', 'endDate', 'totalNbClients', 'client_stat_checked', 'lead_source_checked', 'client_graph_checked', 'client_activities_checked'));
        } else {

            $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));

            // Fetch clients created within the last month
            $clients = Client::getAccessibleClients()
                ->whereBetween('created_at', [$startDate, $endDate]);

            $nb_clients = 0;
            $totalNbClients = 0;
            if ($client_stat_checked) {
                // Get the number of clients created in the last month
                $nb_clients = $clients->count();
                $totalNbClients = Client::getAccessibleClients()->get()->count();
            }

            $clientPerCustom = [];
            if ($client_graph_checked) {
                // Get the clients by day 
                $clientPerCustom = clone $clients;
                $clientPerCustom = $clientPerCustom->selectRaw('MONTH(created_at) as month, DAY(created_at) as day, COUNT(*) as count')
                    ->groupBy('month', 'day') // Group by both month and day
                    ->orderBy('month', 'asc') // Order by month first
                    ->orderBy('day', 'asc')   // Then order by day
                    ->get();
            }

            $clientsBySource = [];
            if ($lead_source_checked) {
                // Get the clients by source within the last month
                $clientsBySource = clone $clients;
                $clientsBySource = $clientsBySource->selectRaw('lead_source, COUNT(*) as count')
                    ->groupBy('lead_source')
                    ->orderBy('lead_source', 'asc')
                    ->get();
            }

            // Prepare the data for the client activity table for the last month
            $clientActivity = [];

            if ($client_activities_checked) {
                //get all client not just in that period
                $all_clients = Client::getAccessibleClients()->with(['commands', 'appointments'])->get();
                foreach ($all_clients as $client) {
                    $commands = $client->commands->whereBetween('created_at', [$startDate, $endDate]);
                    $totalCommands = $commands->count();
                    $confirmedCommands = $commands->where('type', 'done')->count();
                    $cancelledCommands = $commands->where('type', 'cancelled')->count();
                    $totalAppointments = $client->appointments->whereBetween('date_and_time', [$startDate, $endDate])->count();

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
            }

            // Return the view with the generated data
            return view('Reports-template.clients', compact('nb_clients', 'clientPerCustom', 'clientsBySource', 'clientActivity', 'startDate', 'endDate', 'totalNbClients', 'client_stat_checked', 'lead_source_checked', 'client_graph_checked', 'client_activities_checked'));
        }
        // $pdf = PDF::loadView('Reports.clients', compact('clients'));
    }

    public function usersReport()
    {
        return view('Reports.users');
    }



    public function commandsReport()
    {
        return view('Reports.commands');
    }

    public function generateCommandsReport(Request $request)
    {
        $command_stat_checked = false;
        $command_graph_checked = false;
        $command_percentage_checked = false;
        $product_table_checked = false;
        $reportOptions = $request->input('report_options', []);
        if (in_array('commands_stat', $reportOptions)) {
            $command_stat_checked = true;
        }
        if (in_array('commands_graph', $reportOptions)) {
            $command_graph_checked = true;
        }
        if (in_array('products_stat', $reportOptions)) {
            $product_table_checked = true;
        }
        if (in_array('commands_percentage', $reportOptions)) {
            $command_percentage_checked = true;
        }
        if ($request->input('time_period') == 'all_time') {
            // get the accessible commands
            $commands = Command::getAccessibleCommands();

            $nb_commands = 0;
            $nb_confirmed_commands = 0;
            $nb_cancelled_commands = 0;
            $nb_pending_commands = 0;

            if ($command_stat_checked) {
                // loop through the commands and counts the number of each type
                foreach ($commands->get() as $command) {
                    $nb_commands++;
                    if ($command->type == 'done') {
                        $nb_confirmed_commands++;
                    } elseif ($command->type == 'cancelled') {
                        $nb_cancelled_commands++;
                    } else {
                        $nb_pending_commands++;
                    }
                }
            }
            //init the percentage
            $percentage_confirmed = 0;
            $percentage_cancelled = 0;
            $percentage_pending = 0;
            if ($command_percentage_checked) {
                // Calculate the percentage of each type of command
                $percentage_confirmed = $nb_confirmed_commands / $nb_commands * 100;
                $percentage_cancelled = $nb_cancelled_commands / $nb_commands * 100;
                $percentage_pending = $nb_pending_commands / $nb_commands * 100;
            }

            $commandsPerYear = [];
            $commandsPerYear2 = [];
            if ($command_graph_checked) {

                // get the commands per year
                $commandsPerYear = clone $commands;
                $commandsPerYear = $commandsPerYear->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
                    ->groupBy('year')
                    ->get()
                    ->reverse(); // Reverse the order of the results;

                $commandsPerYear2 = clone $commands;
                $commandsPerYear2 = $commands->selectRaw('YEAR(created_at) as year, 
                    SUM(CASE WHEN type = "done" THEN 1 ELSE 0 END) as confirmed_count, 
                    SUM(CASE WHEN type = "pending" THEN 1 ELSE 0 END) as pending_count,
                    SUM(CASE WHEN type = "cancelled" THEN 1 ELSE 0 END) as cancelled_count')
                    ->groupBy('year')
                    ->get()
                    ->reverse(); // Reverse the order of the results;
            }

            // Prepare the data for the table
            $productsTable = [];
            $totalRevenue =0;
            $totalProfit = 0;
            if ($product_table_checked) {
                $prdoducts = Product::all();

                foreach($prdoducts as $product){
                    $productRevenue = $product->price * $product->sold;
                    $totalRevenue += $productRevenue;
                    $productProfit = ($product->price - $product->purchase_price) * $product->sold;
                    $totalProfit += $productProfit;
                    $productsTable[] = [
                        'product_name' => $product->name,
                        'total_sold' => $product->sold,
                        'total_revenue' => $productRevenue,
                        'total_profit' => $productProfit,
                    ];
                }
            }
            $all_time = true;
            return view('Reports-template.commands', compact('nb_commands', 'nb_confirmed_commands', 'nb_cancelled_commands', 'nb_pending_commands', 'percentage_confirmed', 'percentage_cancelled', 'percentage_pending', 'commandsPerYear','commandsPerYear2', 'productsTable', 'all_time', 'command_stat_checked', 'command_graph_checked', 'product_table_checked', 'command_percentage_checked', 'totalRevenue', 'totalProfit'));

            // If the specified time period is 'last_year'
        } elseif ($request->input('time_period') == 'last_year') {

            // Get the start and end dates for the last year
            $endDate = Carbon::now();
            $startDate = $endDate->copy()->subYear();
        }
        return view('Reports-template.commands');
    }
}

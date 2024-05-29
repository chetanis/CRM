<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function dashboard()
    {
        // Get today's date
        $today = Carbon::today();

        // Get the start and end dates of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Get the start and end of last week
        $startOfLastWeek = Carbon::now()->subWeek();
        $endOfLastWeek = Carbon::now();


        // Get the dates of last week
        $datesOfLastWeek = [];
        for ($date = $startOfLastWeek; $date->lte($endOfLastWeek); $date->addDay()) {
            $datesOfLastWeek[$date->format('M d')] = 0;
        }

        // Get the start and end of last week
        $startOfLastWeek = Carbon::now()->subWeek();
        $endOfLastWeek = Carbon::now();
        // Query sales data for last week
        $salesLastWeek = Sale::getAccessibleSales()
            ->whereBetween('sales.created_at', [$startOfLastWeek, $endOfLastWeek])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) as total_sales'))
            ->groupBy('date')
            ->get();

        // Merge sales data with all dates of last week
        foreach ($salesLastWeek as $sale) {
            // Format date without year (e.g., 'May 24')
            $formattedDate = Carbon::parse($sale->date)->format('M d');
            $datesOfLastWeek[$formattedDate] = $sale->total_sales;
        }

        //get the latest 5 sales
        $sales = Sale::getAccessibleSales()->latest()->take(5)->get();

        //get today's appointments
        $appointments = Appointment::getTodayAccessibleAppointments();

        //get the products that have the most sales
        $topProducts = Product::orderBy('sold', 'desc')->take(5)->get();

        // Get the revenue of this month
        $totalRevenue = round(Sale::getAccessibleSales()
            ->whereBetween('sales.created_at', [$startOfMonth, $endOfMonth])
            ->join('commands', 'sales.command_id', '=', 'commands.id')
            ->sum('commands.total_price'));

        // get  the percentage difference between the revenue of this month and the previous month
        $totalRevenuePrevious = Sale::getAccessibleSales()
            ->whereBetween('sales.created_at', [$startOfMonth->subMonth(), $endOfMonth->subMonth()])
            ->join('commands', 'sales.command_id', '=', 'commands.id')
            ->sum('commands.total_price');
        $RevenuePercentageDiff = $totalRevenuePrevious == 0 ? 100 : round((($totalRevenue - $totalRevenuePrevious) / $totalRevenuePrevious) * 100);

        // Get the number of sales for today
        $nbSales = Sale::getAccessibleSales()->whereDate('created_at', $today)
            ->count();

        //get the percentage difference between the number of sales of today and yesterday
        $nbSalesYesterday = Sale::getAccessibleSales()->whereDate('created_at', $today->subDay())->count();

        if ($nbSalesYesterday == 0) {
            $salesPercentageDiff = $nbSales > 0 ? 100 : 0;
        } else {
            $salesPercentageDiff = round((($nbSales - $nbSalesYesterday) / $nbSalesYesterday) * 100);
        }

        // Get the number of clients for this year
        $nbclients = Client::getAccessibleClients()->whereYear('created_at', $today->year)->count();

        // Get the precentage difference between the number of clients of this year and the previous year
        $nbclientsPrevious = Client::getAccessibleClients()->whereYear('created_at', $today->subYear()->year)->count();
        $clientsPercentageDiff = $nbclientsPrevious == 0 ? 100 : round((($nbclients - $nbclientsPrevious) / $nbclientsPrevious) * 100);

        $topClients = Client::getAccessibleClientsQuery()->join('commands', 'clients.id', '=', 'commands.client_id')
            ->select('clients.id', 'clients.first_name', 'clients.last_name', DB::raw('SUM(commands.total_price) as total_revenue'), DB::raw('COUNT(commands.id) as total_sales'))
            ->where('commands.type', 'done')
            ->groupBy('clients.id', 'clients.first_name', 'clients.last_name')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        return view('index', compact(
            'nbclients',
            'sales',
            'topProducts',
            'appointments',
            'totalRevenue',
            'nbSales',
            'salesPercentageDiff',
            'RevenuePercentageDiff',
            'clientsPercentageDiff',
            'topClients',
            'datesOfLastWeek'
        ));
    }

    //filter the sales
    public function filterSales(Request $request)
    {
        $filter = $request->input('filter');
        $now = Carbon::now();
        $salesQuery = Sale::getAccessibleSales();

        $nbSalesCurrent = 0;
        $nbSalesPrevious = 0;

        switch ($filter) {
            case 'today':
                $nbSalesCurrent = $salesQuery->whereDate('created_at', $now->toDateString())->count();
                $nbSalesPrevious = Sale::getAccessibleSales()
                    ->whereDate('created_at', $now->subDay()->toDateString())
                    ->count();
                break;
            case 'month':
                $nbSalesCurrent = $salesQuery->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
                $nbSalesPrevious = Sale::getAccessibleSales()
                    ->whereMonth('created_at', $now->subMonth()->month)
                    ->whereYear('created_at', $now->year)
                    ->count();
                break;
            case 'year':
                $nbSalesCurrent = $salesQuery->whereYear('created_at', $now->year)->count();
                $nbSalesPrevious = Sale::getAccessibleSales()
                    ->whereYear('created_at', $now->subYear()->year)
                    ->count();
                break;
            default:
                return response()->json(['error' => 'Invalid filter'], 400);
        }

        // Calculate the percentage difference
        if ($nbSalesPrevious == 0) {
            $percentageDiff = $nbSalesCurrent > 0 ? 100 : 0;
        } else {
            $percentageDiff = round((($nbSalesCurrent - $nbSalesPrevious) / $nbSalesPrevious) * 100);
        }



        return response()->json([
            'nbSales' => $nbSalesCurrent,
            'percentageDiff' => $percentageDiff,
        ]);
    }

    //filter the revenue
    public function filterRevenue(Request $request)
    {
        try {
            $filter = $request->input('filter');
            $now = Carbon::now();

            $salesQuery = Sale::getAccessibleSales();

            $totalRevenue = 0;
            $totalRevenuePrevious = 0;

            switch ($filter) {
                case 'today':

                    $totalRevenue = $salesQuery->whereDate('sales.created_at', $now->toDateString())->join('commands', 'sales.command_id', '=', 'commands.id')->sum('commands.total_price');
                    $totalRevenuePrevious = Sale::getAccessibleSales()
                        ->whereDate('sales.created_at', $now->subDay()->toDateString())
                        ->join('commands', 'sales.command_id', '=', 'commands.id')
                        ->sum('commands.total_price');


                    break;
                case 'month':
                    $totalRevenue = $salesQuery->whereMonth('sales.created_at', $now->month)->whereYear('sales.created_at', $now->year)->join('commands', 'sales.command_id', '=', 'commands.id')->sum('commands.total_price');
                    $totalRevenuePrevious = Sale::getAccessibleSales()
                        ->whereMonth('sales.created_at', $now->subMonth()->month)
                        ->whereYear('sales.created_at', $now->year)
                        ->join('commands', 'sales.command_id', '=', 'commands.id')
                        ->sum('commands.total_price');
                    break;
                case 'year':
                    $totalRevenue = $salesQuery->whereYear('sales.created_at', $now->year)->join('commands', 'sales.command_id', '=', 'commands.id')->sum('commands.total_price');
                    $totalRevenuePrevious = Sale::getAccessibleSales()
                        ->whereYear('sales.created_at', $now->subYear()->year)
                        ->join('commands', 'sales.command_id', '=', 'commands.id')
                        ->sum('commands.total_price');
                    break;
                default:
                    return response()->json(['error' => 'Invalid filter'], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->__toString()], 442);
        }

        // Calculate the percentage difference
        if ($totalRevenuePrevious == 0) {
            $percentageDiff = $totalRevenue > 0 ? 100 : 0;
        } else {
            $percentageDiff = round((($totalRevenue - $totalRevenuePrevious) / $totalRevenuePrevious) * 100);
        }

        return response()->json([
            'totalRevenue' => round($totalRevenue),
            'percentageDiff' => $percentageDiff,
        ]);
    }

    //filter the clients
    public function filterClients(Request $request)
    {
        $filter = $request->input('filter');
        $now = Carbon::now();
        $clientsQuery = Client::getAccessibleClients();

        $nbClientsCurrent = 0;
        $nbClientsPrevious = 0;

        switch ($filter) {
            case 'today':
                $nbClientsCurrent = $clientsQuery->whereDate('created_at', $now->toDateString())->count();
                $nbClientsPrevious = Client::getAccessibleClients()
                    ->whereDate('created_at', $now->subDay()->toDateString())
                    ->count();
                break;
            case 'month':
                $nbClientsCurrent = $clientsQuery->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
                $nbClientsPrevious = Client::getAccessibleClients()
                    ->whereMonth('created_at', $now->subMonth()->month)
                    ->whereYear('created_at', $now->year)
                    ->count();
                break;
            case 'year':
                $nbClientsCurrent = $clientsQuery->whereYear('created_at', $now->year)->count();
                $nbClientsPrevious = Client::getAccessibleClients()
                    ->whereYear('created_at', $now->subYear()->year)
                    ->count();
                break;
            default:
                return response()->json(['error' => 'Invalid filter'], 400);
        }

        // Calculate the percentage difference
        if ($nbClientsPrevious == 0) {
            $percentageDiff = $nbClientsCurrent > 0 ? 100 : 0;
        } else {
            $percentageDiff = round((($nbClientsCurrent - $nbClientsPrevious) / $nbClientsPrevious) * 100);
        }

        return response()->json([
            'nbClients' => $nbClientsCurrent,
            'percentageDiff' => $percentageDiff,
        ]);
    }
}

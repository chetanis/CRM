<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // Extract unique tables and actions from the logs
        $uniqueTables = Log::selectRaw('DISTINCT(SUBSTRING_INDEX(action, " ", 1)) as `table`')
                           ->pluck('table')
                           ->toArray();

        $uniqueActions = Log::selectRaw('DISTINCT(SUBSTRING_INDEX(SUBSTRING_INDEX(action, " ", 2), " ", -1)) as `action`')
                            ->pluck('action')
                            ->toArray();

        // Filter logs based on search criteria
        $logs = Log::query();

        if ($request->filled('user_id')) {
            $logs->where('user_id', $request->user_id);
        }

        if ($request->filled('table') && $request->filled('action')) {
            $logs->where('action', 'like', $request->table . ' ' . $request->action . '%');
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $logs->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $logs = $logs->latest()->paginate(20);

        return view('logs.index', compact('logs', 'uniqueTables', 'uniqueActions'));
    }
}

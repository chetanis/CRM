<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {

        // Define the unique tables and actions
        $uniqueTables = [
            'utilisateur', 'client', 'commande', 'rendez-vous', 'produit'
        ];

        $uniqueActions = [
            'Créer', 'annuler', 'changer', 'confirmer', 'modifier', 'Reprogrammer', 'supprimer', 'ajouter stock'
        ];

        // Filter logs based on search criteria
        $query = Log::query();

        if ($request->filled('username')) {
            //find the user with that username
            $user = User::where('username', $request->username)->first();
            //if the user is found, filter the logs based on the user_id
            if ($user){
                $query->where('user_id', $user->id);
            }
        }

        if ($request->filled('table')) {
            $query->where('action', 'like', '%' . $request->table . '%');
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $logs = $query->latest()->paginate(20);

        return view('logs.index', compact('logs', 'uniqueTables', 'uniqueActions'));
    }
}

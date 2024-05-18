<?php

namespace App\Http\Controllers;

use App\Models\ProductNotif;
use Illuminate\Http\Request;
use App\Models\PersonalNotif;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $personalNotifications = PersonalNotif::where('user_id', $user->id)->get();
        $productNotifications = ProductNotif::all();

        return response()->json([
            'personal_notifications' => $personalNotifications,
            'product_notifications' => $productNotifications,
        ]);
    }

    public function destroyPersonalNotif($id)
    {
        $notification = PersonalNotif::find($id);
        if ($notification) {
            $notification->delete();
            return response()->noContent();
        }

        return response()->json(['error' => 'Notification not found'], 404);
    }

    public function destroyProductNotif($id)
    {
        $notification = ProductNotif::find($id);
        if ($notification) {
            $notification->delete();
            return response()->noContent();
        }

        return response()->json(['error' => 'Notification not found'], 404);
    }
}

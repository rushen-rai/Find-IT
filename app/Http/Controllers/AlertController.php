<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alert;

class AlertController extends Controller
{
    // Get alerts: For admins, their action alerts; for users, matches.
    public function alerts()
    {
        if (Auth::user()->role === 'admin') {
            // Admins see alerts for their actions (approve/reject/delete)
            $alerts = Alert::where('user_id', Auth::id())
                ->whereIn('type', ['report_approved', 'report_rejected', 'report_deleted', 'claim_approved', 'claim_rejected', 'claim_deleted'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        } else {
            // Users see match alerts
            $alerts = Alert::where('user_id', Auth::id())
                ->where('type', 'match_found')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }

        return response()->json($alerts);
    }

    // Mark an alert as read.
    public function markAsRead($id, Request $request)
    {
        $alert = Alert::find($id);
        if ($alert && $alert->user_id == Auth::id()) {
            $alert->markAsRead();
        }
        return response()->json(['success' => true]);
    }
}

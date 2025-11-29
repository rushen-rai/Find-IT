<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Alert;

class NotificationController extends Controller
{
    // Get notifications: For admins, only their new submission notifications; for users, their own.
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // Admins see only notifications sent to them (new submissions by users)
            $notifications = Notification::where('user_id', Auth::id())
                ->whereIn('type', ['report_submitted', 'claim_submitted'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        } else {
            // Users see their own notifications
            $notifications = Notification::getUserNotifications(Auth::id())->get();
        }

        // Add status and label based on type for consistent rendering
        $notifications->transform(function ($n) {
            $n->status = $this->mapStatus($n->type);
            $n->label = $this->mapLabel($n->type);
            return $n;
        });

        return response()->json($notifications);
    }

    // Map type to status
    private function mapStatus($type)
    {
        $statusMap = [
            // Reports
            'report_submitted' => 'pending',
            'report_approved'  => 'approved',
            'report_rejected'  => 'rejected',
            'report_deleted'   => 'deleted',

            // Claims
            'claim_submitted'  => 'pending',
            'claim_approved'   => 'approved',
            'claim_rejected'   => 'rejected',
            'claim_deleted'    => 'deleted',
        ];

        return $statusMap[$type] ?? 'info';
    }


    // Map type to label
    private function mapLabel($type)
    {
        $labelMap = [
            'report_submitted' => 'report',
            'report_approved'  => 'report',
            'report_rejected'  => 'report',
            'report_deleted'   => 'report',

            'claim_submitted'  => 'claim',
            'claim_approved'   => 'claim',
            'claim_rejected'   => 'claim',
            'claim_deleted'    => 'claim',
        ];

        return $labelMap[$type] ?? 'notification';
    }


    // Mark a notification as read.
    public function markAsRead($id, Request $request)
    {
        $notification = Notification::find($id);
        if ($notification && $notification->user_id == Auth::id()) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    }
}

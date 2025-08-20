<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Show all notifications for the logged in user
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // Mark a notification as read
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->update(['read' => true]);
        }

        return back();
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::whereNull('read_at')->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    /**
     * Delete a notification
     */
    public function delete($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted');
    }

    /**
     * Clear all notifications
     */
    public function clearAll()
    {
        Notification::truncate();

        return redirect()->back()->with('success', 'All notifications cleared');
    }
}

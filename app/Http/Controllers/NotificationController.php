<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for authenticated user.
     */
    public function index()
    {
        $notifications = AppNotification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'type' => $n->type,
                    'title' => $n->title,
                    'message' => $n->message,
                    'icon' => $n->icon,
                    'is_read' => (bool) $n->is_read,
                    'created_at' => $n->created_at->toISOString(),
                    'time_ago' => $n->created_at->diffForHumans(),
                ];
            });

        return response()->json($notifications, 200);
    }

    /**
     * Get unread notification count.
     */
    public function unreadCount()
    {
        $count = AppNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count], 200);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead()
    {
        AppNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true], 200);
    }

    /**
     * Mark a single notification as read.
     */
    public function markRead($id)
    {
        $notification = AppNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true], 200);
    }
}

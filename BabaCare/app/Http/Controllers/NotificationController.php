<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        return view('notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $notif = auth()->user()->notifications()->findOrFail($id);
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
    
        if (is_null($notif->read_at)) {
            $notif->markAsRead();
        }
    
        return view('notifications.show', compact('notif', 'notifications'));
    }

    public function unreadCount()
    {
        return response()->json([
            'count' => auth()->user()->notifications()->where('is_read', false)->count()
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->update(['is_read' => true]);
        return back();
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->update(['is_read' => true]);
        return back();
    }
}

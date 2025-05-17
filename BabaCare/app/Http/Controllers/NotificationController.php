<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();

        return view('notifications.show', compact('notification', 'notifications'));
    }

    public function unreadCount()
    {
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count()
        ]);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
    
        if ($notification) {
            $notification->markAsRead();
        }
    
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }

    public function poll()
    {
        $user = auth()->user();
        $unread = $user->unreadNotifications()->take(5)->get();
    
        return response()->json([
            'count' => $unread->count(),
            'notifications' => $unread->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'title' => $notif->data['title'] ?? 'Notifikasi',
                    'message' => $notif->data['message'] ?? '',
                    'time' => $notif->data['time'] ?? '',
                    'created_at' => $notif->created_at->diffForHumans(),
                    'url' => route('notifications.show', $notif->id),
                ];
            }),
        ]);
    }

    public function latest()
    {
        $user = auth()->user();
        $notif = $user->unreadNotifications()->latest()->first();

        if (!$notif) {
            return response()->json(['has_new' => false]);
        }

        return response()->json([
            'has_new' => true,
            'id' => $notif->id,
            'title' => $notif->data['title'] ?? 'Reminder Janji Temu',
            'message' => $notif->data['message'] ?? '',
            'time' => $notif->data['time'] ?? '',
        ]);
    }

    

}

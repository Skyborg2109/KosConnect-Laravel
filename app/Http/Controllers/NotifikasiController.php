<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function getAdminNotifications()
    {
        $adminId = session('admin.id');
        
        $notifikasis = Notifikasi::where('user_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadCount = Notifikasi::where('user_id', $adminId)
            ->where('is_read', false)
            ->count();
        
        return response()->json([
            'notifications' => $notifikasis,
            'unread_count' => $unreadCount
        ]);
    }
    
    public function markAsRead($id)
    {
        $userId = session('admin.id') ?? session('user.id');
        
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
        $notifikasi->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        $userId = session('admin.id') ?? session('user.id');
        
        Notifikasi::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }
}

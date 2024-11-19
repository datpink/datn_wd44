<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Hiển thị danh sách thông báo cho client.
     */
    public function index()
    {
        // Lấy danh sách thông báo của user hiện tại (giả sử bạn đã cấu hình auth)
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Truyền danh sách thông báo sang view
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Render lại thông báo (ví dụ: thông báo chưa đọc).
     */
    public function temporary()
    {
        $unreadNotifications = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.notifications.temporary', ['notifications' => $unreadNotifications]);
    }
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
    
        if ($notification) {
            $notification->is_read = true; // Đánh dấu là đã đọc
            $notification->save();
        }
    
        return redirect()->back();
    }
    
}

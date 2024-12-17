<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Hiển thị danh sách thông báo cho client.
     */
    public function index()
    {

        if (Auth::check()) {
            $id = Auth::id(); // Lấy ID người dùng hiện tại
            $user = Auth::user(); // Lấy thông tin người dùng hiện tại

            // Lấy các thông báo chưa đọc của người dùng
            $unreadNotifications = Notification::where('user_id', $id)
                ->whereNull('read_at') // Chỉ lấy thông báo chưa đọc
                ->orderBy('created_at', 'desc') // Sắp xếp thông báo theo thứ tự mới nhất
                ->get();

            // Lấy tất cả thông báo của người dùng
            $allNotifications = Notification::where('user_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông báo.');
        }

        // Trả dữ liệu ra view
        return view('client.layouts.notification', compact('unreadNotifications', 'allNotifications', 'user'));
    }


    /**
     * Render lại thông báo (ví dụ: thông báo chưa đọc).
     */
    public function markAsReadAndRedirect($id)
    {
        // Lấy thông báo của người dùng hiện tại
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$notification) {
            return redirect()->route('notifications.index')->with('error', 'Thông báo không tồn tại.');
        }

        // Cập nhật read_at nếu chưa đọc
        if (is_null($notification->read_at)) {
            $notification->read_at = now();
            $notification->save();
        }

        // Chuyển hướng đến URL của thông báo nếu có
        return $notification->url 
            ? redirect($notification->url) 
            : redirect()->route('notifications.index');
    }
    public function destroy($id)
{
    // Lấy thông báo của người dùng hiện tại
    $notification = Notification::where('id', $id)
        ->where('user_id', auth()->id())
        ->first();

    if (!$notification) {
        return redirect()->route('notifications.index')->with('error', 'Thông báo không tồn tại.');
    }

    // Xóa thông báo
    $notification->delete();

    return redirect()->route('client.index')->with('success', 'Đã xóa thông báo thành công.');
}

}
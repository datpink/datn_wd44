<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotificationCreated;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Thông Báo';
        $query = Notification::query();
    
        // Tìm kiếm theo tiêu đề hoặc mô tả
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        }
    
        // Lọc theo trạng thái (đã đọc/chưa đọc)
        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->whereNotNull('read_at');
            } elseif ($request->status === 'unread') {
                $query->whereNull('read_at');
            }
        }
    
        $notificationAll = $query->paginate(10);
    
        return view('admin.notifications.index', compact('notificationAll', 'title'));
    }
    public function create()
    {
        $title = 'Thêm Mới Thông Báo';
        // Lấy tất cả người dùng
        $users = User::all();
        return view('admin.notifications.create', compact('users', 'title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'nullable|url',  // Kiểm tra định dạng URL hợp lệ
        ]);

        // Lấy user_id từ request và tạo thông báo
        $validated['user_id'] = $request->input('user_id');  // Lấy user_id từ form
        $notification = Notification::create($validated);

        // Gửi email thông báo
        $user = User::find($validated['user_id']);
        if ($user) {
            Mail::to($user->email)->send(new NotificationCreated($notification));
        }

        return redirect()->route('admin.notifications.index', compact('notification'))->with('success', 'Thông báo đã được tạo thành công.');
    }
    public function destroy($id)
    {
        // Tìm thông báo theo ID
        $notification = Notification::find($id);

        if (!$notification) {
            return redirect()->route('admin.notifications.index')->with('error', 'Thông báo không tồn tại.');
        }

        // Thực hiện xóa thông báo
        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Thông báo đã được xóa thành công.');
    }


}

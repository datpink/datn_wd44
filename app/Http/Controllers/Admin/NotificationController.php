<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(10); // Lấy danh sách thông báo
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        // Lấy tất cả người dùng
        $users = User::all();
        return view('admin.notifications.create', compact('users'));
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
        Notification::create($validated);
    
        return redirect()->route('admin.notifications.index')->with('success', 'Thông báo đã được tạo thành công.');
    }
    }

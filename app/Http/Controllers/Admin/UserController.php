<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Import model Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $title = 'Danh Sách Người Dùng';
        $users = User::paginate(10);
        return view('admin.users.index', compact('users', 'title'));
        
    }

    // Hiển thị form thêm mới người dùng
    public function create()
    {
        $title = 'Thêm Mới Người Dùng';
        $roles = Role::all(); // Lấy tất cả vai trò
        return view('admin.users.create', compact('title', 'roles'));
        
    }

    // Lưu thông tin người dùng mới và gán vai trò
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:locked,unlocked',
            'role' => 'required' // Kiểm tra role
        ]);

        // Tạo người dùng
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        // Gán vai trò cho người dùng
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $title = 'Chỉnh Sửa Người Dùng';
        $user = User::findOrFail($id);
        $roles = Role::all(); // Lấy tất cả vai trò
        return view('admin.users.edit', compact('title', 'user', 'roles'));
    }

    // Cập nhật thông tin người dùng và vai trò
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:locked,unlocked', // Kiểm tra trạng thái
            'role' => 'required|string', // Thêm kiểm tra cho role
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status; // Cập nhật trạng thái

        // Cập nhật hình ảnh
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Lưu hình ảnh mới
            $user->image = $request->file('image')->store('user_images', 'public');
        }

        // Lưu thay đổi
        $user->save();

        // Gán vai trò mới cho người dùng
        $user->syncRoles([$request->role]); // Sử dụng syncRoles thay vì assignRole

        return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật thành công!');
    }


    public function viewProfile(Request $request)
{
    // Lấy thông tin người dùng sau khi đã đăng nhập
    $user = Auth::user();

    // Kiểm tra xem người dùng có tồn tại không
    if (!$user) {
        return redirect()->route('login')->withErrors(['username' => 'Bạn cần đăng nhập trước khi xem trang này.']);
    }

    info('User logged in: ' . $user->email);

    // Kiểm tra trạng thái tài khoản
    if ($user->status === 'locked') {
        Auth::logout(); // Đăng xuất nếu tài khoản bị khóa
        return redirect()->back()->withErrors(['username' => 'Tài khoản của bạn đã bị khóa.']);
    }

    // Trả về view profile.blade.php và truyền dữ liệu người dùng
    return view('client.user.profile', compact('user')); // 'user' là đối tượng người dùng đã được truyền
}
public function editProfile()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
        return view('client.user.edit-profile', compact('user'));
    }

    // Xử lý cập nhật thông tin người dùng
    public function updateProfile(Request $request, $id)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:2048', // Thêm quy tắc xác thực cho trường ảnh
    ]);

    // Lấy thông tin người dùng hiện tại
    $user = User::findOrFail($id);
    // Cập nhật thông tin
    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->address = $request->address;

    // Cập nhật hình ảnh nếu có
    if ($request->hasFile('image')) {
        // Xóa hình ảnh cũ nếu có
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        // Lưu hình ảnh mới
        $user->image = $request->file('image')->store('user_images', 'public');
    }

    // Lưu thay đổi vào database
    $user->save();

    return redirect()->route('profile.show', ['id' => $user->id])->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
}


    public function editPassword()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
        return view('client.user.edit-password', compact('user'));
    }
    public function updatePassword(Request $request, $id)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed', // mật khẩu mới phải trùng với xác nhận
    ]);

    // Tìm người dùng theo ID
    $user = User::findOrFail($id);

    // Kiểm tra mật khẩu cũ có khớp hay không
    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->withErrors(['current_password' => 'Mật khẩu cũ không đúng']);
    }

    // Cập nhật mật khẩu mới (sử dụng bcrypt để mã hóa)
    $user->password = Hash::make($request->new_password);
    $user->save();

    // Chuyển hướng lại trang profile với thông báo thành công
    return redirect()->route('profile.show', $user->id)->with('success', 'Mật khẩu đã được thay đổi thành công!');
}

}

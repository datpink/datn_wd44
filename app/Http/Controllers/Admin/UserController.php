<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Role; // Import model Role
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index(Request $request)
    {
        $title = 'Danh Sách Người Dùng';
        // Lấy từ khóa tìm kiếm và trạng thái từ request
        $search = $request->input('search');
        $status = $request->input('status');

        // Lọc người dùng dựa trên từ khóa và trạng thái
        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }
        $users = $query->paginate(10); // Phân trang và giữ lại các tham số query

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
            'status' => 'required|in:locked,unlocked', // Kiểm tra trạng thái
            'role' => 'required|string', // Thêm kiểm tra cho role
        ]);

        $user = User::findOrFail($id);
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
        $provinces = Province::all(['id', 'name']); // Lấy danh sách các tỉnh

        // Tách địa chỉ
        $province = $district = $ward = null;
        if ($user->address) {
            // Tách chuỗi địa chỉ thành các phần (Tỉnh - Huyện - Xã)
            $addressParts = explode(' - ', $user->address);

            // Đảm bảo có đủ 3 phần: tỉnh - huyện - xã
            if (count($addressParts) >= 3) {
                $provinceName = trim($addressParts[0]); // Loại bỏ khoảng trắng thừa
                $districtName = trim($addressParts[1]);
                $wardName = trim($addressParts[2]);

                // Tìm tỉnh, huyện, xã/phường từ cơ sở dữ liệu
                $province = Province::where('name', 'like', "%$provinceName%")->first();
                $district = District::where('name', 'like', "%$districtName%")->first();
                $ward = Ward::where('name', 'like', "%$wardName%")->first();
            }
        }

        return view('client.user.edit-profile', compact('user', 'provinces', 'province', 'district', 'ward'));
    }




    // Xử lý cập nhật thông tin người dùng
    public function updateProfile(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        // dd($request->all());
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
        $user->address = $request->full_address;

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

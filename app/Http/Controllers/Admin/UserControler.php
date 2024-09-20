<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserControler extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Người Dùng';
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('parent', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }
        $users = $query->paginate(10);

        return view('admin.users.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Mới Người Dùng';
        $roleUser = User::whereNull('role_id')->get();

        return view('admin.users.create', compact('title', 'roleUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'password' => 'required',
            'address' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^(\+84|0)(\d{9,10})$/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'required|in:1,2,3',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('user_images', 'public');
            $user->image = $imagePath;
        }
        $user->save();
        return redirect()->route('users.index')->with('success', 'Người dùng đã được thêm mới.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Cập Nhật Người Dùng';

        return view('admin.users.edit', ['title', 'user' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'password' => 'required',
            'address' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^(\+84|0)(\d{9,10})$/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'required|in:1,2,3',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('user_images', 'public');;
        }
        $user->save();
        return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $id)
    {
        $user = User::findOrFail($id);

        if (User::where('role_id', $user->id)->exists()) {
            return redirect()->route('user.index')->with('error', 'Không thể xóa người dùng này');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa thành công!');
    }
    public function trash()
    {
        $title = 'Thùng Rác';
        $users = User::onlyTrashed()->get();
        return view('admin.users.trash', compact('users', 'title'));
    }
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trash')->with('success', 'Người dùng đã được khôi phục thành công!');
    }
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (User::where('parent_id', $user->id)->exists()) {
            return redirect()->route('users.trash')->with('error', 'Không thể xóa cứng người dùng này vì nó là người dùng cha của một hoặc nhiều người dùng khác.');
        }

        $user->forceDelete();

        return redirect()->route('users.trash')->with('success', 'Người dùng đã được xóa cứng thành công!');
    }

}

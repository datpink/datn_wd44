<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Danh sách Banner';
        // Thực hiện tìm kiếm nếu có
        $search = $request->input('search');
        $banners = Banner::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin.banners.index', compact('banners', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Mới Banner';
        return view('admin.banners.create', compact('title'));
    }

    // Lưu banner mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        // Lưu hình ảnh vào thư mục storage
        $imagePath = $request->file('image')->store('banners', 'public');

        // Tạo mới banner
        Banner::create([
            'image' => $imagePath,
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'status' => $request->status,
        ]);

        return redirect()->route('banners.index')->with('success', 'Thêm banner thành công!');
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
    public function edit(Banner $banner)
    {
        $title = 'Chỉnh Sửa Banner';
        return view('admin.banners.edit', compact('banner', 'title'));
    }

    // Phương thức để cập nhật banner
    public function update(Request $request, Banner $banner)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cập nhật thông tin banner
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->button_text = $request->button_text;
        $banner->button_link = $request->button_link;
        $banner->status = $request->status;

        // Kiểm tra và xử lý hình ảnh
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($banner->image) {
                Storage::delete($banner->image);
            }

            // Lưu hình ảnh mới
            $path = $request->file('image')->store('banners');
            $banner->image = $path;
        }

        // Lưu thay đổi vào cơ sở dữ liệu
        $banner->save();

        // Chuyển hướng với thông báo thành công
        return redirect()->route('banners.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Xóa thành công');
    }

    public function trash()
    {
        $title = 'Thùng Rác Banner';
        // Fetch soft-deleted banners
        $banners = Banner::onlyTrashed()->get();
        return view('admin.banners.trash', compact('banners', 'title'));
    }

    public function restore($id)
    {
        // Restore the soft-deleted banner
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->restore();

        return redirect()->route('banners.trash')->with('restoreBanner', 'Banner đã được khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        // Permanently delete the banner
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->forceDelete();

        return redirect()->route('banners.trash')->with('forceDeleteBanner', 'Banner đã bị xóa vĩnh viễn!');
    }

}

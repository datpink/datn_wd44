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
        $search = $request->input('search');
        $status = $request->input('status');

        $banners = Banner::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })->when($status, function ($query, $status) {
            return $query->where('status', $status);
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
        // Kiểm tra và xác nhận các trường dữ liệu
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ], [
            'image.required' => 'Hình ảnh là bắt buộc.',
            'image.image' => 'Vui lòng chọn tệp hình ảnh hợp lệ.',
            'image.mimes' => 'Chỉ chấp nhận tệp hình ảnh có đuôi: jpeg, png, jpg, gif.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',

            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả phải là một chuỗi văn bản.',

            'button_text.max' => 'Văn bản nút không được vượt quá 255 ký tự.',
            'button_link.url' => 'Liên kết nút phải là một URL hợp lệ.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "active" hoặc "inactive".',
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ], [
            'image.required' => 'Hình ảnh là bắt buộc.',
            'image.image' => 'Vui lòng chọn tệp hình ảnh hợp lệ.',
            'image.mimes' => 'Chỉ chấp nhận tệp hình ảnh có đuôi: jpeg, png, jpg, gif.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',

            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả phải là một chuỗi văn bản.',

            'button_text.max' => 'Văn bản nút không được vượt quá 255 ký tự.',
            'button_link.url' => 'Liên kết nút phải là một URL hợp lệ.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "active" hoặc "inactive".',
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
            $path = $request->file('image')->store('banners', 'public');
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

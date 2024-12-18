<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh sách Quảng Cáo';
        // Lấy danh sách quảng cáo với tùy chọn tìm kiếm
        $query = Advertisement::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
            // Lọc theo trạng thái
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

        $advertisements = $query->paginate(10); // Phân trang 10 quảng cáo mỗi trang
        return view('admin.advertisements.index', compact('advertisements', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Quảng Cáo';
        return view('admin.advertisements.create', compact('title'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'image' => 'required|image|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'position' => 'required|integer|min:0|unique:advertisements,position', // Kiểm tra tính duy nhất
            'status' => 'required|in:active,inactive',
        ], [
            // Các thông báo lỗi bằng tiếng Việt
            'image.required' => 'Hình ảnh là trường bắt buộc.',
            'image.image' => 'Hình ảnh phải là tệp định dạng hợp lệ.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả phải là chuỗi.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'button_text.string' => 'Văn bản nút phải là chuỗi.',
            'button_text.max' => 'Văn bản nút không được vượt quá 50 ký tự.',
            'button_link.url' => 'Liên kết nút phải là URL hợp lệ.',
            'position.required' => 'Vị trí là trường bắt buộc.',
            'position.integer' => 'Vị trí phải là số nguyên.',
            'position.min' => 'Vị trí phải là số nguyên không âm.',
            'position.unique' => 'Vị trí này đã tồn tại. Vui lòng chọn vị trí khác.',
            'status.required' => 'Trạng thái là trường bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        // Lưu hình ảnh
        $path = $request->file('image')->store('advertisements', 'public');

        // Tạo quảng cáo mới
        Advertisement::create([
            'image' => $path,
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return redirect()->route('advertisements.index')->with('success', 'Quảng cáo đã được thêm thành công.');
    }


    public function edit($id)
    {
        $title = 'Chỉnh Sửa Quảng Cáo';
        $advertisement = Advertisement::findOrFail($id);
        return view('admin.advertisements.edit', compact('advertisement', 'title'));
    }

    public function update(Request $request, $id)
    {
        $advertisement = Advertisement::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'position' => [
                'required',
                'nullable',
                'integer',
                'min:0',
                Rule::unique('advertisements', 'position')->ignore($id), // Kiểm tra tính duy nhất trừ ID hiện tại
            ],
            'status' => 'required|in:active,inactive',
        ], [
            // Các thông báo lỗi bằng tiếng Việt
            'image.required' => 'Hình ảnh là trường bắt buộc.',
            'image.image' => 'Hình ảnh phải là tệp định dạng hợp lệ.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả phải là chuỗi.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'button_text.string' => 'Văn bản nút phải là chuỗi.',
            'button_text.max' => 'Văn bản nút không được vượt quá 50 ký tự.',
            'button_link.url' => 'Liên kết nút phải là URL hợp lệ.',
            'position.required' => 'Vị trí là trường bắt buộc.',
            'position.integer' => 'Vị trí phải là số nguyên.',
            'position.min' => 'Vị trí phải là số nguyên không âm.',
            'position.unique' => 'Vị trí này đã tồn tại. Vui lòng chọn vị trí khác.',
            'status.required' => 'Trạng thái là trường bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        // Cập nhật hình ảnh nếu có
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('advertisements', 'public');
            $advertisement->image = $path;
        }

        // Cập nhật các trường khác
        $advertisement->title = $request->title;
        $advertisement->description = $request->description;
        $advertisement->button_text = $request->button_text;
        $advertisement->button_link = $request->button_link;
        $advertisement->position = $request->position; // Cập nhật trường position
        $advertisement->status = $request->status;

        $advertisement->save();

        return redirect()->route('advertisements.index')->with('success', 'Advertisement updated successfully.');
    }

    public function destroy($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $advertisement->delete();
        return redirect()->route('advertisements.index')->with('success', 'Advertisement deleted successfully.');
    }

    public function advertisementClick($id)
{
    // Lấy địa chỉ IP của người dùng
    $userIp = \Request::ip();

    // Tìm quảng cáo theo ID
    $advertisement = Advertisement::findOrFail($id);

    // Kiểm tra nếu người dùng đã nhấp vào liên kết này chưa
    $existingView = \DB::table('advertisement_views')
        ->where('advertisement_id', $id)
        ->where('user_ip', $userIp)
        ->exists();

    if (!$existingView) {
        // Tăng lượt xem
        $advertisement->increment('view');

        // Lưu thông tin vào bảng advertisement_views
        \DB::table('advertisement_views')->insert([
            'advertisement_id' => $id,
            'user_ip' => $userIp,
            'created_at' => now(),
        ]);
    }

    // Điều hướng người dùng đến link gốc
    return redirect($advertisement->button_link);
}
}

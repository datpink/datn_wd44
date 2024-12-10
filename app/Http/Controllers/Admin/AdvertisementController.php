<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

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
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|url',
            'position' => 'nullable|integer', // Validate trường position
            'status' => 'required|in:active,inactive',
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
            'position' => $request->position, // Lưu trường position
            'status' => $request->status,
        ]);

        return redirect()->route('advertisements.index')->with('success', 'Advertisement created successfully.');
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
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|url',
            'position' => 'nullable|integer', // Validate trường position
            'status' => 'required|in:active,inactive',
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
}

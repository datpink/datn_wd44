<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $title = 'Danh Sách Mã Giảm Giá';
        $promotions = Promotion::paginate(10);
        return view('admin.promotions.index', compact('promotions', 'title'));
    }

        public function create()
    {
        $title = 'Thêm mới mã giảm giá';
        return view('admin.promotions.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validatedData = $request->validate([
            'code' => 'required|string|max:50|unique:promotions',
            'discount_value' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,pending',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $promotion = Promotion::create($validatedData);

        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $title = 'Cập Nhật Mã Giảm Giá';
        $promotion = Promotion::findOrFail($id);
    
        return view('admin.promotions.edit', compact('promotion', 'title'));
    }

    /**
     * Update the specified resource in storage.    
     */
    public function update(Request $request, string $id)
{
    $promotion = Promotion::findOrFail($id);

    // Xác thực dữ liệu
    $validatedData = $request->validate([
        'code' => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
        'discount_value' => 'required|numeric|min:0',
        'status' => 'required|in:active,inactive,pending',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after:start_date',
    ]);

    $promotion->update($validatedData);

    return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được cập nhật thành công!');
}
    public function destroy(string $id)
    {
    $promotion = Promotion::findOrFail($id);
    $promotion->delete();
    return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được xóa thành công!');
    }
}

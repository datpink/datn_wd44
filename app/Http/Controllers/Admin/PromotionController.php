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
        $validated = $request->validate([
            'code' => 'required|unique:promotions,code|max:255',
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    // Kiểm tra nếu loại mã giảm giá là 'percentage', giá trị không vượt quá 100
                    if ($request->input('type') === 'percentage' && $value > 100) {
                        $fail('Giá trị giảm giá không thể vượt quá 100%.');
                    }
                },
            ],
            'status' => 'required|in:active,inactive,pending',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'applies_to_order' => [
                'required',
                'boolean',
                function($attribute, $value, $fail) use ($request){
                    if($request->input('type') === 'free_shipping' && $value == 1){
                        $fail('Mã giảm giá cho đơn hàng Free Shipping ');
                    };
                }
            ],
            'applies_to_shipping' => 'required|boolean',
            'min_order_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    // Kiểm tra nếu loại mã giảm giá là 'percentage', giá trị không vượt quá 100
                    if ($request->input('max_value') <= $value ) {
                        $fail('Giá Trị đơn hàng tối thiểu không được lớn hơn hoặc bằng giá trị đơn hàng tối đa');
                    }
                },
            ], 
            'max_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    // Kiểm tra nếu loại mã giảm giá là 'percentage', giá trị không vượt quá 100
                    if ($request->input('min_order_value') >= $value ) {
                        $fail('Giá Trị đơn hàng tối đa không được nhỏ hơn hoặc bằng giá trị đơn hàng tối thiểu');
                    }
                },
            ],
        ]);
        // Create the new promotion
        $promotion = new Promotion();
        $promotion->code = $request->input('code');
        $promotion->discount_value = $request->input('discount_value');
        $promotion->status = $request->input('status');
        $promotion->start_date = $request->input('start_date');
        $promotion->end_date = $request->input('end_date');
        $promotion->type = $request->input('type');
        $promotion->applies_to_order = $request->input('applies_to_order');
        $promotion->applies_to_shipping = $request->input('applies_to_shipping');
        $promotion->min_order_value = $request->input('min_order_value');  // Lưu giá trị đơn hàng
        $promotion->max_value = $request->input('max_value');  // Lưu giá trị đơn hàng
        $promotion->save();

        return redirect()->route('promotions.index')->with('success', 'Mã Giảm Giá đã được thêm thành công!');
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

        $request->validate([
            'code' => 'required|unique:promotions,code,' . $promotion->id . '|max:255',
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === 'percentage' && $value > 100) {
                        $fail('Giá trị giảm giá phần trăm không thể lớn hơn 100.');
                    }
                }
            ],
            'status' => 'required|in:active,inactive',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'applies_to_order' => 'required|boolean',
            'applies_to_shipping' => [
                'required',
                'boolean',
                function($attribute, $value, $fail) use ($request){
                    if($request->input('type') !== 'free_shipping' && $value === 1){
                        $fail('Mã giảm giá cho đơn hàng Free Shipping ');
                    };
                }
            ],
            'min_order_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    // Kiểm tra nếu loại mã giảm giá là 'percentage', giá trị không vượt quá 100
                    if ($request->input('max_value') <= $value ) {
                        $fail('Giá Trị đơn hàng tối thiểu không được lớn hơn hoặc bằng giá trị đơn hàng tối đa');
                    }
                },
            ], 
            'max_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    // Kiểm tra nếu loại mã giảm giá là 'percentage', giá trị không vượt quá 100
                    if ($request->input('min_order_value') >= $value ) {
                        $fail('Giá Trị đơn hàng tối đa không được nhỏ hơn hoặc bằng giá trị đơn hàng tối thiểu');
                    }
                },
            ],
        ]);

        $promotion->update($request->all());

        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được cập nhật thành công!');
    }
    public function destroy(string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được xóa thành công!');
    }
}

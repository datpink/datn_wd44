<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Mã Giảm Giá';

        $query = Promotion::query();

        // Tìm kiếm theo từ khóa
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo "Áp dụng cho đơn hàng"
        if ($request->filled('applies_to_order')) {
            $query->where('applies_to_order', $request->applies_to_order);
        }

        // Lọc theo "Áp dụng cho phí vận chuyển"
        if ($request->filled('applies_to_shipping')) {
            $query->where('applies_to_shipping', $request->applies_to_shipping);
        }


        $promotions = $query->paginate(10);

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
            'code' => [
                'required',
                'unique:promotions,code,' . ($promotion->id ?? 'NULL') . '|max:255',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[A-Za-z0-9-_]+$/', $value)) {
                        $fail('Mã giảm giá chỉ được chứa chữ cái, số, dấu gạch ngang hoặc gạch dưới.');
                    }
                }
            ],
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
            'start_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime('today')) {
                        $fail('Ngày bắt đầu phải là hôm nay hoặc sau hôm nay.');
                    }
                }
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'min_order_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('max_value') && $value >= $request->input('max_value')) {
                        $fail('Giá trị đơn hàng tối thiểu không được lớn hơn hoặc bằng giá trị đơn hàng tối đa.');
                    }
                }
            ],
            'max_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('min_order_value') && $value <= $request->input('min_order_value')) {
                        $fail('Giá trị đơn hàng tối đa không được nhỏ hơn hoặc bằng giá trị đơn hàng tối thiểu.');
                    }
                }
            ],
        ], [
            'code.required' => 'Mã giảm giá là bắt buộc.',
            'code.unique' => 'Mã giảm giá này đã tồn tại.',
            'code.max' => 'Mã giảm giá không được vượt quá :max ký tự.',
            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là một số.',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn :min.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'type.required' => 'Loại mã giảm giá là bắt buộc.',
            'type.in' => 'Loại mã giảm giá không hợp lệ.',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
            'min_order_value.min' => 'Giá trị đơn hàng tối thiểu không được nhỏ hơn :min.',
            'max_value.numeric' => 'Giá trị đơn hàng tối đa phải là một số.',
            'max_value.min' => 'Giá trị đơn hàng tối đa không được nhỏ hơn :min.',
        ]);

        // Create the new promotion
        $promotion = new Promotion();
        $promotion->code = $request->input('code');
        $promotion->discount_value = $request->input('discount_value');
        $promotion->status = $request->input('status');
        $promotion->start_date = $request->input('start_date');
        $promotion->end_date = $request->input('end_date');
        $promotion->type = $request->input('type');
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

        $validated = $request->validate([
            'code' => [
                'required',
                'unique:promotions,code,' . ($promotion->id ?? 'NULL') . '|max:255',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[A-Za-z0-9-_]+$/', $value)) {
                        $fail('Mã giảm giá chỉ được chứa chữ cái, số, dấu gạch ngang hoặc gạch dưới.');
                    }
                }
            ],
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
            'start_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime('today')) {
                        $fail('Ngày bắt đầu phải là hôm nay hoặc sau hôm nay.');
                    }
                }
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'min_order_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('max_value') && $value >= $request->input('max_value')) {
                        $fail('Giá trị đơn hàng tối thiểu không được lớn hơn hoặc bằng giá trị đơn hàng tối đa.');
                    }
                }
            ],
            'max_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('min_order_value') && $value <= $request->input('min_order_value')) {
                        $fail('Giá trị đơn hàng tối đa không được nhỏ hơn hoặc bằng giá trị đơn hàng tối thiểu.');
                    }
                }
            ],
        ], [
            'code.required' => 'Mã giảm giá là bắt buộc.',
            'code.unique' => 'Mã giảm giá này đã tồn tại.',
            'code.max' => 'Mã giảm giá không được vượt quá :max ký tự.',
            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là một số.',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn :min.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'type.required' => 'Loại mã giảm giá là bắt buộc.',
            'type.in' => 'Loại mã giảm giá không hợp lệ.',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
            'min_order_value.min' => 'Giá trị đơn hàng tối thiểu không được nhỏ hơn :min.',
            'max_value.numeric' => 'Giá trị đơn hàng tối đa phải là một số.',
            'max_value.min' => 'Giá trị đơn hàng tối đa không được nhỏ hơn :min.',
        ]);



        $promotion->update($request->all());

        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được cập nhật thành công!');
    }
    public function destroy(string $id)
    {
        $promotion = Promotion::findOrFail($id);

        // Kiểm tra nếu khuyến mãi đang được tham chiếu trong bất kỳ đơn hàng nào
        if (Order::where('promotion_id', $promotion->id)->exists()) {
            return redirect()->route('promotions.index')->with('error11', 'Không thể xóa khuyến mãi vì nó đã được áp dụng trong đơn hàng.');
        }

        // Kiểm tra nếu khuyến mãi đang trong thời gian áp dụng
        $currentDate = now();
        if ($promotion->start_date <= $currentDate && $promotion->end_date >= $currentDate) {
            return redirect()->route('promotions.index')->with('error22', 'Không thể xóa khuyến mãi vì nó đang trong thời gian áp dụng.');
        }

        // Xóa khuyến mãi
        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được xóa thành công!');
    }

}

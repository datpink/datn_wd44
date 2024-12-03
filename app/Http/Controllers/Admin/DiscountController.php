<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index()
    {
        $title = 'Danh sách Giảm Giá';
        $discounts = Discount::paginate(10);// Lấy 10 bản ghi mỗi trang
        return view('admin.discounts.index', compact('discounts', 'title'));
    }

    public function create()
    {
        $title = 'Thêm mới giảm giá theo danh mục';
        return view('admin.discounts.add', compact('title'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'discount_value' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Tạo mới đợt giảm giá
        $discount = new Discount();
        $discount->discount_value = $request->discount_value;
        $discount->type = $request->type;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->save();

        // Quay lại trang danh sách với thông báo thành công
        return redirect()->route('discounts.index')->with('success', 'Đợt giảm giá đã được thêm thành công!');
    }
    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'discount_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|in:percentage,fixed',
        ]);

        // Tìm và cập nhật giảm giá
        $discount = Discount::findOrFail($id);
        $discount->update($request->all());

        // Trả về thông báo thành công và chuyển hướng
        return redirect()->route('discounts.index')->with('success', 'Đợt giảm giá đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('discounts.index')->with('success', 'Đợt giảm giá đã được xóa!');
    }


    public function showDiscountToCatalogue()
    {
        $title = 'Danh Sách giảm giá theo danh mục';
        // Lấy danh sách tất cả các danh mục cùng thông tin giảm giá
        $catalogues = Catalogue::with(['discounts', 'products'])->get();
        $discounts = Discount::all(); // Lấy tất cả các giảm giá

        return view('admin.discounts.applyToCatalogue', compact('catalogues', 'discounts', 'title'));
    }


    public function applyDiscount(Request $request, $catalogueId)
    {
        // 1. Lấy danh mục theo ID
        $catalogue = Catalogue::find(id: $catalogueId);

        // Kiểm tra nếu danh mục không tồn tại
        if (!$catalogue) {
            return redirect()->back()->with('error', 'Danh mục không tồn tại!');
        }

        // 2. Lấy giảm giá theo ID
        $discount = Discount::find($request->discount_id);

        // Kiểm tra nếu giảm giá không tồn tại
        if (!$discount) {
            return redirect()->back()
                ->with('error', 'Đợt giảm giá không tồn tại!');
        }
        // $products = Product::where('catelogue_id', '=', $catalogueId);
        // foreach ($products as $product){
        //     $discount_price = $product->getDiscountPrice();
        //     // dd($discount_price);
        //     // Product::update('discount_price', $discount_price);
        // }
        // 3. Áp dụng giảm giá cho danh mục
        // Kết nối bảng catalogue_discounts
        $catalogue->discounts()->sync([$discount->id]);

        // 4. Cập nhật giá cho các sản phẩm trong danh mục
        foreach ($catalogue->products as $product) {
            if ($discount->type === 'percentage') {
                // Áp dụng giảm giá theo phần trăm
                $discountAmount = ($product->price * $discount->discount_value) / 100;
                $product->discount_price = $product->price - $discountAmount;
            } else {
                // Áp dụng giảm giá cố định
                $product->discount_price = max(0, $product->price - $discount->discount_value);
            }

            // Lưu thay đổi giá sản phẩm
            $product->save();
        }

        // 5. Trả về thông báo thành công
        return redirect()->back()->with('success', 'Giảm giá đã được áp dụng cho danh mục!');
    }
    public function removeDiscount($catalogueId)
    {
        $catalogue = Catalogue::findOrFail($catalogueId);

        // Kiểm tra nếu có giảm giá đang áp dụng
        if ($catalogue->discounts->isNotEmpty()) {
            // Xóa giảm giá của danh mục từ bảng catalogue_discounts
            foreach ($catalogue->discounts as $discount) {
                DB::table('catelogue_discounts')
                    ->where('catalogue_id', $catalogue->id)
                    ->where('discount_id', $discount->id)
                    ->delete();
            }
            // Cập nhật lại giá của các sản phẩm trong danh mục về giá gốc
            foreach ($catalogue->products as $product) {
                // Đặt lại discount_price về giá gốc (price)
                $product->discount_price = $product->price;
                $product->save();
            }

            return redirect()->route('admin.catalogueList')->with('success', 'Giảm giá đã được hủy thành công!');
        }

        return redirect()->route('admin.catalogueList')->with('error', 'Không có giảm giá nào để hủy!');
    }
}

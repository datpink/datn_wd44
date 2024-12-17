<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DiscountController extends Controller
{
    public function index()
    {
        $title = 'Danh sách Giảm Giá';
        $discounts = Discount::paginate(10); // Lấy 10 bản ghi mỗi trang
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
    // Kiểm tra xem discount còn áp dụng cho sản phẩm nào không
    $discountInProducts = DB::table('discounted_products')
        ->where('discount_id', $id)
        ->exists();

    $discountInCatalogues = DB::table('catelogue_discounts')
        ->where('discount_id', $id)
        ->exists();

    // Nếu có sản phẩm áp dụng giảm giá thì không thực hiện xóa
    if ($discountInProducts || $discountInCatalogues) {
        
        return redirect()->back()->with('errors', 'bạn không thể xóa do còn sản phẩm đang giảm giá');
    }

    // Nếu không còn sản phẩm nào áp dụng giảm giá, tiến hành xóa discount
    $discount = Discount::find($id);

    if ($discount) {
        $discount->delete();
        return redirect()->back()->with('success', 'Giảm giá đã được xóaxóa thành công!');
    }

    return redirect()->back()->with('errors', 'Không tìm thấy giảm giá cần xóa.');
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
            return redirect()->back()->with('errorss', 'Danh mục không tồn tại!');
        }

        // 2. Lấy giảm giá theo ID
        $discount = Discount::find($request->discount_id);

        // Kiểm tra nếu giảm giá không tồn tại
        if (!$discount) {
            return redirect()->back()
                ->with('errorss', 'Đợt giảm giá không tồn tại!');
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


    public function listProductsDiscount($discountId)
    {
        $discount = Discount::findOrFail($discountId);

        // Lấy tất cả sản phẩm
        $products = Product::all()->map(function ($product) {
            // Kiểm tra xem sản phẩm có trong bảng discounted_products không
            $discountEntry = DB::table('discounted_products')
                ->where('product_id', $product->id)
                ->first();

            // Thêm thông tin giảm giá vào sản phẩm
            $product->discount_info = $discountEntry;

            if ($discountEntry) {
                // Lấy thông tin chi tiết giảm giá
                $discount = Discount::find($discountEntry->discount_id);
                $product->current_discount = $discount;

                if ($discount) {
                    $product->status = [
                        'type' => $discount->type,
                        'value' => $discount->discount_value,
                        'formatted_value' => $discount->type === 'percentage'
                            ? $discount->discount_value . '%'
                            : number_format($discount->discount_value, 0, ',', '.') . ' VND',
                    ];
                } else {
                    $product->status = null;
                }
                if ($discount && $discount->expires_at) {
                    $currentTime = now();
                    $expiryTime = \Carbon\Carbon::parse($discount->expires_at);
                    $product->remaining_time = $expiryTime->diffForHumans($currentTime);  // Tính thời gian còn lại
                } else {
                    $product->remaining_time = 'Không có thời gian hết hạn';
                }
            } else {
                $product->status = null; // Không có giảm giá
            }

            return $product;
        });

        return view('admin.discounts.applyToProduct', compact('discount', 'products'));
    }



    public function applyToProducts(Request $request, $discountId)
    {
        $productIds = $request->input('product_ids', []);

        if (empty($productIds)) {
            return redirect()->back()->with('error', 'Không có sản phẩm nào được chọn.');
        }

        $discount = Discount::findOrFail($discountId);

        $errorMessages = []; // Mảng để lưu thông báo lỗi
        $successCount = 0; // Đếm số sản phẩm áp dụng giảm giá thành công

        // Lấy tất cả các sản phẩm với id có trong mảng $productIds
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            // Kiểm tra xem sản phẩm có đang áp dụng giảm giá hay không
            $existingDiscountEntry = DB::table('discounted_products')
                ->where('product_id', $product->id)
                ->where('discount_id', $discountId)
                ->first();

            // Nếu sản phẩm đã có giảm giá với discount_id này
            if ($existingDiscountEntry) {
                $errorMessages[] = 'Sản phẩm "' . $product->name . '" đã áp dụng giảm giá này rồi.';
                continue; // Bỏ qua sản phẩm này
            }

            // Kiểm tra xem sản phẩm có đang áp dụng giảm giá nào khác ngoài discountId này hay không
            $existingDiscount = $product->discounts()->where('discount_id', '!=', $discountId)->first();

            if ($existingDiscount) {
                // Nếu sản phẩm đã có giảm giá khác, lưu thông báo lỗi
                $existingDiscountValue = $existingDiscount->discount_value;
                $existingDiscountType = $existingDiscount->type;

                if ($existingDiscountType === 'percentage') {
                    $existingDiscountValue .= '%';
                } else {
                    $existingDiscountValue = number_format($existingDiscountValue, 0, ',', '.') . '₫';
                }

                $errorMessages[] = 'Sản phẩm "' . $product->name . '" đang được giảm giá bởi chương trình khác. Giảm giá hiện tại: ' . $existingDiscountValue;
                continue; // Bỏ qua sản phẩm này
            }

            // Áp dụng giảm giá cho sản phẩm
            // Cập nhật giá giảm cho sản phẩm
            if ($discount->type === 'percentage') {
                // Giảm giá theo phần trăm
                $discountAmount = $product->price * ($discount->discount_value / 100);
                $product->discount_price = $product->price - $discountAmount;
            } else {
                // Giảm giá theo tiền cứng
                $product->discount_price = $product->price - $discount->discount_value;
            }
            if ($product->discount_price <= 0) {
                return redirect()->back()->with('error', 'Giảm giá lớn hơn số tiền của sản phẩm. Vui lòng dùng giảm giá khác');
            }
            $product->save();
            // Thêm bản ghi vào bảng discounted_products để liên kết sản phẩm với giảm giá này
            DB::table('discounted_products')->insert([
                'product_id' => $product->id,
                'discount_id' => $discountId,
                'created_at' => now(),

            ]);

            $successCount++; // Tăng số đếm sản phẩm thành công
        }

        // Xử lý phản hồi
        if (!empty($errorMessages)) {
            return redirect()->back()->with('error', implode('<br>', $errorMessages));
        }

        if ($successCount > 0) {
            return redirect()->back()->with('success', 'Giảm giá đã được áp dụng thành công cho ' . $successCount . ' sản phẩm.');
        }

        return redirect()->back()->with('error', 'Không có sản phẩm nào được áp dụng giảm giá.');
    }

    public function removeFromProducts(Request $request, $discountId)
    {
        $productIds = $request->input('product_ids', []);

        if (empty($productIds)) {
            return redirect()->back()->with('error', 'Không có sản phẩm nào được chọn.');
        }

        $discount = Discount::findOrFail($discountId);

        $errorMessages = []; // Mảng để lưu thông báo lỗi
        $successCount = 0; // Đếm số sản phẩm hủy giảm giá thành công

        // Lấy tất cả các sản phẩm với id có trong mảng $productIds
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            // Kiểm tra xem cặp product_id và discount_id có tồn tại trong bảng discounted_products hay không
            $existingDiscountEntry = DB::table('discounted_products')
                ->where('product_id', $product->id)
                ->where('discount_id', $discountId)
                ->first();

            // Nếu không tồn tại cặp (product_id, discount_id) trong bảng discounted_products
            if (!$existingDiscountEntry) {
                $errorMessages[] = 'Sản phẩm "' . $product->name . '" không có giảm giá với mã giảm giá này để hủy.';
                continue; // Bỏ qua sản phẩm này và chuyển sang sản phẩm khác
            }

            // Kiểm tra xem sản phẩm đã có giảm giá khác ngoài discountId này hay chưa
            $existingDiscount = $product->discounts()->where('discount_id', '!=', $discountId)->first();

            if ($existingDiscount) {
                // Nếu sản phẩm đã có giảm giá khác, lưu thông báo lỗi
                $existingDiscountValue = $existingDiscount->discount_value;
                $existingDiscountType = $existingDiscount->type;

                if ($existingDiscountType === 'percentage') {
                    $existingDiscountValue .= '%';
                } else {
                    $existingDiscountValue = number_format($existingDiscountValue, 0, ',', '.') . '₫';
                }

                $errorMessages[] = 'Sản phẩm "' . $product->name . '" đang được giảm giá bởi chương trình khác. Giảm giá hiện tại: ' . $existingDiscountValue;
                continue; // Bỏ qua sản phẩm này
            }

            // Cập nhật lại giá gốc
            $product->discount_price = $product->price;
            $product->save();

            // Hủy liên kết giảm giá
            $product->discounts()->detach($discountId);
            $successCount++; // Tăng số đếm sản phẩm thành công
        }

        // Xử lý phản hồi
        if (!empty($errorMessages)) {
            return redirect()->back()->with('error', implode('<br>', $errorMessages));
        }

        if ($successCount > 0) {
            return redirect()->back()->with('success', 'Giảm giá đã được hủy thành công cho ' . $successCount . ' sản phẩm.');
        }

        return redirect()->back()->with('error', 'Không có sản phẩm nào được hủy giảm giá.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $title = 'Danh Sách Phương Thức Thanh Toán';
        $paymentMethods = PaymentMethod::paginate(10);
        return view('admin.payment-methods.index', compact('paymentMethods', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Phương Thức Thanh Toán';
        return view('admin.payment-methods.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            // Tùy chỉnh thông báo lỗi bằng tiếng Việt
            'name.required' => 'Tên phương thức thanh toán là bắt buộc.',
            'name.string' => 'Tên phương thức thanh toán phải là một chuỗi.',
            'name.max' => 'Tên phương thức thanh toán không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên phương thức thanh toán này đã tồn tại, vui lòng chọn tên khác.',
            'description.string' => 'Mô tả phải là một chuỗi.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "active" hoặc "inactive".',
        ]);

        DB::beginTransaction();
        try {
            PaymentMethod::create($request->all());
            DB::commit();
            return redirect()->route('payment-methods.index')->with('success', 'Phương thức thanh toán đã được tạo thành công.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('payment-methods.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        $title = 'Cập Nhật Phương Thức Thanh Toán';
        return view('admin.payment-methods.edit', compact('paymentMethod', 'title'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name,' . $paymentMethod->id,  // Kiểm tra trùng tên, ngoại trừ bản ghi hiện tại
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.unique' => 'Tên phương thức thanh toán đã tồn tại. Vui lòng chọn tên khác.',  // Thông báo lỗi khi trùng tên
            'name.required' => 'Tên phương thức là bắt buộc.',
            'name.max' => 'Tên phương thức không được vượt quá 255 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "Kích hoạt" hoặc "Không kích hoạt".',
        ]);

        DB::beginTransaction();
        try {
            $paymentMethod->update($request->all());
            DB::commit();
            return redirect()->route('payment-methods.index')->with('success', 'Phương thức thanh toán đã được cập nhật thành công.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('payment-methods.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        DB::beginTransaction();
        try {
            $paymentMethod->delete(); // Xóa mềm
            DB::commit();
            return redirect()->route('payment-methods.index')->with('success', 'Xóa phương thức thanh toán thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('payment-methods.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $title = 'Thùng Rác';
        $paymentMethods = PaymentMethod::onlyTrashed()->get();
        return view('admin.payment-methods.trash', compact('paymentMethods', 'title'));
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {
            $paymentMethod = PaymentMethod::withTrashed()->findOrFail($id);
            $paymentMethod->restore(); // Khôi phục phương thức thanh toán
            DB::commit();
            return redirect()->route('payment-methods.trash')->with('restorePaymentMethod', 'Khôi phục phương thức thanh toán thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('payment-methods.trash')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        $paymentMethod = PaymentMethod::onlyTrashed()->findOrFail($id);

        DB::beginTransaction();
        try {
            $paymentMethod->forceDelete(); // Xóa cứng
            DB::commit();
            return redirect()->route('payment-methods.trash')->with('forceDeletePaymentMethod', 'Xóa cứng phương thức thanh toán thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('payment-methods.trash')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
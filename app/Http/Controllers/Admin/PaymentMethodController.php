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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
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
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('promotion_id')->nullable()->constrained('promotions')->onDelete('set null');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->enum('status', [
                'pending_confirmation', // Chờ xác nhận
                'pending_pickup',       // Chờ lấy hàng
                'pending_delivery',     // Chờ giao hàng
                'returned',             // Trả hàng
                'delivered',            // Đã giao
                'confirm_delivered',    // Đã nhận hàng
                'canceled'              // Đã hủy
            ])->default('pending_confirmation');
            $table->enum('payment_status', [
                'unpaid',               // Chưa thanh toán
                'paid',                 // Đã thanh toán
                'pending',              // Đang thanh toán
                'refunded',             // Hoàn trả
                'payment_failed'        // Thanh toán thất bại
            ])->default('unpaid');
            $table->string('shipping_address')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->onDelete('set null');
            $table->string('phone_number')->nullable();
            $table->boolean('is_new')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

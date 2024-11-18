<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('txn_ref'); // Mã đơn hàng
            $table->string('order_info');
            $table->decimal('amount', 15, 2); // Số tiền
            $table->string('status'); // Trạng thái giao dịch (success, failed)
            $table->string('vnp_response_code'); // Mã phản hồi của VNPAY
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

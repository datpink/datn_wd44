<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('refund_reason')->nullable()->after('cancellation_reason');
            $table->string('refund_images')->nullable()->after('refund_reason');
            $table->enum('refund_method', ['store_credit', 'cash', 'exchange'])->default('store_credit');
            $table->enum('admin_status', ['pending', 'approved', 'rejected'])->default('pending'); // Xác nhận admin
            $table->string('qr_code')->nullable(); // Để lưu đường dẫn QR
            $table->string('account_number')->nullable(); // Để lưu số tài khoản
            $table->timestamp('delivered_at')->nullable();  // Thời gian giao hàng
            $table->timestamp('refund_at')->nullable();     // Thời gian hoàn trả
            $table->timestamp('canceled_at')->nullable();
            $table->string('proof_image')->nullable();  // Add the proof_image column
            $table->text('admin_message')->nullable();  // Thêm cột admin_message
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['refund_reason', 'refund_images']);
        });
    }

};

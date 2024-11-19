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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // ID tự động tăng cho mỗi thông báo
            $table->unsignedBigInteger('user_id'); // ID người dùng nhận thông báo
            $table->string('title'); // Tiêu đề thông báo
            $table->text('description')->nullable(); // Mô tả chi tiết
            $table->string('url')->nullable(); // URL để chuyển hướng khi người dùng nhấn vào thông báo
            $table->timestamp('read_at')->nullable(); // Thời điểm thông báo được đọc
            $table->timestamps(); // Bao gồm created_at và updated_at

            // Thiết lập khóa ngoại liên kết với bảng users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

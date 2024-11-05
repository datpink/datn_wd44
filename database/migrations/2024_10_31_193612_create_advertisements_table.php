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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('image');  // Trường cho hình ảnh
            $table->string('title')->nullable();  // Trường cho tiêu đề
            $table->string('description')->nullable();  // Trường cho mô tả
            $table->string('button_text')->nullable();  // Trường cho văn bản nút
            $table->string('button_link')->nullable();  // Trường cho liên kết nút
            $table->integer('position')->nullable();  // Thêm trường position
            $table->enum('status', ['active', 'inactive'])->default('active');  // Trường trạng thái
            $table->softDeletes();  // Trường để hỗ trợ xóa mềm
            $table->timestamps();  // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};

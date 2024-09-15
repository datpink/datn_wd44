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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalogue_id')->constrained('catalogues')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('detailed_description')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->float('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->float('ratings_avg')->default(0);
            $table->integer('ratings_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

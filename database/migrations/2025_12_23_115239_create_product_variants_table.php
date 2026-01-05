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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->string('sku')->unique()->nullable();

            $table->decimal('original_price', 10, 2)->nullable();      // Original price
            $table->decimal('selling_price', 10, 2)->nullable();    // Selling price

            $table->integer('stock')->default(0);
            $table->string('image')->nullable();            // Variant image
            
            $table->boolean('is_default')->default(0);
            $table->boolean('status')->default(1);

            $table->timestamps();

            // FK
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

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
        Schema::create('product_images', function (Blueprint $table) {
            
            $table->id();

            $table->unsignedBigInteger('product_id');

            $table->string('image_path'); // Path to the image
            $table->integer('sort_order')->default(0); // for ordering images
            $table->boolean('is_active')->default(1); // 1 = visible, 0 = hidden

            $table->timestamps();

            // Foreign key
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade'); // delete all images when product deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};

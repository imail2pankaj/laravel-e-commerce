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

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('short_description')->nullable();
            $table->text('description')->nullable();

            $table->string('main_image')->nullable();

            // ENUM for content workflow
            $table->enum('status', ['draft', 'published'])->default('published');

            // Active flag for operational control
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Foreign Keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
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

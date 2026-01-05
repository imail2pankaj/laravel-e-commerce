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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_variant_id');

            // Current available stock
            $table->integer('quantity')->default(0);

            // For low stock alerts
            $table->integer('low_stock_threshold')->default(5);

            // Quick boolean for frontend
            $table->boolean('in_stock')->default(true);

            $table->timestamps();

            // relations
            $table->foreign('product_variant_id')
                ->references('id')
                ->on('product_variants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};

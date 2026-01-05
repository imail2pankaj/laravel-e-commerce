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
        Schema::create('order_items', function (Blueprint $table) {
                $table->id();

                // Relations
                $table->foreignId('order_id')->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->constrained()->restrictOnDelete();
                $table->foreignId('product_variant_id')->constrained()->restrictOnDelete();

                // Product snapshot
                $table->string('product_name');
                $table->string('sku')->nullable();

                // Price snapshot (per item)
                $table->decimal('price', 10, 2);           // price per unit
                $table->decimal('tax_amount', 10, 2)->default(0);
                $table->decimal('discount_amount', 10, 2)->default(0);

                // Quantity & total
                $table->unsignedInteger('quantity');
                $table->decimal('total', 10, 2);            // final item total

                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

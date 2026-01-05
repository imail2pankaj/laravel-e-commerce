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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // bigint, PK

            // Order identity
            $table->string('order_number')->unique()->index();

            // Customer relation
            $table->foreignId('customer_id')->index()->constrained()->cascadeOnDelete();

            // Amounts (snapshot values)
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);

            // Coupon snapshot
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->string('coupon_code')->nullable();

            // Order & payment status
            $table->string('order_status')->index();     // pending, confirmed, shipped, etc
            $table->string('payment_status')->index();   // pending, paid, failed, refunded

            // Payment & shipping method snapshot
            $table->string('payment_method')->nullable();  // cod, razorpay, stripe
            $table->string('shipping_method')->nullable(); // standard, express, pickup

            // Internal notes (admin only)
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

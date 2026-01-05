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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();

            // flat or percent
            $table->enum('discount_type', ['flat', 'percent']);

            $table->decimal('discount_value', 10, 2);

            // only used if percent
            $table->decimal('max_discount', 10, 2)->nullable();

            $table->decimal('min_order_amount', 10, 2)->default(0);

            $table->enum('apply_type', ['all', 'product', 'category', 'brand'])
                ->default('all');

            $table->integer('usage_limit')->nullable();
            $table->integer('usage_limit_per_user')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->boolean('status')->default(1);

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

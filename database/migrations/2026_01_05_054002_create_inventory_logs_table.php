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
        Schema::create('inventory_logs', function (Blueprint $table) {
           $table->id();

            // Relations
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->restrictOnDelete();

            // Stock movement
            $table->string('action')->index(); 
            // deduct | restore | adjust

            $table->integer('quantity');        // + or - value
            $table->integer('before_stock');
            $table->integer('after_stock');

            // Reason & actor
            $table->string('reason')->nullable(); 
            // order_placed | order_cancelled | admin_adjustment

            $table->foreignId('created_by')->nullable()
                ->constrained('admins')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};

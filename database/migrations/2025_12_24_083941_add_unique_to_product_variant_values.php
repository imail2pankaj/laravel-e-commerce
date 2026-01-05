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
        Schema::table('product_variant_values', function (Blueprint $table) {
             $table->unique(['product_variant_id', 'attribute_id', 'attribute_value_id'], 'variant_attr_value_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variant_values', function (Blueprint $table) {
           $table->dropUnique('variant_attr_value_unique');
        });
    }
};

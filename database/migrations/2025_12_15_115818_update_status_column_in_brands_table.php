<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        DB::statement("
            ALTER TABLE brands 
            ADD status 
            ENUM('draft', 'published', 'inactive') 
            NOT NULL 
            DEFAULT 'published'
        ");
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('status')->default(1);
        });
    }
};

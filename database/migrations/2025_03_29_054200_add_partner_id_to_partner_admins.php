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
        Schema::table('partner_admins', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->nullable()->after('id');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_admins', function (Blueprint $table) {
            //
        });
    }
};

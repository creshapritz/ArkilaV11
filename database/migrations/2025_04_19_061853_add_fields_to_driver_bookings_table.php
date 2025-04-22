<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('driver_bookings', function (Blueprint $table) {
        $table->integer('num_days')->nullable();
        $table->decimal('total_driver_fee', 10, 2)->nullable();
        $table->string('status')->default('pending');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driver_bookings', function (Blueprint $table) {
            //
        });
    }
};

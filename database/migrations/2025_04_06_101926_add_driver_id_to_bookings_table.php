<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDriverIdToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->nullable()->after('car_id'); // Add the driver_id column
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null'); // Foreign key reference
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['driver_id']); // Drop the foreign key constraint
            $table->dropColumn('driver_id'); // Drop the driver_id column
        });
    }
}

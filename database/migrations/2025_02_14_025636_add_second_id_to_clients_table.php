<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('driver_front_second_id')->nullable(); // Store the file path
            $table->string('driver_back_second_id')->nullable(); 
            $table->string('driver_back_second_id')->nullable(); // Store the file path
        });// Store the file path
       
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['driver_front_second_id', 'driver_back_second_id']);
        });
    }

};

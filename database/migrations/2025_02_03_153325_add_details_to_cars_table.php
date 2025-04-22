<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToCarsTable extends Migration
{
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('platenum')->nullable();       // License plate number
            $table->integer('mileage')->nullable();       // Mileage of the car
            $table->string('color')->nullable();           // Color of the car
            $table->date('regexpiry')->nullable();         // Registration expiry date
            $table->string('primary_image')->nullable();   // Primary image URL/path
            $table->string('additional_image')->nullable(); // Additional image URL/path
        });
    }

    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['platenum', 'mileage', 'color', 'regexpiry', 'primary_image', 'additional_image']);
        });
    }
}

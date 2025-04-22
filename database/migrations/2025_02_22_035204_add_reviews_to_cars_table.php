<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->decimal('average_rating', 3, 2)->default(0); // Rating out of 5.00
            $table->integer('total_reviews')->default(0); // Count of reviews
        });
    }
    
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['average_rating', 'total_reviews']);
        });
    }
    
};

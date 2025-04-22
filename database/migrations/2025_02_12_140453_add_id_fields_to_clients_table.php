<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('first_id_type')->nullable();
            $table->string('front_first_id')->nullable();
            $table->string('back_first_id')->nullable();
          
        });
    }
    
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['first_id_type', 'front_first_id', 'back_first_id', ]);
        });
    }
    
};

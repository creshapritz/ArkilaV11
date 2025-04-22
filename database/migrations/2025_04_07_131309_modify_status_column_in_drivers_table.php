<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();  // Change column to string
        });
    }

    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->change();  // Rollback to original type
        });
    }

};

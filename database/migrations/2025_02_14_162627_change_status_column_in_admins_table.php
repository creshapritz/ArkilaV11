<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('status')->change();
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->integer('status')->change(); // Revert to integer if you need to rollback
        });
    }

};

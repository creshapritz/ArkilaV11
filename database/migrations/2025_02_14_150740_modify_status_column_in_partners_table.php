<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('partners', function (Blueprint $table) {
        $table->string('status')->change(); // Change status column type to string
    });
}

public function down()
{
    Schema::table('partners', function (Blueprint $table) {
        $table->enum('status', ['Active', 'Inactive'])->change(); // Revert if needed
    });
}

};

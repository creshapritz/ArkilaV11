<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('admins', function (Blueprint $table) {
        $table->string('firstname')->after('id');
        $table->string('lastname')->after('firstname');
        $table->string('role')->after('lastname');
        $table->timestamp('date_created')->useCurrent()->after('role');
        $table->boolean('status')->default(1)->after('date_created'); // 1 for active, 0 for inactive
    });
}

public function down()
{
    Schema::table('admins', function (Blueprint $table) {
        $table->dropColumn(['firstname', 'lastname', 'role', 'date_created', 'status']);
    });
}

};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('second_id_front')->nullable(); // Add Second ID (Front)
            $table->string('second_id_back')->nullable();  // Add Second ID (Back)
        });
    }

    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('second_id_front');
            $table->dropColumn('second_id_back');
        });
    }
};

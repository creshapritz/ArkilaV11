<?php  
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileColumnsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // $table->string('front_license')->nullable();
            $table->string('back_license')->nullable();
            $table->string('front_second_id')->nullable();
            $table->string('back_second_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('front_license');
            $table->dropColumn('back_license');
            $table->dropColumn('front_second_id');
            $table->dropColumn('back_second_id');
            $table->dropColumn('first_id');
            $table->dropColumn('first_id_front');
            $table->dropColumn('first_id_back');
            $table->dropColumn('second_id');
            $table->dropColumn('second_id_front');
            $table->dropColumn('second_id_back');
            $table->dropColumn('agree_privacy');
        });
    }
}

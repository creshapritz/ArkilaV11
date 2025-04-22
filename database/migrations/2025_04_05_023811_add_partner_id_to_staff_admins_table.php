<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('staff_admins', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->nullable()->after('admin_id');

            // Optional: add foreign key if you want it linked to the `partners` table
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('staff_admins', function (Blueprint $table) {
            $table->dropForeign(['partner_id']);
            $table->dropColumn('partner_id');
        });
    }
};

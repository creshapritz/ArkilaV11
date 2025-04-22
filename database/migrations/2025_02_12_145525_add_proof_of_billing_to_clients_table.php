<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->string('proof_of_billing_type')->nullable();
        $table->string('proof_of_billing')->nullable();
    });
}

public function down()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->dropColumn(['proof_of_billing_type', 'proof_of_billing']);
    });
}

};

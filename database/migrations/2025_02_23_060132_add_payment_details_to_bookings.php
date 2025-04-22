<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->after('dropoff_time'); // Add amount column
            $table->string('payment_reference')->nullable()->after('amount'); // Add payment reference
            $table->string('status')->default('pending')->after('payment_reference'); // Add status
        });
    }
    
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['amount', 'payment_reference', 'status']);
        });
    }
    
};

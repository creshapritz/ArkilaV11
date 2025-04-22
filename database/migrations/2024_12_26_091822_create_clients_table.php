<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('extension_name')->nullable();
            $table->integer('age');
            $table->date('dob');
            $table->string('contact_number');
            $table->string('address');
            $table->string('emergency_contact');
            $table->string('emergency_contact_relationship');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            $table->string('service_type');
            $table->string('first_id_type');
            $table->string('driver_license_type')->nullable();
            $table->string('front_license')->nullable();
            $table->string('back_license')->nullable();
            $table->string('second_id_type')->nullable();
            $table->string('front_second_id')->nullable();
            $table->string('back_second_id')->nullable();
            $table->string('driver_front_second_id')->nullable();
            $table->string('driver_back_second_id')->nullable();
            $table->string('proof_of_billing_type');
            $table->string('proof_of_billing')->nullable();
        
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

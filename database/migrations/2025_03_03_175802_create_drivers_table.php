<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Driver's full name
            $table->string('email')->unique(); // Email (must be unique)
            $table->string('contact_number'); // Contact number
            $table->string('profile_picture')->nullable(); // Profile picture path
            $table->string('documentation')->nullable(); // Driver's documentation
            $table->string('license_document')->nullable(); // License document
            $table->string('company_name')->nullable(); // Company name (optional)
            $table->enum('status', ['Active', 'Inactive'])->default('Active'); // Status
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};

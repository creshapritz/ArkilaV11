<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('company_owner');
            $table->string('company_email')->unique();
            $table->string('company_name');
            $table->string('company_phone');
            $table->string('company_logo'); // Store file path
            $table->string('company_document'); // Store file path (PDF)
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('partners');
    }
};

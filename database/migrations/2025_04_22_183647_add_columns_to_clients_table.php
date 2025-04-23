<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Add the columns
            $table->timestamp('deleted_at')->nullable();  // For soft deletes
            $table->boolean('is_archived')->default(false);  // For the boolean flag
            $table->timestamp('archived_at')->nullable();  // For the timestamp when archived
        });
    }
    
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Rollback the changes
            $table->dropColumn('deleted_at');
            $table->dropColumn('is_archived');
            $table->dropColumn('archived_at');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        \DB::table('settings')->insert([
            'key' => 'theme_color',
            'value' => '#F07324' 
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            
        });
    }
};

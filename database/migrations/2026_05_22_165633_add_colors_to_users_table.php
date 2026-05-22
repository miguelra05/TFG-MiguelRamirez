<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('color_primario')->default('#3b82f6')->after('titulo_profesional');
            $table->string('color_secundario')->default('#1e293b')->after('color_primario');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['color_primario', 'color_secundario']);
        });
    }
};

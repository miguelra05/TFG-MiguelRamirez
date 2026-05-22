<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidos')->nullable()->after('name');
            $table->string('telefono')->nullable()->after('email');
            $table->string('direccion')->nullable()->after('telefono');
            $table->text('biografia')->nullable()->after('direccion');
            $table->string('foto_perfil')->nullable()->after('biografia');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['apellidos', 'telefono', 'direccion', 'biografia', 'foto_perfil']);
        });
    }
};

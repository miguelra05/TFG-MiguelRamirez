<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Eliminar la tabla plantillas (no utilizada)
        Schema::dropIfExists('plantillas');

        // 2. Eliminar campos no utilizados de la tabla events
        Schema::table('events', function (Blueprint $table) {
            // Estos campos no se utilizan en la aplicación
            $table->dropColumn([
                'mora',
                'color_evento',
                'is_company_event',
                'ubicacion',
                'detalles_evento'
            ]);
        });

        // 3. Eliminar campo no utilizado de la tabla users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('titulo_profesional');
        });
    }

    public function down(): void
    {
        // Restaurar tabla plantillas
        Schema::create('plantillas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('estilo_css');
            $table->timestamps();
        });

        // Restaurar campos en events
        Schema::table('events', function (Blueprint $table) {
            $table->string('mora')->nullable();
            $table->string('color_evento')->default('#3788d8');
            $table->boolean('is_company_event')->default(false);
            $table->string('ubicacion')->nullable();
            $table->text('detalles_evento')->nullable();
        });

        // Restaurar campo en users
        Schema::table('users', function (Blueprint $table) {
            $table->string('titulo_profesional')->nullable();
        });
    }
};

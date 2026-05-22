<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo'); // nombre personalizado que da el usuario
            $table->string('tipo_documento'); // extensión (pdf, jpg, png, etc.)
            $table->string('ruta'); // ruta del archivo
            $table->date('fecha_subida');
            $table->enum('visibilidad', ['public', 'private'])->default('private');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};

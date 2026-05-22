<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plantilla_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->timestamps(); // created_at y updated_at (updated_at = última modificación)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
};

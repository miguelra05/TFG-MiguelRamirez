<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculum_habilidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained('curriculums')->onDelete('cascade');
            $table->foreignId('habilidad_id')->constrained('habilidades')->onDelete('cascade');
            $table->unique(['curriculum_id', 'habilidad_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_habilidad');
    }
};

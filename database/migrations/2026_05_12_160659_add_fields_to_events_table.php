<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('ubicacion')->nullable();
            $table->text('detalles_evento')->nullable();
            $table->string('estado_evento')->default('pendiente');
            $table->string('color_evento')->default('#3788d8');
            $table->boolean('notificacion')->default(false);
            $table->string('mora')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};

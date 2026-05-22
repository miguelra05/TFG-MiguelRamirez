<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropForeign(['plantilla_id']);
            $table->dropColumn('plantilla_id');
        });
    }

    public function down(): void
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->foreignId('plantilla_id')->nullable()->constrained('plantillas')->onDelete('set null');
        });
    }
};

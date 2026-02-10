<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['course_id']);

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->restrictOnDelete(); // NO permite borrar course si hay students
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['course_id']);

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->cascadeOnDelete(); // vuelve al comportamiento anterior
        });
    }
};

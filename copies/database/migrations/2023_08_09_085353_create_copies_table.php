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
        Schema::create('copies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student');
            $table->string('course', 5);
            $table->boolean('graded');
            $table->string('mark')->nullable();
            $table->string('name_file', 100);
            $table->string('teacher_session_key',2000);
            $table->string('student_session_key',2000);
            $table->foreign("student")->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copies');
    }
};

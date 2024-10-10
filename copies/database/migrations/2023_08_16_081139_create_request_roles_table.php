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
        Schema::create('request_roles', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->unsignedBigInteger('requested_role');
            $table->foreign("username")->references('username')->on('users')->onDelete('cascade');
            $table->foreign("requested_role")->references('id')->on('roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_roles');
    }
};

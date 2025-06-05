<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->unsignedBigInteger('rol_id');
            $table->timestamps();

            // Foreign Key
            $table->foreign('rol_id')->references('rol_id')->on('rol')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};

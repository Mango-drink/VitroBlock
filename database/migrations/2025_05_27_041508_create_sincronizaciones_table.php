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
        Schema::create('sincronizaciones', function (Blueprint $table) {
            $table->id('evento_id');
            $table->enum('estado', ['pendiente', 'éxito', 'fallo']);
            $table->dateTime('fecha_hora');
            $table->unsignedBigInteger('operacion_id');

            $table->foreign('operacion_id')->references('operacion_id')->on('operaciones')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sincronizaciones');
    }
};

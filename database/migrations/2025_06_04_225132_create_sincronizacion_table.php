<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sincronizacion', function (Blueprint $table) {
            $table->id('evento_id');
            $table->enum('estado', ['pendiente', 'éxito', 'fallo']);
            $table->dateTime('fecha_hora');
            $table->unsignedBigInteger('operacion_id');
            $table->unsignedBigInteger('producto_id');

            // Foreign Keys
            $table->foreign('operacion_id')->references('operacion_id')->on('operacion')->onDelete('cascade');
            $table->foreign('producto_id')->references('producto_id')->on('productos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sincronizacion');
    }
};

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
        Schema::create('operaciones', function (Blueprint $table) {
            $table->id('operacion_id');
            $table->enum('tipo', ['alta', 'baja', 'modificación']);
            $table->integer('cantidad');
            $table->dateTime('fecha_hora');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('usuario_id');

            $table->foreign('producto_id')->references('producto_id')->on('productos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('usuario_id')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operaciones');
    }
};

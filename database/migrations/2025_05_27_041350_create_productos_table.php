<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('productos', function (Blueprint $table) {
        $table->id('producto_id');
        $table->string('codigo');
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->string('diseño')->nullable();
        $table->string('color')->nullable();
        $table->string('dimensiones')->nullable();
        $table->integer('piezas_por_caja')->nullable();
        $table->decimal('m2_por_caja', 8, 2)->nullable();
        $table->integer('stock_actual')->default(0);
        $table->decimal('precio', 10, 2);
        $table->string('imagen_url')->nullable();

        // Llaves foráneas
        $table->unsignedBigInteger('categoria_id');
        $table->unsignedBigInteger('origen_id');

        $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        $table->foreign('origen_id')->references('id')->on('origenes')->onDelete('cascade');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

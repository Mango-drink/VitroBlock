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
        Schema::create('categorias', function (Blueprint $table) {
            // Cambiamos $table->id() por bigIncrements('categoria_id')
            $table->bigIncrements('categoria_id');
            $table->string('nombre', 255);
            // Si no vas a usar created_at/updated_at, quita esta línea. 
            // Si sí, déjala:
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};

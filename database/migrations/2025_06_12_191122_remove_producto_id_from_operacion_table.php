<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProductoIdFromOperacionTable extends Migration
{
    public function up(): void
    {
        Schema::table('operacion', function (Blueprint $table) {
            $table->dropForeign(['producto_id']); // Si tienes FK
            $table->dropColumn('producto_id');
        });
    }

    public function down(): void
    {
        Schema::table('operacion', function (Blueprint $table) {
            $table->unsignedBigInteger('producto_id')->nullable();
            // Si quieres restaurar la FK, hazlo aquí también.
        });
    }
}

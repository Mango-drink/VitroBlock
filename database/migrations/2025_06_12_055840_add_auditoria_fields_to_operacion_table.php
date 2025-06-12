<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditoriaFieldsToOperacionTable extends Migration
{
    public function up(): void
    {
        Schema::table('operacion', function (Blueprint $table) {
            // Agregar campos para auditoría general
            $table->string('entidad')->after('tipo');
            $table->unsignedBigInteger('entidad_id')->nullable()->after('entidad');
            $table->text('descripcion')->nullable()->after('entidad_id');
            $table->ipAddress('ip')->nullable()->after('descripcion');
            $table->string('user_agent')->nullable()->after('ip');
            $table->integer('cantidad')->nullable()->change(); // Haz 'cantidad' nullable
        });
    }

    public function down(): void
    {
        Schema::table('operacion', function (Blueprint $table) {
            $table->dropColumn(['entidad', 'entidad_id', 'descripcion', 'ip', 'user_agent']);
            // Si quieres, vuelve a dejar 'cantidad' como NOT NULL aquí (opcional)
        });
    }
}

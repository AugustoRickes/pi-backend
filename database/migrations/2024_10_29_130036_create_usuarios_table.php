<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nome', 255);
            $table->string('cidade', 255);
            $table->string('estado', 255);
            $table->string('localizacao', 255)->nullable();
            $table->boolean('tem_carro');
            $table->float('km_por_litro');
            $table->integer('kudos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};

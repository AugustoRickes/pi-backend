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
        Schema::create('estabelecimentos', function (Blueprint $table) {
            $table->string('cnpj', 14)->primary();
            $table->string('nome', 255);
            $table->string('razao_social', 255);
            $table->string('endereco', 255);
            $table->string('cidade', 255);
            $table->string('estado', 255);
            $table->float('latitude');
            $table->float('longitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estabelecimentos');
    }
};

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
        Schema::create('notas_fiscais', function (Blueprint $table) {
            $table->uuid('nota_fiscal_uuid')->primary();
            $table->uuid('usuario_uuid');
            $table->string('estabelecimento_cnpj', 14);
            $table->timestamp('data_emissao');
            $table->decimal('valor_total', 18, 2);
            $table->timestamps();

            $table->foreign('usuario_uuid')->references('uuid')->on('usuarios')->onDelete('cascade');
            $table->foreign('estabelecimento_cnpj')->references('cnpj')->on('estabelecimentos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_fiscais');
    }
};

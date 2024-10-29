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
        Schema::create('itens_notas_fiscais', function (Blueprint $table) {
            $table->uuid('item_id')->primary();
            $table->uuid('nota_fiscal_uuid');
            $table->string('produto_codigo', 255);
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 18, 2);
            $table->decimal('valor_total', 18, 2);
            $table->timestamps();

            $table->foreign('nota_fiscal_uuid')->references('nota_fiscal_uuid')->on('notas_fiscais')->onDelete('cascade');
            $table->foreign('produto_codigo')->references('codigo')->on('produtos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_notas_fiscais');
    }
};

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
        Schema::create('itemnotafiscal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nota_fiscal_id');
            $table->string('produto_codigo', 255);
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 18, 2);
            $table->decimal('valor_total', 18, 2);
            $table->timestamps();

            $table->foreign('nota_fiscal_id')->references('id')->on('notafiscal')->onDelete('cascade');
//            $table->foreign('produto_codigo')->references('codigo')->on('produto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemnotafiscal');
    }
};

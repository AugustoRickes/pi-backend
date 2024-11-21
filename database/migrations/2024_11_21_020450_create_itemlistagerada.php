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
        Schema::create('itemlistagerada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listagerada_id');
            $table->unsignedBigInteger('produto_id');
            $table->decimal('preco', 18, 2)->nullable();
            $table->decimal('mediamercado', 18, 2)->nullable();
            $table->integer('quantidade');
            $table->timestamps();

            $table->foreign('listagerada_id')->references('id')->on('listagerada');
            $table->foreign('produto_id')->references('id')->on('produto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemlistagerada');
    }
};

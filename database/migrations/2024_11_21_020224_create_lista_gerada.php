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
        Schema::create('listagerada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('estabelecimento_id');
            $table->dateTime('datahora');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('estabelecimento_id')->references('id')->on('estabelecimento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listagerada');
    }
};

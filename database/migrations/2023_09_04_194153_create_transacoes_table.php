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
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->enum('forma_pagamento', ['P', 'C', 'D']);
            $table->unsignedBigInteger('conta_id');
            $table->float('valor', 8, 2);
            $table->timestamps();
            $table->foreign('conta_id')->references('id')->on('contas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
};

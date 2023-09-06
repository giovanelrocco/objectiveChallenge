<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `transacoes` CHANGE `forma_pagamento` `forma_pagamento` ENUM('P','C','D', 'E') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

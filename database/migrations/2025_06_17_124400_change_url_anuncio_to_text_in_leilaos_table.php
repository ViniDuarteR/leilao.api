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
        Schema::table('leilaos', function (Blueprint $table) {
            // Altera a coluna 'url_anuncio' para o tipo TEXT, que suporta textos longos
            $table->text('url_anuncio')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leilaos', function (Blueprint $table) {
            //
        });
    }
};

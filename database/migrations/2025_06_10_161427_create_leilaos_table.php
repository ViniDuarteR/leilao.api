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
        Schema::create('leilaos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('endereco');
            $table->string('matricula');
            $table->string('url_imagem');
            $table->decimal('valor_avaliacao', 15, 2);
            $table->decimal('preco_atual', 15, 2);
            $table->string('url_anuncio');
            $table->string('status', 20)->default('aberto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leilaos');
    }
};

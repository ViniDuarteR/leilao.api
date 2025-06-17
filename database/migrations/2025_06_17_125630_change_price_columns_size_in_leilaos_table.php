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
            // Aumenta o total de dígitos para 20, mantendo 2 casas decimais.
            // Isso permite salvar números na casa dos quatrilhões.
            $table->decimal('valor_avaliacao', 20, 2)->change();
            $table->decimal('preco_atual', 20, 2)->change();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leilaos', function (Blueprint $table) {
            // Adiciona uma coluna de número inteiro, sem sinal (não pode ser negativo),
            // com valor padrão 0, logo depois da coluna 'status'.
            $table->unsignedInteger('view_count')->default(0)->after('status');
        });
    }
    public function down(): void
    {
        Schema::table('leilaos', function (Blueprint $table) {
            // Se precisarmos reverter, este comando apaga a coluna
            $table->dropColumn('view_count');
        });
    }
};

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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('image_path'); // Caminho para o arquivo da imagem do banner
            $table->string('link_url')->nullable(); // O link para onde o banner aponta (pode ser nulo)
            $table->boolean('is_active')->default(true); // Para ativar ou desativar o banner
            $table->integer('display_order')->default(0); // Para controlar a ordem de exibição
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};

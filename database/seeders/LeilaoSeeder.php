<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leilao; // Importa nosso Model

class LeilaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa a tabela para garantir que não teremos dados duplicados
        Leilao::truncate();

        for ($i = 1; $i <= 15; $i++) {
            Leilao::create([
                'titulo' => 'Imóvel de Teste para Paginação Nº ' . $i,
                'endereco' => 'Rua dos Testes, ' . ($i * 100) . ', Bairro da Paginação, SP',
                'matricula' => 'PAG' . date('Y') . $i,
                'url_imagem' => 'leiloes/placeholder.jpg',
                'valor_avaliacao' => 120000 + ($i * 10000),
                'preco_atual' => 60000 + ($i * 5000),
                'url_anuncio' => '#',
                'status' => 'aberto',
                'view_count' => rand(5, 200)
            ]);
        }
    }
}

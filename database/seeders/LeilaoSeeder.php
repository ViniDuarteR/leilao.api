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
        // Apaga todos os leilões existentes para evitar duplicatas ao rodar de novo
        Leilao::truncate();

        // Cria o primeiro leilão de exemplo
        Leilao::create([
            'titulo' => 'APARTAMENTO 204 NA TORRE 1',
            'endereco' => 'AV. BODEN POWELL, 219, CAXIAS, PETROPOLIS',
            'matricula' => '171090',
            'url_imagem' => 'https://via.placeholder.com/400x300.png/003366?text=Imovel+1',
            'valor_avaliacao' => 100000.00,
            'preco_atual' => 50000.00,
            'url_anuncio' => '#',
            'status' => 'aberto'
        ]);

        // Cria o segundo leilão de exemplo
        Leilao::create([
            'titulo' => 'CASA TÉRREA NO CONDOMÍNIO MAJESTY',
            'endereco' => 'RUA DAS FLORES, 123, CENTRO, RIO DE JANEIRO',
            'matricula' => '182544',
            'url_imagem' => 'https://via.placeholder.com/400x300.png/660033?text=Imovel+2',
            'valor_avaliacao' => 250000.00,
            'preco_atual' => 125000.00,
            'url_anuncio' => '#',
            'status' => 'aberto'
        ]);
    }
}

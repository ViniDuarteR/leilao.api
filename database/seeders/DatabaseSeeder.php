<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\LeilaoSeeder; // Garante que a classe seja importada

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // A linha abaixo que causa o erro deve estar comentada ou apagada
        // \App\Models\User::factory(10)->create();

        // Nós chamamos o nosso seeder de leilões diretamente.
        $this->call([
            LeilaoSeeder::class,
        ]);
    }
}

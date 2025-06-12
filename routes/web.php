<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LeilaoController;
use App\Http\Controllers\Admin\BannerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota da Página Inicial Pública
Route::get('/', function () {
    return view('welcome');
});

// Rota do Dashboard, que agora redireciona para a lista de leilões
Route::get('/dashboard', function () {
    return redirect()->route('painel.leiloes.index');
})->middleware(['auth', 'verified'])->name('dashboard');


// Grupo principal do painel, protegido e com prefixo /painel
Route::middleware(['auth'])->prefix('painel')->name('painel.')->group(function () {

    // =================================================================
    //   NOVA ROTA: Redireciona a raiz do painel para a lista de leilões
    // =================================================================
    Route::get('/', function () {
        return redirect()->route('painel.leiloes.index');
    })->name('index');


    // Rotas do Perfil (agora acessíveis em /painel/profile)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas para Leilões (ex: /painel/leiloes, /painel/leiloes/create)
    Route::resource('leiloes', LeilaoController::class)->parameters(['leiloes' => 'leilao']);
    Route::patch('leiloes/{leilao}/toggle-status', [LeilaoController::class, 'toggleStatus'])->name('leiloes.toggleStatus');

    // Rotas para Banners (ex: /painel/banners)
    Route::resource('banners', BannerController::class);
});


require __DIR__ . '/auth.php';

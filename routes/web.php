<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LeilaoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.leiloes.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // --- Rotas do Perfil (padrão do Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Nossas Rotas para Gerenciar Leilões ---
    Route::get('/admin/leiloes', [LeilaoController::class, 'index'])->name('admin.leiloes.index');
    Route::get('/admin/leiloes/create', [LeilaoController::class, 'create'])->name('admin.leiloes.create');
    Route::post('/admin/leiloes', [LeilaoController::class, 'store'])->name('admin.leiloes.store');

    // --> ESTA É A LINHA IMPORTANTE QUE PRECISAMOS CONFIRMAR <--
    Route::get('/admin/leiloes/{leilao}/edit', [LeilaoController::class, 'edit'])->name('admin.leiloes.edit');

    Route::put('/admin/leiloes/{leilao}', [LeilaoController::class, 'update'])->name('admin.leiloes.update');
    Route::delete('/admin/leiloes/{leilao}', [LeilaoController::class, 'destroy'])->name('admin.leiloes.destroy');
    Route::patch('/admin/leiloes/{leilao}/toggle-status', [LeilaoController::class, 'toggleStatus'])->name('admin.leiloes.toggleStatus');
});

require __DIR__ . '/auth.php';

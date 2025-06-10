<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeilaoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/leiloes', [LeilaoController::class, 'index']);
Route::post('/leiloes/{leilao}/increment-view', [LeilaoController::class, 'incrementView']);

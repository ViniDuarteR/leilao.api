<?php
/*
|--------------------------------------------------------------------------
| Informações do Arquivo
|--------------------------------------------------------------------------
|
| Projeto: Leiloeira Fernanda Freire
| Autor: Vinicius Duarte
| Email: viniciusduarterosa@icloud.com
| Data: Junho de 2025
|
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true) // Pega somente banners ativos
            ->orderBy('display_order') // Ordena pela ordem definida
            ->get();

        // Prepara os dados para o frontend, garantindo a URL completa da imagem
        $banners->each(function ($banner) {
            if ($banner->image_path) {
                $banner->image_path = asset('storage/' . $banner->image_path);
            }
        });

        return response()->json($banners);
    }
}

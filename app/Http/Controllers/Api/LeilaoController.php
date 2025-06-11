<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leilao; // 1. Importamos nosso Model 'Leilao'
use Illuminate\Http\Request;

class LeilaoController extends Controller
{
    /**
     * Retorna uma lista de todos os leilões.
     */
    public function index(Request $request)
    {
        $query = Leilao::where('status', 'aberto');

        if ($request->filled('localizacao')) {
            $query->where('endereco', 'LIKE', '%' . $request->localizacao . '%');
        }
        if ($request->filled('preco_min')) {
            $query->where('preco_atual', '>=', $request->preco_min);
        }
        if ($request->filled('preco_max')) {
            $query->where('preco_atual', '<=', $request->preco_max);
        }

        $leiloes = $query->latest()->paginate(6);

        return response()->json($leiloes);
    }
    public function incrementView(Leilao $leilao)
    {
        // O método increment() do Laravel é uma forma segura e eficiente
        // de somar +1 a uma coluna numérica.
        $leilao->increment('view_count');

        // Retorna uma resposta simples de sucesso
        return response()->json(['success' => true]);
    }
}

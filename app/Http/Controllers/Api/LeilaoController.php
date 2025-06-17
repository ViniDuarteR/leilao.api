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

        // Filtro de Localização (continua o mesmo)
        if ($request->filled('localizacao')) {
            $query->where('endereco', 'LIKE', '%' . $request->localizacao . '%');
        }

        // --- NOVA LÓGICA SUPERIOR PARA PREÇOS ---
        // 1. Criamos um formatador que entende o padrão de números do Brasil (pt_BR)
        $formatter = new \NumberFormatter('pt_BR', \NumberFormatter::DECIMAL);

        // Filtro de Preço Mínimo
        if ($request->filled('preco_min')) {
            // 2. Usamos o formatador para converter a string (ex: "150.000,50") em um número puro (150000.50)
            $precoMin = $formatter->parse($request->input('preco_min'));

            // 3. Adicionamos uma checagem de segurança. Se a conversão for bem-sucedida...
            if ($precoMin !== false) {
                // ... usamos o número limpo na busca.
                $query->where('preco_atual', '>=', $precoMin);
            }
        }

        // Filtro de Preço Máximo
        if ($request->filled('preco_max')) {
            $precoMax = $formatter->parse($request->input('preco_max'));
            if ($precoMax !== false) {
                $query->where('preco_atual', '<=', $precoMax);
            }
        }

        $leiloes = $query->latest()->paginate(6);

        // Transforma a URL da imagem para o caminho completo
        $leiloes->getCollection()->transform(function ($leilao) {
            if ($leilao->url_imagem) {
                $leilao->url_imagem = asset('storage/' . $leilao->url_imagem);
            }
            return $leilao;
        });

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

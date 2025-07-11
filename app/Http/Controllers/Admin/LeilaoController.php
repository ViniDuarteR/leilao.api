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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leilao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeilaoController extends Controller
{
    /**
     * Mostra a lista de leilões.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Leilao::query()
            ->when($search, function ($q, $search) {
                return $q->where('id', $search)
                    ->orWhere('titulo', 'LIKE', "%{$search}%");
            });
        $leiloes = $query->latest()->paginate(10);
        return view('admin.leiloes.index', ['leiloes' => $leiloes]);
    }

    /**
     * Mostra o formulário de criação.
     */
    public function create()
    {
        return view('admin.leiloes.create');
    }

    /**
     * Salva um novo leilão.
     */
    public function store(Request $request)
    {
        $this->cleanPriceInputs($request);
        $request->validate([
            'titulo' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'matricula' => 'required|string|max:50',
            'valor_avaliacao' => 'required|numeric|min:0',
            'preco_atual' => 'required|numeric|min:0',
            'url_anuncio' => 'required|string',
            'status' => 'required|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);
        $data = $request->except('imagem');
        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('leiloes', 'public');
            $data['url_imagem'] = $path;
        }
        Leilao::create($data);

        // ROTA CORRIGIDA AQUI
        return redirect()->route('painel.leiloes.index')->with('success', 'Leilão criado com sucesso!');
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Leilao $leilao)
    {
        return view('admin.leiloes.edit', ['leilao' => $leilao]);
    }

    /**
     * Atualiza um leilão existente.
     */
    public function update(Request $request, Leilao $leilao)
    {
        $this->cleanPriceInputs($request);
        $request->validate([
            'titulo' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'matricula' => 'required|string|max:50',
            'valor_avaliacao' => 'required|numeric|min:0',
            'preco_atual' => 'required|numeric|min:0',
            'url_anuncio' => 'required|string',
            'status' => 'required|string',
            'imagem' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);
        $data = $request->except('imagem');
        if ($request->hasFile('imagem')) {
            if ($leilao->url_imagem) {
                Storage::disk('public')->delete($leilao->url_imagem);
            }
            $path = $request->file('imagem')->store('leiloes', 'public');
            $data['url_imagem'] = $path;
        }
        $leilao->update($data);

        // ROTA CORRIGIDA AQUI
        return redirect()->route('painel.leiloes.index')->with('success', 'Leilão atualizado com sucesso!');
    }

    /**
     * Alterna o status de um leilão.
     */
    public function toggleStatus(Leilao $leilao)
    {
        $leilao->status = $leilao->status === 'aberto' ? 'inativo' : 'aberto';
        $leilao->save();
        return redirect()->route('painel.leiloes.index')->with('success', 'Status do leilão alterado com sucesso!');
    }

    /**
     * Apaga um leilão.
     */
    public function destroy(Leilao $leilao)
    {
        if ($leilao->url_imagem) {
            Storage::disk('public')->delete($leilao->url_imagem);
        }
        $leilao->delete();

        // ROTA CORRIGIDA AQUI
        return redirect()->route('painel.leiloes.index')->with('success', 'Leilão apagado com sucesso!');
    }
    private function cleanPriceInputs(Request $request)
    {
        $priceFields = ['valor_avaliacao', 'preco_atual'];

        foreach ($priceFields as $field) {
            if ($request->filled($field)) {
                // 1. Pega o valor do input (ex: "150.000,50")
                $rawValue = $request->input($field);
                // 2. Remove os pontos de milhar
                $cleanedValue = str_replace('.', '', $rawValue);
                // 3. Troca a vírgula do decimal por ponto
                $cleanedValue = str_replace(',', '.', $cleanedValue);

                // 4. Sobrescreve o valor no request com o número limpo
                $request->merge([$field => $cleanedValue]);
            }
        }
    }
}

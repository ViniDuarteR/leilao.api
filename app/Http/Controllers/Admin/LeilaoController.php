<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leilao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- A LINHA QUE ESTAVA FALTANDO

class LeilaoController extends Controller
{
    /**
     * Mostra a lista de todos os leilões (Read)
     */
    public function index(Request $request)
    {
        // Pega o termo de busca da URL (se existir)
        $search = $request->input('search');

        // Começa a construir a consulta ao banco de dados
        $query = Leilao::query()
            // O método 'when' só executa o código de dentro se o primeiro
            // parâmetro ($search) não for nulo ou vazio.
            ->when($search, function ($q, $search) {
                // Procura onde o ID é igual ao buscado OU onde o título contém o texto buscado
                return $q->where('id', $search)
                    ->orWhere('titulo', 'LIKE', "%{$search}%");
            });

        // Aplica a ordenação e a paginação na consulta, já com os filtros
        $leiloes = $query->latest()->paginate(10);

        // Retorna a view, passando os leilões encontrados
        return view('admin.leiloes.index', ['leiloes' => $leiloes]);
    }
    /**
     * Mostra o formulário para criar um novo leilão (Create)
     */
    public function create()
    {
        return view('admin.leiloes.create');
    }

    /**
     * Salva o novo leilão no banco de dados
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'matricula' => 'required|string|max:50',
            'valor_avaliacao' => 'required|numeric|min:0',
            'preco_atual' => 'required|numeric|min:0',
            'url_anuncio' => 'required|string',
            'status' => 'required|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('leiloes', 'public');
            $data['url_imagem'] = $path;
        }

        Leilao::create($data);

        return redirect()->route('admin.leiloes.index')->with('success', 'Leilão criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um leilão existente (Edit)
     */
    public function edit(Leilao $leilao)
    {
        return view('admin.leiloes.edit', ['leilao' => $leilao]);
    }

    /**
     * Atualiza o leilão no banco de dados (Update)
     */
    public function update(Request $request, Leilao $leilao)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'preco_atual' => 'required|numeric|min:0',
            'valor_avaliacao' => 'required|numeric|min:0',
            'imagem' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagem')) {
            // Apaga a imagem antiga
            Storage::disk('public')->delete($leilao->url_imagem);

            // Salva a nova imagem
            $path = $request->file('imagem')->store('leiloes', 'public');
            $data['url_imagem'] = $path;
        }

        $leilao->update($data);

        return redirect()->route('admin.leiloes.index')->with('success', 'Leilão atualizado com sucesso!');
    }

    /**
     * Remove o leilão do banco de dados (Delete)
     */
    public function destroy(Leilao $leilao)
    {
        // Antes de apagar o registro, apaga o arquivo da imagem
        if ($leilao->url_imagem) {
            Storage::disk('public')->delete($leilao->url_imagem);
        }

        $leilao->delete();

        return redirect()->route('admin.leiloes.index')->with('success', 'Leilão apagado com sucesso!');
    }
    public function toggleStatus(Leilao $leilao)
    {
        // Lógica simples de troca: se o status for 'aberto', vira 'inativo'. Senão, vira 'aberto'.
        $leilao->status = $leilao->status === 'aberto' ? 'inativo' : 'aberto';
        $leilao->save();

        return redirect()->route('admin.leiloes.index')->with('success', 'Status do leilão alterado com sucesso!');
    }
}

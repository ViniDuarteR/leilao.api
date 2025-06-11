<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leilao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            ->when($search, function ($q, $search) {
                return $q->where('id', $search)
                    ->orWhere('titulo', 'LIKE', "%{$search}%");
            });

        // Aplica a ordenação e a paginação na consulta
        $leiloes = $query->latest()->paginate(10); // Usando 10 itens por página para o painel

        // A LINHA CRUCIAL: Deve usar 'view()' para carregar a página da tabela
        return view('admin.leiloes.index', ['leiloes' => $leiloes]);
    }
    public function create()
    {
        return view('admin.leiloes.create');
    }

    /**
     * Salva o novo leilão no banco de dados
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados, agora com regras para o arquivo de imagem
        $request->validate([
            'titulo' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'matricula' => 'required|string|max:50',
            'valor_avaliacao' => 'required|numeric|min:0',
            'preco_atual' => 'required|numeric|min:0',
            'url_anuncio' => 'required|string',
            'status' => 'required|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // required, image, mime types, max 2MB
        ]);

        // 2. Pega todos os dados, exceto o arquivo da imagem por enquanto
        $data = $request->except('imagem');

        // 3. Se um arquivo de imagem foi enviado...
        if ($request->hasFile('imagem')) {
            // ...salva a imagem na pasta 'storage/app/public/leiloes' e pega o caminho
            $path = $request->file('imagem')->store('leiloes', 'public');
            // ...e adiciona o caminho da imagem aos dados que serão salvos no banco.
            $data['url_imagem'] = $path;
        }

        // 4. Cria o novo leilão com todos os dados
        Leilao::create($data);

        // 5. Redireciona de volta para a lista
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
        // 1. Validação (note que a imagem não é 'required' na edição)
        $request->validate([
            'titulo' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'matricula' => 'required|string|max:50',
            'valor_avaliacao' => 'required|numeric|min:0',
            'preco_atual' => 'required|numeric|min:0',
            'url_anuncio' => 'required|string',
            'status' => 'required|string',
            'imagem' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 2. Pega todos os dados da requisição
        $data = $request->all();

        // 3. Se uma nova imagem foi enviada...
        if ($request->hasFile('imagem')) {
            // Apaga a imagem antiga para não ocupar espaço
            Storage::disk('public')->delete($leilao->url_imagem);

            // Salva a nova imagem na pasta 'leiloes' e pega o caminho
            $path = $request->file('imagem')->store('leiloes', 'public');

            // Atualiza o caminho da imagem nos dados a serem salvos
            $data['url_imagem'] = $path;
        }

        // 4. Atualiza o leilão com os novos dados
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

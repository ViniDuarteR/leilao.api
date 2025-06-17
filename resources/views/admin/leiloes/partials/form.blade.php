<div class="mb-4">
    <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
    <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $leilao->titulo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<div class="mb-4">
    <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço</label>
    <input type="text" name="endereco" id="endereco" value="{{ old('endereco', $leilao->endereco ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<div class="mb-4">
    <label for="matricula" class="block text-sm font-medium text-gray-700">Matrícula</label>
    <input type="text" name="matricula" id="matricula" value="{{ old('matricula', $leilao->matricula ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<div class="mb-4">
    <label for="url_anuncio" class="block text-sm font-medium text-gray-700">URL do Anúncio</label>
    <input type="text" name="url_anuncio" id="url_anuncio" value="{{ old('url_anuncio', $leilao->url_anuncio ?? '#') }}" placeholder="https://..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<div class="mb-4">
    <label for="preco_atual" class="block text-sm font-medium text-gray-700">Preço Atual</label>
    {{-- CORREÇÃO: Usamos number_format para exibir no padrão brasileiro --}}
    <input type="text" inputmode="decimal" name="preco_atual" id="preco_atual" value="{{ old('preco_atual', isset($leilao) ? number_format($leilao->preco_atual, 2, ',', '.') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<div class="mb-4">
    <label for="valor_avaliacao" class="block text-sm font-medium text-gray-700">Valor de Avaliação</label>
    {{-- CORREÇÃO: Usamos number_format para exibir no padrão brasileiro --}}
    <input type="text" inputmode="decimal" name="valor_avaliacao" id="valor_avaliacao" value="{{ old('valor_avaliacao', isset($leilao) ? number_format($leilao->valor_avaliacao, 2, ',', '.') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<div class="mb-4">
    <label for="imagem" class="block text-sm font-medium text-gray-700">
        Imagem do Leilão
        @isset($leilao)
        <span class="text-gray-500 text-xs">(Opcional: envie uma nova para substituir a atual)</span>
        @endisset
    </label>
    <input type="file" name="imagem" id="imagem" class="mt-1 block w-full border-gray-300" @if(!isset($leilao)) required @endif>
    <p class="mt-1 text-xs text-gray-500">Formatos aceitos: JPG, PNG, GIF, WEBP. Tamanho máximo: 2MB.</p>
    @isset($leilao->url_imagem)
    <div class="mt-2">
        <p class="text-sm text-gray-500">Imagem Atual:</p>
        <img src="{{ asset('storage/' . $leilao->url_imagem) }}" alt="Imagem atual" class="h-20 w-auto rounded">
    </div>
    @endisset
</div>

<input type="hidden" name="status" value="{{ old('status', $leilao->status ?? 'aberto') }}">
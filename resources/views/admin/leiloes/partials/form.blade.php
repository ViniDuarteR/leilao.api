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
    <label for="preco_atual" class="block text-sm font-medium text-gray-700">Preço Atual</label>
    <input type="number" name="preco_atual" id="preco_atual" value="{{ old('preco_atual', $leilao->preco_atual ?? '') }}" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<div class="mb-4">
    <label for="valor_avaliacao" class="block text-sm font-medium text-gray-700">Valor de Avaliação</label>
    <input type="number" name="valor_avaliacao" id="valor_avaliacao" value="{{ old('valor_avaliacao', $leilao->valor_avaliacao ?? '') }}" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
</div>

<div class="mb-4">
    <label for="imagem" class="block text-sm font-medium text-gray-700">Imagem do Leilão</label>
    <input type="file" name="imagem" id="imagem" class="mt-1 block w-full">
    @isset($leilao->url_imagem)
        <div class="mt-2">
            <p class="text-sm text-gray-500">Imagem Atual:</p>
            <img src="{{ asset('storage/' . $leilao->url_imagem) }}" alt="Imagem atual" class="h-20 w-auto rounded">
        </div>
    @endisset
</div>

{{-- Campos escondidos para simplificar --}}
<input type="hidden" name="matricula" value="{{ old('matricula', $leilao->matricula ?? '00000') }}">
<input type="hidden" name="url_anuncio" value="{{ old('url_anuncio', $leilao->url_anuncio ?? '#') }}">
<input type="hidden" name="status" value="{{ old('status', $leilao->status ?? 'aberto') }}">
<div class="mb-4">
    <label for="image_path" class="block text-sm font-medium text-gray-700">Imagem do Banner</label>
    <input type="file" name="image_path" id="image_path" class="mt-1 block w-full border-gray-300"
        @if(!isset($banner)) required @endif>
    <p class="mt-1 text-xs text-gray-500">Recomendado: 1920x500 pixels, nos formatos PNG ou JPG. Tamanho máximo: 2MB.</p>
    @isset($banner->image_path)
    <div class="mt-2"><img src="{{ asset('storage/' . $banner->image_path) }}" alt="Banner atual" class="h-20 w-auto rounded"></div>
    @endisset
</div>

<div class="mb-4">
    <label for="link_url" class="block text-sm font-medium text-gray-700">Link de Redirecionamento (Opcional)</label>
    <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $banner->link_url ?? '') }}" placeholder="https://..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
</div>

<div class="mb-4">
    <label for="display_order" class="block text-sm font-medium text-gray-700">Ordem de Exibição</label>
    <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $banner->display_order ?? '0') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
</div>

<div class="mb-4">
    <label for="is_active" class="inline-flex items-center">
        <input type="checkbox" name="is_active" id="is_active" value="1"
            class="rounded border-gray-300 text-indigo-600 shadow-sm"
            @if(old('is_active', $banner->is_active ?? true)) checked @endif>
        <span class="ms-2 text-sm text-gray-600">Banner Ativo?</span>
    </label>
</div>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciar Leilões') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-4 text-right">
                        <a href="{{ route('admin.leiloes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Adicionar Novo Leilão
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Atual</th>
            
            {{-- NOVO CABEÇALHO DA COLUNA --}}
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
            
            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse ($leiloes as $leilao)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $leilao->titulo }}</td>
                <td class="px-6 py-4 whitespace-nowrap">R$ {{ number_format($leilao->preco_atual, 2, ',', '.') }}</td>
                
                {{-- NOVO DADO DA COLUNA --}}
                <td class="px-6 py-4 whitespace-nowrap">{{ $leilao->view_count }}</td>
                
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.leiloes.edit', $leilao->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                    <form class="inline-block" action="{{ route('admin.leiloes.destroy', $leilao->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar este leilão?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Apagar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                {{-- Ajustado para ocupar 4 colunas agora --}}
                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Nenhum leilão cadastrado.</td>
            </tr>
        @endforelse
    </tbody>
</table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
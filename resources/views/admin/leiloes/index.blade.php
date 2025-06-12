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
                    
                    <div class="flex justify-between items-center mb-4">
                        <form method="GET" action="{{ route('painel.leiloes.index') }}" class="w-1/2">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Buscar por ID ou Título..." 
                                       class="w-full rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ request('search') }}">
                                <button type="submit" class="px-4 py-2 bg-gray-800 text-white font-bold rounded-r-md hover:bg-gray-700">
                                    Buscar
                                </button>
                            </div>
                        </form>

                        <div class="text-right">
                            <a href="{{ route('painel.leiloes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                + Adicionar Novo Leilão
                            </a>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($leiloes as $leilao)
                                <tr class="@if($leilao->status === 'inativo') bg-gray-100 opacity-60 @endif">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $leilao->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $leilao->titulo }}</td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($leilao->status === 'aberto')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Inativo</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $leilao->view_count }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('painel.leiloes.edit', $leilao->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        
                                        <form class="inline-block ml-4" action="{{ route('painel.leiloes.toggleStatus', $leilao->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="font-bold {{ $leilao->status === 'aberto' ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}">
                                                {{ $leilao->status === 'aberto' ? 'Desativar' : 'Ativar' }}
                                            </button>
                                        </form>

                                        <form class="inline-block ml-4" action="{{ route('painel.leiloes.destroy', $leilao->id) }}" method="POST" onsubmit="return confirm('APAGAR É PERMANENTE! Tem certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Apagar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Nenhum leilão cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $leiloes->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
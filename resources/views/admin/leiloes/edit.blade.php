<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Editar Leilão: ') }} {{ $leilao->titulo }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('painel.leiloes.update', $leilao) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- CORREÇÃO: O caminho da pasta aqui continua sendo 'admin', não 'painel' --}}
                        @include('admin.leiloes.partials.form', ['leilao' => $leilao])
                        
                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('painel.leiloes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Voltar para a Lista
                            </a>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
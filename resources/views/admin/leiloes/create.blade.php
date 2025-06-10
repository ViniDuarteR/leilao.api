<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Adicionar Novo Leilão') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.leiloes.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('admin.leiloes.partials.form')
                    <div class="flex items-center justify-end mt-4 gap-4">
                        <a href="{{ route('admin.leiloes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Salvar Leilão
                        </button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Nota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('notas.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Título:</label>
                        <input type="text" name="titulo" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Conteúdo:</label>
                        <textarea name="conteudo" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
                    </div>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Salvar Nota</button>
                    <a href="{{ route('notas.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
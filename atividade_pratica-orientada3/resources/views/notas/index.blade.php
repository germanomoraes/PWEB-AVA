<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Notas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <a href="{{ route('notas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                    + Criar Nova Nota
                </a>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    @forelse ($notas as $nota)
                        <div class="border p-4 rounded shadow bg-gray-50 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">{{ $nota->titulo }}</h3>
                                <p class="text-gray-600 mt-2">{{ $nota->conteudo }}</p>
                            </div>
                            <div class="mt-4 flex justify-between items-center text-sm text-gray-500 border-t pt-2">
                                <span>Criada em: {{ $nota->created_at->format('d/m/Y H:i') }}</span>
                                <div class="space-x-2">
                                    <a href="{{ route('notas.edit', $nota->id) }}" class="text-blue-600 hover:underline">Editar</a>
                                    <form action="{{ route('notas.destroy', $nota->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Deseja realmente excluir?')">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Nenhuma nota cadastrada ainda.</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
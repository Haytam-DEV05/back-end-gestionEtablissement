@extends('base')

@section('title', 'Types de Locaux')

@section('content')
    <div class="max-w-6xl mx-auto p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Gestion des Types de Locaux</h2>
                <a href="{{ route('etablissement.index') }}" class="text-blue-600 hover:underline text-sm font-medium">
                    ← Retour aux établissements
                </a>
            </div>
            <a href="{{ route('type_locaux.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all shadow-sm">
                <span class="mr-2">+</span> Créer un type
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($typeLocaux as $local)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="mb-6">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $local->nom_type }}</h3>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <a href="{{ route('type_locaux.edit', $local->id) }}"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
                            Modifier
                        </a>

                        <form action="{{ route('type_locaux.destroy', $local->id) }}" method="POST"
                            onsubmit="return confirm('Supprimer ce type ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm font-semibold text-red-500 hover:text-red-700 transition cursor-pointer">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
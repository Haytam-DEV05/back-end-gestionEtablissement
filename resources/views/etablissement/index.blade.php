@extends('base')

@section('title', 'Tableau de bord')

@section('content')
    <div class="p-4 md:p-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div class="logo">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Mes Établissements</h1>
            </div>
            <div class="actions flex justify-between space-x-2.5 items-center">
                <a href="{{ route('etablissement.create') }}"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-500/30 transition-all duration-300">
                    <span class="text-xl">+</span> Créer un établissement
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8 shadow-sm"
                id="message-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($etablissements as $etab)
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 flex flex-col">

                    <a href="{{ route('etablissement.show', $etab->id) }}" class="grow">
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <img src="{{ asset('storage/' . $etab->logo) }}" alt="Logo"
                                class="w-full h-full object-cover rounded-2xl">
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $etab->nom }}</h2>
                        <p class="text-gray-500 text-sm font-medium">{{ $etab->ville }}</p>
                    </a>

                    <div class="flex items-center justify-between pt-6 mt-6 border-t border-black">
                        <a href="{{ route('etablissement.edit', $etab->id) }}"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Modifier
                        </a>

                        <form action="{{ route('etablissement.destroy', $etab->id) }}" method="POST"
                            onsubmit="return confirm('Êtes-vous sûr ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
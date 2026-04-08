@extends('base')

@section('title', 'Gestion de ' . $etablissement->nom)

@section('content')
    <div class="max-w-5xl mx-auto p-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 md:flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $etablissement->nom }}</h1>
                <p class="text-gray-500">{{ $etablissement->ville }}</p>
            </div>
            <div class="right space-x-4 mt-5 space-y-3 md:space-y-0 md:flex justify-between items-center">
                <a href="{{ route('equipement.deplacer', $etablissement->id) }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition max-w-fit block">
                    Historique
                </a>
                <a href="{{ route('equipement.deplacer', $etablissement->id) }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition max-w-fit block">
                    Deplacer Equipement
                </a>
                <a href="{{ route('locaux.create', ['etablissement_id' => $etablissement->id]) }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition max-w-fit block">
                    + Ajouter une salle
                </a>
            </div>
        </div>

        <!-- MESSAGE SUCCESS -->
        @if (session('success'))
            <div id="message-success"
                class="mb-6 flex items-center p-4 text-green-800 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif


        @if (session('error'))
            <div id="message-error"
                class="mb-6 flex items-center p-4 text-red-800 bg-green-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 mb-8">
            <h4 class="text-blue-800 font-bold mb-2">Importation massive</h4>
            <form action="{{ route('etablissement.import', $etablissement->id) }}" method="POST"
                enctype="multipart/form-data" class="flex items-center gap-4">
                @csrf
                <input type="file" name="excel_file"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                    required>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    Importer
                </button>
            </form>
        </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 p-6">
            @foreach($etablissement->locauxes as $local)
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition-shadow">

                    <div class="mb-4">
                        <a href="{{ route('locaux.show', $local->id) }}">
                            <h3 class="text-lg font-bold text-gray-800 tracking-tight">
                                {{ $local->nom_local }}
                            </h3>
                            <span class="text-xs text-gray-400 uppercase font-semibold">Local / Salle</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-3 border-t border-gray-50 pt-4">
                        <a href="{{ route('locaux.edit', $local->id) }}"
                            class="flex-1 text-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white py-2 rounded-lg text-sm font-medium transition-colors">
                            Modifier
                        </a>

                        <form action="{{ route('locaux.destroy', $local->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Etes-vous sûr ?')"
                                class="w-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white py-2 rounded-lg text-sm font-medium transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endsection
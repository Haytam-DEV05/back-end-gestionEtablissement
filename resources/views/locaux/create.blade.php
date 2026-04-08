@extends('base')

@section('title', 'Créer un local')

@section('content')
    <div class="max-w-xl mx-auto p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ajouter une salle/local</h2>

        <form action="{{ route('locaux.store') }}" method="POST"
            class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            @csrf

            <input type="hidden" name="etablissement_id" value="{{ $etablissement_id }}">

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom du local</label>
                <input type="text" name="nom_local" required
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                    placeholder="Ex: Salle 1, Bureau A...">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition-all shadow-md">
                Enregistrer le local
            </button>
        </form>
    </div>
@endsection
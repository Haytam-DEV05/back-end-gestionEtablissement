@extends('base')

@section('title', 'Créer un établissement')

@section('content')
    <div class="max-w-2xl mx-auto p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Mis a Jour de L'etablissement</h2>

        <form action="{{ route('etablissement.update', $etablissement->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'établissement</label>
                <input type="text" name="nom" required
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                    placeholder="Ex: NTIC" value="{{ old('nom', $etablissement->nom) }}">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                <input type="text" name="ville"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                    placeholder="Ex: Beni Mellal" value="{{ old('ville', $etablissement->ville) }}">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                <input type="file" name="logo"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition-all shadow-md">
                Mise A Jour l'établissement
            </button>
        </form>
    </div>
@endsection
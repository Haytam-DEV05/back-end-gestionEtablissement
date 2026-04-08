@extends('base')

@section('title', 'Créer un établissement')

@section('content')
    <div class="max-w-2xl mx-auto p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un Établissement</h2>
        <!-- MESSAGE DYAL ERROR -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800 font-bold">Veuillez corriger les erreurs suivantes :</span>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1 ml-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('etablissement.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'établissement</label>
                <input type="text" name="nom"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                    placeholder="Ex: NTIC">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                <input type="text" name="ville"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                    placeholder="Ex: Beni Mellal">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                <input type="file" name="logo"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition-all shadow-md">
                Enregistrer l'établissement
            </button>
        </form>
    </div>
@endsection
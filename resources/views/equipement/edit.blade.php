@extends('base')
@section('title', 'Créer un Équipement')
@section('content')
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <!-- ERROR MESSAGE -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm" id="error-message">
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
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Ajouter un nouvel équipement</h2>

        <form action="{{ route('equipement.update', $equipement->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <input type="hidden" value="{{ $equipement->local_id }}" name="local_id">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nom Equipement</label>
                <input type="text" name="nom" value="{{ old('nom', $equipement->nom) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Code Inventaire</label>
                <input type="text" name="code_inventaire" placeholder="Ex: LI180"
                    value="{{ old('code_inventaire', $equipement->code_inventaire) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">État</label>
                <select name="etat"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">
                    <option value="" disabled>-- Sélectionner l'état --</option>
                    <option value="bon" {{ old('etat', $equipement->etat) == 'Bon' ? 'selected' : ''}}>Bon</option>
                    <option value="moyen" {{ old('etat', $equipement->etat) == 'oyen' ? 'selected' : ''}}>Moyen</option>
                    <option value="en panne" {{ old('etat', $equipement->etat) == 'En Panne' ? 'selected' : ''}}>En panne
                    </option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-200">
                    Modofier l'équipement
                </button>
            </div>
        </form>
    </div>
@endsection

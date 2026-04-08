@extends('base')

@section('title', 'Déplacer Équipement')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4">

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Gestion des Mouvements</h2>
                <p class="text-gray-500 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    Déplacer un équipement d'un local à un autre
                </p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <form action="{{ route('equipement.get', $etablissement_id) }}" method="POST"
                class="flex flex-col md:flex-row gap-4 items-end">
                @csrf
                <div class="grow">
                    <label class="block text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wider">Rechercher
                        l'équipement</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" placeholder="Code Inventaire..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                    </div>
                </div>
                <button type="submit"
                    class="bg-gray-800 hover:bg-black text-white px-8 py-2.5 rounded-lg font-medium transition duration-200 shadow-md">
                    Rechercher
                </button>
            </form>
        </div>

        @if ($equipement)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-full">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Détails Actuels</h3>

                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold">Nom</span>
                                <p class="text-gray-800 font-semibold text-lg">{{ $equipement->nom }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold">Code Inventaire</span>
                                <p class="text-blue-600 font-mono">{{ $equipement->code_inventaire }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold">Local Actuel</span>
                                <p class="text-gray-700 font-medium">{{ $currentLocation }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 uppercase font-bold">État</span>
                                <div class="mt-1">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium {{ $equipement->etat == 'Bon' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ strtoupper($equipement->etat) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-50 p-3 rounded-full mr-4 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Transférer vers un nouveau local</h3>
                        </div>

                        <form action="{{ route('equipement.historique') }}" method="POST">
                            @csrf
                            <input type="hidden" name="ancien_local_id" value="{{ $equipement->local_id }}">
                            <input type="hidden" name="equipement_id" value="{{ $equipement->id }}">
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Choisir la nouvelle destination
                                </label>
                                <select name="nouveau_local_id"
                                    class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50">
                                    <option value="" disabled selected>-- Sélectionner le local cible --</option>
                                    @foreach ($newLocaux as $local)
                                        <option value="{{ $local->id }}">{{ $local->nom_local }} (ID: {{ $local->id }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="my-3">
                                <label>La Date De Changement</label>
                                <input
                                    class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50"
                                    type="date" name="date_deplacement">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200 shadow-lg shadow-blue-100">
                                    Confirmer le Déplacement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
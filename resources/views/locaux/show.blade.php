@extends('base')

@section('title', 'Détails du Local')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4">

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">{{ $locaux->nom_local }}</h2>
                <p class="text-gray-500 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    Établissement: <span class="font-semibold ml-1 text-blue-600">
                        {{ $locaux->etablissement?->nom ?? 'Non assigné' }}
                    </span>
                </p>
            </div>

            <div class="mt-4 md:mt-0">
                <a href="{{ route('equipement.create', ['local_id' => $local_id]) }}"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 shadow-lg shadow-blue-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"></path>
                    </svg>
                    Ajouter Équipement
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8 shadow-sm"
                id="message-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 uppercase tracking-wider">Liste des Équipements
                ({{ $locaux->equipements->count() }})
            </h3>
        </div>

        <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Équipement</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Code Inventaire</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">État</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($locaux->equipements as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 p-1.5 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $item->nom }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 italic">
                                {{ $item->code_inventaire }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->etat == 'Bon' ? 'bg-green-100 text-green-800' : ($item->etat == 'En Panne' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ strtoupper($item->etat) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('equipement.edit', $item->id) }}"
                                        class="text-gray-400 hover:text-blue-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('equipement.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">
                                Aucun équipement trouvé dans ce local.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
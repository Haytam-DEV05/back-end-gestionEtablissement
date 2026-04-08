<?php

namespace App\Http\Controllers;

use App\Models\equipement;
use App\Models\locaux;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\historiques;


class equipementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, equipement $equipement)
    {
        $local_id = $request->local_id;
        return view('equipement.create', compact('local_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'code_inventaire' => 'required|unique:equipements',
            'etat' => 'required',
            'local_id' => 'required|exists:locauxes,id',
        ]);
        equipement::create($validated);

        return redirect()
            ->route('locaux.show', $request->local_id)
            ->with('success', 'Équipement ajouté !');
    }

    /**
     * Display the specified resource.
     */
    public function show(equipement $equipement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(equipement $equipement)
    {
        return view('equipement.edit', compact('equipement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, equipement $equipement)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'code_inventaire' => [
                'required',
                Rule::unique('equipements')->ignore($equipement->id),
            ],
            'etat' => 'required',
            'local_id' => 'required|exists:locauxes,id',
        ]);

        $equipement->update($validated);

        return redirect()
            ->route('locaux.show', $request->local_id)
            ->with('success', 'Équipement modifié !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(equipement $equipement)
    {
        $equipement->delete();
        return Redirect()
            ->route('locaux.show', $equipement->local_id)
            ->with('success', 'equipement supprimer avec succe');
    }

    public function deplacerEquipement(Request $request)
    {
        return view('deplacer_equipement.index', [
            'equipement' => null,
            'etablissement_id' => $request->id
        ]);
    }

    public function getEquipementById(Request $request)
    {
        $etablissement_id = $request->id;
        $equipement = equipement::where('code_inventaire', $request->search)->first();
        $locaux = locaux::all();
        $newLocaux = [];
        $currentLocation = '';
        foreach ($locaux as $local) {
            if ($local['id'] == $equipement->local_id) {
                $currentLocation = $local->nom_local;
            } else {
                array_push($newLocaux, $local);
            }
        }

        return view('deplacer_equipement.index', compact('equipement', 'newLocaux', 'currentLocation', 'etablissement_id'));
    }

    public function historique(Request $request)
    {

        // AWAL HAJA HIYA ANANI NDIR UPDATE LDAK LOCALE ID DYALE DAK L EQUIPEMENT 
        // TANI HAJA HIYA ANANI NHAT HAT CHANGEMENT LI DAR FAL LA TABLE DYAL HISTORIQUE
        // dd($request);
        $equipement = equipement::where('id', $request->equipement_id)->first();
        $equipement->update([
            'local_id' => $request->nouveau_local_id
        ]);

        historiques::create([
            'equipement_id' => $request->equipement_id,
            'ancien_local_id' => $request->ancien_local_id,
            'nouveau_local_id' => $request->nouveau_local_id,
            'date_mouvement' => $request->date_deplacement
        ]);

    }

}

<?php

namespace App\Http\Controllers;

use App\Models\locaux;
use Illuminate\Http\Request;
use App\Models\equipement;

class locauxControlelr extends Controller
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
    public function create(Request $request)
    {
        $etablissement_id = $request->query('etablissement_id');
        return view('locaux.create', compact('etablissement_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formField = $request->validate([
            'nom_local' => 'required',
            'etablissement_id' => 'required|numeric',
        ]);
        $formField['nom_local'] = strtoupper($formField['nom_local']) ;

        locaux::create($formField);
        return to_route('etablissement.show', $formField['etablissement_id'])
            ->with('success', 'Local créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(locaux $locaux)
    {
        // dd($locaux) ;
        $local_id = $locaux->id ;
        $locaux->load(['equipements.categorie', 'etablissement']);
        return view('locaux.show', compact('locaux', 'local_id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(locaux $locaux, Request $request)
    {
        $etablissement_id = $request->query('etablissement_id');
        // $types = type_locaux::all();
        return view('locaux.edit', compact('locaux', 'etablissement_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, locaux $locaux)
    {
        $formField = $request->validate([
            'nom_local' => 'required',
        ]);
        $formField['etablissement_id'] = $locaux->etablissement_id;
        $locaux->update($formField);
        return to_route('etablissement.show', $locaux->etablissement_id)
            ->with('success', 'Le local a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(locaux $locaux)
    {
        $locaux->delete();
        return to_route('etablissement.show', $locaux->etablissement_id)
            ->with('success', 'supprimer locale avec succe');
    }
}

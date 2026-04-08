<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\locaux;

class locauxApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locauxes = locaux::all();
        return response()->json([
            'message' => true,
            'data' => $locauxes
        ]);
    }

    public function getLocauxEtab(Request $request)
    {
        $locauxes = locaux::where('etablissement_id', $request->id)->get();
        return response()->json([
            'message' => true,
            'data' => $locauxes
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatore = $request->validate([
            'nom_local' => 'required|string',
            'etablissement_id' => 'required'
        ]);

        locaux::create($validatore);
        return response()->json([
            'message' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $local = locaux::findOrFail($id);
        return response()->json([
            'message' => true,
            'data' => $local
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $local = locaux::findOrFail($id);
        $validatore = $request->validate([
            'nom_local' => 'required|string',
            'etablissement_id' => 'required'
        ]);

        $local->update($validatore);
        return response()->json([
            'message' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $local = locaux::findOrFail($id);
        $local->delete();
        return response()->json([
            'message' => true
        ]);
    }
}

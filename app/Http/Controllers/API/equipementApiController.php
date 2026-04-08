<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\equipement;
use Illuminate\Http\Request;

class equipementApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipements = equipement::all();
        return response()->json([
            'message' => true,
            'data' => $equipements
        ]);
    }


    public function grabEquipements(string $id, Request $request)
    {
        $equipements = equipement::where('local_id', $request->id)->get();
        return response()->json([
            'message' => true,
            'data' => $equipements
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'nom' => 'required',
            'code_inventaire' => 'required|unique:equipements',
            'etat' => 'required',
            'local_id' => 'required|exists:locauxes,id',
        ]);

        equipement::create($validator);
        return response()->json([
            'message' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipement = equipement::findOrFail($id);
        return response()->json([
            'message' => true,
            'data' => $equipement
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $equipement = equipement::findOrFail($id);
        $validator = $request->validate([
            'nom' => 'required',
            'code_inventaire' => 'required|unique:equipements,code_inventaire' . $id,
            'etat' => 'required',
            'local_id' => 'required|exists:locauxes,id',
        ]);
        $equipement->update($validator);
        return response()->json([
            'message' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipement = equipement::findOrFail($id);
        $equipement->delete();
        return response()->json([
            'message' => true
        ]);
    }
}

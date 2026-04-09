<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\historiques;
use Exception;
use Illuminate\Http\Request;
use App\Models\equipement;
use Illuminate\Support\Facades\DB;

class historiqueApiController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipement_id' => "required|exists:equipements,id",
            'ancien_local_id' => "required",
            'nouveau_local_id' => "required",
            'date_mouvement' => "required"
        ]);

        DB::beginTransaction();

        try {

            $historique = historiques::create($validated);
            $equipement = equipement::find($request->equipement_id);
            $equipement->update([
                'local_id' => $request->nouveau_local_id
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Déplacement effectué avec succès',
                'data' => $historique
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            if (!$historique) {
                return response()->json([
                    'status' => false,
                    'message' => "Erreur lors du déplacement" . $e->getMessage(),
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(historiques $historiques)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(historiques $historiques)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, historiques $historiques)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(historiques $historiques)
    {
        //
    }
}

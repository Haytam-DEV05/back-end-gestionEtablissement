<?php

namespace App\Http\Controllers\API;



use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\etablissement;
use App\Models\locaux;
use App\Models\equipement;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EquipementsExport;


class etablissementApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etablissements = etablissement::all();
        return response()->json([
            'message' => 'success',
            'data' => $etablissements
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatore = $request->validate([
            'nom' => 'required',
            'ville' => 'required',
            'logo' => 'image|mimes:png,jpg,jpeg,webp,avif'
        ]);

        if ($request->hasFile('logo')) {
            $validatore['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $etablissement = etablissement::create($validatore);
        if (!$etablissement) {
            return response()->json([
                'message' => "Erreur lors de la création"
            ], 500);
        }
        return response()->json([
            'message' => true,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $etablissement = etablissement::find($id);
        return response()->json([
            'message' => true,
            'etablissement' => $etablissement
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $etablissement = etablissement::findOrFail($id);
        // dd($etablissement);
        $validatore = $request->validate([
            'nom' => 'required|string',
            'ville' => 'required|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp'
        ]);

        if ($request->hasFile('logo')) {
            // HADI GHADI NHAYDO BIHA TASSWIRA LA9DIMA =>
            if ($etablissement->logo) {
                Storage::disk('public')->delete($etablissement->logo);
            }
            $validatore['logo'] = $request->file('logo')->store('logos', 'public');
        } else {
            $validatore['logo'] = $etablissement->logo;
        }

        $etablissement->update($validatore);

        return response()->json([
            'message' => true,
            'etablissement' => $etablissement
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $etablissement = etablissement::findOrFail($id);
        $etablissement->delete();
        return response()->json([
            'message' => true,
        ]);
    }

    public function import(Request $request)
    {
        // ✅ 1. Validation
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
            'etablissement_id' => 'required|exists:etablissements,id'
        ]);

        $etablissement_id = $request->etablissement_id;

        // ✅ 2. Lire Excel
        $data = Excel::toArray([], $request->file('excel_file'));

        $tableEquipementSalle = [];
        $tableLocal = [];

        // ✅ 3. Traitement + skip header
        foreach ($data[0] as $index => $row) {
            if ($index == 0)
                continue; // skip header

            $local = $row[6] ?? null;
            $equipement = $row[1] ?? null;
            $identifiant = $row[0] ?? null;
            $qte = $row[7] ?? 0;

            if (!$local || !$equipement)
                continue;

            $tableLocal[] = $local;

            $tableEquipementSalle[] = [
                'local' => $local,
                'equipement' => $equipement,
                'identifiant' => $identifiant,
                'qte' => $qte
            ];
        }

        // ✅ 4. Unique locaux
        $localWithoutRepeat = array_unique($tableLocal);

        DB::beginTransaction();

        try {
            // ✅ 5. Create or get locaux
            $locauxMap = [];

            foreach ($localWithoutRepeat as $local) {
                $localModel = locaux::firstOrCreate([
                    'nom_local' => $local,
                    'etablissement_id' => $etablissement_id
                ]);

                $locauxMap[$local] = $localModel->id;
            }

            // ✅ 6. Insert equipements
            foreach ($tableEquipementSalle as $row) {

                if ($row['qte'] <= 0)
                    continue;

                $localId = $locauxMap[$row['local']] ?? null;

                if (!$localId)
                    continue;

                // 👉 ila qte > 1
                if ($row['qte'] > 1) {

                    for ($i = 0; $i < $row['qte']; $i++) {
                        equipement::create([
                            'nom' => $row['equipement'],
                            'code_inventaire' => 'LI' . ($row['identifiant'] + $i),
                            'etat' => 'Bon',
                            'local_id' => $localId,
                        ]);
                    }

                } else {
                    // 👉 ila qte = 1
                    equipement::create([
                        'nom' => $row['equipement'],
                        'code_inventaire' => 'LI' . $row['identifiant'],
                        'etat' => 'Bon',
                        'local_id' => $localId,
                    ]);
                }
            }

            DB::commit();

            // ✅ 7. Response clean
            return response()->json([
                'success' => true,
                'message' => 'Importation effectuée avec succès',
                'locaux_count' => count($localWithoutRepeat),
                'equipements_count' => count($tableEquipementSalle)
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'importation',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function exportEquipements(Request $request)
    {
        return Excel::download(new EquipementsExport($request->id), 'liste_equipements.xlsx');
    }


    public function getEquipementsByEtablissement($id)
    {
        $etablissement = etablissement::findOrFail($id);
        $allEquipements = $etablissement->equipements;
        return response()->json($allEquipements);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\etablissement;
use Illuminate\Http\Request;
use App\Imports\InventoryImport;
use Illuminate\Validation\Concerns\ReplacesAttributes;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\locaux;
use App\Models\equipement;

class etablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etablissements = etablissement::all();
        return view('etablissement.index', compact('etablissements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('etablissement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formField = $request->validate([
            'nom' => 'required',
            'ville' => 'required',
            'logo' => 'image|mimes:png,jpg,webp'
        ]);
        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }
        etablissement::create($formField);
        return Redirect()
            ->route('etablissement.index')
            ->with('success', 'etablissement ajouter avec succe!');
    }

    /**
     * Display the specified resource.
     */
    public function show(etablissement $etablissement)
    {
        return view('etablissement.show', compact('etablissement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(etablissement $etablissement)
    {
        return view('etablissement.edit', compact('etablissement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, etablissement $etablissement)
    {
        $formField = $request->validate([
            'nom' => 'required',
            'ville' => 'required',
        ]);
        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        } else {
            $formField['logo'] = $etablissement->logo;
        }
        $etablissement->update($formField);
        return Redirect()
            ->route('etablissement.index')
            ->with('success', 'etablissement modifer avec succe!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(etablissement $etablissement)
    {
        $etablissement->delete();
        return to_route('etablissement.index')
            ->with('success', 'etablissements supprimer avec succe');
    }

    public function import(Request $request, $id)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            // Excel::import(new InventoryImport($id), $request->file('excel_file'));
            // return back()->with('success', 'Importation des locaux et équipements réussie !');

            $data = Excel::toArray([], $request->file('excel_file'));
            // foreach ($data as $row => $key) {
            //     if ($row === 0)
            //         continue; // skeep header
            //     echo $row ;
            //     dd($row);
            // }
            // dd($data[0][0]);
            $tableLocal = [];
            $localWithoutRepeat = [];
            $tableEquipementSalle = [];
            foreach ($data as $row) {
                foreach ($row as $key) {
                    // echo str_repeat("=", 30) . "</br>";
                    // echo $key[0] . "</br>";
                    // echo $key[1] . "</br>";
                    // echo $key[3] . "</br>";
                    // echo $key[6] . "</br>";
                    // echo str_repeat("=", 30) . "</br>";
                    array_push($tableLocal, $key[6]); // HNA KANPUSHI GHA3 DOUK LES LOCALES LI 3ANDI FDAKE L EXCEL
                    array_push($tableEquipementSalle, [
                        'local' => $key[6],
                        'equipement' => $key[1],
                        'Identifiant Unique' => $key[0],
                        'numero li corrige' => $key[5],
                        'qte prise en charge' => $key[7]
                    ]);
                }
            }

            $localWithoutRepeat = array_unique($tableLocal); // HNA KANXAD DIK L ARRAY DYAL LOCAL KANKHALIHA MATKOUNX KAT3AWDE OU KANHATHA F ARRAY JDIDA
            $localWithoutRepeat = array_slice($localWithoutRepeat, 1);
            // dd($localWithoutRepeat);

            // HNA KANDIR L CREATION DYAL DOUK LES LOCALES LI 3ANDI F WAST DIK L ETABLISSEMENT =>
            foreach ($localWithoutRepeat as $local) {
                if ($local) {
                    locaux::create([
                        'nom_local' => $local,
                        'etablissement_id' => $id
                    ]);
                }
            }


            // KHASSNI DABA N9AD LABLAN BAX ANANI NA9DAR NDIR L CREATION DYAL LES EQUIPEMENTS WAST MAN COULA SALLE =>
            // ============================================= //
            // KHASSNI NJIB HTA L'ID DYAL GA3 LES LOCAL LI 3ANDI F LITABLISSEMENT DYALI, LAHI9AXE MALI GHADI NABGHI NDAKHAL 
            // DOUK LES EQUIPEMENTS RAH DARORI KHASSNI NHAT M3AHOUM HTA L ID DYAL LOCAL LI KAYNTAMIW LIH =>
            $locaux = locaux::select('id', 'nom_local')->get();
            foreach ($tableEquipementSalle as $row) {
                if ($row['qte prise en charge']) {
                    echo str_repeat("=", 100) . "</br>";
                    foreach ($locaux as $local) {
                        // HNA GHADI NATAKADO ANAHOU 3ANDHOUM NAFSSE SMAYA DYAL LOCAL BAX NXADOU L ID DYAL DAK LOCAL =>
                        if ($local->nom_local == $row['local']) {
                            // echo str_repeat("=", 50) . "</br>";
                            // echo "local id : " . $local->id . "</br>";
                            // echo "nom local : " . $local->nom_local . "</br>";
                            // echo $row['equipement'] . "</br>";
                            // echo "Identifiant Unique : " . $row['Identifiant Unique'] . "</br>";
                            // echo "qte prise en charge : " . $row['qte prise en charge'] . "</br>";
                            // HNA KHASSNA NXOUFOU WAX DAK QYE DYAL DAK EQUIPEMENT KBAR MAN WAHD =>
                            // ILA KANT KBARE MAN WAHD KHASSNA NDIRO LIHA L CREATION DYALHA KTAR MAN MARA 
                            if ($row['qte prise en charge'] > 1) {
                                // echo str_repeat("=", 20) . "</br>";
                                for ($i = $row['Identifiant Unique']; $i < ($row['Identifiant Unique'] + $row['qte prise en charge']); $i++) {
                                    equipement::create([
                                        'nom' => $row['equipement'],
                                        'code_inventaire' => 'LI' . $i,
                                        'etat' => 'Bon',
                                        'local_id' => $local->id,
                                    ]);
                                }
                                // echo "</br>";
                                // echo str_repeat("=", 20) . "</br>";
                                // HNA GHADI NDIRO LIHA L CREATION GHIR MARA WAHDA =>
                            } else {
                                equipement::create([
                                    'nom' => $row['equipement'],
                                    'code_inventaire' => 'LI' . $row['Identifiant Unique'],
                                    'etat' => 'Bon',
                                    'local_id' => $local->id,
                                ]);
                            }
                            // echo $row['local'] . "</br>";
                            // echo str_repeat("=", 50) . "</br>";
                        }
                    }
                    // echo str_repeat("=", 100) . "</br>";
                }
            }
            // echo str_repeat("=", 30) . "</br>";
            // dd($locaux);





        } catch (\Exception $e) {
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
}

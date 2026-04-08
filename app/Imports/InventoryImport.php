<?php

namespace App\Imports;

use App\Models\equipement;
use App\Models\locaux;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class InventoryImport implements ToCollection, WithHeadingRow
{
    private $etablissement_id;
    private $locauxCache = [];

    public function __construct($etablissement_id)
    {
        $this->etablissement_id = $etablissement_id;
    }

    public function collection(Collection $rows)
    {
        // ÉTAPE 1: Créer les locaux
        foreach ($rows as $row) {
            $nomLocal = trim($row['Local'] ?? $row['local'] ?? '');

            if (!empty($nomLocal)) {
                $local = Locaux::firstOrCreate(
                    [
                        'nom_local' => $nomLocal,
                        'etablissement_id' => $this->etablissement_id
                    ],
                    [
                        'nom_local' => $nomLocal,
                        'etablissement_id' => $this->etablissement_id
                    ]
                );
                $this->locauxCache[$nomLocal] = $local->id;

                // Debug
                \Log::info("Local créé: $nomLocal avec ID: " . $local->id);
            }
        }

        // ÉTAPE 2: Créer les équipements
        foreach ($rows as $index => $row) {
            $nomLocal = trim($row['Local'] ?? $row['local'] ?? '');
            $localId = $this->locauxCache[$nomLocal] ?? null;

            // Debug
            \Log::info("Ligne $index: Local='$nomLocal', LocalID=" . ($localId ?? 'NULL'));

            if (!$localId) {
                \Log::error("Local non trouvé pour: $nomLocal");
                continue; // Skip cette ligne
            }

            $designation = $row['Désignation de l’immobilisation'] ?? 'Sans nom';
            $identifiant = $row['Identifiant Unité'] ?? null;
            $codeInventaire = $identifiant ?? ('INV-' . uniqid());

            Equipement::create([
                'nom' => $designation,
                'code_inventaire' => (string) $codeInventaire,
                'etat' => 'Bon',
                'local_id' => $localId,
            ]);
        }
    }
}

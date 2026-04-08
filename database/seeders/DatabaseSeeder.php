<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\etablissement;
use App\Models\locaux;
use App\Models\type_locaux;
use App\Models\categorie;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        etablissement::create(['nom' => 'ISTA NTIC', 'ville' => 'Beni-Mellal']);
        type_locaux::create(['nom_type' => 'Salle de classe']);
        type_locaux::create(['nom_type' => 'Bureau administratif']);

        locaux::create(['nom_local' => 'SALLE 1', 'type_local_id' => 1, 'etablissement_id' => 1]);
        locaux::create(['nom_local' => 'BUREAU', 'type_local_id' => 2, 'etablissement_id' => 1]);

        categorie::create(['nom_categorie' => 'Chaise']);
        categorie::create(['nom_categorie' => 'Table']);
    }
}

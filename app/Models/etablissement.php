<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\locaux;
use App\Models\equipement;

class etablissement extends Model
{
    protected $fillable = [
        'nom',
        'ville',
        'logo'
    ];

    public function locauxes()
    {
        return $this->hasMany(locaux::class, 'etablissement_id');
    }

    public function equipements()
    {
        return $this->hasManyThrough(
            Equipement::class,
            locaux::class,
            'etablissement_id', // 1. Foreign key f-table "locaux"
            'local_id',         // 2. Foreign key f-table "equipements" (Hadi hiya li fiha l-mouchkil)
            'id',               // 3. Local key f-table "etablissements"
            'id'                // 4. Local key f-table "locaux"
        );
    }
}

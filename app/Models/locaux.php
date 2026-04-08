<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\etablissement;

class locaux extends Model
{
    // protected $table = 'locaux';
    protected $fillable = [
        'nom_local',
        'etablissement_id'
    ];


    public function etablissement()
    {
        return $this->belongsTo(etablissement::class, 'etablissement_id');
    }

    public function equipements()
    {
        return $this->hasMany(equipement::class, 'local_id');
    }

}

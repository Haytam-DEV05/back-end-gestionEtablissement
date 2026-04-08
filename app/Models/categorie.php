<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categorie extends Model
{
    protected $fillable = ['nom_categorie'];

    public function equipements()
    {
        return $this->hasMany(equipement::class);
    }


}

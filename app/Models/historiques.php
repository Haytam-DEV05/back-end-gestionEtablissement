<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historiques extends Model
{
    protected $fillable = [
        'equipement_id',
        'ancien_local_id',
        'nouveau_local_id',
        'date_mouvement'
    ];
}

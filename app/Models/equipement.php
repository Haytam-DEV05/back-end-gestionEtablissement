<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\categorie;
use App\Models\locaux ;

class equipement extends Model
{
    protected $fillable = [
        'nom',
        'code_inventaire',
        'etat',
        'local_id'
    ];

    public function categorie()
    {
        return $this->belongsTo(categorie::class, 'categorie_id');
    }

    public function local()
    {
        return $this->belongsTo(locaux::class, 'local_id');
    }

}

<?php
namespace App\Exports;

use App\Models\equipement;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EquipementsExport implements FromQuery, WithHeadings, WithMapping
{

    protected $etablissement_id;

    public function __construct($id)
    {
        $this->etablissement_id = $id ;
    }
    public function query()
    {
        return Equipement::whereHas('local', function ($query) {
            $query->where('etablissement_id', $this->etablissement_id);
        });
    }

    // Hna kan-hadedo achmen columns bghina f-Excel
    public function headings(): array
    {
        return [
            'ID',
            'Nom Equipement',
            'Code Inventaire',
            'Etat',
            'Local',
            'Établissement',
        ];
    }

    // Hna kan-mapping l-data (bach n-affichiw smya f-blast l-ID)
    public function map($equipement): array
    {
        return [
            $equipement->id,
            $equipement->nom,
            $equipement->code_inventaire,
            $equipement->etat,
            $equipement->local ? $equipement->local->nom_local : 'N/A',
            $equipement->local && $equipement->local->etablissement ? $equipement->local->etablissement->nom : 'N/A',
        ];
    }
}
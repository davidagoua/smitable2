<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

enum HospitalisationState : int {
    const EN_ATTENTE = 0;
    const EN_COURS = 10;
    const TERMINE = 20;
}

class Hospitalisation extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_debut','date_fin','appointement_id','data','state','chambre_lit_id'
    ];

    public function appointement() : BelongsTo
    {
        return $this->belongsTo(Appointement::class);
    }

    public function chambre_lit(): BelongsTo
    {
        return $this->belongsTo(ChambreLit::class);
    }
}

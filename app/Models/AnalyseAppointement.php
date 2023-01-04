<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


// AnalyseAppointementStatus (DEMANDE -> 0, ENCOUR -> 1, ANNULE -> 2, TERMINER -> 3)
enum AnalyseAppointementStatus: int
{
    case DEMANDE = 0;
    case ENCOUR = 1;
    case ANNULE = 2;
    case TERMINER = 3;
}

class AnalyseAppointement extends Model
{
    use HasFactory;
    protected $fillable = [
        'analyse_id','appintement_id','status'
    ];

    public function analyse(): BelongsTo
    {
        return $this->belongsTo(Analyse::class);
    }

    public function appointement(): BelongsTo
    {
        return $this->belongsTo(Appointement::class);
    }
}

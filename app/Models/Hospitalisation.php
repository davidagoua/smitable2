<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hospitalisation extends Model
{
    use HasFactory;

    public function appointement() : BelongsTo
    {
        return $this->belongsTo(Hospitalisation::class);
    }

    public function chambreLit(): BelongsTo
    {
        return $this->belongsTo(ChambreLit::class);
    }
}

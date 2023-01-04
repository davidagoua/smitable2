<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ordonance extends Model
{
    use HasFactory;

    public function appointement(): BelongsTo
    {
        return $this->belongsTo(Appointement::class);
    }

    public function ligne_ordonances(): HasMany
    {
        return $this->hasMany(LigneOrdonance::class);
    }

    public function getTotalAttribute()
    {
        return $this->ligne_ordonances->sum(function ($ligne_ordonance) {
            return $ligne_ordonance->quantite * $ligne_ordonance->prix;
        });
    }
}

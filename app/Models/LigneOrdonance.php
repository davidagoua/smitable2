<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneOrdonance extends Model
{
    use HasFactory;

    public function medicament(): BelongsTo
    {
        return $this->belongsTo(Medicament::class);
    }

}

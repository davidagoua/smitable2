<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analyse extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom','type_analyse_id','laboratoire_id','prix'
    ];

    public function laboratoire(): BelongsTo
    {
        return $this->belongsTo(Laboratoire::class);
    }
}

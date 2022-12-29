<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'temperature','poids','taille','pouls','data','tension','appointement_id'
    ];
    protected $casts = [
        'data'=>'array'
    ];

    public function appointements(): BelongsTo
    {
        return $this->belongsTo(Appointement::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Appointement extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id','start','service_id','motifs'
    ];

    protected $casts = [
        'motifs'=>'array',
        'start'=>'datetime'
    ];


    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    public function consultation(): Consultation
    {
        return $this->consultations()->get()->last();
    }

    public function getAgeAttribute()
    {
        return (new Carbon($this->created_at))->diffInYears($this->patient->date_naissance) ;
    }
}

<?php

namespace App\Models;

use App\Http\Livewire\Hospitalisation\Reservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChambreLit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom','nbr_place','stock','type','prix',
    ];

    public function hospitalisations(): HasMany
    {
        return $this->hasMany(Hospitalisation::class);
    }

    public function getDisponibleAttribute()
    {
        return $this->hospitalisations()->count() > $this->nbr_place ;
    }
}

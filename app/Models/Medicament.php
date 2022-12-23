<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicament extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom','description','prix','numero','expired_at','type_medicamant_id','stock'
    ];

    public function ligne_ordonance(): HasMany
    {
        return $this->hasMany(LigneOrdonance::class)->whereNotNull(['solded_at']);
    }

    public function getStockRestantAttrbute()
    {
        return $this->stock - $this->ligne_ordonance()->count();
    }
}

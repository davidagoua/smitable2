<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory;


    protected $fillable = [
        'nom','prenoms','sexe','nationalite','profession','email','mobile','domicile','situation_matrimoniale',
        'date_naissance','scolarisation','data','lieu_naissance'
    ];

    public function appointments() : HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function getFullNameAttribute() : string
    {
        return $this->nom.' '.$this->prenoms;
    }

    public function getAvatarAttribute()
    {
        return "https://ui-avatars.com/api/?name=". Str::replace(' ', '+', $this->getFullNameAttribute());
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->code_patient = 'SMT-'. strtoupper(Str::random(6)) .'-CI';
            //$model->index = Str::remove(' ',$model->nom.''.$model->prenoms.''.$model->date_naissance.''.$model->mobile);
        });

        static::updating(function($model){
            if ($model->code_patient === ''){
                $model->code_patient = 'SMT-'. strtoupper(Str::random(6)) .'-CI';
            }
            //$model->index = Str::remove(' ',$model->nom.''.$model->prenoms.''.$model->date_naissance.''.$model->mobile);
        });
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Appointement;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Service;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class UrgencePatientForm extends Component implements HasForms
{

    use InteractsWithForms;

    public $data = [

    ];

    public function getFormStatePath()
    {
        return 'data';
    }

    public function getFormSchema()
    {
        return [
            Section::make('Enregistrer')->schema([
                Grid::make(['default'=>2])->schema([
                    TextInput::make('nom')->required(),
                    TextInput::make('prenoms')->required(),
                    Radio::make('sexe')->options([
                        'Homme'=>'Homme',
                        'Femme'=>'Femme'
                    ])->inline() ->columnSpan(2)->required(),

                    Radio::make('situation_matrimoniale')
                        ->required()
                        ->columnSpan(2)
                        ->inline()
                        ->options(['Marie'=>'Marie','Celibataire'=>'Celibataire','Autres'=>'Autres']),
                    TextInput::make('date_naissance')
                        ->type('date')
                        ->required()->label("Date de naissance"),
                    TextInput::make('lieu_naissance')->required()->label("Lieu de naissance"),
                    TextInput::make('email')->type('email'),
                    TextInput::make('mobile')->required()->tel()->prefix('+225'),
                    CheckboxList::make('type_antecedant')->options(['Medicaux'=>'Medicaux','Churigicaux'=>'Churigicaux',
                        'Vénérologie'=>'Vénérologie','Mode de vie'=>'Mode de vie',
                        'Gyneco-obstétrique'=>'Gyneco-obstétrique','Autres'=>'Autres'])->columns(2),
                ])
            ]),

            Section::make('Constantes')->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('temperature')->numeric()
                            ->label('Température')
                            ->suffix('°C'),
                        TextInput::make('tension')->numeric()
                            ->suffix('cmHg'),
                        TextInput::make('poids')
                            ->suffix('kg'),
                        TextInput::make('taille')->numeric()
                            ->suffix('cm'),
                        TextInput::make('pouls')->numeric()
                            ->suffix('Battement / secondes'),
                    ]),
                CheckboxList::make('data')->label("Signes Fonctionnel")
                    ->options(["Diarhée", "Constipation", "Vomissement",
                        "Douleur abdominale", "Emission de glaire", "Douleur thoracique", "Toux grâce"])->columns(['default' => 2]),
            ]),
        ];
    }

    public function fillFromCodePatient($state, callable $set, $get){
        if($state != null){
            $patient = Patient::find($state);
            $this->data['nom'] = $patient->nom;
            $this->data['prenoms'] = $patient->prenoms;
            $this->data['date_naissance'] = $patient->date_naissance;
            $this->data['lieu_naissance'] = $patient->lieu_naissance;
            $this->data['email'] = $patient->email;
            $this->data['situation_matrimoniale'] = $patient->situation_matrimoniale;
            $this->data['domicile'] = $patient->domicile;
            $this->data['sexe'] = $patient->sexe;
            $this->data['nationalite'] = $patient->nationalite;
            $this->data['profession'] = $patient->profession;
            $this->data['scolarisation'] = $patient->scolarisation;
            $this->data['mobile'] = $patient->mobile;

        }else{
            $this->data = [
                'patient_id'=>null,
                'date_naissance'=>null,
                'nationalite'=>null,
                'rdv'=> [
                    'service_id'=>null,
                    'start'=>null,
                ],
            ];
        }
    }

    public function render()
    {
        return view('livewire.urgence-patient-form');
    }

    public function submit()
    {

        $patient = Patient::create($this->data);

        $appointement = Appointement::create([
            'patient_id'=>$patient->id,
            'start'=> $entries['rdv']['start'] ?? now()
        ]);
        $appointement->setStatus('urgence');
        $consultation = Consultation::create([...$this->data, 'appointement_id'=>$appointement->id]);

        return redirect()->route('urgence.patient_list');
    }


}

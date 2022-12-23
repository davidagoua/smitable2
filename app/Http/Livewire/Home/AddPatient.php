<?php

namespace App\Http\Livewire\Home;

use App\Models\Appointement;
use App\Models\Patient;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class AddPatient extends Component implements HasForms
{
    use InteractsWithForms;
    public $data = [];

    public function render()
    {
        return view('livewire.home.add-patient');
    }

    public function submit()
    {
        $patient = Patient::create($this->form->getState());
        $appointement = new Appointement($this->form->getState());
        $appointement->patient_id = $patient->id;

        Filament::notify('success', "Rendez-vous enregistré");
        return redirect()->route('home.patient_list');
    }

    public function getFormSchema()
    {
        return [
          Wizard::make([
              Wizard\Step::make('Patient')->schema([
                  Section::make('Rechercher')->schema([
                      Select::make('patient_id')
                          ->searchable()->label("Code du patient")->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])->allowHtml()
                          ->getSearchResultsUsing(function (string $search) {
                              $patients = Patient::where('code_patient', 'like', "%{$search}%")
                                  ->orWhere('nom', 'like', "%{$search}%")
                                  ->orWhere('prenoms', 'like', "%{$search}%")
                                  ->limit(50)
                                  ->get();

                              return $patients->mapWithKeys(function($patient){
                                  return [$patient->id => static::getCleanOptionString($patient)];
                              });
                          })

                          ->getOptionLabelsUsing(function($value){
                              $patient = Patient::find($value);
                              return static::getCleanOptionString($patient);
                          })
                          ->afterStateUpdated(fn ($set, $get) => $this->fillFromCodePatient($set, $get))->reactive()
                  ]),
                  Section::make('Enregistrer')->schema([
                      Grid::make(['default'=>2])->schema([
                          TextInput::make('nom')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])->required(),
                          TextInput::make('prenoms')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])->required(),
                          Radio::make('sexe')->options([
                              'Homme'=>'Homme',
                              'Femme'=>'Femme'
                          ])->inline()->required(),

                          Select::make('situation_matrimoniale')->options(['Marie'=>'Marie','Celibataire'=>'Celibataire','Autres'=>'Autres']),
                          DatePicker::make('date_naissance'),
                          TextInput::make('lieu_naissance')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])->required(),

                          TextInput::make('email')->type('email'),
                          TextInput::make('mobile')->tel()->prefix('+225'),
                          TextInput::make('domicile')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])->placeholder('Ville, quartier, rue'),

                          Select::make('profession')->options([
                              'Armée'=>'Armée',
                              'Medicale'=>'Medicale',
                              'Militaire'=>'Militaire',
                              'Justice'=>'Justice',
                              'Adminitative'=>'Adminitative',
                              'Privé'=>'Privé',
                          ])->label('Corps'),

                          Select::make('nationalite')
                              ->searchable()
                              ->options(['IVOIRIEN','MALIEN','GHANEEN','AUTRES']),

                          Checkbox::make('scolarisation')
                      ])
                  ])
              ]),
              Wizard\Step::make('Motifs')
                  ->statePath('motifs')
                  ->schema([
                      Radio::make('mode_in')->options(['Urgence','Consultation','Transfert'])->inline()->label("Mode d'entrée"),
                      Repeater::make('motif_consultation')->schema([
                          TextInput::make('motif')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])
                      ]),
                      Repeater::make('antecedant')->schema([
                          Select::make('type_antecedant')->options(['Medicaux'=>'Medicaux','Churigicaux',
                              'Vénérologie'=>'Vénérologie','Mode de vie'=>'Mode de vie',
                              'Gyneco-obstétrique'=>'Gyneco-obstétrique','Autres'=>'Autres']),
                          TextInput::make('motif')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])
                      ])->columns(['default'=>2]),
                  ]),
              Wizard\Step::make('Rendez-vous')->schema([
                  Select::make('service_id')->label('service')
                      ->options([
                          1=>"Consultation Générale",
                          2=>'COVID-19',
                          3=>'Lèpre',
                          4=>'SIDA',
                          5=>'Tuberculose',
                          6=>'Urgence'
                      ])
                      ->searchable(),
                  DateTimePicker::make('start')->label('Date du RDV')->default(now())
              ]),

          ])->submitAction(new HtmlString('<button class="filament-button" type="submit">Enregistrer</button>'))
        ];
    }

    public function fillFromCodePatient(callable $set, $state){
        dd($state);
        if($state != null){
            $patient = Patient::find($state);

            $set('data.nom', $patient->nom);
            $set('data.prenoms', $patient->prenoms);
            $set('data.date_naissance', $patient->date_naissance);
            $set('data.lieu_naissance', $patient->lieu_naissance);
            $set('data.mobile', $patient->mobile);
            $set('data.situation_matrimoniale', $patient->situation_matrimoniale);
            $set('data.domicile', $patient->domicile);
            $set('data.email', $patient->email);
            $set('data.sexe', $patient->sexe);
            $set('data.nationalite', $patient->nationalite);
            $set('data.scolarisation', $patient->scolarisation);
            $set('data.profession', $patient->profession);
        }else{
            $set('data.nom', null);
            $set('data.prenoms', null);
            $set('data.date_naissance', null);
            $set('data.lieu_naissance', null);
            $set('data.mobile', null);
            $set('data.domicile', null);
            $set('data.email', null);
            $set('data.sexe', null);
            $set('data.nationalite', null);
            $set('data.scolarisation', null);
            $set('data.profession', null);
        }
    }

    public function getFormStatePath() : string
    {
        return 'data';
    }

    public static function getCleanOptionString(Model $model): string
    {
        return
            view('filament.search_patient_view')
                ->with('name', $model?->name)
                ->with('email', $model?->email)
                ->with('code_patient', $model?->code_patient)
                ->with('avatar', $model?->avatar)
                ->render()
        ;
    }
}

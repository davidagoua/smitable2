<?php

namespace App\Http\Livewire\Home;

use App\Events\PatientRegistered;
use App\Models\Appointement;
use App\Models\Patient;
use App\Models\Service;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class AddPatient extends Component implements HasForms
{
    use InteractsWithForms;
    public $data = [
        'patient_id'=>null,
        'date_naissance'=>null,
        'nationalite'=>null,
        'rdv'=> [
            'service_id'=>null,
            'start'=>null,
        ],
    ];
    public $service_id, $start;

    public function render()
    {
        return view('livewire.home.add-patient');
    }

    public function submit()
    {
        $entries = $this->form->getState();
        $patient = Patient::firstOrCreate(['id'=> $entries['patient_id']], $entries);

        // register
        $id = DB::table('appointements')->insertGetId([
            'patient_id'=>$patient->id,
            'service_id'=> $entries['rdv']['service_id'],
            //'motifs'=> $entries['motifs'],
            'start'=> $entries['rdv']['start'] ?? now()
        ]);

        $appointement = Appointement::find($id);

        //dd($appointement);
        $event = new PatientRegistered($patient, $appointement)  ;
        event($event);
        auth()->user()->notify();
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
                          ->searchable()->label("Code du patient")->allowHtml()
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
                          ->afterStateUpdated(fn ($state, $set, $get) => $this->fillFromCodePatient($state, $set, $get))->reactive()
                  ]),

                  Section::make('Enregistrer')->schema([
                      Grid::make(['default'=>2])->schema([
                          TextInput::make('nom')->required(),
                          TextInput::make('prenoms')->required(),
                          Radio::make('sexe')->options([
                              'Homme'=>'Homme',
                              'Femme'=>'Femme'
                          ])->inline()->required(),

                          Select::make('situation_matrimoniale')
                              ->required()
                              ->options(['Marie'=>'Marie','Celibataire'=>'Celibataire','Autres'=>'Autres']),
                          DatePicker::make('date_naissance')->required()->label("Date de naissance"),
                          TextInput::make('lieu_naissance')->required()->label("Lieu de naissance"),
                          TextInput::make('email')->type('email'),
                          TextInput::make('mobile')->tel()->prefix('+225'),
                          TextInput::make('domicile')->placeholder('Ville, commune, quartier'),
                          Select::make('profession')->options([
                              'Armée'=>'Armée',
                              'Medicale'=>'Medicale',
                              'Militaire'=>'Militaire',
                              'Justice'=>'Justice',
                              'Adminitrative'=>'Adminitrative',
                              'Privé'=>'Privé',
                          ])->label('Corps'),

                          Select::make('nationalite')
                              ->searchable()
                              ->options(['IVOIRIEN','MALIEN','GHANEEN','AUTRES']),

                          Checkbox::make('scolarisation')->inline(false)
                      ])
                  ])
              ]),
              Wizard\Step::make('Motifs')
                  ->statePath('motifs')
                  ->schema([
                      Radio::make('mode_in')->options(['Urgence'=>'Urgence','Consultation'=>'Consultation','Transfert'=>'Transfert'])->inline()->label("Mode d'entrée"),
                      Repeater::make('motif_consultation')->schema([
                          TextInput::make('motif')
                      ]),
                      Repeater::make('antecedant')->schema([
                          Select::make('type_antecedant')->options(['Medicaux'=>'Medicaux','Churigicaux'=>'Churigicaux',
                              'Vénérologie'=>'Vénérologie','Mode de vie'=>'Mode de vie',
                              'Gyneco-obstétrique'=>'Gyneco-obstétrique','Autres'=>'Autres']),
                          TextInput::make('motif')
                      ])->columns(['default'=>2]),
                  ]),
              Wizard\Step::make('Rendez-vous')
                  ->statePath('rdv')
                  ->schema([
                  Select::make('service_id')->label('service')
                      ->required()
                      ->options(Service::all('id','nom')->pluck('nom','id'))
                      ->searchable(),
                  DateTimePicker::make('start')->label('Date du RDV')->default(now())
              ]),

          ])->submitAction(new HtmlString('<button class="filament-button" type="submit">Enregistrer</button>'))
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

    public function getFormStatePath() : string
    {
        return 'data';
    }

    public static function getCleanOptionString(Model $model): string
    {
        return
            view('filament.search_patient_view')
                ->with('name', $model?->fullName)
                ->with('email', $model?->email)
                ->with('code_patient', $model?->code_patient)
                ->with('avatar', $model?->avatar)
                ->render()
        ;
    }
}

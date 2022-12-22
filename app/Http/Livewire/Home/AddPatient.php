<?php

namespace App\Http\Livewire\Home;

use App\Models\Patient;
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
use Livewire\Component;

class AddPatient extends Component implements HasForms
{
    use InteractsWithForms;

    public function render()
    {
        return view('livewire.home.add-patient');
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
                          ->afterStateUpdated(function(callable $set, $state){
                              if($state != null){
                                  $patient = Patient::find($state);
                                  $set('nom', $patient->nom);
                                  $set('prenoms', $patient->prenoms);
                                  $set('date_naissance', $patient->date_naissance);
                                  $set('lieu_naissance', $patient->lieu_naissance);
                                  $set('mobile', $patient->mobile);
                                  $set('situation_matrimoniale', $patient->situation_matrimoniale);
                                  $set('domicile', $patient->domicile);
                                  $set('email', $patient->email);
                                  $set('sexe', $patient->sexe);
                                  $set('nationalite', $patient->nationalite);
                                  $set('scolarisation', $patient->scolarisation);
                                  $set('profession', $patient->profession);
                              }else{
                                  $set('nom', null);
                                  $set('prenoms', null);
                                  $set('date_naissance', null);
                                  $set('lieu_naissance', null);
                                  $set('mobile', null);
                                  $set('domicile', null);
                                  $set('email', null);
                                  $set('sexe', null);
                                  $set('nationalite', null);
                                  $set('scolarisation', null);
                                  $set('profession', null);
                              }
                          })->reactive()
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
                              'H'=>'Homme',
                              'F'=>'Femme'
                          ])->inline()->required(),

                          Select::make('situation_matrimoniale')->options(['Marie','Celibataire','Autre']),
                          DatePicker::make('date_naissance'),
                          TextInput::make('lieu_naissance')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])->required(),

                          TextInput::make('email')->type('email'),
                          TextInput::make('mobile')->tel()->prefix('+225'),
                          TextInput::make('domicile')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ])->placeholder('Ville, quartier, rue'),

                          TextInput::make('profession')->extraAttributes([
                              'onKeyUp'=>'this.value = this.value.toUpperCase()'
                          ]),

                          Select::make('nationalite')
                              ->searchable()
                              ->options(['IVOIRIEN','MALIEN','GHANEEN','AUTRES']),

                          Checkbox::make('scolarisation')
                      ])
                  ])
              ]),
              Wizard\Step::make('Sante')
                  ->statePath('motif')
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

          ])
        ];
    }
}

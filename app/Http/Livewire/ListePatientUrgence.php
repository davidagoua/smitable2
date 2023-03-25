<?php

namespace App\Http\Livewire;

use App\Models\Appointement;
use App\Models\Consultation;
use App\Models\Medicament;
use App\Models\Service;
use Filament\Facades\Filament;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListePatientUrgence extends Component implements HasTable
{
    use InteractsWithTable;

    public function getTableQuery()
    {
        return Appointement::currentStatus('urgence');
    }

    public function getTableColumns()
    {
        return [
          TextColumn::make('patient.code_patient')->label('Code Patient'),
          TextColumn::make('patient.nom')->label('Nom'),
          TextColumn::make('patient.prenoms')->label('Prénoms'),
          TextColumn::make('created_at')->label("Date d'entrée"),
          TextColumn::make('consultation_count')->label('Consultations')->counts("consultations"),
          TextColumn::make('last_consultation')
              ->getStateUsing(fn($record) => $record->consultation()->created_at)
              ->label('Dernière consultation'),
        ];
    }

    public function getTableActions()
    {
        return [
            Action::make('stable')->button()->label('Stable')->requiresConfirmation()
                ->action(function($record){

                }),
          ActionGroup::make([
              Action::make('constante')
                  ->action(function($record, $data){
                      Consultation::create([
                          ...$data,
                         'appointement_id'=> $record->id
                      ]);
                  })
                  ->form(function($record){
                      return [
                          Hidden::make('consultation_id'),
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
                              ->options(["Diarhée", "Constipation","Vomissement",
                                  "Douleur abdominale","Emission de glaire","Douleur thoracique","Toux grâce"])->columns(['default'=>2]),

                      ];
                  })
                ->label("Ajouter Constante"),
              Action::make('consultation')
                  ->action(function($record, $data){
                      if (count($data['analyses']) == 0 ) {
                          $record->outed = now();
                      } else {
                          foreach ($data['analyses'] as $analyse) {
                              if( $analyse['id'] != null){
                                  DB::table('analyse_appointements')->insert([
                                      'analyse_id' => $analyse['id'],
                                      'appointement_id' => $record->id
                                  ]);
                              }
                          }
                      }

                      if (count($data['ordonances']) >= 1) {
                          $ordonance_id = DB::table('ordonances')->insertGetId(['appointement_id' => $record->id]);
                          foreach ($data['ordonances'] as $medicament) {
                              $medicament = Medicament::find($medicament['id']);
                              DB::table('ligne_ordonances')->insert([
                                  'ordonance_id' => $ordonance_id,
                                  'medicament_id' => $medicament['id'],
                                  'frequence' => $medicament['frequence'],
                                  'quantite' => 1,
                                  'prix'=> $medicament->prix,
                              ]);
                          }
                      }

                      if ($data['chambre_lit_id'] != null) {
                          DB::table('hospitalisations')->insert([
                              'chambre_lit_id' => $data['chambre_lit_id'],
                              'appointement_id' => $record->id,
                              'date_debut' => $data['date_debut'],
                              'date_fin' => $data['date_fin'],
                              'state' => 0
                          ]);
                      }
                      Filament::notify('sucess', "Traitement enregistrer");
                  })
                  ->form(function ($record) {
                      return [
                          RichEditor::make('description')->default(''),

                          Repeater::make('ordonances')->label('Ordonance')
                              ->schema([
                                  Select::make('id')
                                      ->label("Medicament")
                                      ->options(Medicament::all()->pluck('nom', 'id')),
                                  TextInput::make('frequence')
                              ])->columns(['default' => 2]),
                          Repeater::make('analyses')->label('Analyse')
                              ->schema([
                                  Select::make('id')
                                      ->options(DB::table('analyses')->select('id', 'nom')->get()->pluck('nom', 'id'))
                                      ->label('Analyse'),
                              ])->columns(['default' => 2]),

                          Grid::make(4)
                              ->schema([
                                  Select::make('chambre_lit_id')
                                      ->columnSpan(2)
                                      ->label('Chambre')
                                      ->options(DB::table('chambre_lits')->select('id', 'nom')->get()->pluck('nom', 'id')),
                                  DatePicker::make('date_debut')
                                      ->label("Date d'entrée")
                                      ->default(now()),
                                  DatePicker::make('date_fin')
                                      ->label('Date de sortie')
                              ])
                      ];
                  }),
              Action::make('hospitalisation')
                  ->action(function($record, $data){

                  })
                  ->form([
                      Select::make('service_id')->options(Service::all()->pluck('nom','id'))
                  ])
                  ->label('Hospitaliser')
          ])
        ];
    }

    public function render()
    {
        return view('livewire.liste-patient-urgence');
    }
}

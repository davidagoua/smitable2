<?php

namespace App\Http\Livewire\Service;

use App\Http\Controllers\AnalyseController;
use App\Models\Analyse;
use App\Models\AnalyseAppointement;
use App\Models\Appointement;
use App\Models\Medicament;
use App\Models\Ordonance;
use App\Models\Service;
use Filament\Facades\Filament;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListPatient extends Component implements HasTable
{
    use InteractsWithTable;

    public $service;

    public function mount()
    {
        $this->services = [
          [
              'nom'=>"Aujourd'hui",
              "appointements_count"=> $this->getTableQuery()->whereDay('updated_at', now())->get()
          ]  ,
            [
              'nom'=>"Cette semaine",
              "appointements_count"=> $this->getTableQuery()->whereBetween('updated_at', [today()->startOfWeek(), today()->startOfWeek()->addDays(7)])->get()
          ]  ,
            [
              'nom'=>"Ce mois",
              "appointements_count"=> $this->getTableQuery()->whereMonth('updated_at',now())->get()
          ]  ,
            [
              'nom'=>"Cette année",
              "appointements_count"=> $this->getTableQuery()->whereYear('updated_at', now())->get()
          ]  ,

        ];

    }

    public function getTableQuery(): Builder
    {
        return Appointement::query()
            ->with(['patient','consultations'])
            ->where('service_id', $this->service->id);
    }

    public function render()
    {
        return view('livewire.service.list-patient');
    }

    public function getTableColumns()
    {
        return [
          TextColumn::make('patient.code_patient')->label('Code Patient'),
          TextColumn::make('patient.nom')->label('nom'),
          TextColumn::make('patient.prenoms')->label('prenoms'),
          TextColumn::make('age')->label('Age')->suffix(' ans'),
        ];
    }

    public function getTableActions()
    {
        return [
          Action::make('view')->label("Voir")->button()->color('secondary')
            ->action(function($record, $data){
                dd($record);
            })
            ->form(function($record){
                return [
                    Card::make([
                        Placeholder::make('resumer')->content(function(Appointement $record){
                            return view('filament.services.recap',);
                        })
                    ])
                ];
            }),
            Action::make('traiter')->button()
                ->action(function($record, $data){

                    if(count($data['analyses']) == 0 && !$data['hospitalisation']){
                        $record->outed = now();
                    }else{
                        foreach ($data['analyses'] as $analyse){
                            DB::table('analyse_appointements')->insert([
                                'analyse_id'=>$analyse['id'],
                                'appointement_id'=>$record->id
                            ]);
                        }
                    }

                    if(count($data['ordonances']) >= 1){
                        $ordonance_id = DB::table('ordonance')->insertGetId(['appointement_id'=>$record->id]);
                        foreach ($data['ordonances'] as $medicament){
                            DB::table('ligne_ordonances')->insert([
                               'ordonance_id'=> $ordonance_id,
                               'medicament_id'=> $medicament['id'],
                               'frequence'=>$medicament['frequence']
                            ]);
                        }
                    }

                    Filament::notify('sucess',"Traitement enregistrer");
                })
                ->form(function ($record) {
                    return [
                        RichEditor::make('description')->default(''),
                        Repeater::make('ordonances')->label('Ordonance')
                            ->schema([
                                Select::make('id')->options(Medicament::all()->pluck('name','id')),
                                TextInput::make('frequence')
                            ])->columns(['default'=>2]),
                        Repeater::make('analyses')->label('Analyse')
                            ->schema([
                                Select::make('id')
                                    ->searchable()
                                    ->options(Analyse::all()->pluck('nom', 'id'))->label('Analyse'),
                            ])->columns(['default'=>2]),
                        Checkbox::make('hospitalisation')->label("Patient à hospitaliser"),
                    ];
                }),

            ActionGroup::make([
                Action::make('Urgence')
                    ->label('Urgence')
                    ->action(function($record, $data){

                    })
                    ->requiresConfirmation(),
                DeleteAction::make('supprimer'),
            ])
        ];
    }
}

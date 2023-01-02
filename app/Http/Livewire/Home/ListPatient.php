<?php

namespace App\Http\Livewire\Home;

use App\Events\PatientConsulted;
use App\Models\Appointement;
use App\Models\Consultation;
use App\Models\Service;
use App\Models\Patient;
use Filament\Facades\Filament;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ListPatient extends Component implements HasTable
{
    use InteractsWithTable;
    public $services;

    public function mount()
    {
        $this->services = \cache()->remember('services', 60, function(){
            return Service::withCount('appointements')->get();
        });
    }

    public function render()
    {
        return view('livewire.home.list-patient');
    }

    public function getTableQuery()
    {
        return Appointement::query()->with(['patient','service']);
    }

    public function getTableHeaderActions()
    {
        return [
            Action::make('Ajouter')
                ->button()
                ->url(route('home.patient_add'))
        ];
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('patient.code_patient')->searchable(),
            TextColumn::make('patient.nom')->label('nom')->searchable(),
            TextColumn::make('patient.prenoms')->label('prenoms')->searchable(),
            TextColumn::make('service.start')->label('Date et heure RDV')->searchable(),
            TextColumn::make('service.nom')->searchable(),
        ];
    }

    public function getTableActions()
    {
        return [
            Action::make('Constantes')
                ->button()
                ->action(function($record, $data){
                    $consultation = Consultation::create([...$data, 'appointement_id'=>$record->id]);
                    event(new PatientConsulted($record));
                    Filament::notify('success', "Patient Consulté");
                })
                ->modalHeading(fn ($record) => "Consultation patient #".$record->patient->code_patient)
                ->form(function($record){
                    return [
                        Grid::make(2)
                            ->schema([
                                TextInput::make('temperature')->numeric()
                                    ->label('Température')
                                    ->suffix('°C')
                                    ->default($record->temperature),
                                TextInput::make('tension')->numeric()
                                    ->suffix('cmHg')
                                    ->default($record->tension),
                                TextInput::make('poids')
                                    ->suffix('kg')
                                    ->numeric()->default($record->poids),
                                TextInput::make('taille')->numeric()
                                    ->suffix('cm')
                                    ->default($record->taille),
                                TextInput::make('pouls')->numeric()
                                    ->suffix('Battement / secondes')
                                    ->default($record->pouls),
                            ]),
                        CheckboxList::make('data')->label("Signes Fonctionnel")
                            ->default($record->data)
                            ->options(["Diarhée", "Constipation","Vomissement",
                                "Douleur abdominale","Emission de glaire","Douleur thoracique","Toux grâce"])->columns(['default'=>2]),

                    ];
                }),
            ActionGroup::make([
                Action::make('Urgence')
                    ->label('Urgence')
                    ->action(function(){

                    })
                    ->requiresConfirmation(),
                DeleteAction::make('supprimer'),
            ])
        ];
    }
}

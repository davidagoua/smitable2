<?php

namespace App\Http\Livewire\Hospitalisation;

use App\Models\Hospitalisation;
use App\Models\HospitalisationState;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reservation extends Component implements HasTable
{
    use InteractsWithTable;

    public function getTableQuery()
    {
        return Hospitalisation::query()->with(['appointement','chambre_lit']);
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('appointement.patient.code_patient')
                ->searchable()
                ->label("Code Patient"),
            TextColumn::make('appointement.patient.nom')->label("Nom"),
            TextColumn::make('appointement.patient.prenoms')->label("Prénoms"),
            TextColumn::make('chambre_lit.nom')->label("Chambre"),
            TextColumn::make('appointement.service.nom')->label("Service"),
            BadgeColumn::make('state')->label("Etat")    ->colors([
                'primary',
                'success' => static fn ($state): bool => $state === 10,
                'secondary' => static fn ($state): bool => $state === 20,
            ])
            ->enum([
                0 => 'En attente',
                10 => 'En cours',
                20 => 'Terminé',
            ]),
            TextColumn::make('date_debut')->label("Date d'entrée"),
            TextColumn::make('date_fin')->label("Date de sortie"),
        ];
    }

    public function getTableBulkActions()
    {
        return [
            BulkAction::make("Liberer")
        ];
    }

    public function getTableActions()
    {
        return [

            ActionGroup::make([
                EditAction::make("modifier")->form([
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
                ]),
                Action::make("Liberer")->visible(fn($record) => $record->state == 10),
                Action::make("Accepter")->visible(fn($record) => $record->state == 0)
                    ->action(fn($record) => $record->update(['state'=>HospitalisationState::EN_COURS])),
            ])
        ];
    }

    public function getTableFilters()
    {
        return [
            SelectFilter::make('state')->label("Etat")->options([
                0 => 'En attente',
                10 => 'En cours',
                20 => 'Terminé',
            ])
        ];
    }

    public function render()
    {
        return view('livewire.hospitalisation.reservation');
    }
}

<?php

namespace App\Http\Livewire\Hospitalisation;

use App\Models\Hospitalisation;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
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
          TextColumn::make('appointement.nom')->label("Nom"),
          TextColumn::make('appointement.prenoms')->label("Prénoms"),
            TextColumn::make('chambre_lit.nom')->label("Chambre"),
            TextColumn::make('appointement.service.nom')->label("Service"),
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

    public function render()
    {
        return view('livewire.hospitalisation.reservation');
    }
}

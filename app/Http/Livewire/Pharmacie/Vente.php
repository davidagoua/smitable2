<?php

namespace App\Http\Livewire\Pharmacie;

use App\Models\Ordonance;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class Vente extends Component implements HasTable
{
    use InteractsWithTable;

    public function getTableQuery()
    {
        return Ordonance::with('appointement');
    }

    public function render()
    {
        return view('livewire.pharmacie.vente');
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('appointement.patient.code', 'Code du patient'),
        ];
    }
}

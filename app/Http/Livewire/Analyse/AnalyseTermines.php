<?php

namespace App\Http\Livewire\Analyse;

use App\Models\AnalyseAppointement;
use App\Models\AnalyseAppointementStatus;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class AnalyseTermines extends Component implements HasTable
{
    use InteractsWithTable;

    public function getTableQuery()
    {
        return AnalyseAppointement::query()->with(['analyse','appointement'])->where('status', AnalyseAppointementStatus::TERMINER);
    }

    public function render()
    {
        return view('livewire.analyse.analyse-termines');
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('appointement.patient.nom')->label("Nom"),
            TextColumn::make('appointement.patient.prenoms')->label("Prenoms"),
            TextColumn::make('analyse.nom')->label("Analyse"),
            TextColumn::make('created_at')->label("Date de demande"),
            TextColumn::make('Resultat')->label("resultat"),
        ];
    }
}

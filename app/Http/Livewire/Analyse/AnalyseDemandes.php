<?php

namespace App\Http\Livewire\Analyse;

use App\Models\AnalyseAppointement;
use App\Models\AnalyseAppointementStatus;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class AnalyseDemandes extends Component implements HasTable
{
    use InteractsWithTable;

    public function getTableQuery()
    {
        return AnalyseAppointement::query()->with(['analyse','appointement'])
            ->where('status', AnalyseAppointementStatus::DEMANDE);
    }

    public function render()
    {
        return view('livewire.analyse.analyse-demandes');
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('appointement.patient.code_patient')->label("Code patient"),
            TextColumn::make('appointement.patient.nom')->label("Nom"),
            TextColumn::make('appointement.patient.prenoms')->label("Prenoms"),
            TextColumn::make('analyse.nom')->label("Analyse"),
            TextColumn::make('created_at')->label("Date de demande"),
        ];
    }

    public function getTableActions()
    {
        return [
            Action::make('accepter')->label("Accepter")->button()
                ->requiresConfirmation()
                ->action(fn($record) => $record->update(['status' => AnalyseAppointementStatus::ENCOUR])),
            Action::make('annuler')->label("Annuler")
                ->color('danger')
                ->button()
        ];
    }
}

<?php

namespace App\Http\Livewire\Analyse;

use App\Models\AnalyseAppointement;
use App\Models\AnalyseAppointementStatus;
use App\Models\Service;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class AnalyseCourant extends Component implements HasTable
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
        return view('livewire.analyse.analyse-courant');
    }

    public function getTableQuery()
    {
        return AnalyseAppointement::query()
            ->where('status', AnalyseAppointementStatus::ENCOUR)
            ->with(['analyse','appointement']);
    }

    public function getTableColumns()
    {
        return [
          TextColumn::make('appointement.patient.nom')->label("Nom"),
          TextColumn::make('appointement.patient.prenoms')->label("Prenoms"),
          TextColumn::make('analyse.nom')->label("Analyse"),
          TextColumn::make('created_at')->label("Date de demande"),
        ];
    }

    public function getTableActions()
    {
        return [
            Action::make('Resultat')->action(function($record, $data){

            })
                ->color('secondary')
                ->button()
            ->form([
                Toggle::make('resultat')->label("Positive"),
            ])
        ];
    }
}

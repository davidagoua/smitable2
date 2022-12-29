<?php

namespace App\Http\Livewire\Service;

use App\Models\Appointement;
use App\Models\Service;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class ListPatient extends Component implements HasTable
{
    use InteractsWithTable;

    public $service;

    public function mount()
    {

    }

    public function getTableQuery()
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
          TextColumn::make('age')->label('Age'),
        ];
    }
}

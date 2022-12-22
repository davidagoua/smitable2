<?php

namespace App\Http\Livewire\Service;

use App\Models\Appointement;
use App\Models\Service;
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
        return Appointement::query()->where('service_id', $this->service->id);
    }

    public function render()
    {
        return view('livewire.service.list-patient');
    }
}

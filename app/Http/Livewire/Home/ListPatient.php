<?php

namespace App\Http\Livewire\Home;

use App\Models\Appointement;
use App\Models\Service;
use App\Models\Patient;
use Filament\Tables\Actions\Action;
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
        return Appointement::query();
    }

    public function getTableHeaderActions()
    {
        return [
            Action::make('Ajouter')
                ->button()
                ->url(route('home.patient_add'))
        ];
    }
}

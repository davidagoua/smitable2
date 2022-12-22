<?php

namespace App\Http\Livewire\Analyse;

use App\Models\AnalyseAppointement;
use App\Models\Service;
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
        return AnalyseAppointement::query()->with(['analyse','appointement']);
    }
}

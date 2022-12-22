<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;

class Menu extends Component
{
    public $services;

    public function mount()
    {
        $this->services = \cache()->remember('services', 60, function(){
            return Service::withCount('appointements')->get();
        });
    }

    public function render()
    {
        return view('livewire.menu');
    }
}

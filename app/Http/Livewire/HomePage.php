<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $urgence_url = '';
        return view('livewire.home-page');
    }
}

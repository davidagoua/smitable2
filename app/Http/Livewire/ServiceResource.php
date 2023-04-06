<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class ServiceResource extends Component implements HasTable
{

    use InteractsWithTable;

    public function getTableQuery()
    {
        return Service::query();
    }

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('nom')->label("Nom")
        ];
    }

    public function getTableActions(): array
    {
        return [
            DeleteAction::make()->button()
        ];
    }

    public function render()
    {
        return view('livewire.service-resource');
    }
}

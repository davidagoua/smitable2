<?php

namespace App\Http\Livewire\Home;

use App\Models\Patient;
use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class RecherchePage extends Component implements HasTable
{

    use InteractsWithTable;


    protected function getHeaderWidgets(): array
    {
        return [
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Patient::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('code_patient')->label('Code Patient')->searchable(),
            TextColumn::make('nom')->label('Nom')->searchable(),
            TextColumn::make('prenoms')->label('Prenoms')->searchable(),
            TextColumn::make('sexe')->label('Sexe')
                ->getStateUsing(function($record){
                    return $record->sexe == 'H' ? 'Masculin' : 'Féminin';
                })
                ->searchable(),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('service_id')->label('Service')->options(
                Service::all()->pluck('nom', 'id')
            ),
        ];
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make(['default'=>2])
                ->schema([
                    TextInput::make('nom')->label('Nom'),
                    TextInput::make('prenoms')->label('Prénoms'),
                    DatePicker::make('date_naissance')->label('Date de naissance'),
                    TextInput::make('lieu_naissance')->label('Lieu de naissance'),
                ])
        ];
    }

    public function getTableActions(): array
    {
        return [
            //Tables\Actions\DeleteAction::make()->button()
        ]        ;
    }
}

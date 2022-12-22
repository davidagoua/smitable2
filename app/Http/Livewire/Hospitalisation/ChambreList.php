<?php

namespace App\Http\Livewire\Hospitalisation;

use App\Models\ChambreLit;
use Faker\Provider\Text;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class ChambreList extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('livewire.hospitalisation.chambre-list');
    }

    public function getTableQuery()
    {
        return ChambreLit::query();
    }

    public function getTableHeaderActions()
    {
        return [
            Action::make('Ajouter')->button()
                ->action(function($data){
                    ChambreLit::create($data);
                    Filament::notify('success', "Chambre Ajouter");
                })
                ->form([
                    Grid::make(2)->schema([
                        TextInput::make('nom')->required()->label('Numero de la chambre'),
                        Select::make('type')->required()->options([
                            'Chambre climatisée','Chambre spécialisée','Chambre Simple'
                        ])->label('Type de chambre'),
                    ]),
                    Grid::make(3)->schema([
                        TextInput::make('stock')->required()->label('Nombre de chambre')->default(1),
                        TextInput::make('nbr_place')->required()->label('Nombre de lit')->default(1),
                        TextInput::make('prix')->required()->suffix('FCFA')->default(0),
                    ])
                ])
        ];
    }

    public function getTableColumns()
    {
        return [
          TextColumn::make('nom')->label('Numero'),
          BadgeColumn::make('Type')->getStateUsing(function($record){
              return [
                  'Chambre climatisée','Chambre spécialisée','Chambre Simple'
              ][$record->type];
          }),
            TextColumn::make('disponible')
                ->label("Lits Disponibles")
                ->getStateUsing(fn ($record) => $record->nbr_place - $record->hospitalisations()->count() .'/'. $record->nbr_place),

        ];
    }

    public function getTableActions()
    {
        return [
            EditAction::make('modifier')->button()
                ->form([
                    Grid::make(2)->schema([
                        TextInput::make('nom')->required()->label('Numero de la chambre'),
                        Select::make('type')->options([
                            'Chambre climatisée','Chambre spécialisée','Chambre Simple'
                        ])->required()->label('Type de chambre'),
                    ]),
                    Grid::make(3)->schema([
                        TextInput::make('stock')->required()->label('Nombre de chambre')->default(1),
                        TextInput::make('nbr_place')->required()->label('Nombre de lit')->default(1),
                        TextInput::make('prix')->required()->suffix('FCFA')->default(0),
                    ])
                ]),
            DeleteAction::make('Supprimer')->button()
        ];
    }
}

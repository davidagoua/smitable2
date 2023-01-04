<?php

namespace App\Http\Livewire\Pharmacie;

use App\Models\Ordonance;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class Vente extends Component implements HasTable
{
    use InteractsWithTable;

    public function getTableQuery()
    {
        return Ordonance::with([
            'appointement',
            'ligne_ordonances',
            'appointement.patient'
        ]);
    }

    public function render()
    {
        return view('livewire.pharmacie.vente');
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('appointement.patient.code_patient')->label("Code Patient"),
            TextColumn::make('ligne_ordonances_count')->label("Nombre de medicaments")
                ->counts('ligne_ordonances'),
            TextColumn::make('total')->label("Total")->getStateUsing(fn ($record) => $record->total),
        ];
    }

    public function getTableActions()
    {
        return [
          Action::make('details')
              ->button()
              ->action(function($record, $data){
                  $this->emit('showDetails', $record->id);
              })
              ->form(function($record){
                  return [
                      Placeholder::make('details')->content(function($record){
                          return view('livewire.pharmacie.vente-details', [
                              'record' => $record
                          ]);
                      })
                  ];
              }),
            ActionGroup::make([
                DeleteAction::make('supprimer')
            ])
        ];
    }
}

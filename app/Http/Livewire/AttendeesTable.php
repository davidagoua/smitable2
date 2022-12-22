<?php

namespace App\Http\Livewire;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class AttendeesTable extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('livewire.attendees-table');
    }

    public function getTableQuery()
    {
        return User::query();
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('name')->searchable(),
            TextColumn::make('email'),
        ];
    }

    public function getTableBulkActions()
    {
        return [
          DeleteBulkAction::make('supprimer')
        ];
    }

    public function getTableActions()
    {
        return [
          Action::make('Fiche')->button(),
            ActionGroup::make([
                DeleteAction::make('supprimer')->label('Supprimer'),
                EditAction::make('modifier')
                    ->label('Modifier')
                    ->action(function($record){
                        $this->fill($record);
                    })
            ])
        ];
    }

    public function getTableHeaderActions()
    {
        return [
            Action::make('Ajouter')->button(),
            Action::make('importer')->button()
                ->color('secondary')
                ->action(function($data){

                })
                ->form([
                    FileUpload::make('fichier')
                ])
                ->label("Importer")
        ];
    }

    public function getFormSchema()
    {
        return [
            TextInput::make('name'),
            TextInput::make('email'),
            TextInput::make('password'),
            Select::make('jour')->options(['Lundi','Mardi','Mercredi'])
        ];
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserResource extends Component implements HasTable
{
    use InteractsWithTable;


    public function getTableQuery(): Builder
    {
        return User::query();
    }

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id'),
            TextColumn::make('name')->searchable(isIndividual: true),
            TextColumn::make('email')->searchable(isIndividual: true),
            TextColumn::make('role'),
        ];
    }

    public function render()
    {
        return view('livewire.user-resource');
    }

    public function getTableHeaderActions(): array
    {
        return [
          Action::make('Ajouter')
            ->button()
            ->action(function($data){
                $u = new User($data);
                $u->password = Hash::make($data['password']);
                $u->save();
                Filament::notify('success', "Utilisateur crée");
            })
            ->form([
                Grid::make(2)->schema([
                    TextInput::make('name')->label("Nom"),
                    TextInput::make('email')->label("Email"),
                    TextInput::make('password')->label("Mot de passe")->password(),
                ])
            ])
        ];
    }
}

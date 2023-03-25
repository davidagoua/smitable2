<?php

namespace App\Http\Livewire\Pharmacie;

use App\Models\Medicament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelReader;

class Stock extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('livewire.pharmacie.stock');
    }

    public function getTableQuery()
    {
        return Medicament::query();
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('numero')->searchable(),
            TextColumn::make('nom')->searchable(),
            TextColumn::make('prix')->suffix('FCFA'),
            TextColumn::make('en_stock')
                ->label('En stock')
                ->getStateUsing(fn ($record) => $record->stock_restant),
        ];
    }

    public function getTableHeaderActions()
    {
        return [
            CreateAction::make('Ajouter')
                ->form([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('numero')
                            ->rules('required'),
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom')
                            ->rules('required'),
                        Forms\Components\TextInput::make('prix')
                            ->label('Prix')
                            ->suffix('FCFA')
                            ->numeric()
                            ->rules('required'),
                        Forms\Components\TextInput::make('stock')
                            ->label("Nombre en stock")
                            ->numeric()
                            ->rules('required'),
                        Forms\Components\Textarea::make('description')->columnSpan(2),
                        Select::make('type_medicament_id')
                            ->label('type de medicament')->options(['Anti-Retroviraux','Autres']),
                        Forms\Components\DateTimePicker::make('expired_at')
                            ->label("Date d'expiration")
                            ->rules('required'),
                    ]),
                ]),
            Action::make('Importer')->button()
                ->action(function($data){
                    $rows = SimpleExcelReader::create(storage_path('app/public/'.$data['fichier']))->getRows();

                    $rows->each(function(array $row) {
                        DB::table('medicaments')->insert([
                            'nom'=> $row['Désignation'],
                            'numero'=>$row['CodeProduit'],
                            'stock'=> $row['Total'],
                            'categorie'=> $row['Categorie'],
                            'unite'=> $row['Unité'],
                        ]);
                    });
                })
                ->form([
                    FileUpload::make('fichier')
                ])
        ];
    }

    public function getTableActions()
    {
        return [
            EditAction::make('modifier')->button()
                ->form([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('numero')
                            ->rules('required'),
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom')
                            ->rules('required'),
                        Forms\Components\TextInput::make('prix')
                            ->label('Prix')
                            ->suffix('FCFA')
                            ->numeric()
                            ->rules('required'),
                        Forms\Components\TextInput::make('stock')
                            ->label("Nombre en stock")
                            ->numeric()
                            ->rules('required'),
                        Forms\Components\Textarea::make('description')->columnSpan(2),
                        Select::make('type_medicament_id')
                            ->label('type de medicament')->options(['Anti-Retroviraux','Autres']),
                        Forms\Components\DateTimePicker::make('expired_at')
                            ->label("Date d'expiration")
                            ->rules('required'),
                    ]),
                ]),
            DeleteAction::make('supprimer')->button()
        ];
    }

    public function getTableBulkActions()
    {
        return [
            DeleteBulkAction::make('supprimer')
        ];
    }
}

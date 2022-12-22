<?php

namespace App\Http\Livewire\Analyse;

use App\Models\Analyse;
use App\Models\AnalyseAppointement;
use App\Models\Laboratoire;
use Faker\Provider\Text;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelReader;

class CatalogueAnalyse extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('livewire.analyse.catalogue-analyse');
    }

    public function getTableQuery()
    {
        return Analyse::query()->with('laboratoire');
    }

    public function getTableHeaderActions()
    {
        return [
            Action::make('Importer')->button()
                ->action(function($data){

                    $rows = SimpleExcelReader::create(storage_path('analyses.xlsx'))->getRows();
                    $rows->each(function(array $rowProperties) {
                        // todo: load analyse from rowProperties
                        dd($rowProperties);
                    });
                }),
            Action::make('ajouter')->button()
                ->action(function($data){
                    Analyse::create($data);
                    Filament::notify('success', "Analyse créee");
                })
                ->form([
                    Grid::make(2)
                        ->schema([
                            Select::make('laboratoire_id')->label('Laboratoire')
                                ->options(Laboratoire::all(['id','nom'])->pluck('nom','id')),
                            TextInput::make('nom')->label("Nom de l'analyse"),
                            Select::make('type_analyse_id')->options(['Type1','Type2'])->label("Type d'analyse"),
                            TextInput::make('prix')->label("Coût de l'analyse")->suffix('FCFA')
                        ])
                ])
        ];
    }

    public function getTableColumns()
    {
        return [
          TextColumn::make('nom') ,
            TextColumn::make('laboratoire.nom'),
            TextColumn::make('prix')->suffix(' FCFA')
        ];
    }

    public function getTableActions()
    {
        return [
            EditAction::make('modifier')->button()
                ->form([
                    Select::make('laboratoire_id')->label('Laboratoire')
                        ->options(Laboratoire::all(['id','nom'])->pluck('nom','id')),
                    TextInput::make('nom')->label("Nom de l'analyse"),
                    Select::make('type_analyse_id')->options(['Type1','Type2'])->label("Type d'analyse"),
                    TextInput::make('prix')->label("Coût de l'analyse")->suffix('FCFA')
                ]),
            DeleteAction::make('supprimer')->button()
        ];
    }
}

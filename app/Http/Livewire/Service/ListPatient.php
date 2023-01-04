<?php

namespace App\Http\Livewire\Service;

use App\Events\PatientConsulted;

use App\Models\Appointement;
use App\Models\Consultation;
use App\Models\Medicament;
use Filament\Facades\Filament;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class ListPatient extends Component implements HasTable
{
    use InteractsWithTable;

    public $service;
    public bool $hospitalisation = false;

    public function mount()
    {
        $this->services = [


        ];

    }

    public function getTableQuery(): Builder
    {
        return Appointement::query()
            ->with(['patient', 'consultations'])
            ->where('service_id', $this->service->id);
    }

    public function render()
    {
        return view('livewire.service.list-patient');
    }

    public function getTableColumns()
    {
        return [
            TextColumn::make('patient.code_patient')->label('Code Patient'),
            TextColumn::make('patient.nom')->label('nom'),
            TextColumn::make('patient.prenoms')->label('prenoms'),
            TextColumn::make('age')->label('Age')->suffix(' ans'),
        ];
    }

    public function getTableActions()
    {
        return [
            Action::make('view')->label("Constantes")->button()->color('secondary')
                ->action(function ($record, $data) {
                    $consultation = Consultation::updateOrCreate(['id' => $data['consultation_id']], [...$data, 'appointement_id' => $record->id]);
                    event(new PatientConsulted($record));
                    Filament::notify('success', "Patient Consulté");
                })
                ->steps(function ($record) {
                    $consultation = $record->consultation();
                    return [
                        Wizard\Step::make('Résumé')
                            ->schema([
                                Card::make([
                                    Placeholder::make('')->content(function () use ($consultation, $record) {
                                        return view('filament.services.recap', [
                                            'consultation' => $consultation,
                                            'age' => $record->age,
                                            'imc' => $consultation->imc,
                                        ]);
                                    })
                                ])
                            ]),
                        Wizard\Step::make('Modifier')
                            ->schema([
                                Hidden::make('consultation_id')->default($consultation->id ?? null),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('temperature')->numeric()
                                            ->label('Température')
                                            ->suffix('°C')
                                            ->default($consultation->temperature),
                                        TextInput::make('tension')->numeric()
                                            ->suffix('cmHg')
                                            ->default($consultation->tension),
                                        TextInput::make('poids')
                                            ->suffix('kg')
                                            ->numeric()->default($consultation->poids),
                                        TextInput::make('taille')->numeric()
                                            ->suffix('cm')
                                            ->default($consultation->taille),
                                        TextInput::make('pouls')->numeric()
                                            ->suffix('Battement / secondes')
                                            ->default($consultation->pouls),
                                    ]),
                                CheckboxList::make('data')->label("Signes Fonctionnel")
                                    ->default($consultation->data)
                                    ->options(["Diarhée", "Constipation", "Vomissement",
                                        "Douleur abdominale", "Emission de glaire", "Douleur thoracique", "Toux grâce"])->columns(['default' => 2]),
                            ]),
                    ];
                }),

            Action::make('Consulter')->button()
                ->action(function ($record, $data) {

                    if (count($data['analyses']) == 0 && !$data['hospitalisation']) {
                        $record->outed = now();
                    } else {
                        foreach ($data['analyses'] as $analyse) {
                            DB::table('analyse_appointements')->insert([
                                'analyse_id' => $analyse['id'],
                                'appointement_id' => $record->id
                            ]);
                        }
                    }

                    if (count($data['ordonances']) >= 1) {
                        $ordonance_id = DB::table('ordonances')->insertGetId(['appointement_id' => $record->id]);
                        foreach ($data['ordonances'] as $medicament) {
                            DB::table('ligne_ordonances')->insert([
                                'ordonance_id' => $ordonance_id,
                                'medicament_id' => $medicament['id'],
                                'frequence' => $medicament['frequence']
                            ]);
                        }
                    }

                    if ($data['chambre_lit_id'] != null) {
                        DB::table('hospitalisations')->insert([
                            'chambre_lit_id' => $data['chambre_lit_id'],
                            'appointement_id' => $record->id,
                            'date_debut' => $data['date_debut'],
                            'date_fin' => $data['date_fin'],
                            'state' => 0
                        ]);
                    }
                    Filament::notify('sucess', "Traitement enregistrer");
                })
                ->form(function ($record) {
                    return [
                        RichEditor::make('description')->default(''),
                        Repeater::make('ordonances')->label('Ordonance')
                            ->schema([
                                Select::make('id')
                                    ->label("Medicament")
                                    ->options(Medicament::all()->pluck('nom', 'id')),
                                TextInput::make('frequence')
                            ])->columns(['default' => 2]),
                        Repeater::make('analyses')->label('Analyse')
                            ->schema([
                                Select::make('id')
                                    ->options(DB::table('analyses')->select('id', 'nom')->get()->pluck('nom', 'id'))
                                    ->label('Analyse'),
                            ])->columns(['default' => 2]),
                        Grid::make(4)
                            ->schema([
                                Select::make('chambre_lit_id')
                                    ->columnSpan(2)
                                    ->label('Chambre')
                                    ->options(DB::table('chambre_lits')->select('id', 'nom')->get()->pluck('nom', 'id')),
                                DatePicker::make('date_debut')
                                    ->label("Date d'entrée")
                                    ->default(now()),
                                DatePicker::make('date_fin')
                                    ->label('Date de sortie')
                            ])
                    ];
                }),

            ActionGroup::make([
                Action::make('Urgence')
                    ->label('Urgence')
                    ->action(function ($record, $data) {

                    })
                    ->requiresConfirmation(),
                DeleteAction::make('supprimer'),
            ])
        ];
    }

}

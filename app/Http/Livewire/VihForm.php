<?php

namespace App\Http\Livewire;

use App\Models\Appointement;
use App\Models\Patient;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Livewire\Component;

class VihForm extends Component implements HasForms
{

    use InteractsWithForms;

    public Appointement $appointement;
    public Patient $patient;

    public bool $handicap = false;
    public bool $arv = false;
    public bool $ptme = false;
    public bool $contraception = false;
    public bool $tuberculose = false;
    public bool $contrimoxazole = false;
    public bool $traitement_contrimoxazole = false;
    public bool $transfusion = false;
    public $profession = "";
    public $situation_matrimoniale = "";

    public bool $enfant = false;

    public function render()
    {
        return view('livewire.vih-form');
    }

    public function mount()
    {
        $this->consultation = Appointement::find((int) request()->query('consultation'));

    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(['default'=>2])->schema([
                Section::make("Données socio-demographique patient: ". $this->patient->fullName)->schema([
                    Grid::make(['default'=>2])->schema([
                        Fieldset::make("")->schema([
                            TextInput::make('patient.nom')->label('Nom')->default($this->patient->nom),
                            TextInput::make('patient.prenoms')->label('Prénoms')->default('patient.prenoms'),
                            Radio::make('patient.sexe')->label('Sexe')->options([
                                'Homme' => 'Masculin',
                                'Femme' => 'Féminin',
                            ])->default($this->patient->sexe),
                            DatePicker::make('patient.date_naissance')->label('Date de naissance'),
                            TextInput::make('patient.lieu_naissance')->label('Lieu de naissance'),
                            Select::make('patient.nationalite')->options([
                                'IVOIRIENNE','AUTRE',
                            ]),
                            Radio::make('patient.religion')->label('Religion')->options([
                                'CHRISTIANISME','HINDOUISME','ISLAM','BUDDHISTE','AUTRE',
                            ])->columnSpan(2)->columns(2),

                            Select::make('profession')->options([
                                'ETUDIANT','EMPLOYE','AUTRE',
                            ]),
                            Radio::make('profession_state')->label('')->options([
                                'En activité','Au chômage','A la retraite',
                            ])->inline(),
                            Toggle::make('handicap')->label('Population hautement vulnerable')->reactive(),
                            Radio::make('handicap_type')->label('Type de population')->options([
                                'Population carcerale','Professionel du sexe','HSH','UDI','Autres'
                            ])->visible($this->handicap)->columns(2)->columnSpan(2),
                        ])->columnSpan(1),

                        Fieldset::make("")->columnSpan(1)->schema([
                            Radio::make("niveau_instruction")->label("Niveau d'instruction")->options([
                                'Primaire','Secondaire','Universitaire','Non scolarisé',
                            ])->inline(),

                            Radio::make("situation_matrimoniale")->label("Situation matrimonial")->options([
                                'Célibataire','Marie','Divorcé','Veuf(ve)','Concubinage','Autres',
                            ])->inline(),

                            Toggle::make('patner_advertised')->label("Conjoint(e)/Partenaire informé"),
                            Toggle::make('patner_infected')->label("Conjoint(e)/Partenaire infecté"),

                            TextInput::make('ville')->label("Ville / Sous-prefecture"),
                            TextInput::make('commune')->label("Commune / village"),
                            TextInput::make('quartier')->label('Quartier'),
                            TextInput::make('tel')->tel()->label('Téléphone'),
                            TextInput::make('cel')->tel()->label('Celulaire'),

                            Toggle::make('enfant')
                                ->columnSpan(2)->inline()->label("Enfant née d'une mère seropositive")
                                ->reactive()
                        ])
                    ]),
                ]),

                Section::make("enfant")->schema([
                    Grid::make(2)->schema([
                        Fieldset::make("")->schema([
                            Radio::make('mode_accouchement')->inline()->options(['Voie basse','Césarienne'])->columnSpan(2),
                            TextInput::make('poids')->label("Poids de naissance")->suffix('g')->numeric(),
                            TextInput::make('taille')->label("Taille de naissance")->suffix('cm')->numeric(),
                            TextInput::make('perimetre')->label("Périmètre crânien ")->suffix('cm')->numeric(),
                            TextInput::make('apgar'),
                            Toggle::make('ptme')->label("La mère est-elle bénéficiare d'une PTME pendant la naissance"),
                            TextInput::make('regime_ptme')->visible($this->ptme)
                        ])->columnSpan(1),
                        Fieldset::make("")->columnSpan(1)->schema([
                            Toggle::make('arv')->label("L'enfant a-t-il reçu une prophalyxe ARV à la naissance ?"),
                            TextInput::make('regime_arv')->visible($this->arv),
                            Toggle::make('cotrimoxazole')->label("Cotrimoxazole")
                        ])

                    ])
                ])->visible($this->enfant),

                Section::make("Test Sida")->schema([
                    Radio::make('test_sida')->label('Test Sida')->options([
                        'VIH-1','VIH-2','VIH 1+2',
                    ])->inline(),

                    DatePicker::make('test_sida_date')->label('Date du test'),
                    TextInput::make('test_sida_lieu')->label('Lieu du test'),

                    Radio::make('test_sida_result')->label('Résultat')->options([
                        'Négatif','Positif','Non testé',
                    ])->inline(),
                    DatePicker::make('test_sida_date')->label('Date du annonce'),
                ])->columnSpan(1)->hidden($this->enfant),

                Section::make('Personne soutient (à contacter)')->columnSpan(1)->schema([
                    TextInput::make('nom')->label('Nom'),
                    TextInput::make('prenom')->label('Prénom'),
                    TextInput::make('adresse')->label('Adresse'),
                    TextInput::make('tel')->tel()->label('Téléphone'),

                ])->hidden($this->enfant),

                Section::make("Point d'entrée pour les soins")->columnSpan(1)->schema([
                    CheckboxList::make('point_entree')->label('Point d\'entrée pour les soins')->options([
                        "CDV","PTME","CAT ou CDT","Medecine","Pédiatrie","IST","Hospitalisation",
                        "Auto-reference","OBC","Toxicologie","AES","Autres"
                    ])->columns(['default'=>2]),
                    Toggle::make("resume")->label("Referé avec résumé"),
                    DatePicker::make("date_reference")->label("Date de référence"),
                    TextInput::make("lieu_reference")->label("Centre de référence"),
                ]),

                Section::make("Antecedent ARv et/ou PTME")->columnSpan(1)->schema([
                    Toggle::make("arv")->label("ARV")->reactive(),
                    DatePicker::make('date_demarage')->visible($this->arv),
                    TextInput::make('regime_arv'),
                    TextInput::make('nb_enfants')->label("Nombre d'enfants vivants")->numeric(),
                    Radio::make('ptme')->label("A bénéficié d'une PTME ?")->options([
                        "Oui","Non","ne sais pas","Non applicable"
                    ]),
                    TextInput::make('regime_ptme')->label("regime")
                ]),

                Section::make("Autres antecedents")->schema([
                    Grid::make(2)->schema([
                        Fieldset::make("")->columnSpan(1)->schema([
                            Toggle::make('contraception')->label("Contraception")->reactive(),
                            CheckboxList::make('type_contraception')->options([
                                "Contraceptifs oraux","Contraceptifs injectables","Implants","Stérilets",
                                "Préservatif masculin","Préservatif féminin"
                            ])->visible($this->contraception),
                            Toggle::make('contrimoxazole')->reactive(),
                            DatePicker::make('date_cotrimoxazole')->visible($this->contrimoxazole),
                            Toggle::make('traitement_contrimoxazole')->reactive(),
                            DatePicker::make('date_traitement_cotrimoxazole')->visible($this->traitement_contrimoxazole),
                        ]),
                        Fieldset::make("")->columnSpan(1)->schema([
                            Toggle::make('tuberculose')->reactive(),
                            DatePicker::make('date_tuberculose')->visible($this->tuberculose),
                            Toggle::make('zona'),
                            Toggle::make("transfusion")->label("Transfusion sanguine")->reactive(),
                            Grid::make(2)->schema([
                                TextInput::make('nbr_transfusion')->label("Nombre de transfusion"),
                                DatePicker::make('date_last_transfusion')->label("Date dernière transfusion")
                            ])->visible($this->transfusion),
                            Radio::make('autres_maladies_chronique')->options(['Diabète','HTA']),
                            TextInput::make('autres_maladies'),
                        ]),
                    ])
                ])->hidden($this->enfant),

                Section::make("Adulte & Enfants")->schema([
                    Fieldset::make("Traitement antiretroviral")->schema([
                        DatePicker::make('date'),
                        Toggle::make('eligible_stable_cdc'),
                        Radio::make('motif')->options([
                            "Clinique","CD4","Autre"
                        ]),
                        Toggle::make("eligible")->label("Eligible et prets pour le traitement ARV"),
                        DatePicker::make("Transfert de"),
                        Repeater::make("traitement")->schema([
                            DatePicker::make("debut_traitement"),
                            TextInput::make('regime'),
                            TextInput::make('poids')->suffix('kg'),
                            TextInput::make('score_karnosfky')->numeric(),
                            Radio::make('validite')->options([
                                'Valide', 'Ambulatoire', 'Alité'
                            ]),
                            Fieldset::make("1er substitution")->schema([
                                TextInput::make('regime'),
                                TextInput::make('motif')
                            ]),
                            Fieldset::make("2eme substitution")->schema([
                                TextInput::make('regime'),
                                TextInput::make('motif')
                            ])
                        ])
                    ])
                ]),

                Section::make('bilan')->schema([
                    TableRepeater::make('items')
                        ->schema([
                            TextInput::make('Bilan initial'),
                            TextInput::make('J 0'),
                            TextInput::make('M 1'),
                            TextInput::make('M 6'),
                            TextInput::make('M 12'),
                        ])
                        ->collapsible()
                        ->defaultItems(3),
                ]),

            ])
        ];
    }
}

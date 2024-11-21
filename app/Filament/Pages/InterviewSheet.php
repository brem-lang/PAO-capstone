<?php

namespace App\Filament\Pages;

use Faker\Provider\ar_EG\Text;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class InterviewSheet extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.interview-sheet';

    protected static ?string $title = '';

    protected static ?string $navigationLabel = 'InterView Sheet';

    public ?array $adviceData = [];

    public ?array $notarizeData = [];

    public ?array $dummyAdviceData = [];

    public static function canAccess(): bool
    {
        return auth()->user()->isClient();
    }

    protected function getForms(): array
    {
        return [
            'adviceForm',
            'notarizeForm',
            'previewAdviceForm',
        ];
    }

    public function adviceForm(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('INTERVIEW SHEET (Para sa Serbisyong-Legal at/o Representasyon)')
                        ->schema([
                            Select::make('region')
                                ->label('Rehiyon')
                                ->options([
                                    'Region I' => 'Region I',
                                    'Region II' => 'Region II',
                                    'Region III' => 'Region III',
                                    'Region IV-A' => 'Region IV-A',
                                    'MIMAROPA' => 'MIMAROPA',
                                    'Region V' => 'Region V',
                                    'Region VI' => 'Region VI',
                                    'Region VII' => 'Region VII',
                                    'Region VIII' => 'Region VIII',
                                    'Region IX' => 'Region IX',
                                    'Region X' => 'Region X',
                                    'Region XI' => 'Region XI',
                                    'Region XII' => 'Region XII',
                                    'Region XIII' => 'Region XIII',
                                    'NCR' => 'NCR',
                                    'CAR' => 'CAR',
                                    'BRMM' => 'BRMM',
                                ])
                                ->placeholder('Pumili ng Rehiyon')
                                ->required(),
                            TextInput::make('referredBy')
                                ->label('Ini-refer ni/Inindorso ng')
                                ->required(),
                            TextInput::make('district_office')
                                ->label('District Office')
                                ->required(),
                            Fieldset::make('Ginawang Aksyon')
                                ->schema([
                                    Checkbox::make('merit')
                                        ->label('Higit pang pag-aaralan (merit at indency test)')
                                        ->columnSpanFull(),
                                    Checkbox::make('rep')
                                        ->label('Para sa representasyon at iba pang tulong-legal')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                            DatePicker::make('petsa')
                                ->required(),
                            TextInput::make('assignTo')
                                ->label('Ini-atas kay')
                                ->required(),
                            TextInput::make('cnl')
                                ->label('Control No.')
                                ->disabled()
                                ->numeric(),
                            Fieldset::make('')
                                ->schema([
                                    Checkbox::make('iservicel-check')
                                        ->live()
                                        ->label('Ibinigay na serbisyong-legal')
                                        ->columnSpanFull(),
                                    TextInput::make('iservicel')
                                        ->disabled(function (Get $get) {
                                            return ! $get('iservicel-check');
                                        })
                                        ->label('')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                            TextInput::make('mananayam')
                                ->label('Mananayam')
                                ->required(),
                            Fieldset::make('')
                                ->schema([
                                    Checkbox::make('iothers-check')
                                        ->live()
                                        ->label('Iba pa')
                                        ->columnSpanFull(),
                                    TextInput::make('iothers')
                                        ->disabled(function (Get $get) {
                                            return ! $get('iothers-check');
                                        })
                                        ->label('')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                        ])
                        ->columns(2),
                    Wizard\Step::make('I. URI NG HINIHINGI NG TULONG (Para sa kawani ng PAO)')
                        ->schema([
                            Fieldset::make('Pumili ng kahit isa*')
                                ->schema([
                                    Checkbox::make('legalDoc')
                                        ->label('Legal Documentation'),
                                    Checkbox::make('ao')
                                        ->label('Administration of Oath'),
                                    Checkbox::make('courtRep')
                                        ->label('Representasyon sa Korte o ibang Tanggapin'),
                                    Checkbox::make('legalAs')
                                        ->label('Inquest Legal Assistance'),
                                    Checkbox::make('medcon')
                                        ->label('Mediation/Concilliation'),
                                    Fieldset::make('')
                                        ->schema([
                                            Checkbox::make('iothers2-check')
                                                ->live()
                                                ->label('Iba pa')
                                                ->columnSpanFull(),
                                            TextInput::make('iothers2')
                                                ->disabled(function (Get $get) {
                                                    return ! $get('iothers2-check');
                                                })
                                                ->label('')
                                                ->columnSpanFull(),
                                        ])
                                        ->columnSpan(1),
                                ])
                                ->columns(3)
                                ->columnSpanFull(1),
                        ]),
                    Wizard\Step::make('II. IMPORMASYON UKOL SA APLIKANTE (Para sa aplikante/representative. Gumamit ng panibago kung higit sa isa ang aplikante /kliyente)')
                        ->schema([
                            TextInput::make('name2')
                                ->label('Pangalan')
                                ->required(),
                            Fieldset::make('')
                                ->schema([
                                    TextInput::make('age')
                                        ->required()
                                        ->label('Edad'),
                                    Select::make('sex')
                                        ->label('Sex')
                                        ->options([
                                            'Male' => 'Male',
                                            'Female' => 'Female',
                                        ])
                                        ->required(),
                                    Select::make('civilStatus')
                                        ->label('Civil Status')
                                        ->options([
                                            'Single' => 'Single',
                                            'Married' => 'Married',
                                            'Widowed' => 'Widowed',
                                            'Divorced' => 'Divorced',
                                            'Separated' => 'Separated',
                                        ])
                                        ->required(),
                                ])
                                ->columns(3)
                                ->columnSpan(1),
                            Select::make('religion')
                                ->label('Relihiyon')
                                ->required()
                                ->options([
                                    'rc' => 'Roman Catholic',
                                    'islam' => 'Islam',
                                    'iglesia' => 'Iglesia ni Cristo',
                                    'sda' => 'Seventh Day Adventist',
                                    'bible_bap' => 'Bible Baptist Church',
                                    'jehovah' => "Jehovah's Witness",
                                    'others' => 'Others',
                                ]),
                            Select::make('degree')
                                ->label('Naabot na Pag-aaral')  // Set the label
                                ->options([
                                    'elementary' => 'Elementary',
                                    'high_school' => 'High School',
                                    'senior_high_school' => 'Senior High School',
                                    'collage_level' => 'College Level',
                                    'collage' => 'College Graduate',
                                ])
                                ->placeholder('Select Degree')  // Set placeholder text
                                ->required(),
                            Select::make('citizenship')
                                ->label('Pagkamamamayan')
                                // ->searchable()
                                ->options([
                                    'afghan' => 'Afghan',
                                    'albanian' => 'Albanian',
                                    'algerian' => 'Algerian',
                                    'andorran' => 'Andorran',
                                    'angolan' => 'Angolan',
                                    'argentinian' => 'Argentinian',
                                    'armenian' => 'Armenian',
                                    'australian' => 'Australian',
                                    'austrian' => 'Austrian',
                                    'azerbaijani' => 'Azerbaijani',
                                    'bahamian' => 'Bahamian',
                                    'bahraini' => 'Bahraini',
                                    'bangladeshi' => 'Bangladeshi',
                                    'barbadian' => 'Barbadian',
                                    'belarusian' => 'Belarusian',
                                    'belgian' => 'Belgian',
                                    'belizean' => 'Belizean',
                                    'beninese' => 'Beninese',
                                    'bhutanese' => 'Bhutanese',
                                    'bolivian' => 'Bolivian',
                                    'bosnian' => 'Bosnian',
                                    'brazilian' => 'Brazilian',
                                    'british' => 'British',
                                    'bulgarian' => 'Bulgarian',
                                    'burkinabe' => 'Burkinabe',
                                    'burmese' => 'Burmese',
                                    'burundian' => 'Burundian',
                                    'cambodian' => 'Cambodian',
                                    'cameroonian' => 'Cameroonian',
                                    'canadian' => 'Canadian',
                                    'cape_verdean' => 'Cape Verdean',
                                    'central_african' => 'Central African',
                                    'chadian' => 'Chadian',
                                    'chilean' => 'Chilean',
                                    'chinese' => 'Chinese',
                                    'colombian' => 'Colombian',
                                    'comorian' => 'Comorian',
                                    'congolese' => 'Congolese',
                                    'costa_rican' => 'Costa Rican',
                                    'ivorian' => 'Ivorian',
                                    'croatian' => 'Croatian',
                                    'cuban' => 'Cuban',
                                    'cypriot' => 'Cypriot',
                                    'czech' => 'Czech',
                                    'danish' => 'Danish',
                                    'djiboutian' => 'Djiboutian',
                                    'dominican' => 'Dominican',
                                    'ecuadorian' => 'Ecuadorian',
                                    'egyptian' => 'Egyptian',
                                    'emirati' => 'Emirati',
                                    'equatorial_guinean' => 'Equatorial Guinean',
                                    'eritrean' => 'Eritrean',
                                    'estonian' => 'Estonian',
                                    'ethiopian' => 'Ethiopian',
                                    'fijian' => 'Fijian',
                                    'finnish' => 'Finnish',
                                    'french' => 'French',
                                    'gabonese' => 'Gabonese',
                                    'gambian' => 'Gambian',
                                    'georgian' => 'Georgian',
                                    'german' => 'German',
                                    'ghanaian' => 'Ghanaian',
                                    'greek' => 'Greek',
                                    'grenadian' => 'Grenadian',
                                    'guatemalan' => 'Guatemalan',
                                    'guinean' => 'Guinean',
                                    'guinea_bissauan' => 'Guinea-Bissauan',
                                    'guyanese' => 'Guyanese',
                                    'haitian' => 'Haitian',
                                    'honduran' => 'Honduran',
                                    'hungarian' => 'Hungarian',
                                    'icelandic' => 'Icelandic',
                                    'indian' => 'Indian',
                                    'indonesian' => 'Indonesian',
                                    'iranian' => 'Iranian',
                                    'iraqi' => 'Iraqi',
                                    'irish' => 'Irish',
                                    'israeli' => 'Israeli',
                                    'italian' => 'Italian',
                                    'jamaican' => 'Jamaican',
                                    'japanese' => 'Japanese',
                                    'jordanian' => 'Jordanian',
                                    'kazakh' => 'Kazakh',
                                    'kenyan' => 'Kenyan',
                                    'kuwaiti' => 'Kuwaiti',
                                    'kyrgyz' => 'Kyrgyz',
                                    'laotian' => 'Laotian',
                                    'latvian' => 'Latvian',
                                    'lebanese' => 'Lebanese',
                                    'liberian' => 'Liberian',
                                    'libyan' => 'Libyan',
                                    'liechtensteiner' => 'Liechtensteiner',
                                    'lithuanian' => 'Lithuanian',
                                    'luxembourgish' => 'Luxembourgish',
                                    'malagasy' => 'Malagasy',
                                    'malawian' => 'Malawian',
                                    'malaysian' => 'Malaysian',
                                    'maldivian' => 'Maldivian',
                                    'malian' => 'Malian',
                                    'maltese' => 'Maltese',
                                    'marshallese' => 'Marshallese',
                                    'mauritanian' => 'Mauritanian',
                                    'mauritian' => 'Mauritian',
                                    'mexican' => 'Mexican',
                                    'micronesian' => 'Micronesian',
                                    'moldovan' => 'Moldovan',
                                    'monegasque' => 'Monegasque',
                                    'mongolian' => 'Mongolian',
                                    'montenegrin' => 'Montenegrin',
                                    'moroccan' => 'Moroccan',
                                    'mozambican' => 'Mozambican',
                                    'myanmarese' => 'Myanmarese',
                                    'namibian' => 'Namibian',
                                    'nauruan' => 'Nauruan',
                                    'nepalese' => 'Nepalese',
                                    'dutch' => 'Dutch',
                                    'new_zealand' => 'New Zealand',
                                    'nicaraguan' => 'Nicaraguan',
                                    'nigerian' => 'Nigerian',
                                    'nigerien' => 'Nigerien',
                                    'north_korean' => 'North Korean',
                                    'macedonian' => 'Macedonian',
                                    'norwegian' => 'Norwegian',
                                    'omani' => 'Omani',
                                    'pakistani' => 'Pakistani',
                                    'palauan' => 'Palauan',
                                    'panamanian' => 'Panamanian',
                                    'papuan_new_guinean' => 'Papuan New Guinean',
                                    'paraguayan' => 'Paraguayan',
                                    'peruvian' => 'Peruvian',
                                    'philippine' => 'Philippine',
                                    'polish' => 'Polish',
                                    'portuguese' => 'Portuguese',
                                    'qatari' => 'Qatari',
                                    'romanian' => 'Romanian',
                                    'russian' => 'Russian',
                                    'rwandan' => 'Rwandan',
                                    'saint_lucian' => 'Saint Lucian',
                                    'saint_vincent_and_the_grenadines_citizen' => 'Saint Vincent and the Grenadines citizen',
                                    'samoan' => 'Samoan',
                                    'sanmarinoan' => 'Sanmarinoan',
                                    'sao_tomean' => 'São Toméan',
                                    'senegalese' => 'Senegalese',
                                    'serbian' => 'Serbian',
                                    'seychellois' => 'Seychellois',
                                    'sierra_leonean' => 'Sierra Leonean',
                                    'singaporean' => 'Singaporean',
                                    'slovak' => 'Slovak',
                                    'slovenian' => 'Slovenian',
                                    'solomon_islands' => 'Solomon Islands',
                                    'somali' => 'Somali',
                                    'south_african' => 'South African',
                                    'south_korean' => 'South Korean',
                                    'south_sudanese' => 'South Sudanese',
                                    'spanish' => 'Spanish',
                                    'sri_lankan' => 'Sri Lankan',
                                    'sudanese' => 'Sudanese',
                                    'swazi' => 'Swazi',
                                    'swedish' => 'Swedish',
                                    'swiss' => 'Swiss',
                                    'syrian' => 'Syrian',
                                    'tajik' => 'Tajik',
                                    'tanzanian' => 'Tanzanian',
                                    'thai' => 'Thai',
                                    'timorese' => 'Timorese',
                                    'togolese' => 'Togolese',
                                    'tongan' => 'Tongan',
                                    'trinidadian_and_tobagonian' => 'Trinidadian and Tobagonian',
                                    'tunisian' => 'Tunisian',
                                    'turkish' => 'Turkish',
                                    'turkmen' => 'Turkmen',
                                    'tuvaluan' => 'Tuvaluan',
                                    'ugandan' => 'Ugandan',
                                    'ukrainian' => 'Ukrainian',
                                    'uruguayan' => 'Uruguayan',
                                    'uzbek' => 'Uzbek',
                                    'venezuelan' => 'Venezuelan',
                                    'vietnamese' => 'Vietnamese',
                                    'yemeni' => 'Yemeni',
                                    'zambian' => 'Zambian',
                                    'zimbabwean' => 'Zimbabwean',
                                ])
                                ->required(),
                            Select::make('language')
                                ->label('Dialekto')
                                ->options([
                                    'Bisaya' => 'Bisaya',
                                    'Tagalog' => 'Tagalog',
                                    'English' => 'English',
                                    'Ilocano' => 'Ilocano',
                                    'Hiligaynon' => 'Hiligaynon',
                                    'Bikol' => 'Bikol',
                                    'Waray' => 'Waray',
                                    'Kapampangan' => 'Kapampangan',
                                    'Pangasinan' => 'Pangasinan',
                                    'Chavacano' => 'Chavacano',
                                    'Maranao' => 'Maranao',
                                    'Tausug' => 'Tausug',
                                    'Maguindanao' => 'Maguindanao',
                                    'Ivatan' => 'Ivatan',
                                    'Kinaray-a' => 'Kinaray-a',
                                    'Yakan' => 'Yakan',
                                    'Sambal' => 'Sambal',
                                    'Others' => 'Others',
                                ])
                                ->required(),
                            FieldSet::make('')
                                ->schema([
                                    Select::make('regions')->required()
                                        ->preload()
                                        ->required()
                                        ->options(function () {
                                            return DB::table('regions')->pluck('name', 'region_id');
                                        })
                                        ->live(),
                                    Select::make('province')->required()
                                        ->preload()
                                        ->required()
                                        ->options(function () {
                                            return DB::table('provinces')->pluck('name', 'code');
                                        }),
                                    Select::make('city')->required()
                                        ->preload()
                                        ->required()
                                        ->options(function () {
                                            return DB::table('cities')->pluck('name', 'code');
                                        }),
                                    // Select::make('barangay')
                                    //     ->preload()
                                    //     ->required()
                                    //     ->options(function () {
                                    //         return DB::table('barangays')->pluck('name', 'code');
                                    //     }),
                                ])
                                ->columns(2)
                                ->columnSpan(1),
                            TextInput::make('contact_number')
                                ->numeric()
                                ->label('Contact Number')
                                ->required(),
                            TextInput::make('email')
                                ->required(),
                            TextInput::make('asawa')
                                ->label('Asawa')
                                ->required(),
                            TextInput::make('income')
                                ->label('Individual Monthly Income')
                                ->required(),
                            TextInput::make('asawaAddress')
                                ->label('Tirahan ng asawa')
                                ->required(),
                            Radio::make('nakakulong')
                                ->required()
                                ->live()
                                ->options([
                                    'true' => 'Oo',
                                    'false' => 'Hindi',
                                ])
                                ->default('false')
                                ->label('Nakakulong')
                                ->inline(),
                            TextInput::make('contactNumberAsawa')
                                ->label('Contact Number ng asawa')
                                ->numeric()
                                ->required(),
                            DatePicker::make('dateofKulong')
                                ->disabled(function (Get $get) {
                                    return $get('nakakulong') === 'false';
                                })
                                ->required(),
                            Select::make('dPlace')
                                ->label('Lugar ng Detention')
                                ->options([
                                    'Dujali Police Station' => 'Dujali Police Station',
                                    'BJMP Panabo' => 'BJMP Panabo',
                                    'PNP, Sto. Tomas' => 'PNP, Sto. Tomas',
                                    'PNP, Carmen' => 'PNP, Carmen',
                                    'BJMP Peñaplata' => 'BJMP Peñaplata',
                                    'Igacos' => 'Igacos',
                                ])
                                ->required(),
                        ])->columns(2),
                    Wizard\Step::make('Select optional sections to fill up')
                        ->schema([
                            FieldSet::make('')
                                ->schema([
                                    Checkbox::make('card1')
                                        ->live()
                                        ->label('II-A. IMPORMASYON UKOL SA REPRESENTATIVE (Pupunan kung wala ang aplikante)'),
                                    Checkbox::make('card2')
                                        ->live()
                                        ->label('III. URI NG KASO'),
                                    Checkbox::make('card3')
                                        ->live()
                                        ->label('IV. SEKTOR NA KABILANG ANG APLIKANTE'),
                                ])->columns(3),
                            Fieldset::make('II-A. IMPORMASYON UKOL SA REPRESENTATIVE (Pupunan kung wala ang aplikante)')
                                ->schema([
                                    TextInput::make('representativeName')
                                        ->label('Pangalan'),
                                    FieldSet::make('')
                                        ->schema([
                                            TextInput::make('representativeAge')
                                                ->label('Edad')
                                                ->numeric(),
                                            Select::make('representativeSex')
                                                ->label('Sex')
                                                ->options([
                                                    'Male' => 'Male',
                                                    'Female' => 'Female',
                                                ]),
                                            Select::make('representativeCivilStatus')
                                                ->label('Civil Status')
                                                ->options([
                                                    'Single' => 'Single',
                                                    'Married' => 'Married',
                                                    'Widowed' => 'Widowed',
                                                    'Divorced' => 'Divorced',
                                                    'Separated' => 'Separated',
                                                ]),
                                        ])
                                        ->columnSpan(1)
                                        ->columns(3),
                                    TextInput::make('representativeTirahan')
                                        ->label('Tirahan'),
                                    TextInput::make('representativeContactNumber')
                                        ->label('Contact Number')
                                        ->numeric(),
                                    TextInput::make('representativeRelationship')
                                        ->label('Relasyon sa aplikante'),
                                    TextInput::make('representativeEmail')
                                        ->label('Email'),
                                ])
                                ->columns(2)
                                ->visible(function (Get $get) {
                                    return $get('card1');
                                }),
                            Fieldset::make('III. URI NG KASO')
                                ->schema([
                                    Radio::make('type_of_case')
                                        ->label('')
                                        ->options([
                                            'criminal' => 'Criminal',
                                            'civil' => 'Civil',
                                            'administrative' => 'Administrative',
                                            'appealed' => 'Appealed',
                                            'labor' => 'Labor',
                                        ])
                                        ->required()
                                        ->inline()
                                        ->columnSpanFull(),
                                ])->columns(3)
                                ->visible(function (Get $get) {
                                    return $get('card2');
                                }),
                            Fieldset::make('IV. SEKTOR NA KABILANG ANG APLIKANTE')
                                ->schema([
                                    Checkbox::make('child_in_conflict')
                                        ->label('Child in Conflict with the Law')
                                        ->columnSpan(2),
                                    Checkbox::make('senior_citizen')
                                        ->label('Senior Citizen')
                                        ->columnSpan(2),
                                    Checkbox::make('woman')
                                        ->label('Woman'),
                                    Checkbox::make('victim_of_VAWC')
                                        ->label('Biktima ng VAWC'),
                                    Checkbox::make('drug_refugee')
                                        ->columnSpan(2)
                                        ->label('Refugee/Evacuee'),
                                    Checkbox::make('law_enforcer')
                                        ->label('Law Enforcer'),
                                    Checkbox::make('drug_related_duty')
                                        ->label('Drug-related Duty'),
                                    Checkbox::make('tenant_of_agrarian_case')
                                        ->label('Tenant ng Agrarian Case')
                                        ->columnSpan(2),
                                    Checkbox::make('ofw_land_based')
                                        ->label('OFW - Land-based')
                                        ->columnSpan(2),
                                    Checkbox::make('arrested_for_terrorism')
                                        ->label('Arrested for Terrorism (R.A. No. 11479)')
                                        ->columnSpan(2),
                                    Checkbox::make('ofw_sea_based')
                                        ->label('OFW - Sea-based')
                                        ->columnSpan(2),
                                    Checkbox::make('victim_of_torture')
                                        ->label('Victim of Torture (R.A. No. 9745)')
                                        ->columnSpan(2),
                                    Checkbox::make('former_rebel')
                                        ->label('Former Rebel (FR) and Former Violent Extremist (FVE)')
                                        ->columnSpan(2),
                                    Checkbox::make('victim_of_trafficking')
                                        ->label('Victim of Trafficking (R.A. No. 9208)')
                                        ->columnSpan(2),
                                    Checkbox::make('foreign_national')
                                        ->live()
                                        ->label('Foreign National')
                                        ->columnSpan(2),
                                    Checkbox::make('indigenous_people')
                                        ->live()
                                        ->label('Indigenous People')
                                        ->columnSpan(2),
                                    TextInput::make('foreign_national_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('foreign_national');
                                        })
                                        ->columnSpan(2),
                                    TextInput::make('indigenous_people_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('indigenous_people');
                                        })
                                        ->columnSpan(2),
                                    Checkbox::make('urban_poor')
                                        ->live()
                                        ->label('Urban Poor')
                                        ->columnSpan(2),
                                    Checkbox::make('pwd_type')
                                        ->live()
                                        ->label('PWD; Type of Disability')
                                        ->columnSpan(2),
                                    TextInput::make('urban_poor_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('urban_poor');
                                        })
                                        ->columnSpan(2),
                                    Select::make('pwd_type_input')
                                        ->label('')
                                        ->options([
                                            'visual-impairment' => 'Visual Impairment',
                                            'hearing-impairment' => 'Hearing Impairment',
                                            'mobility-impairment' => 'Mobility Impairment',
                                            'intellectual-disability' => 'Intellectual Disability',
                                        ])
                                        ->disabled(function (Get $get) {
                                            return ! $get('pwd_type');
                                        })
                                        ->columnSpan(2),
                                    Checkbox::make('rural_poor')
                                        ->live()
                                        ->label('Rural Poor')
                                        ->columnSpan(2),
                                    Checkbox::make('petitioner_drugs')
                                        ->live()
                                        ->label('Petitioner for Voluntary Rehabilitation (Drugs)')
                                        ->columnSpan(2),
                                    TextInput::make('rural_poor_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('rural_poor');
                                        })
                                        ->columnSpan(2),
                                    TextInput::make('petitioner_drugs_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('petitioner_drugs');
                                        })
                                        ->columnSpan(2),
                                ])->columns(4)
                                ->visible(function (Get $get) {
                                    return $get('card3');
                                }),
                        ]),
                ])->submitAction(view('filament.forms.adviceFormButton')),
            ])
            ->statePath('adviceData');
    }

    public function previewAdviceForm(Form $form): Form
    {
        return $form
            ->schema([
                FieldSet::make('')
                    ->label('Para sa Serbisyong-Legal at/o Representasyon')
                    ->schema([
                        Select::make('region')
                            ->label('Rehiyon')
                            ->required()
                            ->options([
                                'Region I' => 'Region I',
                                'Region II' => 'Region II',
                                'Region III' => 'Region III',
                                'Region IV-A' => 'Region IV-A',
                                'MIMAROPA' => 'MIMAROPA',
                                'Region V' => 'Region V',
                                'Region VI' => 'Region VI',
                                'Region VII' => 'Region VII',
                                'Region VIII' => 'Region VIII',
                                'Region IX' => 'Region IX',
                                'Region X' => 'Region X',
                                'Region XI' => 'Region XI',
                                'Region XII' => 'Region XII',
                                'Region XIII' => 'Region XIII',
                                'NCR' => 'NCR',
                                'CAR' => 'CAR',
                                'BRMM' => 'BRMM',
                            ]),
                        TextInput::make('district_office')
                            ->label('District Office')
                            ->required(),
                        DatePicker::make('petsa')
                            ->required(),
                        TextInput::make('cnl')
                            ->label('Control No.')
                            ->disabled(),
                        TextInput::make('referredBy')
                            ->label('Ini-refer ni/Inindorso ng')
                            ->required(),
                        Fieldset::make('Ginawang Aksyon')
                            ->schema([
                                Checkbox::make('merit')
                                    ->label('Higit pang pag-aaralan (merit at indency test)')
                                    ->columnSpanFull(),
                                Checkbox::make('rep')
                                    ->label('Para sa representasyon at iba pang tulong-legal')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                        TextInput::make('assignTo')
                            ->label('Ini-atas kay')
                            ->required(),
                        Fieldset::make('')
                            ->schema([
                                Checkbox::make('iservicel-check')
                                    ->live()
                                    ->label('Ibinigay na serbisyong-legal')
                                    ->columnSpanFull(),
                                TextInput::make('iservicel')
                                    ->disabled(function (Get $get) {
                                        return ! $get('iservicel-check');
                                    })
                                    ->label('')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(2),
                FieldSet::make('')
                    ->label('I. URI NG HINIHINGING TULONG')
                    ->schema([
                        Fieldset::make('Pumili ng kahit isa*')
                            ->schema([
                                Checkbox::make('legalDoc')
                                    ->label('Legal Documentation'),
                                Checkbox::make('ao')
                                    ->label('Administration of Oath'),
                                Checkbox::make('courtRep')
                                    ->label('Representasyon sa Korte o ibang Tanggapin'),
                                Checkbox::make('legalAs')
                                    ->label('Inquest Legal Assistance'),
                                Checkbox::make('medcon')
                                    ->label('Mediation/Concilliation'),
                                Fieldset::make('')
                                    ->schema([
                                        Checkbox::make('iothers2-check')
                                            ->live()
                                            ->label('Iba pa')
                                            ->columnSpanFull(),
                                        TextInput::make('iothers2')
                                            ->disabled(function (Get $get) {
                                                return ! $get('iothers2-check');
                                            })
                                            ->label('')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpan(1),
                            ])
                            ->columns(3)
                            ->columnSpanFull(1),
                    ]),
                FieldSet::make('')
                    ->label('II. IMPORMASYON UKOL SA APLIKANTE (Para sa aplikante/representative. Gumamit ng panibago kung higit sa isa ang aplikante /kliyente)')
                    ->schema([
                        TextInput::make('name2')
                            ->label('Pangalan')
                            ->required(),
                        Fieldset::make('')
                            ->schema([
                                TextInput::make('age')
                                    ->required()
                                    ->label('Edad'),
                                Select::make('sex')
                                    ->label('Sex')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                    ])
                                    ->required(),
                                Select::make('civilStatus')
                                    ->label('Civil Status')
                                    ->options([
                                        'Single' => 'Single',
                                        'Married' => 'Married',
                                        'Widowed' => 'Widowed',
                                        'Divorced' => 'Divorced',
                                        'Separated' => 'Separated',
                                    ])
                                    ->required(),
                            ])
                            ->columns(3)
                            ->columnSpan(1),
                        Select::make('religion')
                            ->label('Relihiyon')
                            ->required()
                            ->options([
                                'rc' => 'Roman Catholic',
                                'islam' => 'Islam',
                                'iglesia' => 'Iglesia ni Cristo',
                                'sda' => 'Seventh Day Adventist',
                                'bible_bap' => 'Bible Baptist Church',
                                'jehovah' => "Jehovah's Witness",
                                'others' => 'Others',
                            ]),
                        Select::make('degree')
                            ->label('Naabot na Pag-aaral')  // Set the label
                            ->options([
                                'elementary' => 'Elementary',
                                'high_school' => 'High School',
                                'senior_high_school' => 'Senior High School',
                                'collage_level' => 'College Level',
                                'collage' => 'College Graduate',
                            ])
                            ->placeholder('Select Degree')  // Set placeholder text
                            ->required(),
                        Select::make('citizenship')
                            ->label('Pagkamamamayan')
                            // ->searchable()
                            ->options([
                                'afghan' => 'Afghan',
                                'albanian' => 'Albanian',
                                'algerian' => 'Algerian',
                                'andorran' => 'Andorran',
                                'angolan' => 'Angolan',
                                'argentinian' => 'Argentinian',
                                'armenian' => 'Armenian',
                                'australian' => 'Australian',
                                'austrian' => 'Austrian',
                                'azerbaijani' => 'Azerbaijani',
                                'bahamian' => 'Bahamian',
                                'bahraini' => 'Bahraini',
                                'bangladeshi' => 'Bangladeshi',
                                'barbadian' => 'Barbadian',
                                'belarusian' => 'Belarusian',
                                'belgian' => 'Belgian',
                                'belizean' => 'Belizean',
                                'beninese' => 'Beninese',
                                'bhutanese' => 'Bhutanese',
                                'bolivian' => 'Bolivian',
                                'bosnian' => 'Bosnian',
                                'brazilian' => 'Brazilian',
                                'british' => 'British',
                                'bulgarian' => 'Bulgarian',
                                'burkinabe' => 'Burkinabe',
                                'burmese' => 'Burmese',
                                'burundian' => 'Burundian',
                                'cambodian' => 'Cambodian',
                                'cameroonian' => 'Cameroonian',
                                'canadian' => 'Canadian',
                                'cape_verdean' => 'Cape Verdean',
                                'central_african' => 'Central African',
                                'chadian' => 'Chadian',
                                'chilean' => 'Chilean',
                                'chinese' => 'Chinese',
                                'colombian' => 'Colombian',
                                'comorian' => 'Comorian',
                                'congolese' => 'Congolese',
                                'costa_rican' => 'Costa Rican',
                                'ivorian' => 'Ivorian',
                                'croatian' => 'Croatian',
                                'cuban' => 'Cuban',
                                'cypriot' => 'Cypriot',
                                'czech' => 'Czech',
                                'danish' => 'Danish',
                                'djiboutian' => 'Djiboutian',
                                'dominican' => 'Dominican',
                                'ecuadorian' => 'Ecuadorian',
                                'egyptian' => 'Egyptian',
                                'emirati' => 'Emirati',
                                'equatorial_guinean' => 'Equatorial Guinean',
                                'eritrean' => 'Eritrean',
                                'estonian' => 'Estonian',
                                'ethiopian' => 'Ethiopian',
                                'fijian' => 'Fijian',
                                'finnish' => 'Finnish',
                                'french' => 'French',
                                'gabonese' => 'Gabonese',
                                'gambian' => 'Gambian',
                                'georgian' => 'Georgian',
                                'german' => 'German',
                                'ghanaian' => 'Ghanaian',
                                'greek' => 'Greek',
                                'grenadian' => 'Grenadian',
                                'guatemalan' => 'Guatemalan',
                                'guinean' => 'Guinean',
                                'guinea_bissauan' => 'Guinea-Bissauan',
                                'guyanese' => 'Guyanese',
                                'haitian' => 'Haitian',
                                'honduran' => 'Honduran',
                                'hungarian' => 'Hungarian',
                                'icelandic' => 'Icelandic',
                                'indian' => 'Indian',
                                'indonesian' => 'Indonesian',
                                'iranian' => 'Iranian',
                                'iraqi' => 'Iraqi',
                                'irish' => 'Irish',
                                'israeli' => 'Israeli',
                                'italian' => 'Italian',
                                'jamaican' => 'Jamaican',
                                'japanese' => 'Japanese',
                                'jordanian' => 'Jordanian',
                                'kazakh' => 'Kazakh',
                                'kenyan' => 'Kenyan',
                                'kuwaiti' => 'Kuwaiti',
                                'kyrgyz' => 'Kyrgyz',
                                'laotian' => 'Laotian',
                                'latvian' => 'Latvian',
                                'lebanese' => 'Lebanese',
                                'liberian' => 'Liberian',
                                'libyan' => 'Libyan',
                                'liechtensteiner' => 'Liechtensteiner',
                                'lithuanian' => 'Lithuanian',
                                'luxembourgish' => 'Luxembourgish',
                                'malagasy' => 'Malagasy',
                                'malawian' => 'Malawian',
                                'malaysian' => 'Malaysian',
                                'maldivian' => 'Maldivian',
                                'malian' => 'Malian',
                                'maltese' => 'Maltese',
                                'marshallese' => 'Marshallese',
                                'mauritanian' => 'Mauritanian',
                                'mauritian' => 'Mauritian',
                                'mexican' => 'Mexican',
                                'micronesian' => 'Micronesian',
                                'moldovan' => 'Moldovan',
                                'monegasque' => 'Monegasque',
                                'mongolian' => 'Mongolian',
                                'montenegrin' => 'Montenegrin',
                                'moroccan' => 'Moroccan',
                                'mozambican' => 'Mozambican',
                                'myanmarese' => 'Myanmarese',
                                'namibian' => 'Namibian',
                                'nauruan' => 'Nauruan',
                                'nepalese' => 'Nepalese',
                                'dutch' => 'Dutch',
                                'new_zealand' => 'New Zealand',
                                'nicaraguan' => 'Nicaraguan',
                                'nigerian' => 'Nigerian',
                                'nigerien' => 'Nigerien',
                                'north_korean' => 'North Korean',
                                'macedonian' => 'Macedonian',
                                'norwegian' => 'Norwegian',
                                'omani' => 'Omani',
                                'pakistani' => 'Pakistani',
                                'palauan' => 'Palauan',
                                'panamanian' => 'Panamanian',
                                'papuan_new_guinean' => 'Papuan New Guinean',
                                'paraguayan' => 'Paraguayan',
                                'peruvian' => 'Peruvian',
                                'philippine' => 'Philippine',
                                'polish' => 'Polish',
                                'portuguese' => 'Portuguese',
                                'qatari' => 'Qatari',
                                'romanian' => 'Romanian',
                                'russian' => 'Russian',
                                'rwandan' => 'Rwandan',
                                'saint_lucian' => 'Saint Lucian',
                                'saint_vincent_and_the_grenadines_citizen' => 'Saint Vincent and the Grenadines citizen',
                                'samoan' => 'Samoan',
                                'sanmarinoan' => 'Sanmarinoan',
                                'sao_tomean' => 'São Toméan',
                                'senegalese' => 'Senegalese',
                                'serbian' => 'Serbian',
                                'seychellois' => 'Seychellois',
                                'sierra_leonean' => 'Sierra Leonean',
                                'singaporean' => 'Singaporean',
                                'slovak' => 'Slovak',
                                'slovenian' => 'Slovenian',
                                'solomon_islands' => 'Solomon Islands',
                                'somali' => 'Somali',
                                'south_african' => 'South African',
                                'south_korean' => 'South Korean',
                                'south_sudanese' => 'South Sudanese',
                                'spanish' => 'Spanish',
                                'sri_lankan' => 'Sri Lankan',
                                'sudanese' => 'Sudanese',
                                'swazi' => 'Swazi',
                                'swedish' => 'Swedish',
                                'swiss' => 'Swiss',
                                'syrian' => 'Syrian',
                                'tajik' => 'Tajik',
                                'tanzanian' => 'Tanzanian',
                                'thai' => 'Thai',
                                'timorese' => 'Timorese',
                                'togolese' => 'Togolese',
                                'tongan' => 'Tongan',
                                'trinidadian_and_tobagonian' => 'Trinidadian and Tobagonian',
                                'tunisian' => 'Tunisian',
                                'turkish' => 'Turkish',
                                'turkmen' => 'Turkmen',
                                'tuvaluan' => 'Tuvaluan',
                                'ugandan' => 'Ugandan',
                                'ukrainian' => 'Ukrainian',
                                'uruguayan' => 'Uruguayan',
                                'uzbek' => 'Uzbek',
                                'venezuelan' => 'Venezuelan',
                                'vietnamese' => 'Vietnamese',
                                'yemeni' => 'Yemeni',
                                'zambian' => 'Zambian',
                                'zimbabwean' => 'Zimbabwean',
                            ])
                            ->required(),
                        Select::make('language')
                            ->label('Dialekto')
                            ->options([
                                'Bisaya' => 'Bisaya',
                                'Tagalog' => 'Tagalog',
                                'English' => 'English',
                                'Ilocano' => 'Ilocano',
                                'Hiligaynon' => 'Hiligaynon',
                                'Bikol' => 'Bikol',
                                'Waray' => 'Waray',
                                'Kapampangan' => 'Kapampangan',
                                'Pangasinan' => 'Pangasinan',
                                'Chavacano' => 'Chavacano',
                                'Maranao' => 'Maranao',
                                'Tausug' => 'Tausug',
                                'Maguindanao' => 'Maguindanao',
                                'Ivatan' => 'Ivatan',
                                'Kinaray-a' => 'Kinaray-a',
                                'Yakan' => 'Yakan',
                                'Sambal' => 'Sambal',
                                'Others' => 'Others',
                            ])
                            ->required(),
                        FieldSet::make('')
                            ->schema([
                                Select::make('regions')->required()
                                    ->preload()
                                    ->required()
                                    ->options(function () {
                                        return DB::table('regions')->pluck('name', 'region_id');
                                    })
                                    ->live(),
                                Select::make('province')->required()
                                    ->preload()
                                    ->required()
                                    ->options(function () {
                                        return DB::table('provinces')->pluck('name', 'code');
                                    }),
                                Select::make('city')->required()
                                    ->preload()
                                    ->required()
                                    ->options(function () {
                                        return DB::table('cities')->pluck('name', 'code');
                                    }),
                                // Select::make('barangay')
                                //     ->preload()
                                //     ->required()
                                //     ->options(function () {
                                //         return DB::table('barangays')->pluck('name', 'code');
                                //     }),
                            ])
                            ->columns(2)
                            ->columnSpan(1),
                        TextInput::make('contact_number')
                            ->numeric()
                            ->label('Contact Number')
                            ->required(),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('asawa')
                            ->label('Asawa')
                            ->required(),
                        TextInput::make('income')
                            ->label('Individual Monthly Income')
                            ->required(),
                        TextInput::make('asawaAddress')
                            ->label('Tirahan ng asawa')
                            ->required(),
                        Radio::make('nakakulong')
                            ->required()
                            ->live()
                            ->options([
                                'true' => 'Oo',
                                'false' => 'Hindi',
                            ])
                            ->default('false')
                            ->label('Nakakulong')
                            ->inline(),
                        TextInput::make('contactNumberAsawa')
                            ->label('Contact Number ng asawa')
                            ->numeric()
                            ->required(),
                        DatePicker::make('dateofKulong')
                            ->disabled(function (Get $get) {
                                return $get('nakakulong') === 'false';
                            })
                            ->required(),
                        Select::make('dPlace')
                            ->label('Lugar ng Detention')
                            ->options([
                                'Dujali Police Station' => 'Dujali Police Station',
                                'BJMP Panabo' => 'BJMP Panabo',
                                'PNP, Sto. Tomas' => 'PNP, Sto. Tomas',
                                'PNP, Carmen' => 'PNP, Carmen',
                                'BJMP Peñaplata' => 'BJMP Peñaplata',
                                'Igacos' => 'Igacos',
                            ])
                            ->required(),
                    ])
                    ->columns(2),
                FieldSet::make('')
                    ->schema([
                        Checkbox::make('card1')
                            ->live()
                            ->label('II-A. IMPORMASYON UKOL SA REPRESENTATIVE (Pupunan kung wala ang aplikante)'),
                        Checkbox::make('card2')
                            ->live()
                            ->label('III. URI NG KASO'),
                        Checkbox::make('card3')
                            ->live()
                            ->label('IV. SEKTOR NA KABILANG ANG APLIKANTE'),
                    ])->columns(3),
                Fieldset::make('II-A. IMPORMASYON UKOL SA REPRESENTATIVE (Pupunan kung wala ang aplikante)')
                    ->schema([
                        TextInput::make('representativeName')
                            ->label('Pangalan'),
                        FieldSet::make('')
                            ->schema([
                                TextInput::make('representativeAge')
                                    ->label('Edad')
                                    ->numeric(),
                                Select::make('representativeSex')
                                    ->label('Sex')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                    ]),
                                Select::make('representativeCivilStatus')
                                    ->label('Civil Status')
                                    ->options([
                                        'Single' => 'Single',
                                        'Married' => 'Married',
                                        'Widowed' => 'Widowed',
                                        'Divorced' => 'Divorced',
                                        'Separated' => 'Separated',
                                    ]),
                            ])
                            ->columnSpan(1)
                            ->columns(3),
                        TextInput::make('representativeTirahan')
                            ->label('Tirahan'),
                        TextInput::make('representativeContactNumber')
                            ->label('Contact Number')
                            ->numeric(),
                        TextInput::make('representativeRelationship')
                            ->label('Relasyon sa aplikante'),
                        TextInput::make('representativeEmail')
                            ->label('Email'),
                    ])
                    ->columns(2)
                    ->visible(function (Get $get) {
                        return $get('card1');
                    }),
                Fieldset::make('III. URI NG KASO')
                    ->schema([
                        Radio::make('type_of_case')
                            ->label('')
                            ->options([
                                'criminal' => 'Criminal',
                                'civil' => 'Civil',
                                'administrative' => 'Administrative',
                                'appealed' => 'Appealed',
                                'labor' => 'Labor',
                            ])
                            ->required()
                            ->inline()
                            ->columnSpanFull(),
                    ])->columns(3)
                    ->visible(function (Get $get) {
                        return $get('card2');
                    }),
                Fieldset::make('IV. SEKTOR NA KABILANG ANG APLIKANTE')
                    ->schema([
                        Checkbox::make('child_in_conflict')
                            ->label('Child in Conflict with the Law')
                            ->columnSpan(2),
                        Checkbox::make('senior_citizen')
                            ->label('Senior Citizen')
                            ->columnSpan(2),
                        Checkbox::make('woman')
                            ->label('Woman'),
                        Checkbox::make('victim_of_VAWC')
                            ->label('Biktima ng VAWC'),
                        Checkbox::make('drug_refugee')
                            ->columnSpan(2)
                            ->label('Refugee/Evacuee'),
                        Checkbox::make('law_enforcer')
                            ->label('Law Enforcer'),
                        Checkbox::make('drug_related_duty')
                            ->label('Drug-related Duty'),
                        Checkbox::make('tenant_of_agrarian_case')
                            ->label('Tenant ng Agrarian Case')
                            ->columnSpan(2),
                        Checkbox::make('ofw_land_based')
                            ->label('OFW - Land-based')
                            ->columnSpan(2),
                        Checkbox::make('arrested_for_terrorism')
                            ->label('Arrested for Terrorism (R.A. No. 11479)')
                            ->columnSpan(2),
                        Checkbox::make('ofw_sea_based')
                            ->label('OFW - Sea-based')
                            ->columnSpan(2),
                        Checkbox::make('victim_of_torture')
                            ->label('Victim of Torture (R.A. No. 9745)')
                            ->columnSpan(2),
                        Checkbox::make('former_rebel')
                            ->label('Former Rebel (FR) and Former Violent Extremist (FVE)')
                            ->columnSpan(2),
                        Checkbox::make('victim_of_trafficking')
                            ->label('Victim of Trafficking (R.A. No. 9208)')
                            ->columnSpan(2),
                        Checkbox::make('foreign_national')
                            ->live()
                            ->label('Foreign National')
                            ->columnSpan(2),
                        Checkbox::make('indigenous_people')
                            ->live()
                            ->label('Indigenous People')
                            ->columnSpan(2),
                        TextInput::make('foreign_national_input')
                            ->label('')
                            ->disabled(function (Get $get) {
                                return ! $get('foreign_national');
                            })
                            ->columnSpan(2),
                        TextInput::make('indigenous_people_input')
                            ->label('')
                            ->disabled(function (Get $get) {
                                return ! $get('indigenous_people');
                            })
                            ->columnSpan(2),
                        Checkbox::make('urban_poor')
                            ->live()
                            ->label('Urban Poor')
                            ->columnSpan(2),
                        Checkbox::make('pwd_type')
                            ->live()
                            ->label('PWD; Type of Disability')
                            ->columnSpan(2),
                        TextInput::make('urban_poor_input')
                            ->label('')
                            ->disabled(function (Get $get) {
                                return ! $get('urban_poor');
                            })
                            ->columnSpan(2),
                        Select::make('pwd_type_input')
                            ->label('')
                            ->options([
                                'visual-impairment' => 'Visual Impairment',
                                'hearing-impairment' => 'Hearing Impairment',
                                'mobility-impairment' => 'Mobility Impairment',
                                'intellectual-disability' => 'Intellectual Disability',
                            ])
                            ->disabled(function (Get $get) {
                                return ! $get('pwd_type');
                            })
                            ->columnSpan(2),
                        Checkbox::make('rural_poor')
                            ->live()
                            ->label('Rural Poor')
                            ->columnSpan(2),
                        Checkbox::make('petitioner_drugs')
                            ->live()
                            ->label('Petitioner for Voluntary Rehabilitation (Drugs)')
                            ->columnSpan(2),
                        TextInput::make('rural_poor_input')
                            ->label('')
                            ->disabled(function (Get $get) {
                                return ! $get('rural_poor');
                            })
                            ->columnSpan(2),
                        TextInput::make('petitioner_drugs_input')
                            ->label('')
                            ->disabled(function (Get $get) {
                                return ! $get('petitioner_drugs');
                            })
                            ->columnSpan(2),
                    ])->columns(4)
                    ->visible(function (Get $get) {
                        return $get('card3');
                    }),
            ])
            ->statePath('dummyAdviceData');
    }

    public function previewAdviceData()
    {
        $this->previewAdviceForm->fill(
            $this->adviceData,
        );

        $this->dispatch('open-modal', id: 'edit-comment');
    }

    public function notarizeForm(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('INTERVIEW SHEET (Para sa Serbisyong-Legal at/o Representasyon)')
                        ->schema([
                            Select::make('region')
                                ->label('Rehiyon')
                                ->options([
                                    'Region I' => 'Region I',
                                    'Region II' => 'Region II',
                                    'Region III' => 'Region III',
                                    'Region IV-A' => 'Region IV-A',
                                    'MIMAROPA' => 'MIMAROPA',
                                    'Region V' => 'Region V',
                                    'Region VI' => 'Region VI',
                                    'Region VII' => 'Region VII',
                                    'Region VIII' => 'Region VIII',
                                    'Region IX' => 'Region IX',
                                    'Region X' => 'Region X',
                                    'Region XI' => 'Region XI',
                                    'Region XII' => 'Region XII',
                                    'Region XIII' => 'Region XIII',
                                    'NCR' => 'NCR',
                                    'CAR' => 'CAR',
                                    'BRMM' => 'BRMM',
                                ])
                                ->placeholder('Pumili ng Rehiyon')
                                ->required(),
                            TextInput::make('referredBy')
                                ->label('Ini-refer ni/Inindorso ng')
                                ->required(),
                            TextInput::make('district_office')
                                ->label('District Office')
                                ->required(),
                            Fieldset::make('Ginawang Aksyon')
                                ->schema([
                                    Checkbox::make('merit')
                                        ->label('Higit pang pag-aaralan (merit at indency test)')
                                        ->columnSpanFull(),
                                    Checkbox::make('rep')
                                        ->label('Para sa representasyon at iba pang tulong-legal')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                            DatePicker::make('petsa')
                                ->required(),
                            TextInput::make('assignTo')
                                ->label('Ini-atas kay')
                                ->required(),
                            TextInput::make('cnl')
                                ->label('Control No.')
                                ->disabled()
                                ->numeric(),
                            Fieldset::make('')
                                ->schema([
                                    Checkbox::make('iservicel-check')
                                        ->live()
                                        ->label('Ibinigay na serbisyong-legal')
                                        ->columnSpanFull(),
                                    TextInput::make('iservicel')
                                        ->disabled(function (Get $get) {
                                            return ! $get('iservicel-check');
                                        })
                                        ->label('')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                            TextInput::make('mananayam')
                                ->label('Mananayam')
                                ->required(),
                            Fieldset::make('')
                                ->schema([
                                    Checkbox::make('iothers-check')
                                        ->live()
                                        ->label('Iba pa')
                                        ->columnSpanFull(),
                                    TextInput::make('iothers')
                                        ->disabled(function (Get $get) {
                                            return ! $get('iothers-check');
                                        })
                                        ->label('')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                        ])
                        ->columns(2),
                    Wizard\Step::make('I. URI NG HINIHINGI NG TULONG (Para sa kawani ng PAO)')
                        ->schema([
                            Fieldset::make('Pumili ng kahit isa*')
                                ->schema([
                                    Checkbox::make('legalDoc')
                                        ->label('Legal Documentation'),
                                    Checkbox::make('ao')
                                        ->label('Administration of Oath'),
                                    Checkbox::make('courtRep')
                                        ->label('Representasyon sa Korte o ibang Tanggapin'),
                                    Checkbox::make('legalAs')
                                        ->label('Inquest Legal Assistance'),
                                    Checkbox::make('medcon')
                                        ->label('Mediation/Concilliation'),
                                    Fieldset::make('')
                                        ->schema([
                                            Checkbox::make('iothers2-check')
                                                ->live()
                                                ->label('Iba pa')
                                                ->columnSpanFull(),
                                            TextInput::make('iothers2')
                                                ->disabled(function (Get $get) {
                                                    return ! $get('iothers2-check');
                                                })
                                                ->label('')
                                                ->columnSpanFull(),
                                        ])
                                        ->columnSpan(1),
                                ])
                                ->columns(3)
                                ->columnSpanFull(1),
                        ]),
                    Wizard\Step::make('II. IMPORMASYON UKOL SA APLIKANTE (Para sa aplikante/representative. Gumamit ng panibago kung higit sa isa ang aplikante /kliyente)')
                        ->schema([
                            TextInput::make('name2')
                                ->label('Pangalan')
                                ->required(),
                            Fieldset::make('')
                                ->schema([
                                    TextInput::make('age')
                                        ->required()
                                        ->label('Edad'),
                                    Select::make('sex')
                                        ->label('Sex')
                                        ->options([
                                            'Male' => 'Male',
                                            'Female' => 'Female',
                                        ])
                                        ->required(),
                                    Select::make('civilStatus')
                                        ->label('Civil Status')
                                        ->options([
                                            'Single' => 'Single',
                                            'Married' => 'Married',
                                            'Widowed' => 'Widowed',
                                            'Divorced' => 'Divorced',
                                            'Separated' => 'Separated',
                                        ])
                                        ->required(),
                                ])
                                ->columns(3)
                                ->columnSpan(1),
                            Select::make('religion')
                                ->label('Relihiyon')
                                ->required()
                                ->options([
                                    'rc' => 'Roman Catholic',
                                    'islam' => 'Islam',
                                    'iglesia' => 'Iglesia ni Cristo',
                                    'sda' => 'Seventh Day Adventist',
                                    'bible_bap' => 'Bible Baptist Church',
                                    'jehovah' => "Jehovah's Witness",
                                    'others' => 'Others',
                                ]),
                            Select::make('degree')
                                ->label('Naabot na Pag-aaral')  // Set the label
                                ->options([
                                    'elementary' => 'Elementary',
                                    'high_school' => 'High School',
                                    'senior_high_school' => 'Senior High School',
                                    'collage_level' => 'College Level',
                                    'collage' => 'College Graduate',
                                ])
                                ->placeholder('Select Degree')  // Set placeholder text
                                ->required(),
                            Select::make('citizenship')
                                ->label('Pagkamamamayan')
                                // ->searchable()
                                ->options([
                                    'afghan' => 'Afghan',
                                    'albanian' => 'Albanian',
                                    'algerian' => 'Algerian',
                                    'andorran' => 'Andorran',
                                    'angolan' => 'Angolan',
                                    'argentinian' => 'Argentinian',
                                    'armenian' => 'Armenian',
                                    'australian' => 'Australian',
                                    'austrian' => 'Austrian',
                                    'azerbaijani' => 'Azerbaijani',
                                    'bahamian' => 'Bahamian',
                                    'bahraini' => 'Bahraini',
                                    'bangladeshi' => 'Bangladeshi',
                                    'barbadian' => 'Barbadian',
                                    'belarusian' => 'Belarusian',
                                    'belgian' => 'Belgian',
                                    'belizean' => 'Belizean',
                                    'beninese' => 'Beninese',
                                    'bhutanese' => 'Bhutanese',
                                    'bolivian' => 'Bolivian',
                                    'bosnian' => 'Bosnian',
                                    'brazilian' => 'Brazilian',
                                    'british' => 'British',
                                    'bulgarian' => 'Bulgarian',
                                    'burkinabe' => 'Burkinabe',
                                    'burmese' => 'Burmese',
                                    'burundian' => 'Burundian',
                                    'cambodian' => 'Cambodian',
                                    'cameroonian' => 'Cameroonian',
                                    'canadian' => 'Canadian',
                                    'cape_verdean' => 'Cape Verdean',
                                    'central_african' => 'Central African',
                                    'chadian' => 'Chadian',
                                    'chilean' => 'Chilean',
                                    'chinese' => 'Chinese',
                                    'colombian' => 'Colombian',
                                    'comorian' => 'Comorian',
                                    'congolese' => 'Congolese',
                                    'costa_rican' => 'Costa Rican',
                                    'ivorian' => 'Ivorian',
                                    'croatian' => 'Croatian',
                                    'cuban' => 'Cuban',
                                    'cypriot' => 'Cypriot',
                                    'czech' => 'Czech',
                                    'danish' => 'Danish',
                                    'djiboutian' => 'Djiboutian',
                                    'dominican' => 'Dominican',
                                    'ecuadorian' => 'Ecuadorian',
                                    'egyptian' => 'Egyptian',
                                    'emirati' => 'Emirati',
                                    'equatorial_guinean' => 'Equatorial Guinean',
                                    'eritrean' => 'Eritrean',
                                    'estonian' => 'Estonian',
                                    'ethiopian' => 'Ethiopian',
                                    'fijian' => 'Fijian',
                                    'finnish' => 'Finnish',
                                    'french' => 'French',
                                    'gabonese' => 'Gabonese',
                                    'gambian' => 'Gambian',
                                    'georgian' => 'Georgian',
                                    'german' => 'German',
                                    'ghanaian' => 'Ghanaian',
                                    'greek' => 'Greek',
                                    'grenadian' => 'Grenadian',
                                    'guatemalan' => 'Guatemalan',
                                    'guinean' => 'Guinean',
                                    'guinea_bissauan' => 'Guinea-Bissauan',
                                    'guyanese' => 'Guyanese',
                                    'haitian' => 'Haitian',
                                    'honduran' => 'Honduran',
                                    'hungarian' => 'Hungarian',
                                    'icelandic' => 'Icelandic',
                                    'indian' => 'Indian',
                                    'indonesian' => 'Indonesian',
                                    'iranian' => 'Iranian',
                                    'iraqi' => 'Iraqi',
                                    'irish' => 'Irish',
                                    'israeli' => 'Israeli',
                                    'italian' => 'Italian',
                                    'jamaican' => 'Jamaican',
                                    'japanese' => 'Japanese',
                                    'jordanian' => 'Jordanian',
                                    'kazakh' => 'Kazakh',
                                    'kenyan' => 'Kenyan',
                                    'kuwaiti' => 'Kuwaiti',
                                    'kyrgyz' => 'Kyrgyz',
                                    'laotian' => 'Laotian',
                                    'latvian' => 'Latvian',
                                    'lebanese' => 'Lebanese',
                                    'liberian' => 'Liberian',
                                    'libyan' => 'Libyan',
                                    'liechtensteiner' => 'Liechtensteiner',
                                    'lithuanian' => 'Lithuanian',
                                    'luxembourgish' => 'Luxembourgish',
                                    'malagasy' => 'Malagasy',
                                    'malawian' => 'Malawian',
                                    'malaysian' => 'Malaysian',
                                    'maldivian' => 'Maldivian',
                                    'malian' => 'Malian',
                                    'maltese' => 'Maltese',
                                    'marshallese' => 'Marshallese',
                                    'mauritanian' => 'Mauritanian',
                                    'mauritian' => 'Mauritian',
                                    'mexican' => 'Mexican',
                                    'micronesian' => 'Micronesian',
                                    'moldovan' => 'Moldovan',
                                    'monegasque' => 'Monegasque',
                                    'mongolian' => 'Mongolian',
                                    'montenegrin' => 'Montenegrin',
                                    'moroccan' => 'Moroccan',
                                    'mozambican' => 'Mozambican',
                                    'myanmarese' => 'Myanmarese',
                                    'namibian' => 'Namibian',
                                    'nauruan' => 'Nauruan',
                                    'nepalese' => 'Nepalese',
                                    'dutch' => 'Dutch',
                                    'new_zealand' => 'New Zealand',
                                    'nicaraguan' => 'Nicaraguan',
                                    'nigerian' => 'Nigerian',
                                    'nigerien' => 'Nigerien',
                                    'north_korean' => 'North Korean',
                                    'macedonian' => 'Macedonian',
                                    'norwegian' => 'Norwegian',
                                    'omani' => 'Omani',
                                    'pakistani' => 'Pakistani',
                                    'palauan' => 'Palauan',
                                    'panamanian' => 'Panamanian',
                                    'papuan_new_guinean' => 'Papuan New Guinean',
                                    'paraguayan' => 'Paraguayan',
                                    'peruvian' => 'Peruvian',
                                    'philippine' => 'Philippine',
                                    'polish' => 'Polish',
                                    'portuguese' => 'Portuguese',
                                    'qatari' => 'Qatari',
                                    'romanian' => 'Romanian',
                                    'russian' => 'Russian',
                                    'rwandan' => 'Rwandan',
                                    'saint_lucian' => 'Saint Lucian',
                                    'saint_vincent_and_the_grenadines_citizen' => 'Saint Vincent and the Grenadines citizen',
                                    'samoan' => 'Samoan',
                                    'sanmarinoan' => 'Sanmarinoan',
                                    'sao_tomean' => 'São Toméan',
                                    'senegalese' => 'Senegalese',
                                    'serbian' => 'Serbian',
                                    'seychellois' => 'Seychellois',
                                    'sierra_leonean' => 'Sierra Leonean',
                                    'singaporean' => 'Singaporean',
                                    'slovak' => 'Slovak',
                                    'slovenian' => 'Slovenian',
                                    'solomon_islands' => 'Solomon Islands',
                                    'somali' => 'Somali',
                                    'south_african' => 'South African',
                                    'south_korean' => 'South Korean',
                                    'south_sudanese' => 'South Sudanese',
                                    'spanish' => 'Spanish',
                                    'sri_lankan' => 'Sri Lankan',
                                    'sudanese' => 'Sudanese',
                                    'swazi' => 'Swazi',
                                    'swedish' => 'Swedish',
                                    'swiss' => 'Swiss',
                                    'syrian' => 'Syrian',
                                    'tajik' => 'Tajik',
                                    'tanzanian' => 'Tanzanian',
                                    'thai' => 'Thai',
                                    'timorese' => 'Timorese',
                                    'togolese' => 'Togolese',
                                    'tongan' => 'Tongan',
                                    'trinidadian_and_tobagonian' => 'Trinidadian and Tobagonian',
                                    'tunisian' => 'Tunisian',
                                    'turkish' => 'Turkish',
                                    'turkmen' => 'Turkmen',
                                    'tuvaluan' => 'Tuvaluan',
                                    'ugandan' => 'Ugandan',
                                    'ukrainian' => 'Ukrainian',
                                    'uruguayan' => 'Uruguayan',
                                    'uzbek' => 'Uzbek',
                                    'venezuelan' => 'Venezuelan',
                                    'vietnamese' => 'Vietnamese',
                                    'yemeni' => 'Yemeni',
                                    'zambian' => 'Zambian',
                                    'zimbabwean' => 'Zimbabwean',
                                ])
                                ->required(),
                            Select::make('language')
                                ->label('Dialekto')
                                ->options([
                                    'Bisaya' => 'Bisaya',
                                    'Tagalog' => 'Tagalog',
                                    'English' => 'English',
                                    'Ilocano' => 'Ilocano',
                                    'Hiligaynon' => 'Hiligaynon',
                                    'Bikol' => 'Bikol',
                                    'Waray' => 'Waray',
                                    'Kapampangan' => 'Kapampangan',
                                    'Pangasinan' => 'Pangasinan',
                                    'Chavacano' => 'Chavacano',
                                    'Maranao' => 'Maranao',
                                    'Tausug' => 'Tausug',
                                    'Maguindanao' => 'Maguindanao',
                                    'Ivatan' => 'Ivatan',
                                    'Kinaray-a' => 'Kinaray-a',
                                    'Yakan' => 'Yakan',
                                    'Sambal' => 'Sambal',
                                    'Others' => 'Others',
                                ])
                                ->required(),
                            FieldSet::make('')
                                ->schema([
                                    Select::make('regions')->required()
                                        ->preload()
                                        ->required()
                                        ->options(function () {
                                            return DB::table('regions')->pluck('name', 'region_id');
                                        })
                                        ->live(),
                                    Select::make('province')->required()
                                        ->preload()
                                        ->required()
                                        ->options(function () {
                                            return DB::table('provinces')->pluck('name', 'code');
                                        }),
                                    Select::make('city')->required()
                                        ->preload()
                                        ->required()
                                        ->options(function () {
                                            return DB::table('cities')->pluck('name', 'code');
                                        }),
                                    // Select::make('barangay')
                                    //     ->preload()
                                    //     ->required()
                                    //     ->options(function () {
                                    //         return DB::table('barangays')->pluck('name', 'code');
                                    //     }),
                                ])
                                ->columns(2)
                                ->columnSpan(1),
                            TextInput::make('contact_number')
                                ->numeric()
                                ->label('Contact Number')
                                ->required(),
                            TextInput::make('email')
                                ->required(),
                            TextInput::make('asawa')
                                ->label('Asawa')
                                ->required(),
                            TextInput::make('income')
                                ->label('Individual Monthly Income')
                                ->required(),
                            TextInput::make('asawaAddress')
                                ->label('Tirahan ng asawa')
                                ->required(),
                            Radio::make('nakakulong')
                                ->required()
                                ->live()
                                ->options([
                                    'true' => 'Oo',
                                    'false' => 'Hindi',
                                ])
                                ->default('false')
                                ->label('Nakakulong')
                                ->inline(),
                            TextInput::make('contactNumberAsawa')
                                ->label('Contact Number ng asawa')
                                ->numeric()
                                ->required(),
                            DatePicker::make('dateofKulong')
                                ->disabled(function (Get $get) {
                                    return $get('nakakulong') === 'false';
                                })
                                ->required(),
                            Select::make('dPlace')
                                ->label('Lugar ng Detention')
                                ->options([
                                    'Dujali Police Station' => 'Dujali Police Station',
                                    'BJMP Panabo' => 'BJMP Panabo',
                                    'PNP, Sto. Tomas' => 'PNP, Sto. Tomas',
                                    'PNP, Carmen' => 'PNP, Carmen',
                                    'BJMP Peñaplata' => 'BJMP Peñaplata',
                                    'Igacos' => 'Igacos',
                                ])
                                ->required(),
                        ])->columns(2),
                    Wizard\Step::make('IV. SEKTOR NA KABILANG ANG APLIKANTE')
                        ->schema([
                            Fieldset::make('IV. SEKTOR NA KABILANG ANG APLIKANTE')
                                ->schema([
                                    Checkbox::make('child_in_conflict')
                                        ->label('Child in Conflict with the Law')
                                        ->columnSpan(2),
                                    Checkbox::make('senior_citizen')
                                        ->label('Senior Citizen')
                                        ->columnSpan(2),
                                    Checkbox::make('woman')
                                        ->label('Woman'),
                                    Checkbox::make('victim_of_VAWC')
                                        ->label('Biktima ng VAWC'),
                                    Checkbox::make('drug_refugee')
                                        ->columnSpan(2)
                                        ->label('Refugee/Evacuee'),
                                    Checkbox::make('law_enforcer')
                                        ->label('Law Enforcer'),
                                    Checkbox::make('drug_related_duty')
                                        ->label('Drug-related Duty'),
                                    Checkbox::make('tenant_of_agrarian_case')
                                        ->label('Tenant ng Agrarian Case')
                                        ->columnSpan(2),
                                    Checkbox::make('ofw_land_based')
                                        ->label('OFW - Land-based')
                                        ->columnSpan(2),
                                    Checkbox::make('arrested_for_terrorism')
                                        ->label('Arrested for Terrorism (R.A. No. 11479)')
                                        ->columnSpan(2),
                                    Checkbox::make('ofw_sea_based')
                                        ->label('OFW - Sea-based')
                                        ->columnSpan(2),
                                    Checkbox::make('victim_of_torture')
                                        ->label('Victim of Torture (R.A. No. 9745)')
                                        ->columnSpan(2),
                                    Checkbox::make('former_rebel')
                                        ->label('Former Rebel (FR) and Former Violent Extremist (FVE)')
                                        ->columnSpan(2),
                                    Checkbox::make('victim_of_trafficking')
                                        ->label('Victim of Trafficking (R.A. No. 9208)')
                                        ->columnSpan(2),
                                    Checkbox::make('foreign_national')
                                        ->live()
                                        ->label('Foreign National')
                                        ->columnSpan(2),
                                    Checkbox::make('indigenous_people')
                                        ->live()
                                        ->label('Indigenous People')
                                        ->columnSpan(2),
                                    TextInput::make('foreign_national_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('foreign_national');
                                        })
                                        ->columnSpan(2),
                                    TextInput::make('indigenous_people_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('indigenous_people');
                                        })
                                        ->columnSpan(2),
                                    Checkbox::make('urban_poor')
                                        ->live()
                                        ->label('Urban Poor')
                                        ->columnSpan(2),
                                    Checkbox::make('pwd_type')
                                        ->live()
                                        ->label('PWD; Type of Disability')
                                        ->columnSpan(2),
                                    TextInput::make('urban_poor_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('urban_poor');
                                        })
                                        ->columnSpan(2),
                                    Select::make('pwd_type_input')
                                        ->label('')
                                        ->options([
                                            'visual-impairment' => 'Visual Impairment',
                                            'hearing-impairment' => 'Hearing Impairment',
                                            'mobility-impairment' => 'Mobility Impairment',
                                            'intellectual-disability' => 'Intellectual Disability',
                                        ])
                                        ->disabled(function (Get $get) {
                                            return ! $get('pwd_type');
                                        })
                                        ->columnSpan(2),
                                    Checkbox::make('rural_poor')
                                        ->live()
                                        ->label('Rural Poor')
                                        ->columnSpan(2),
                                    Checkbox::make('petitioner_drugs')
                                        ->live()
                                        ->label('Petitioner for Voluntary Rehabilitation (Drugs)')
                                        ->columnSpan(2),
                                    TextInput::make('rural_poor_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('rural_poor');
                                        })
                                        ->columnSpan(2),
                                    TextInput::make('petitioner_drugs_input')
                                        ->label('')
                                        ->disabled(function (Get $get) {
                                            return ! $get('petitioner_drugs');
                                        })
                                        ->columnSpan(2),
                                ])->columns(4),
                        ]),
                ])
                    ->submitAction(view('filament.forms.adviceFormButton')),
            ])
            ->statePath('notarizeData');
    }

    public function saveInterviewSheet()
    {
        dd(true);
    }
}

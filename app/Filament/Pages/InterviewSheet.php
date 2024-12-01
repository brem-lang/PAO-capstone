<?php

namespace App\Filament\Pages;

use App\Models\IDType;
use App\Models\InterViewSheet as ModelsInterViewSheet;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Text;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class InterviewSheet extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.interview-sheet';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = '';

    protected static ?string $navigationLabel = 'Interview Sheet';

    public ?array $adviceData = [];

    public ?array $notarizeData = [];

    public ?array $dummyAdviceData = [];

    public ?array $dummyNotarizeData = [];

    public $isAutoFill = false;

    public static function canAccess(): bool
    {
        return auth()->user()->isClient();
    }

    public function mount()
    {
        $this->initializeForms();
    }

    public function initializeForms()
    {
        if ($this->isAutoFill) {

            $interviewSheet = ModelsInterViewSheet::where('user_id', auth()->user()->id)
                ->latest()
                ->first();

            if ($interviewSheet) {
                $interviewSheet = $interviewSheet->toArray();
            } else {
                // Handle the case where there is no data, for example, return an empty array
                $interviewSheet = [];
            }

            $this->notarizeForm->fill($interviewSheet);

            $this->adviceForm->fill($interviewSheet);
        } else {
            $this->notarizeForm->fill([
                'date' => now()->format('Y-m-d'),
                'region' => 'Region XI',
                'regions' => '11',
                'province' => '1102300000',
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'citizenship' => 'philippine',
            ]);

            $this->adviceForm->fill([
                'region' => 'Region XI',
                'regions' => '11',
                'province' => '1102300000',
                'newAOL_type' => 'Affidavit',
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'citizenship' => 'philippine',
            ]);
        }
    }

    public function autoFill()
    {
        $this->isAutoFill = true;
        $this->initializeForms();
    }

    protected function getForms(): array
    {
        return [
            'adviceForm',
            'notarizeForm',
            'previewAdviceForm',
            'previewNotarizeForm',
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
                            DatePicker::make('date')
                                ->label('Petsa')
                                ->required(),
                            TextInput::make('assignTo')
                                ->label('Ini-atas kay')
                                ->required(),
                            TextInput::make('control_no')
                                ->label('Control No.')
                                ->disabled()
                                ->numeric(),
                            Fieldset::make('')
                                ->schema([
                                    Checkbox::make('isServiceCheck')
                                        ->live()
                                        ->label('Ibinigay na serbisyong-legal')
                                        ->columnSpanFull(),
                                    TextInput::make('isServiceInput')
                                        ->disabled(function (Get $get) {
                                            return ! $get('isServiceCheck');
                                        })
                                        ->label('')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                            TextInput::make('mananayam')
                                ->label('Mananayam'),
                            Fieldset::make('')
                                ->schema([
                                    Checkbox::make('isOthersCheck')
                                        ->live()
                                        ->label('Iba pa')
                                        ->columnSpanFull(),
                                    TextInput::make('isOthersInput')
                                        ->disabled(function (Get $get) {
                                            return ! $get('isOthersCheck');
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
                                        ->label('Legal Documentation')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('adminOath', false);
                                                $set('courtRep', false);
                                                $set('inquest', false);
                                                $set('mediation', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Checkbox::make('adminOath')
                                        ->label('Administration of Oath')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('legalDoc', false);
                                                $set('courtRep', false);
                                                $set('inquest', false);
                                                $set('mediation', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Checkbox::make('courtRep')
                                        ->label('Representasyon sa Korte o ibang Tanggapin')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('legalDoc', false);
                                                $set('adminOath', false);
                                                $set('inquest', false);
                                                $set('mediation', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Checkbox::make('inquest')
                                        ->label('Inquest Legal Assistance')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('legalDoc', false);
                                                $set('adminOath', false);
                                                $set('courtRep', false);
                                                $set('mediation', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Checkbox::make('mediation')
                                        ->label('Mediation/Concilliation')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('legalDoc', false);
                                                $set('adminOath', false);
                                                $set('courtRep', false);
                                                $set('inquest', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Fieldset::make('')
                                        ->schema([
                                            Checkbox::make('isOthers2Check')
                                                ->live()
                                                ->reactive()
                                                ->label('Iba pa')
                                                ->afterStateUpdated(function (callable $set, $state) {
                                                    if ($state) {
                                                        $set('legalDoc', false);
                                                        $set('adminOath', false);
                                                        $set('courtRep', false);
                                                        $set('inquest', false);
                                                        $set('mediation', false);
                                                    }
                                                }),
                                            TextInput::make('isOthers2Input')
                                                ->disabled(function (Get $get) {
                                                    return ! $get('isOthers2Check');
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
                            TextInput::make('name')
                                ->label('Pangalan')
                                ->required(),
                            Fieldset::make('')
                                ->schema([
                                    TextInput::make('age')
                                        ->numeric()
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
                                        ->required()
                                        ->options(function () {
                                            return DB::table('regions')->pluck('name', 'region_id');
                                        }),
                                    Select::make('province')->required()
                                        ->required()
                                        ->options(function () {
                                            return DB::table('provinces')->pluck('name', 'code');
                                        }),
                                    TextInput::make('city')->required(),
                                    TextInput::make('barangay')->required(),
                                    // Select::make('city')->required()
                                    //     ->preload()
                                    //     ->required()
                                    //     ->options(function () {
                                    //         return DB::table('cities')->pluck('name', 'code');
                                    //     }),
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
                                ->tel()->telRegex('/^(0|63)\d{10}$/')
                                ->label('Contact Number')
                                ->required(),
                            TextInput::make('email')
                                ->required(),
                            TextInput::make('asawa')
                                ->label('Asawa'),
                            TextInput::make('income')
                                ->numeric()
                                ->label('Individual Monthly Income')
                                ->required(),
                            TextInput::make('asawaAddress')
                                ->label('Tirahan ng asawa'),
                            Radio::make('nakakulong')
                                ->required()
                                ->live()
                                ->options([
                                    true => 'Oo',
                                    false => 'Hindi',
                                ])
                                ->default('false')
                                ->label('Nakakulong')
                                ->inline(),
                            TextInput::make('contactNumberAsawa')
                                ->label('Contact Number ng asawa')
                                ->tel()->telRegex('/^(0|63)\d{10}$/'),
                            DatePicker::make('dateofKulong')
                                ->label('Petsa ng pagkakulong')
                                ->disabled(function (Get $get) {
                                    return $get('nakakulong') === false;
                                }),
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
                            FieldSet::make('Select Option')
                                ->schema([
                                    Checkbox::make('card1')
                                        ->dehydrated(false)
                                        ->live()
                                        ->label('II-A. IMPORMASYON UKOL SA REPRESENTATIVE (Pupunan kung wala ang aplikante)'),
                                    Checkbox::make('card2')
                                        ->dehydrated(false)
                                        ->live()
                                        ->label('III. URI NG KASO'),
                                    Checkbox::make('card3')
                                        ->dehydrated(false)
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
                                        ->tel()->telRegex('/^(0|63)\d{10}$/'),
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
                        DatePicker::make('date')
                            ->label('Petsa')
                            ->required(),
                        TextInput::make('assignTo')
                            ->label('Ini-atas kay')
                            ->required(),
                        TextInput::make('control_no')
                            ->label('Control No.')
                            ->disabled()
                            ->numeric(),
                        Fieldset::make('')
                            ->schema([
                                Checkbox::make('isServiceCheck')
                                    ->live()
                                    ->label('Ibinigay na serbisyong-legal')
                                    ->columnSpanFull(),
                                TextInput::make('isServiceInput')
                                    ->disabled(function (Get $get) {
                                        return ! $get('isServiceCheck');
                                    })
                                    ->label('')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                        TextInput::make('mananayam')
                            ->label('Mananayam'),
                        Fieldset::make('')
                            ->schema([
                                Checkbox::make('isOthersCheck')
                                    ->live()
                                    ->label('Iba pa')
                                    ->columnSpanFull(),
                                TextInput::make('isOthersInput')
                                    ->disabled(function (Get $get) {
                                        return ! $get('isOthersCheck');
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
                                    ->label('Legal Documentation')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('adminOath', false);
                                            $set('courtRep', false);
                                            $set('inquest', false);
                                            $set('mediation', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Checkbox::make('adminOath')
                                    ->label('Administration of Oath')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('legalDoc', false);
                                            $set('courtRep', false);
                                            $set('inquest', false);
                                            $set('mediation', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Checkbox::make('courtRep')
                                    ->label('Representasyon sa Korte o ibang Tanggapin')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('legalDoc', false);
                                            $set('adminOath', false);
                                            $set('inquest', false);
                                            $set('mediation', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Checkbox::make('inquest')
                                    ->label('Inquest Legal Assistance')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('legalDoc', false);
                                            $set('adminOath', false);
                                            $set('courtRep', false);
                                            $set('mediation', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Checkbox::make('mediation')
                                    ->label('Mediation/Concilliation')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('legalDoc', false);
                                            $set('adminOath', false);
                                            $set('courtRep', false);
                                            $set('inquest', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Fieldset::make('')
                                    ->schema([
                                        Checkbox::make('isOthers2Check')
                                            ->live()
                                            ->reactive()
                                            ->label('Iba pa')
                                            ->afterStateUpdated(function (callable $set, $state) {
                                                if ($state) {
                                                    $set('legalDoc', false);
                                                    $set('adminOath', false);
                                                    $set('courtRep', false);
                                                    $set('inquest', false);
                                                    $set('mediation', false);
                                                }
                                            }),
                                        TextInput::make('isOthers2Input')
                                            ->disabled(function (Get $get) {
                                                return ! $get('isOthers2Check');
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
                        TextInput::make('name')
                            ->label('Pangalan')
                            ->required(),
                        Fieldset::make('')
                            ->schema([
                                TextInput::make('age')
                                    ->numeric()
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
                                TextInput::make('city')->required(),
                                TextInput::make('barangay')->required(),
                                // Select::make('city')->required()
                                //     ->preload()
                                //     ->required()
                                //     ->options(function () {
                                //         return DB::table('cities')->pluck('name', 'code');
                                //     }),
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
                            ->tel()->telRegex('/^(0|63)\d{10}$/')
                            ->label('Contact Number')
                            ->required(),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('asawa')
                            ->label('Asawa'),
                        TextInput::make('income')
                            ->numeric()
                            ->label('Individual Monthly Income')
                            ->required(),
                        TextInput::make('asawaAddress')
                            ->label('Tirahan ng asawa'),
                        Radio::make('nakakulong')
                            ->required()
                            ->live()
                            ->options([
                                true => 'Oo',
                                false => 'Hindi',
                            ])
                            ->default('false')
                            ->label('Nakakulong')
                            ->inline(),
                        TextInput::make('contactNumberAsawa')
                            ->label('Contact Number ng asawa')
                            ->tel()->telRegex('/^(0|63)\d{10}$/'),
                        DatePicker::make('dateofKulong')
                            ->label('Petsa ng pagkakulong')
                            ->disabled(function (Get $get) {
                                return $get('nakakulong') === false;
                            }),
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
                FieldSet::make('Select Option')
                    ->schema([
                        Checkbox::make('card1')
                            ->dehydrated(false)
                            ->live()
                            ->label('II-A. IMPORMASYON UKOL SA REPRESENTATIVE (Pupunan kung wala ang aplikante)'),
                        Checkbox::make('card2')
                            ->dehydrated(false)
                            ->live()
                            ->label('III. URI NG KASO'),
                        Checkbox::make('card3')
                            ->dehydrated(false)
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
                            ->tel()->telRegex('/^(0|63)\d{10}$/'),
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

        $this->dispatch('open-modal', id: 'preview-advice');
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
                                ->label('Ini-refer ni/Inindorso ng'),
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
                            DatePicker::make('date')
                                ->label('Petsa')
                                ->required(),
                            TextInput::make('assignTo')
                                ->label('Ini-atas kay'),
                            TextInput::make('control_no')
                                ->label('Control No.')
                                ->disabled()
                                ->numeric(),
                            Fieldset::make('')
                                ->schema([
                                    Checkbox::make('isServiceCheck')
                                        ->live()
                                        ->label('Ibinigay na serbisyong-legal')
                                        ->columnSpanFull(),
                                    TextInput::make('isServiceInput')
                                        ->disabled(function (Get $get) {
                                            return ! $get('isServiceCheck');
                                        })
                                        ->label('')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                            TextInput::make('mananayam')
                                ->label('Mananayam'),
                            Fieldset::make('')
                                ->schema([
                                    Checkbox::make('isOthersCheck')
                                        ->live()
                                        ->label('Iba pa')
                                        ->columnSpanFull(),
                                    TextInput::make('isOthersInput')
                                        ->disabled(function (Get $get) {
                                            return ! $get('isOthersCheck');
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
                                        ->label('Legal Documentation')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('adminOath', false);
                                                $set('courtRep', false);
                                                $set('inquest', false);
                                                $set('mediation', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Checkbox::make('adminOath')
                                        ->label('Administration of Oath')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('legalDoc', false);
                                                $set('courtRep', false);
                                                $set('inquest', false);
                                                $set('mediation', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Checkbox::make('courtRep')
                                        ->label('Representasyon sa Korte o ibang Tanggapin')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('legalDoc', false);
                                                $set('adminOath', false);
                                                $set('inquest', false);
                                                $set('mediation', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Checkbox::make('inquest')
                                        ->label('Inquest Legal Assistance')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('legalDoc', false);
                                                $set('adminOath', false);
                                                $set('courtRep', false);
                                                $set('mediation', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Checkbox::make('mediation')
                                        ->label('Mediation/Concilliation')
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state) {
                                            if ($state) {
                                                $set('legalDoc', false);
                                                $set('adminOath', false);
                                                $set('courtRep', false);
                                                $set('inquest', false);
                                                $set('isOthers2Check', false);
                                            }
                                        }),
                                    Fieldset::make('')
                                        ->schema([
                                            Checkbox::make('isOthers2Check')
                                                ->live()
                                                ->reactive()
                                                ->label('Iba pa')
                                                ->afterStateUpdated(function (callable $set, $state) {
                                                    if ($state) {
                                                        $set('legalDoc', false);
                                                        $set('adminOath', false);
                                                        $set('courtRep', false);
                                                        $set('inquest', false);
                                                        $set('mediation', false);
                                                    }
                                                }),
                                            TextInput::make('isOthers2Input')
                                                ->disabled(function (Get $get) {
                                                    return ! $get('isOthers2Check');
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
                            TextInput::make('name')
                                ->label('Pangalan')
                                ->required(),
                            Fieldset::make('')
                                ->schema([
                                    TextInput::make('age')
                                        ->numeric()
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
                                    TextInput::make('city')->required(),
                                    TextInput::make('barangay')->required(),
                                    // Select::make('city')->required()
                                    //     ->preload()
                                    //     ->required()
                                    //     ->options(function () {
                                    //         return DB::table('cities')->pluck('name', 'code');
                                    //     }),
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
                                ->tel()->telRegex('/^(0|63)\d{10}$/')
                                ->label('Contact Number')
                                ->required(),
                            TextInput::make('email')
                                ->required(),
                            TextInput::make('asawa')
                                ->label('Asawa'),
                            TextInput::make('income')
                                ->numeric()
                                ->label('Individual Monthly Income')
                                ->required(),
                            TextInput::make('asawaAddress')
                                ->label('Tirahan ng asawa'),
                            Radio::make('nakakulong')
                                ->required()
                                ->live()
                                ->options([
                                    true => 'Oo',
                                    false => 'Hindi',
                                ])
                                ->default('false')
                                ->label('Nakakulong')
                                ->inline(),
                            TextInput::make('contactNumberAsawa')
                                ->label('Contact Number ng asawa')
                                ->tel()->telRegex('/^(0|63)\d{10}$/'),
                            DatePicker::make('dateofKulong')
                                ->label('Petsa ng pagkakulong')
                                ->disabled(function (Get $get) {
                                    return $get('nakakulong') === false;
                                }),
                            Select::make('dPlace')
                                ->label('Lugar ng Detention')
                                ->options([
                                    'Dujali Police Station' => 'Dujali Police Station',
                                    'BJMP Panabo' => 'BJMP Panabo',
                                    'PNP, Sto. Tomas' => 'PNP, Sto. Tomas',
                                    'PNP, Carmen' => 'PNP, Carmen',
                                    'BJMP Peñaplata' => 'BJMP Peñaplata',
                                    'Igacos' => 'Igacos',
                                ]),
                        ])
                        ->columns(2),
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
                    Wizard\Step::make('AOL')
                        ->schema([
                            Select::make('id_type')
                                ->dehydrated()
                                ->searchable()
                                ->label('ID Presented')
                                ->options(IDType::pluck('description', 'name'))
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label('New ID Type') // Optional: Label for clarity
                                        ->required()
                                        ->unique(IDType::class, 'name'),
                                ])
                                ->createOptionUsing(function ($data) {
                                    IDType::create([
                                        'name' => $data['name'],
                                        'description' => $data['name'],
                                    ]);

                                    return $data['name'];
                                }),
                            Select::make('aol_type')
                                ->dehydrated()
                                ->label('Affidavit of Loss')
                                ->live()
                                ->options([
                                    'affidavit_loss' => 'Affidavit of Loss',
                                    'qr_code' => 'QR Code',
                                    'id' => 'I.D',
                                    'id_philippine' => 'I.D/Philippine I.D',
                                    'atm_passbook' => 'ATM/Passbook/Cash Card',
                                    'documents' => 'Document/s',
                                    'prof_nonprof_drivers_license' => 'Prof/Non-Prof Driver\'s License',
                                    'lost_items_documents' => 'Lost Item/s Document/s',
                                    'new_type' => 'New Type',
                                ]),
                            TextInput::make('id_number'),
                            Select::make('stuDEmp')
                                ->label('Student/Employee')
                                ->options([
                                    'student' => 'Student',
                                    'employee' => 'Employee',
                                ])
                                ->visible(function (Get $get) {
                                    return in_array($get('aol_type'), ['affidavit_loss', 'id', 'documents']);
                                }),
                            TextInput::make('documentTypeAOL')
                                ->visible(function (Get $get) {
                                    if (in_array($get('aol_type'), ['prof_nonprof_drivers_license', 'atm_passbook', 'id_philippine'])) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                })
                                ->label('Document Type'),
                            Textarea::make('issuedByAOL')
                                ->visible(function (Get $get) {
                                    if (in_array($get('aol_type'), ['prof_nonprof_drivers_license', 'atm_passbook', 'id_philippine'])) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                })
                                ->label('Issued By'),
                            TextInput::make('newAOL_type')
                                ->label('Affidavit Name')
                                ->columnSpanFull()
                                ->visible(function (Get $get) {
                                    return $get('aol_type') == 'new_type';
                                }),
                            Repeater::make('statements')
                                ->reorderable(true)
                                ->addActionLabel('Add Statement')
                                ->label('Statements')
                                ->simple(
                                    Textarea::make('statement')->required(),
                                )
                                ->columns(1)
                                ->default([
                                    'statement' => 'test',
                                ])
                                ->columnSpanFull()
                                ->visible(function (Get $get) {
                                    return $get('aol_type') == 'new_type';
                                }),
                        ])->columns(2),
                ])
                    ->submitAction(view('filament.forms.notarizeFormButton')),
            ])
            ->statePath('notarizeData');
    }

    public function previewNotarizeForm(Form $form): Form
    {
        return $form
            ->schema([
                FieldSet::make('')
                    ->label('Para sa Serbisyong-Legal at/o Representasyon')
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
                            ->label('Ini-refer ni/Inindorso ng'),
                        TextInput::make('district_office')
                            ->label('District Office'),
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
                        DatePicker::make('date')
                            ->label('Petsa')
                            ->required(),
                        TextInput::make('assignTo')
                            ->label('Ini-atas kay'),
                        TextInput::make('control_no')
                            ->label('Control No.')
                            ->disabled()
                            ->numeric(),
                        Fieldset::make('')
                            ->schema([
                                Checkbox::make('isServiceCheck')
                                    ->live()
                                    ->label('Ibinigay na serbisyong-legal')
                                    ->columnSpanFull(),
                                TextInput::make('isServiceInput')
                                    ->disabled(function (Get $get) {
                                        return ! $get('isServiceCheck');
                                    })
                                    ->label('')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                        TextInput::make('mananayam')
                            ->label('Mananayam'),
                        Fieldset::make('')
                            ->schema([
                                Checkbox::make('isOthersCheck')
                                    ->live()
                                    ->label('Iba pa')
                                    ->columnSpanFull(),
                                TextInput::make('isOthersInput')
                                    ->disabled(function (Get $get) {
                                        return ! $get('isOthersCheck');
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
                                    ->label('Legal Documentation')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('adminOath', false);
                                            $set('courtRep', false);
                                            $set('inquest', false);
                                            $set('mediation', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Checkbox::make('adminOath')
                                    ->label('Administration of Oath')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('legalDoc', false);
                                            $set('courtRep', false);
                                            $set('inquest', false);
                                            $set('mediation', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Checkbox::make('courtRep')
                                    ->label('Representasyon sa Korte o ibang Tanggapin')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('legalDoc', false);
                                            $set('adminOath', false);
                                            $set('inquest', false);
                                            $set('mediation', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Checkbox::make('inquest')
                                    ->label('Inquest Legal Assistance')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('legalDoc', false);
                                            $set('adminOath', false);
                                            $set('courtRep', false);
                                            $set('mediation', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Checkbox::make('mediation')
                                    ->label('Mediation/Concilliation')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('legalDoc', false);
                                            $set('adminOath', false);
                                            $set('courtRep', false);
                                            $set('inquest', false);
                                            $set('isOthers2Check', false);
                                        }
                                    }),
                                Fieldset::make('')
                                    ->schema([
                                        Checkbox::make('isOthers2Check')
                                            ->live()
                                            ->reactive()
                                            ->label('Iba pa')
                                            ->afterStateUpdated(function (callable $set, $state) {
                                                if ($state) {
                                                    $set('legalDoc', false);
                                                    $set('adminOath', false);
                                                    $set('courtRep', false);
                                                    $set('inquest', false);
                                                    $set('mediation', false);
                                                }
                                            }),
                                        TextInput::make('isOthers2Input')
                                            ->disabled(function (Get $get) {
                                                return ! $get('isOthers2Check');
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
                        TextInput::make('name')
                            ->label('Pangalan')
                            ->required(),
                        Fieldset::make('')
                            ->schema([
                                TextInput::make('age')
                                    ->numeric()
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
                                TextInput::make('city')->required(),
                                TextInput::make('barangay')->required(),
                                // Select::make('city')->required()
                                //     ->preload()
                                //     ->required()
                                //     ->options(function () {
                                //         return DB::table('cities')->pluck('name', 'code');
                                //     }),
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
                            ->tel()->telRegex('/^(0|63)\d{10}$/')
                            ->label('Contact Number')
                            ->required(),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('asawa')
                            ->label('Asawa'),
                        TextInput::make('income')
                            ->numeric()
                            ->label('Individual Monthly Income')
                            ->required(),
                        TextInput::make('asawaAddress')
                            ->label('Tirahan ng asawa'),
                        Radio::make('nakakulong')
                            ->required()
                            ->live()
                            ->options([
                                true => 'Oo',
                                false => 'Hindi',
                            ])
                            ->default('false')
                            ->label('Nakakulong')
                            ->inline(),
                        TextInput::make('contactNumberAsawa')
                            ->label('Contact Number ng asawa')
                            ->tel()->telRegex('/^(0|63)\d{10}$/'),
                        DatePicker::make('dateofKulong')
                            ->label('Petsa ng pagkakulong')
                            ->disabled(function (Get $get) {
                                return $get('nakakulong') === false;
                            }),
                        Select::make('dPlace')
                            ->label('Lugar ng Detention')
                            ->options([
                                'Dujali Police Station' => 'Dujali Police Station',
                                'BJMP Panabo' => 'BJMP Panabo',
                                'PNP, Sto. Tomas' => 'PNP, Sto. Tomas',
                                'PNP, Carmen' => 'PNP, Carmen',
                                'BJMP Peñaplata' => 'BJMP Peñaplata',
                                'Igacos' => 'Igacos',
                            ]),
                    ])
                    ->columns(2),
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
            ])
            ->statePath('dummyNotarizeData');
    }

    public function previewNotarizeData()
    {
        $this->previewNotarizeForm->fill(
            $this->notarizeData,
        );

        $this->dispatch('open-modal', id: 'preview-notarize');
    }

    public function downloadAol()
    {
        if ($this->notarizeData['id_type'] == null || $this->notarizeData['aol_type'] == null || $this->notarizeData['id_number'] == null) {
            Notification::make()
                ->title('Please Select fill up to Download AOL')
                ->warning()
                ->send();
        } else {
            $view = '';

            switch ($this->notarizeData['aol_type']) {
                case 'affidavit_loss':
                    $view = 'AOL';
                    break;

                case 'qr_code':
                    $view = 'QRCode';
                    break;

                case 'id':
                    $view = 'ID';
                    break;

                case 'id_philippine':
                    $view = 'PhilippineID';
                    break;

                case 'atm_passbook':
                    $view = 'ATMPASSBOOK';
                    break;

                case 'documents':
                    $view = 'Document';
                    break;

                case 'prof_nonprof_drivers_license':
                    $view = 'License';
                    break;

                case 'lost_items_documents':
                    $view = 'LostItem';
                    break;

                case 'new_type':
                    $view = 'newAOL';
                    break;
            }

            $date = Carbon::now(); // Or any date, e.g., Carbon::parse('2024-11-23')

            $formattedDate = $date->format('jS').' day of '.$date->format('F Y');

            $data = array_column($this->notarizeData['statements'], 'statement');
            // $data[] =>
            $data[] = 'That I am executing this affidavit in order to inform the authorities concerned of the veracity of the forgoing facts and for whatever legal purpose it may serve.';

            $pdf = \PDF::loadView('pdf.'.$view, [
                'age' => $this->notarizeData['age'],
                'civilStatus' => $this->notarizeData['civilStatus'],
                'stuDEmp' => $this->notarizeData['stuDEmp'],
                'documentTypeAOL' => $this->notarizeData['documentTypeAOL'],
                'issuedByAOL' => $this->notarizeData['issuedByAOL'],
                'newAOL_type' => $this->notarizeData['newAOL_type'] ?? null,
                'statements' => $data ?? null,
                //
                'name' => $this->notarizeData['name'],
                'idType' => $this->handleIDType($this->notarizeData['id_type']) ?? $this->notarizeData['id_type'],
                'id_number' => $this->notarizeData['id_number'],
                'formattedDate' => $formattedDate,
                'address' => $this->notarizeData['barangay'].', '.$this->notarizeData['city'].', '.$this->handleTypeProvince($this->notarizeData['province']),
            ])->setPaper('legal');

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, ucfirst($this->notarizeData['aol_type']).'-'.now()->format('Y-m-d h:i:s').'.pdf');
        }
    }

    public function handleIDType($idType)
    {
        $idTypes = [
            'passport' => 'Passport',
            'drivers_license' => 'Driver\'s License',
            'prc_license' => 'PRC License',
            'umid' => 'UMID',
            'postal_id' => 'Postal ID',
            'voters_id' => 'Voter\'s ID ',
            'philhealth' => 'PhilHealth',
            'pagibig' => 'Pag-IBIG ID',
            'barangay_cert' => 'Barangay Certification',
            'sss_id' => 'SSS ID',
            'senior_citizen' => 'Senior Citizen ID',
            'pwd_id' => 'PWD ID',
        ];

        if (array_key_exists($idType, $idTypes)) {
            return $idTypes[$idType];
        }

        return null;
    }

    public function handleTypeProvince($code)
    {
        return DB::table('provinces')->where('code', $code)->first()->name;
    }

    public function saveAdviceForm()
    {
        $user = [
            'user_id' => auth()->user()->id,
            'doc_type' => 'advice',
            'status' => 'pending',
        ];
        $data = array_merge($this->previewAdviceForm->getState(), $user);

        $interViewSheet = ModelsInterViewSheet::create($data);

        Notification::make()
            ->title('Advice Saved')
            ->body('View your request to my request tab and wait for the staff to approved your request , it will show to your notification bell once approved ')
            ->success()
            ->send();

        redirect('/app/interview-sheet');
    }

    public function saveNotarizeForm()
    {
        $statments = array_column($this->notarizeData['statements'], 'statement');
        // $data[] =>
        $statments[] = 'That I am executing this affidavit in order to inform the authorities concerned of the veracity of the forgoing facts and for whatever legal purpose it may serve.';

        $user = [
            'status' => 'pending',
            'user_id' => auth()->user()->id,
            'doc_type' => 'notarize',
            'id_type' => $this->notarizeData['id_type'],
            'aol_type' => $this->notarizeData['aol_type'],
            'id_number' => $this->notarizeData['id_number'],
            'stuDEmp' => $this->notarizeData['stuDEmp'],
            'documentTypeAOL' => $this->notarizeData['documentTypeAOL'],
            'issuedByAOL' => $this->notarizeData['issuedByAOL'],
            'statements' => $statments,
            'newAOL_type' => $this->notarizeData['newAOL_type'],
        ];
        $data = array_merge($this->previewNotarizeForm->getState(), $user);

        $interViewSheet = ModelsInterViewSheet::create($data);

        Notification::make()
            ->title('Notarize Saved')
            ->body('View your request to my request tab and wait for the staff to approved your request , it will show to your notification bell once approved ')
            ->success()
            ->send();

        redirect('/app/interview-sheet');
    }
}

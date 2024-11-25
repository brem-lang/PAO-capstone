<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Client extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.client';

    protected static ?int $navigationSort = 2;

    public array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name'),
                        TextInput::make('email'),
                        Select::make('gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ]),
                        TextInput::make('number')->tel()->telRegex('/^(0|63)\d{10}$/'),
                        DatePicker::make('birthday'),
                        TextInput::make('age'),
                        Select::make('religion')
                            ->options([
                                'rc' => 'Roman Catholic',
                                'islam' => 'Islam',
                                'iglesia' => 'Iglesia ni Cristo',
                                'sda' => 'Seventh Day Adventist',
                                'bible_bap' => 'Bible Baptist Church',
                                'jehovah' => "Jehovah's Witness",
                                'others' => 'Others',
                            ]),
                        Select::make('citizenship')
                            ->searchable()
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
                            ]),
                        Select::make('civil_status')
                            ->label('Civil Status')
                            ->options([
                                'Single' => 'Single',
                                'Married' => 'Married',
                                'Widowed' => 'Widowed',
                                'Divorced' => 'Divorced',
                                'Separated' => 'Separated',
                            ]),
                        TextInput::make('address'),
                        Select::make('region')
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
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::where('role', 'client')->latest())
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('gender')
                    ->searchable(),
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ViewAction::make()
                    ->form(fn (Form $form) => $this->form($form)),
                EditAction::make()
                    ->form(fn (Form $form) => $this->form($form)),
                DeleteAction::make(),
            ])
            ->bulkActions([
                // ...
            ]);
    }
}

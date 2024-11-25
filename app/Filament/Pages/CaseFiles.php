<?php

namespace App\Filament\Pages;

use App\Models\Transaction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CaseFiles extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static string $view = 'filament.pages.case-files';

    protected static ?int $navigationSort = 4;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('item_no')
                            ->label('Item No')

                            ->maxLength(255),
                        TextInput::make('control_no')
                            ->label('Control No')

                            ->maxLength(255),
                        Select::make('party_represented')
                            ->label('Party Represented')

                            ->options([
                                'accused' => 'Accused',
                                'respondents' => 'Respondents',
                                'defendants' => 'Defendants',
                                'petitioner' => 'Petitioner',
                                'plaintiff' => 'Plaintiff',
                            ]),
                        Select::make('gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ])

                            ->label('Gender'),
                        TextInput::make('title_of_case')

                            ->maxLength(255),
                        Select::make('court_body')
                            ->label('Court/Body')

                            ->options([
                                'RTC 34' => 'RTC 34',
                                'RTC 4' => 'RTC 4',
                                'RTC 3' => 'RTC 3',
                                'MTCC' => 'MTCC',
                                'MCTC-CARMEN' => 'MCTC-CARMEN',
                                'MCTC STO. TOMAS' => 'MCTC STO. TOMAS',
                            ]),
                        Select::make('case_type')
                            ->label('Type of Case')

                            ->options([
                                'Criminal' => 'Criminal',
                                'Administrative' => 'Administrative',
                                'Civil' => 'Civil',
                                'Appealed' => 'Appealed',
                                'Labor' => 'Labor',
                            ]),
                        TextInput::make('case_no')

                            ->maxLength(255),
                        Select::make('last_action_taken')
                            ->label('Last Action Taken')
                            ->placeholder('Last Action Taken') // Placeholder text
                            ->options([
                                'Plea bargained' => 'Plea bargained',
                                'Warrant of arrest' => 'Warrant of arrest',
                                'Applied probation' => 'Applied probation',
                                'Comp. agreement' => 'Comp. agreement',
                                'Arraign. / prom' => 'Arraign. / prom',
                                'Trial' => 'Trial',
                                'Arraignment' => 'Arraignment',
                                'Desistance' => 'Desistance',
                                'Pre-trial' => 'Pre-trial',
                                'Manifestation' => 'Manifestation',
                                'Disp. measures' => 'Disp. measures',
                                'Trial / prom.' => 'Trial / prom.',
                                'Affidavit Desist.' => 'Affidavit Desist.',
                                'Released bail' => 'Released bail',
                                'Motion to release' => 'Motion to release',
                                'Arraigned' => 'Arraigned',
                                'Hearing' => 'Hearing',
                                'Failed JDR' => 'Failed JDR',
                                'Judicial Affidavit' => 'Judicial Affidavit',
                                'Compromise agreement' => 'Compromise agreement',
                                'Assisted in inquest proc.' => 'Assisted in inquest proc.',
                                'Motion for reconsideration' => 'Motion for reconsideration',
                            ]),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'resolved' => 'Resolved',
                                'terminated' => 'Terminated',
                            ])
                            ->label('Status'),
                        DatePicker::make('case_received'),
                        DatePicker::make('date_of_termination'),
                        Select::make('cause_of_action')
                            ->label('Cause of Action')
                            ->options([
                                'Violation of Sec. 5 of RA 9165' => 'Violation of Sec. 5 of RA 9165',
                                'Violation of Sec. 11 of RA 9165' => 'Violation of Sec. 11 of RA 9165',
                                'Violation of Sec. 12 of RA 9165' => 'Violation of Sec. 12 of RA 9165',
                                'Violation of RA 10591' => 'Violation of RA 10591',
                                'Violation of Sec. 6 of RA 9165' => 'Violation of Sec. 6 of RA 9165',
                                'Violation of Sec. 14 of RA 9165' => 'Violation of Sec. 14 of RA 9165',
                                'Violation of RA 9165' => 'Violation of RA 9165',
                                'Violation of PD 1866' => 'Violation of PD 1866',
                                'Violation of RA 9262' => 'Violation of RA 9262',
                                'Attempted Homicide' => 'Attempted Homicide',
                                'Theft' => 'Theft',
                                'Arson' => 'Arson',
                                'Malicious Mischief' => 'Malicious Mischief',
                                'Less Serious Physical Injuries' => 'Less Serious Physical Injuries',
                                'Malversation of Public Funds' => 'Malversation of Public Funds',
                                'Frustrated Murder' => 'Frustrated Murder',
                                'Violation of RA 9287' => 'Violation of RA 9287',
                                'Robbery' => 'Robbery',
                                'Rape' => 'Rape',
                                'Violation of RA 7610' => 'Violation of RA 7610',
                                'Violation of RA 9287 by RA 9262' => 'Violation of RA 9287 by RA 9262',
                                'Grave Threats' => 'Grave Threats',
                                'Qualified Trafficking,etc.' => 'Qualified Trafficking,etc.',
                                'Violation of RA 9775, etc.' => 'Violation of RA 9775, etc.',
                                'Violation of RA 7610 by RA 9231' => 'Violation of RA 7610 by RA 9231',
                                'Viol. Of Comelec Resolution' => 'Viol. Of Comelec Resolution',
                                'Estafa' => 'Estafa',
                                'Homicide' => 'Homicide',
                                'Murder' => 'Murder',
                                'BL' => 'BL',
                                'Qualified Theft' => 'Qualified Theft',
                                'Acts of Lasc. In Rel to RA 7610' => 'Acts of Lasc. In Rel to RA 7610',
                                'Violation of RA 6539' => 'Violation of RA 6539',
                                'Violation of Sec. 3 of RA 9287' => 'Violation of Sec. 3 of RA 9287',
                                'Statutory Rape' => 'Statutory Rape',
                                'Rape by Sexual Assault' => 'Rape by Sexual Assault',
                                'Illegal Poss. Of Firearms' => 'Illegal Poss. Of Firearms',
                                'Simple Theft' => 'Simple Theft',
                                'Violation of Art. 212 RPC' => 'Violation of Art. 212 RPC',
                                'Robbery with Homicide' => 'Robbery with Homicide',
                                'Reckless Imprudence,etc.' => 'Reckless Imprudence,etc.',
                                'Robbery in an Inhabited Place' => 'Robbery in an Inhabited Place',
                                'Parricide' => 'Parricide',
                                'Qualified Trafficking,etc.' => 'Qualified Trafficking,etc.',
                                'Grave Misconduct' => 'Grave Misconduct',
                                'Viol. Of Sec. 3 of RA 3019' => 'Viol. Of Sec. 3 of RA 3019',
                                'Viol. Of Art. 266 of RPC' => 'Viol. Of Art. 266 of RPC',
                                'Misconduct and Abuse of Authority' => 'Misconduct and Abuse of Authority',
                                'Simple Misconduct' => 'Simple Misconduct',
                            ]),
                        Select::make('cause_of_termination')
                            ->label('Cause of Termination')

                            ->options([
                                'Acquitted' => 'Acquitted',
                                'Dismissed with prejudice' => 'Dismissed with prejudice',
                                'Motion to quash granted' => 'Motion to quash granted',
                                'Demurrer to evidence granted' => 'Demurrer to evidence granted',
                                'Provisionally dismissed' => 'Provisionally dismissed',
                                'Convicted to lesser offense' => 'Convicted to lesser offense',
                                'Probation granted' => 'Probation granted',
                                'Won (civil, labor, and administrative)' => 'Won (civil, labor, and administrative)',
                                'Granted lesser award (civil, administrative & labor)' => 'Granted lesser award (civil, administrative & labor)',
                                'Dismissed cases based on compromise agreement (civil & labor)' => 'Dismissed cases based on compromise agreement (civil & labor)',
                                'Favorable Criminal cases for preliminary investigation' => 'Favorable Criminal cases for preliminary investigation',
                                'Pre-trial releases and other dispositions' => 'Pre-trial releases and other dispositions',
                                'Convicted as charged' => 'Convicted as charged',
                                'Lost (civil, administrative & labor)' => 'Lost (civil, administrative & labor)',
                                'Dismissed (civil, administrative & labor)' => 'Dismissed (civil, administrative & labor)',
                                'Unfavorable Criminal cases for preliminary investigation' => 'Unfavorable Criminal cases for preliminary investigation',
                                'Archived' => 'Archived',
                                'Withdrawn' => 'Withdrawn',
                                'Transferred to private lawyer/IBP/etc.' => 'Transferred to private lawyer/IBP/etc.',
                            ]),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaction::latest())
            ->columns([
                TextColumn::make('item_no')
                    ->label('Item No')
                    ->searchable(),
                TextColumn::make('control_no')
                    ->label('Control No')
                    ->searchable(),
                TextColumn::make('title_of_case')
                    ->label('Title of Case')
                    ->searchable(),
                TextColumn::make('case_no')
                    ->label('Case No')
                    ->searchable(),
                TextColumn::make('court_body')
                    ->label('Court/Body')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'resolved' => 'success',
                        'terminated' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->date('F d, Y h:i A')->timezone('Asia/Manila')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('court_body')
                    ->options([
                        'RTC 34' => 'RTC 34',
                        'RTC 4' => 'RTC 4',
                        'RTC 3' => 'RTC 3',
                        'MTCC' => 'MTCC',
                        'MCTC-CARMEN' => 'MCTC-CARMEN',
                        'MCTC STO. TOMAS' => 'MCTC STO. TOMAS',
                    ]),
                SelectFilter::make('case_type')
                    ->options([
                        'Criminal' => 'Criminal',
                        'Administrative' => 'Administrative',
                        'Civil' => 'Civil',
                        'Appealed' => 'Appealed',
                        'Labor' => 'Labor',
                    ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                ViewAction::make()
                    ->form(fn (Form $form) => $this->form($form)),
            ])
            ->persistFiltersInSession()
            ->filtersFormColumns(3)
            ->bulkActions([
                // ...
            ]);
    }
}

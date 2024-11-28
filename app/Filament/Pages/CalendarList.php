<?php

namespace App\Filament\Pages;

use App\Models\CalendarEvents;
use App\Models\User;
use App\Services\EmailSender;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CalendarList extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static string $view = 'filament.pages.calendar-list';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Calendar';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return ! auth()->user()->isClient();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->options(User::where('role', 'client')->pluck('name', 'id')),
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),
                        Textarea::make('description')
                            ->label('Description')
                            ->required(),
                        DateTimePicker::make('startDate')
                            ->label('Start Date')
                            ->required(),
                        Select::make('status')
                            ->options([
                                'attend' => 'Attend',
                                'not_attend' => 'Not Attend',
                                'reschedule' => 'Reschedule',
                                'pending' => 'Pending',
                            ])
                            ->label('Status'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(CalendarEvents::query()->latest())
            ->columns([
                TextColumn::make('user.name')
                    ->label('Client')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('startDate')
                    ->label('Interview Date')
                    ->date('F d, Y h:i A')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function ($state) {
                        return ucfirst($state) ?? 'n/a';
                    }),
                // ->icon(function ($state) {
                //     $startDate = Carbon::parse($state);
                //     $now = Carbon::now();
                //     if ($startDate->greaterThan($now)) {
                //         return 'heroicon-o-x-circle';
                //     } elseif ($startDate->lessThan($now)) {
                //         return 'heroicon-o-bell-alert';
                //     }
                // })
                // ->color(function ($state) {
                //     $startDate = Carbon::parse($state);
                //     $now = Carbon::now();
                //     if ($startDate->greaterThan($now)) {
                //         return 'danger';
                //     } elseif ($startDate->lessThan($now)) {
                //         return 'warning';
                //     }
                // }),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Client')
                    ->options(User::where('role', 'client')->pluck('name', 'id')),
                TrashedFilter::make(),
            ])
            ->actions([
                Action::make('resched')
                    ->icon('heroicon-o-paper-airplane')
                    ->action(function ($record, $data) {
                        $record->status = 'reschedule';
                        $record->startDate = $data['startDate'];
                        $record->save();

                        (new EmailSender)->handle($record->user, $data, 'reschedule');
                    })
                    ->form([
                        DateTimePicker::make('startDate')
                            ->label('Start Date')
                            ->required(),
                    ])
                    ->visible(function ($record) {
                        $startDate = Carbon::parse($record->startDate);
                        $now = Carbon::now();
                        if ($startDate->greaterThan($now)) {
                            return false;
                        } elseif ($startDate->lessThan($now)) {
                            return true;
                        }
                    })
                    ->label('Reschedule'),
                EditAction::make('edit')
                    ->form(fn (Form $form) => $this->form($form)),
                DeleteAction::make('delete'),
            ])
            ->bulkActions([
                // ...
            ]);
    }
}

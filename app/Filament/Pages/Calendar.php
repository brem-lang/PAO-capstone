<?php

namespace App\Filament\Pages;

use App\Models\CalendarEvents;
use App\Models\User;
use App\Services\EmailSender;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Calendar extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static string $view = 'filament.pages.calendar';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Calendar';

    public ?array $data = [];

    public $calendarData = [];

    public static function canAccess(): bool
    {
        return ! auth()->user()->isClient();
    }

    public function mount()
    {
        $events = CalendarEvents::get();

        $mappedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id ?? null,
                'name' => $event->user['name'] ?? null,
                'attorney' => $event->attorney['name'] ?? null,
                'title' => $event->title ?? null,
                'start' => $event->startDate ?? null,
                'description' => $event->description ?? null,
            ];
        });

        $this->calendarData = $mappedEvents;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('user_id')
                            ->required()
                            ->label('User')
                            ->options(User::where('role', 'client')->pluck('name', 'id')),
                        Select::make('attorney_id')
                            ->required()
                            ->label('Attorney')
                            ->options(User::where('role', 'attorney')->pluck('name', 'id')),
                        Select::make('title')
                            ->label('Place')
                            ->required()
                            ->options([
                                'RTC 34' => 'RTC 34',
                                'RTC 4' => 'RTC 4',
                                'RTC 3' => 'RTC 3',
                                'MTCC' => 'MTCC',
                                'MCTC-CARMEN' => 'MCTC-CARMEN',
                                'MCTC STO. TOMAS' => 'MCTC STO. TOMAS',
                            ]),
                        DateTimePicker::make('startDate')
                            ->label('Start Date')
                            ->minDate(now()->startOfDay())
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function addEvent()
    {
        $data = $this->form->getState();
        $user = User::find($data['user_id']);
        $formattedDate = Carbon::parse($data['startDate'])->format('F j Y g:i A');

        CalendarEvents::create($data);

        Notification::make()
            ->title('Event Added')
            ->success()
            ->send();

        Notification::make()
            ->title('Reminder: Upcoming Hearing on '.$formattedDate)
            ->success()
            ->actions([
                Action::make('read')
                    ->label('Mark as read')
                    ->button()
                    ->markAsRead(),
            ])
            ->sendToDatabase($user);

        if (auth()->user()->isStaff()) {
            Notification::make()
                ->title('Reminder: Upcoming Hearing on'.$formattedDate.' in '.$data['title'])
                ->success()
                ->actions([
                    Action::make('read')
                        ->label('Mark as read')
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase(User::where('role', 'attorney')->get());
        }

        (new EmailSender)->handle($user, $data);

        return redirect('/app/calendar');
    }
}

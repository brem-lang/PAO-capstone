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
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Calendar extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static string $view = 'filament.pages.calendar';

    protected static ?int $navigationSort = 5;

    public ?array $data = [];

    public $calendarData = [];

    public static function canAccess(): bool
    {
        return ! auth()->user()->isClient();
    }

    public function mount()
    {
        $events = CalendarEvents::all();

        $mappedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => $event->user['name'],
                'title' => $event->title,
                'start' => $event->startDate,
                'description' => $event->description,
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
            ->title('You have event on '.$formattedDate)
            ->success()
            ->body($data['description'])
            ->actions([
                Action::make('read')
                    ->label('Mark as read')
                    ->button()
                    ->markAsRead(),
            ])
            ->sendToDatabase($user);

        (new EmailSender)->handle($user, $data);

        return redirect('/app/calendar');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(CalendarEvents::latest())
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('desciption')
                    ->searchable()
                    ->sortable(),
            ]);
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\Documents as ModelsDocuments;
use App\Models\IDType;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Actions\Action as ActionsAction;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;

class Documents extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.documents';

    protected static ?string $navigationGroup = 'Settings';

    public function mount()
    {
        $auth = auth()->user();

        if ($auth->isClient()) {
            $this->form->fill([
                'id_type' => $auth->documents->first()?->id_type,
                'id_number' => $auth->documents->first()?->id_number,
                'front_id' => $auth->documents->first()?->front_id,
                'back_id' => $auth->documents->first()?->back_id,
            ]);
        }
    }

    public static function canAccess(): bool
    {
        return ! auth()->user()->isAttorney();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsDocuments::latest())
            ->columns([
                TextColumn::make('user.name')
                    ->label('Name')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state == 'approved' ? 'completed' : $state)))
                    ->searchable(),
                TextColumn::make('created_at')->label('Created At')->date('F d, Y h:i A')->timezone('Asia/Manila')
                    ->searchable(),
            ])
            ->filters([])
            ->actions([
                Action::make('update')
                    ->hidden(fn ($record) => $record->status == 'approved')
                    ->icon('heroicon-o-arrow-path')
                    ->form([
                        Select::make('status')->options([
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                        ])->live(),
                        TextArea::make('reason')
                            ->label('Reason')
                            ->visible(
                                fn (Get $get) => $get('status') === 'rejected'
                            ),
                    ])->action(function ($data, $record) {

                        $data['reason'] = $data['reason'] ?? null;
                        $record->update($data);

                        Notification::make()
                            ->title('Your document has been '.$data['status'])
                            ->success()
                            ->body($data['reason'])
                            ->actions([
                                ActionsAction::make('read')
                                    ->label('Mark as read')
                                    ->button()
                                    ->markAsRead(),
                            ])
                            ->sendToDatabase($record->user);

                        Notification::make()
                            ->title('Document Updated')
                            ->success()
                            ->send();
                    }),
                ViewAction::make()
                    ->modalWidth('full')
                    ->form(fn (Form $form) => $this->form($form)),
                DeleteAction::make()
                    ->action(function ($record) {
                        // front
                        if (file_exists(public_path('id-photo/'.$record->front_id))) {
                            File::delete(public_path('id-photo/'.$record->front_id));
                        }

                        // back
                        if (file_exists(public_path('id-photo/'.$record->back_id))) {
                            File::delete(public_path('id-photo/'.$record->back_id));
                        }

                        $record->delete();

                        Notification::make()
                            ->title('Document Deleted')
                            ->success()
                            ->sendToDatabase($record->user);
                    }),
            ])
            ->bulkActions([
                // ...
            ])
            ->modifyQueryUsing(function ($query) {

                return $query->latest();
            });
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('id_type')
                            ->required()
                            ->dehydrated()
                            ->searchable()
                            ->label('ID Type')
                            ->options(IDType::pluck('name', 'id')),
                        TextInput::make('id_number')
                            ->label('ID Number')
                            ->required(),
                        FileUpload::make('front_id')
                            ->openable()
                            ->label('Front ID')
                            ->required()
                            ->maxSize(1024)
                            ->directory('/')                // Files will go directly into public/profile-photos
                            ->disk('public_uploads')        // Custom disk for public storage
                            ->rules(['nullable', 'mimes:jpg,jpeg,png', 'max:1024']),
                        FileUpload::make('back_id')
                            ->label('Back ID')
                            ->openable()
                            ->maxSize(1024)
                            ->required()
                            ->directory('/')                // Files will go directly into public/profile-photos
                            ->disk('public_uploads')        // Custom disk for public storage
                            ->rules(['nullable', 'mimes:jpg,jpeg,png', 'max:1024']),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $data = $this->form->getState();
        $data['status'] = 'pending';

        $user = auth()->user();

        $user->documents()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        Notification::make()
            ->title('Document Added')
            ->success()
            ->send();

        Notification::make()
            ->title(auth()->user()->name.' added a document')
            ->success()
            ->actions([
                ActionsAction::make('read')
                    ->label('Mark as read')
                    ->button()
                    ->markAsRead(),
            ])
            ->sendToDatabase(User::whereIn('role', ['attorney', 'staff'])->get());

        redirect('/app/documents');
    }

    public function accept()
    {
        $user = auth()->user();
        $user->terms_condition = true;
        $user->save();

        Notification::make()
            ->title('Accepted')
            ->success()
            ->send();

        redirect('/app/documents');
    }
}

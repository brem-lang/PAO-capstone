<?php

namespace App\Filament\Pages;

use App\Models\InterViewSheet;
use Filament\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class MyRequest extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static string $view = 'filament.pages.my-request';

    public static function canAccess(): bool
    {
        return auth()->user()->isClient();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(InterViewSheet::query()->where('user_id', auth()->user()->id)->latest())
            ->columns([
                TextColumn::make('doc_type')
                    ->searchable()
                    ->label('Purpose')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->weight(FontWeight::Bold),
                TextColumn::make('created_at')->label('Date Transact')->date('F d, Y h:i A')->timezone('Asia/Manila')
                    ->searchable(),
                TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'accepted' => 'success',
                    'pending' => 'gray',
                })
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([])
            ->bulkActions([
                // ...
            ]);
    }
}

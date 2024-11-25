<?php

namespace App\Livewire;

use App\Models\InterViewSheet;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Appointment extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(InterViewSheet::query()->latest())
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('doc_type')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->label('Purpose'),
                TextColumn::make('created_at')
                    ->date('F d, Y h:i A')->timezone('Asia/Manila')
                    ->label('Date'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ])->paginated([10]);
    }

    public function render(): View
    {
        return view('livewire.appointment');
    }
}

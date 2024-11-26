<?php

namespace App\Livewire;

use App\Models\InterViewSheet;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $activeCase = Transaction::where('status', 'pending')->count();
        $transactionCount = Transaction::count();
        $client = User::where('role', 'client')->count();

        $user = User::onlyTrashed()->count();
        $transaction = Transaction::onlyTrashed()->count();
        $interview = InterViewSheet::onlyTrashed()->count();

        return [
            Stat::make('Active Cases', $activeCase)->icon('heroicon-o-document-text'),
            Stat::make('Clients', $client)->icon('heroicon-o-user-circle'),
            Stat::make('Transactions', $transactionCount)->icon('heroicon-o-banknotes'),
            Stat::make('Archive', ($user + $transaction + $interview))->icon('heroicon-o-archive-box'),
        ];
    }
}

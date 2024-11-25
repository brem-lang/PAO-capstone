<?php

namespace App\Livewire;

use App\Models\InterViewSheet;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $interview = InterViewSheet::query();

        $user = User::query();

        $activeCase = $interview->where('status', 'active')->count();
        $client = $user->where('role', 'client')->count();

        return [
            Stat::make('Active Cases', $activeCase)->icon('heroicon-o-document-text'),
            Stat::make('Clients', $client)->icon('heroicon-o-user-circle'),
            Stat::make('Transactions', 1)->icon('heroicon-o-banknotes'),
            Stat::make('Archive', 1)->icon('heroicon-o-archive-box'),
        ];
    }
}

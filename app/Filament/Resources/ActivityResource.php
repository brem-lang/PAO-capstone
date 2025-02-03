<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages\ListActivities;
use App\Filament\Resources\ActivityResource\Pages\ViewActivity;
use Filament\Tables\Table;
use Rmsramos\Activitylog\Resources\ActivitylogResource;

class ActivityResource extends ActivitylogResource
{
    protected static ?string $slug = 'activitylogs';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                static::getLogNameColumnCompoment(),
                static::getEventColumnCompoment(),
                // static::getSubjectTypeColumnCompoment(),
                static::getCauserNameColumnCompoment(),
                static::getPropertiesColumnCompoment(),
                static::getCreatedAtColumnCompoment(),
            ])
            ->defaultSort(config('filament-activitylog.resources.default_sort_column', 'created_at'), config('filament-activitylog.resources.default_sort_direction', 'asc'))
            ->filters([
                static::getDateFilterComponent(),
                static::getEventFilterCompoment(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivities::route('/'),
            'view' => ViewActivity::route('/{record}'),
        ];
    }
}

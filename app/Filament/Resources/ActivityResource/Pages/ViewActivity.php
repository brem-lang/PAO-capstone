<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Rmsramos\Activitylog\Resources\ActivitylogResource;

class ViewActivity extends ViewRecord
{
    public static function getResource(): string
    {
        return ActivitylogResource::class;
    }
}

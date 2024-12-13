<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class InterViewSheet extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'statements' => 'json', // Cast this field to JSON
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }

    public function scopeCurrentYear($query)
    {
        return $query->whereYear('created_at', Carbon::now()->year);
    }
}

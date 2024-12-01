<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCodes extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SamsLog extends Model
{
    protected $guarded = [];


    /* # Relationships # */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

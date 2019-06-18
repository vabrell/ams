<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];


    /* # Relationships # */

    public function tasks()
    {
        return $this->hasMany(ConsultantTask::class);
    }
}

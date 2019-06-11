<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];


    /* # Helpers # */
    public function path()
    {
        return '/accounts/' . $this->id;
    }
}

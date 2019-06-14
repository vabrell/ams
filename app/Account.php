<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];


    /* # Helpers # */
    public function path()
    {
        return route('accounts.consultants.show', $this->id);
    }
}

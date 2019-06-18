<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantTask extends Model
{
    protected $guarded = [];

    /* # Relationships */

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

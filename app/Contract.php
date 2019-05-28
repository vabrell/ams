<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/neptune/contracts/' . $this->id;
    }
}

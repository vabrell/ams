<?php

namespace App;

use App\NeptuneContract;
use Illuminate\Database\Eloquent\Model;

class NeptuneRole extends Model
{
    protected $guarded = [];


    /* # Helpers # */
    public function path()
    {
        return '/neptune/roles/' . $this->id;
    }

    /* # Relatonships # */
    public function contracts()
    {
        return $this->hasMany(NeptuneContract::class);
    }
}

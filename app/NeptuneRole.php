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
        return route('neptune.roles.show', $this->id);
    }

    /* # Relatonships # */
    public function contracts()
    {
        return $this->hasMany(NeptuneContract::class, 'role_id');
    }
}

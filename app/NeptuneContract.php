<?php

namespace App;

use App\NeptuneRole;
use Illuminate\Database\Eloquent\Model;

class NeptuneContract extends Model
{
    protected $guarded = [];

    /* # Helpers # */
    public function path()
    {
        return '/neptune/contracts/' . $this->id;
    }

    /* # Relationships # */
    public function role()
    {
        return $this->belongsTo(NeptuneRole::class);
    }
}

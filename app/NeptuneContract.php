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
        return route('neptune.contracts.show', $this->id);
    }

    /* # Relationships # */
    public function role()
    {
        return $this->belongsTo(NeptuneRole::class);
    }
}

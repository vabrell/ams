<?php

namespace App\Http\Controllers;

use App\NeptuneRole;
use Illuminate\Http\Request;

class NeptuneRolesController extends Controller
{
    public function store()
    {
        // Validate the role request and store in the database
        NeptuneRole::create($this->validateRequest());
    }

    public function update(NeptuneRole $role)
    {
        // Validate the role request then update it in the database
        $role->update($this->validateRequest());
    }

    public function destroy(NeptuneRole $role)
    {
        // Delete the role from the database
        $role->delete();
    }


    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }
}

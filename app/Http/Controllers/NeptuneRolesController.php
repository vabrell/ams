<?php

namespace App\Http\Controllers;

use App\NeptuneRole;
use App\NeptuneContract;
use Illuminate\Http\Request;
use App\Http\Controllers\NeptuneContractsController;

class NeptuneRolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(NeptuneRole $role)
    {
        // Return the view to show a specific role
        return view('neptune.roles.show', compact('role'));
    }

    public function create()
    {
        // Return the view for creating a new role
        return view('neptune.roles.create');
    }

    public function edit(NeptuneRole $role)
    {
        // Get contracts without a role
        $contractsNoRole = NeptuneContract::where('role_id', 0)->orderBy('code')->get();

        // Return the view for editing a specific role
        return view('neptune.roles.edit', compact('role', 'contractsNoRole'));
    }

    public function store()
    {
        // Validate the role request and store in the database
        $role = NeptuneRole::create($this->validateRequest());

        // Redirect the user to the new role
        return redirect($role->path())->with('status', 'Tillägg av rollen har genomförts!');
    }

    public function update(NeptuneRole $role)
    {
        // Validate the role request then update it in the database
        $role->update($this->validateRequest());

        // Add relationship to role on contract
        if(!empty(request()->contract))
        {
            foreach(request()->contract as $contract)
            {
                $cc = new NeptuneContractsController();
                $cc->addRelationship(NeptuneContract::findOrFail($contract), $role);
            }
        }

        // Remove relationship to role on contract
        if(!empty(request()->noRole))
        {
            foreach(request()->noRole as $noRole)
            {
                $cc = new NeptuneContractsController();
                $cc->removeRelationship(NeptuneContract::findOrFail($noRole));
            }
        }

        // Redirect the user to the updated role
        return redirect($role->path())->with('status', 'Ändringen av rollen har genomförts!');
    }

    public function destroy(NeptuneRole $role)
    {
        // Delete the role from the database
        $role->delete();

        // Redirect the user to the Neptune index
        return redirect()->route('neptune.index')->with('status', 'Borttaget av rollen har genomförts!');
    }


    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }
}

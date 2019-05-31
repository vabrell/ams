<?php

namespace App\Http\Controllers;

use App\NeptuneRole;
use App\NeptuneContract;
use Illuminate\Http\Request;

class NeptuneContractsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(NeptuneContract $contract)
    {
        // Return view to show specific contract
        return view('neptune.contracts.show', compact('contract'));
    }

    public function edit(NeptuneContract $contract)
    {
        // Get all roles
        $roles = NeptuneRole::orderBy('name')->get();

        // Return edit view for specific contract
        return view('neptune.contracts.edit', compact('contract', 'roles'));
    }

    public function create()
    {
        // Return create view
        return view('neptune.contracts.create');
    }

    public function store()
    {
        // Validate the contract request and then store it in the database
        $contract = NeptuneContract::create($this->validateRequest());

        // Redirect back to the created contract
        return redirect($contract->path())->with('status', 'Tillägg av avtal lyckades!');
    }

    public function update(NeptuneContract $contract)
    {
        // Validate the contract request and then update it in the database
        $contract->update($this->validateRequest());

        // Redirect back to the updated contract
        return redirect($contract->path())->with('status', 'Uppdateringen av avtalet lyckades!');
    }

    public function addRelationship(NeptuneContract $contract, NeptuneRole $role)
    {
        $contract->update([
            'role_id' => $role->id
        ]);
    }

    public function removeRelationship(NeptuneContract $contract)
    {
        $contract->update([
            'role_id' => 0
        ]);
    }

    public function destroy(NeptuneContract $contract)
    {
        // Remove the contract from the database
        $contract->delete();

        // Redirect back to neptune index
        return redirect()->route('neptune.index')->with('status', 'Borttagningen av avtalet lyckades!');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'code' => 'required|unique:neptune_contracts|sometimes',
            'name' => 'required|sometimes',
            'role_id' => 'required|sometimes'
        ]);
    }
}

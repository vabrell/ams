<?php

namespace App\Http\Controllers;

use App\NeptuneContract;
use Illuminate\Http\Request;

class NeptuneContractsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
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

        return redirect()->route('neptune.index');
    }

    public function update(NeptuneContract $contract)
    {
        // Validate the contract request and then update it in the database
        $contract->update($this->validateRequest());
    }

    public function destroy(NeptuneContract $contract)
    {
        // Remove the contract from the database
        $contract->delete();
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

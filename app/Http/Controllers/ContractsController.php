<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;

class ContractsController extends Controller
{
    public function store()
    {
        // Validate the contract request and then store it in the database
        Contract::create($this->validateRequest());
    }

    public function update(Contract $contract)
    {
        // Validate the contract request and then update it in the database
        $contract->update($this->validateRequest());
    }

    public function destroy(Contract $contract)
    {
        // Remove the contract from the database
        $contract->delete();
    }

    protected function validateRequest()
    {
        return request()->validate([
            'number' => 'required|integer|sometimes',
            'name' => 'required|sometimes',
            'role_id' => 'required|sometimes'
        ]);
    }
}

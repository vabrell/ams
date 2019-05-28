<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;

class ContractsController extends Controller
{
    public function store()
    {
        // Validate the request and then store it in database
        Contract::create($this->validateRequest());
    }

    protected function validateRequest()
    {
        return request()->validate([
            'number' => 'required|integer',
            'name' => 'required'
        ]);
    }
}

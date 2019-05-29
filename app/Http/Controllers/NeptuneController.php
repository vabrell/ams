<?php

namespace App\Http\Controllers;

use App\NeptuneRole;
use App\NeptuneContract;
use Illuminate\Http\Request;

class NeptuneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $contracts = NeptuneContract::orderBy('code', 'ASC')->get();
        $roles = NeptuneRole::orderBy('name', 'ASC')->get();

        return view('neptune.index', compact(['contracts', 'roles']));
    }
}

<?php

namespace App\Http\Controllers;

use App\NeptuneContract;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $contractsNoRole = NeptuneContract::where('role_id', 0)->orderBy('code')->get();

        return view('home', compact('contractsNoRole'));
    }

    public function settings()
    {
        return view('settings.index');
    }
}

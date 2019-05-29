<?php

namespace App\Http\Controllers;

use App\NeptuneContract;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contractsNoRole = NeptuneContract::where('role_id', 0)->orderBy('code')->get();

        return view('home', compact('contractsNoRole'));
    }
}

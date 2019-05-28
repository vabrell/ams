<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NeptuneController extends Controller
{
    public function index()
    {
        return view('neptune.index');
    }
}

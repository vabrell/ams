<?php

namespace App\Http\Controllers;

use App\SamsLog;
use Illuminate\Http\Request;

class SamsLogController extends Controller
{
    public function index()
    {
        $logs = SamsLog::orderBy('id', 'desc')->get();

        return view('logs.index', compact('logs'));
    }

    public function addLog($user_id, $action, $message)
    {
        // Add a new log
        SamsLog::create([
            'user_id' => $user_id,
            'action' => $action,
            'message' => $message
        ]);
    }
}

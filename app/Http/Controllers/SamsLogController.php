<?php

namespace App\Http\Controllers;

use App\SamsLog;
use Illuminate\Http\Request;

class SamsLogController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $logs = SamsLog::orderBy('id', 'desc')->paginate('30');

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

    public function search()
    {
        // Validate the request
        request()->validate([
            'start' => 'required',
            'end' => 'required|after:start'
        ],[
            'start.required' => 'En start period måste väljas.',
            'end.required' => 'En slut period måste väljas.',
            'end.after' => 'Slut perioden måste vara efter start perioden.',
        ]);

        // Get all logs from the searched period
        $logs = SamsLog::where('created_at', '>=', request()->start)
                                ->where('created_at', '<', request()->end)
                                ->orderBy('id', 'desc')
                                ->paginate('30');

        // Return the user to the tasks report
        return view('logs.index', compact('logs'));
    }
}

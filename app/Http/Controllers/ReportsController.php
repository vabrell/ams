<?php

namespace App\Http\Controllers;

use App\ConsultantTask;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        // Return the user to the reports index
        return view('reports.index');
    }

    public function tasks()
    {
        // Set tasks to null
        $tasks = null;

        // Return the user to the tasks report
        return view('reports.tasks.index', compact('tasks'));

    }

    public function searchTasks()
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

        // Get all tasks from the searched period
        $tasks = ConsultantTask::where('startDate', '>=', request()->start)
                                ->where('startDate', '<', request()->end)
                                ->get();

        // Set period dates
        $start = request()->start;
        $end = request()->end;

        // Return the user to the tasks report
        return view('reports.tasks.index', compact('tasks', 'start', 'end'));
    }
}

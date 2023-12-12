<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        // $tasks = Task::simplepaginate(10);
        $user = Auth::user()->id ?? '';

        $tasks = Task::where('user_id', $user)->get();


        return view('dashboard', compact('tasks'));


    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',

        ]);
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id,

        ]);
        // $request->session()->flash('alert-success', 'Task Greated Successfully');
        return redirect()->route('tasks.index')->with('success', 'Task Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',

        ]);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,

        ]);

        return redirect()->route('tasks.index')->with('success', 'Task Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task Deleted Successfully');
    }

}


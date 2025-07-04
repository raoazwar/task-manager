<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Show the task index page
    public function index()
    {
        $tasks = Task::all(); // Fetch tasks from the database
        return view('tasks.index', compact('tasks')); // Reference the 'tasks.index' view
    }

    // Show the task create page
    public function create()
    {
        return view('tasks.create'); // Reference the 'tasks.create' view
    }

    // Store a newly created task
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:500',
            'due_at' => 'required|date',
        ], [
            'title.required' => 'The task title is required.',
            'due_at.required' => 'The due date and time is required.',
            'due_at.date' => 'The due date must be a valid date and time.'
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'due_at' => $request->due_at,
        ]);

        // Redirect back to tasks index
        return redirect()->route('tasks.index');
    }

    // Delete a task
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }

    // Toggle task completion
    public function toggle(Task $task)
    {
        $task->is_completed = !$task->is_completed;
        $task->save();

        return redirect()->route('tasks.index');
    }
    // Show the edit form for a task
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You cannot edit the task as this task is completed.');
        }
        return view('tasks.edit', compact('task'));
    }

    // Update a task
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:500',
            'due_at' => 'required|date',
        ], [
            'title.required' => 'The task title is required.',
            'due_at.required' => 'The due date and time is required.',
            'due_at.date' => 'The due date must be a valid date and time.'
        ]);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_at' => $request->due_at,
        ]);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
}

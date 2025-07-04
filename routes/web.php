<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Models\Task;

Route::view('/', 'welcome');

Route::get('dashboard', function () {
    $tasks = Task::where('user_id', auth()->id())->latest()->get();
    return view('dashboard', compact('tasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
Route::middleware(['auth'])->group(function () {
    // Route for displaying tasks (index)
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    // Route for creating new tasks
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

    // Route for storing new tasks
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

    // Route for deleting tasks
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Route for toggling task completion
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Route for editing a task
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

// Route for updating a task
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::get('/calendar', function () {
    return view('calendar');
})->middleware(['auth', 'verified'])->name('calendar');

Route::get('/calendar/tasks', function () {
    $tasks = Task::where('user_id', auth()->id())->get();
    return response()->json($tasks);
})->middleware(['auth', 'verified']);

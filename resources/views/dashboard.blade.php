@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" role="region" aria-label="Dashboard Overview">
    <!-- Welcome/User Info Card -->
    <div class="bg-gradient-to-br from-indigo-500 to-blue-400 dark:from-gray-900 dark:to-gray-800 text-white rounded-xl shadow-lg p-6 flex flex-col justify-between" role="region" aria-label="User Info">
        <div>
            <h2 class="text-xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
            <p class="text-sm opacity-90">{{ Auth::user()->email }}</p>
        </div>
        <a href="{{ route('profile') }}" class="mt-6 inline-block text-indigo-100 underline hover:text-white font-semibold focus:outline-none focus:ring-2 focus:ring-white rounded" aria-label="View Profile and Settings">View Profile & Settings</a>
    </div>
    <!-- Task Stats -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 flex flex-col items-center justify-center" role="region" aria-label="Task Overview">
        <h3 class="text-lg font-semibold mb-2 text-gray-700">Task Overview</h3>
        <div class="flex space-x-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $tasks->count() }}</div>
                <div class="text-xs text-gray-500">Total Tasks</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-500">{{ $tasks->where('is_completed', true)->count() }}</div>
                <div class="text-xs text-gray-500">Completed</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-red-500">{{ $tasks->where('is_completed', false)->count() }}</div>
                <div class="text-xs text-gray-500">Pending</div>
            </div>
        </div>
    </div>
    <!-- Quick Add Task Button -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 flex flex-col items-center justify-center" role="region" aria-label="Quick Add Task">
        <button onclick="document.getElementById('quickAddModal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow transition focus:outline-none focus:ring-2 focus:ring-indigo-400" aria-label="Quick Add Task">+ Quick Add Task</button>
        <a href="{{ route('tasks.index') }}" class="mt-4 text-indigo-600 hover:underline text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 rounded" aria-label="View All Tasks">View All Tasks</a>
    </div>
</div>
@php
    $now = now();
    $dueSoon = $tasks->filter(function($task) use ($now) {
        return !$task->is_completed && $task->due_at && $now->diffInMinutes($task->due_at, false) <= 60 && $now->diffInMinutes($task->due_at, false) > 0;
    });
    $overdue = $tasks->filter(function($task) use ($now) {
        return !$task->is_completed && $task->due_at && $now->diffInMinutes($task->due_at, false) < 0;
    });
@endphp
@if($dueSoon->count() || $overdue->count())
    <div class="mb-6">
        @if($overdue->count())
            <div class="mb-2 p-4 bg-red-100 text-red-800 rounded-lg shadow flex items-center gap-2" role="alert" aria-label="Overdue Tasks">
                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                <div>
                    <strong>Overdue:</strong> You have {{ $overdue->count() }} overdue task(s):
                    <ul class="list-disc ml-6 mt-1">
                        @foreach($overdue as $task)
                            <li>{{ $task->title }} <span class="text-xs text-gray-500">(Due: {{ $task->due_at->format('M d, H:i') }})</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($dueSoon->count())
            <div class="p-4 bg-yellow-100 text-yellow-900 rounded-lg shadow flex items-center gap-2" role="alert" aria-label="Tasks Due Soon">
                <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01" /></svg>
                <div>
                    <strong>Due Soon:</strong> You have {{ $dueSoon->count() }} task(s) due within 1 hour:
                    <ul class="list-disc ml-6 mt-1">
                        @foreach($dueSoon as $task)
                            <li>{{ $task->title }} <span class="text-xs text-gray-500">(Due: {{ $task->due_at->format('M d, H:i') }})</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endif
<!-- Recent Tasks Preview -->
<div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 mb-8" role="region" aria-label="Recent Tasks">
    <h3 class="text-lg font-bold mb-4 text-gray-700">Recent Tasks</h3>
    @if($tasks->count())
        <ul class="divide-y divide-gray-200">
            @foreach($tasks->sortByDesc('created_at')->take(5) as $task)
                <li class="py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2 md:gap-0">
                    <div class="flex items-center gap-3">
                        <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="mr-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 rounded" aria-label="Toggle completion for {{ $task->title }}">
                                <input type="checkbox" onchange="this.form.submit()" {{ $task->is_completed ? 'checked' : '' }} aria-checked="{{ $task->is_completed ? 'true' : 'false' }}">
                            </button>
                        </form>
                        <span class="{{ $task->is_completed ? 'line-through text-gray-400' : '' }} text-base font-medium">{{ $task->title }}</span>
                        <span class="ml-2 text-xs text-gray-500">{{ $task->created_at->diffForHumans() }}</span>
                        <span class="ml-2 text-xs font-bold px-2 py-1 rounded {{ $task->priority == 'High' ? 'bg-red-500 text-white' : ($task->priority == 'Medium' ? 'bg-yellow-400 text-white' : 'bg-gray-300 text-gray-800') }}">{{ $task->priority }}</span>
                        <p class="text-gray-500 text-xs ml-2">{{ Str::limit($task->description, 40) }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($task->due_at)
                        <span class="text-xs text-blue-500">Due: {{ $task->due_at->format('M d, H:i') }}</span>
                        @endif
                        <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-500 hover:text-indigo-700 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-400 rounded" aria-label="Edit {{ $task->title }}">Edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-xs focus:outline-none focus:ring-2 focus:ring-red-400 rounded" aria-label="Delete {{ $task->title }}">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No tasks yet. <a class="text-blue-500 underline" href="{{ route('tasks.create') }}">Create one</a>.</p>
    @endif
</div>
<!-- Quick Add Task Modal -->
<div id="quickAddModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden" role="dialog" aria-modal="true" aria-label="Quick Add Task Modal">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl p-8 w-full max-w-md relative">
        <button onclick="document.getElementById('quickAddModal').classList.add('hidden')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl focus:outline-none focus:ring-2 focus:ring-indigo-400 rounded" aria-label="Close Quick Add Task Modal">&times;</button>
        <h3 class="text-xl font-bold mb-4 text-indigo-700">Quick Add Task</h3>
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Task Title</label>
                <input type="text" name="title" id="title" required class="mt-1 w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" value="{{ old('title') }}" aria-required="true">
                @error('title')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Task Description</label>
                <textarea name="description" id="description" class="mt-1 w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div class="mb-4">
                <label for="due_at" class="block text-gray-700">Due Date & Time</label>
                <input type="datetime-local" name="due_at" id="due_at" class="mt-1 w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @error('due_at') border-red-500 @enderror" value="{{ old('due_at') }}" aria-required="true">
                @error('due_at')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="priority" class="block text-gray-700">Priority</label>
                <select name="priority" id="priority" class="mt-1 w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400" aria-label="Add Task">Add Task</button>
            </div>
        </form>
    </div>
</div>
@endsection

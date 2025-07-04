@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold">Your Tasks</h1>
        <form method="GET" action="" class="flex gap-2 items-center">
            <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}" class="border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            <select name="filter" class="border border-gray-300 rounded px-2 py-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All</option>
                <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
        </form>
    </div>
    <!-- Reminders for tasks due soon -->
    @php
        $now = now();
        $soon = $tasks->filter(function($task) use ($now) {
            return !$task->is_completed && $task->due_at && $now->diffInHours($task->due_at, false) <= 24 && $now->diffInHours($task->due_at, false) >= 0;
        });
    @endphp
    @if($soon->count())
        <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded">
            <strong>Reminders:</strong> You have {{ $soon->count() }} task(s) due within 24 hours!
            <ul class="list-disc ml-6 mt-2">
                @foreach($soon as $task)
                    <li>{{ $task->title }} <span class="text-xs text-gray-500">(Due: {{ $task->due_at->format('M d, H:i') }})</span></li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if($tasks->count())
        <ul class="divide-y divide-gray-200">
            @php
                $filtered = $tasks;
                if(request('filter') == 'completed') $filtered = $filtered->where('is_completed', true);
                if(request('filter') == 'pending') $filtered = $filtered->where('is_completed', false);
                if(request('search')) $filtered = $filtered->filter(fn($t) => str_contains(strtolower($t->title.' '.$t->description), strtolower(request('search'))));
            @endphp
            @foreach($filtered as $task)
                @php
                    $urgent = !$task->is_completed && $task->due_at && now()->diffInHours($task->due_at, false) <= 24 && now()->diffInHours($task->due_at, false) >= 0;
                @endphp
                <li class="flex items-center justify-between py-4 {{ $urgent ? 'bg-yellow-50' : '' }}">
                    <div class="flex items-center gap-3">
                        <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="mr-2">
                                <input type="checkbox" onchange="this.form.submit()" {{ $task->is_completed ? 'checked' : '' }}>
                            </button>
                        </form>
                        <span class="{{ $task->is_completed ? 'line-through text-gray-400 dark:text-gray-500' : '' }} text-lg font-medium">{{ $task->title }}</span>
                        <span class="ml-2 text-xs font-bold px-2 py-1 rounded {{ $task->priority == 'High' ? 'bg-red-500 text-white' : ($task->priority == 'Medium' ? 'bg-yellow-400 text-white' : 'bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }}">{{ $task->priority }}</span>
                        <p class="text-gray-600 dark:text-gray-300 text-sm ml-2">{{ $task->description }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if($task->due_at)
                        <div 
                            x-data="{
                                dueAt: new Date('{{ $task->due_at->format('Y-m-d\TH:i:s') }}Z').getTime(),
                                now: Date.now(),
                                timer: null,
                                get timeLeft() {
                                    let diff = Math.floor((this.dueAt - this.now)/1000);
                                    if (diff <= 0) return 'Time is up!';
                                    let hours = Math.floor(diff / 3600);
                                    let minutes = Math.floor((diff % 3600) / 60);
                                    let seconds = diff % 60;
                                    return `${hours}h ${minutes}m ${seconds}s left`;
                                }
                            }"
                            x-init="timer = setInterval(() => { now = Date.now() }, 1000)"
                            x-text="timeLeft"
                            class="text-sm font-semibold text-blue-600"
                        ></div>
                        @endif
                        <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No tasks yet. <a class="text-blue-500 underline" href="{{ route('tasks.create') }}">Create one</a>.</p>
    @endif
</div>
@endsection
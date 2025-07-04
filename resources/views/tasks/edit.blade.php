@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Task</h1>
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Task Title</label>
            <input type="text" name="title" id="title" required
                   class="mt-1 w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" value="{{ old('title', $task->title) }}">
            @error('title')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Task Description</label>
            <textarea name="description" id="description"
                      class="mt-1 w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">{{ old('description', $task->description) }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="due_at" class="block text-gray-700">Due Date & Time</label>
            <input type="datetime-local" name="due_at" id="due_at"
                   class="mt-1 w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @error('due_at') border-red-500 @enderror"
                   value="{{ old('due_at', $task->due_at ? $task->due_at->format('Y-m-d\TH:i') : '') }}">
            @error('due_at')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="priority" class="block text-gray-700">Priority</label>
            <select name="priority" id="priority" class="mt-1 w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                <option value="Low" {{ old('priority', $task->priority) == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ old('priority', $task->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ old('priority', $task->priority) == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Update Task</button>
        </div>
    </form>
</div>
@endsection
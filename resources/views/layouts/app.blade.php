<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen font-sans">
    @include('partials.toast')
    <nav class="bg-white shadow mb-6">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('tasks.index') }}" class="text-xl font-bold text-blue-600">Task Manager</a>
            <div>
                <a href="{{ route('tasks.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ New Task</a>
                <a href="{{ route('calendar') }}" class="ml-4 text-blue-600 font-semibold hover:underline">Calendar</a>
                <a href="{{ route('logout') }}" class="ml-4 text-gray-700">Logout</a>
            </div>
        </div>
    </nav>
    <main class="max-w-4xl mx-auto px-4">
        @yield('content')
    </main>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>

</html>

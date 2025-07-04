<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Task Manager</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
                min-height: 100vh;
            }
            .hero-bg {
                background: linear-gradient(120deg, #6366f1 0%, #60a5fa 100%);
            }
            .glass {
                background: rgba(255,255,255,0.7);
                backdrop-filter: blur(8px);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            }
            .feature-icon {
                background: linear-gradient(135deg, #6366f1 0%, #60a5fa 100%);
                color: #fff;
            }
            .cta-btn {
                background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
                color: #fff;
                transition: background 0.3s, transform 0.2s;
            }
            .cta-btn:hover {
                background: linear-gradient(90deg, #60a5fa 0%, #6366f1 100%);
                transform: translateY(-2px) scale(1.03);
            }
        </style>
    </head>
    <body class="antialiased font-sans">
        <!-- Header -->
        <header class="w-full px-4 md:px-0 py-6 flex items-center justify-between max-w-6xl mx-auto">
            <div class="flex items-center gap-2">
                <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V20a2 2 0 01-2 2z" /></svg>
                <span class="text-2xl font-bold text-indigo-700">Task Manager</span>
            </div>
            <div>
                @if (Route::has('login'))
                    <div class="flex gap-4">
                        <a href="{{ route('login') }}" class="px-5 py-2 rounded-lg font-semibold text-indigo-600 border border-indigo-600 hover:bg-indigo-50 transition">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 rounded-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">Register</a>
                        @endif
                    </div>
                @endif
            </div>
        </header>
        <div class="hero-bg py-16 px-4 md:px-0">
            <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between gap-10">
                <div class="text-white max-w-xl">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">Organize Your Work & Life with <span class="text-[#a5b4fc]">Task Manager</span></h1>
                    <p class="text-lg md:text-xl mb-8 opacity-90">Boost your productivity, manage your tasks, and collaborate with your team—all in one beautiful, intuitive platform.</p>
                    <a href="{{ route('login') }}" class="cta-btn px-8 py-3 rounded-lg text-lg font-semibold shadow-lg">Get Started</a>
                </div>
                <div class="w-full md:w-1/2 flex justify-center">
                    <img src="https://img.freepik.com/free-vector/organizing-concept-illustration_114360-1351.jpg?w=826&t=st=1718030000~exp=1718030600~hmac=demo" alt="Task Manager Illustration" class="rounded-2xl shadow-2xl w-full max-w-md">
                </div>
            </div>
        </div>
        <main class="max-w-6xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass rounded-xl p-8 flex flex-col items-center text-center">
                    <div class="feature-icon rounded-full p-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V20a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Smart Task Management</h3>
                    <p class="text-gray-700">Create, organize, and prioritize your tasks with ease. Stay on top of your work and never miss a deadline again.</p>
                </div>
                <div class="glass rounded-xl p-8 flex flex-col items-center text-center">
                    <div class="feature-icon rounded-full p-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4V6a4 4 0 10-8 0v4m12 0H4" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Team Collaboration</h3>
                    <p class="text-gray-700">Work together with your team, assign tasks, set deadlines, and track progress in real-time.</p>
                </div>
                <div class="glass rounded-xl p-8 flex flex-col items-center text-center">
                    <div class="feature-icon rounded-full p-4 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Real-Time Notifications</h3>
                    <p class="text-gray-700">Get instant updates on task changes, deadlines, and team activity so you're always in the loop.</p>
                </div>
            </div>
            <div class="mt-16 flex flex-col md:flex-row items-center justify-between gap-8 bg-gradient-to-r from-indigo-100 to-blue-100 rounded-2xl p-8 shadow-lg">
                <div class="max-w-xl">
                    <h2 class="text-2xl md:text-3xl font-bold mb-2 text-indigo-800">Ready to get organized?</h2>
                    <p class="text-lg text-indigo-700 mb-4">Sign up now and start managing your tasks efficiently with our modern Task Manager app.</p>
                    <a href="{{ route('register') }}" class="cta-btn px-8 py-3 rounded-lg text-lg font-semibold shadow-lg">Create Account</a>
                </div>
                <img src="https://img.freepik.com/free-vector/kanban-board-concept-illustration_114360-1495.jpg?w=826&t=st=1718030000~exp=1718030600~hmac=demo" alt="Kanban Board" class="rounded-xl shadow-xl w-full max-w-xs">
            </div>
        </main>
        <footer class="py-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Task Manager. All rights reserved. | Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </body>
</html>

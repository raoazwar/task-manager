@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h1 class="text-2xl font-bold mb-6">Task Calendar</h1>
    <div id="calendar"></div>
</div>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 650,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: async function(fetchInfo, successCallback, failureCallback) {
                try {
                    const res = await fetch('/calendar/tasks');
                    const tasks = await res.json();
                    const events = tasks.map(task => ({
                        id: task.id,
                        title: task.title + (task.priority ? ' [' + task.priority + ']' : ''),
                        start: task.due_at,
                        url: `/tasks/${task.id}/edit`,
                        backgroundColor: task.is_completed ? '#a3e635' : (task.priority === 'High' ? '#ef4444' : (task.priority === 'Medium' ? '#facc15' : '#a3a3a3')),
                        borderColor: task.is_completed ? '#a3e635' : (task.priority === 'High' ? '#ef4444' : (task.priority === 'Medium' ? '#facc15' : '#a3a3a3')),
                        textColor: task.is_completed ? '#166534' : '#1e293b',
                    }));
                    successCallback(events);
                } catch (e) {
                    failureCallback(e);
                }
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.url) {
                    window.location.href = info.event.url;
                }
            },
            eventDidMount: function(info) {
                if (info.event.extendedProps.is_completed) {
                    info.el.style.textDecoration = 'line-through';
                }
            }
        });
        calendar.render();
    });
</script>
@endsection 
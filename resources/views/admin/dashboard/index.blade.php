@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div id='calendar'></div>

    </section>


    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });

    </script>



@endsection

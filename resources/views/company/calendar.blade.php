<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendario de ') . $employee->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id='calendar'></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('/TFG-MiguelRamirez/public/api/events/employee/{{ $employee->id }}')
                        .then(response => response.json())
                        .then(data => {
                            const events = data.map(event => ({
                                id: event.id,
                                title: event.title,
                                start: event.start,
                                end: event.end,
                                color: event.color_evento || '#3788d8'
                            }));
                            successCallback(events);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            failureCallback(error);
                        });
                },
                editable: false,
                selectable: true,
                select: function(info) {
                    Swal.fire({
                        title: 'Nuevo evento para {{ $employee->name }}',
                        html: `
                            <input id="title" class="swal2-input" placeholder="Título">
                            <input id="start" class="swal2-input" type="datetime-local" value="${formatDate(info.start)}">
                            <input id="end" class="swal2-input" type="datetime-local" value="${formatDate(info.end)}">
                        `,
                        preConfirm: () => ({
                            title: document.getElementById('title').value,
                            start: document.getElementById('start').value,
                            end: document.getElementById('end').value
                        })
                    }).then((result) => {
                        if (result.value && result.value.title) {
                            fetch('{{ route("company.storeEvent", $employee->id) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(result.value)
                            }).then(() => calendar.refetchEvents());
                        }
                    });
                }
            });
            calendar.render();
        });

        function formatDate(date) {
            let d = new Date(date);
            return d.toISOString().slice(0, 16);
        }
    </script>
</x-app-layout>

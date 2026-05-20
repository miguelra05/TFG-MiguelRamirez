<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Calendario de Citas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id='calendar'></div>
            </div>
        </div>
    </div>

    <!-- Scripts de FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                editable: true,
                selectable: true,
                events: '/TFG-MiguelRamirez/public/api/events',

                // Al hacer clic en un evento (editar/eliminar)
                eventClick: function(info) {
                    Swal.fire({
                        title: info.event.title,
                        html: `
                    <p><strong>Inicio:</strong> ${info.event.start.toLocaleString()}</p>
                    ${info.event.end ? `<p><strong>Fin:</strong> ${info.event.end.toLocaleString()}</p>` : ''}
                `,
                        showCancelButton: true,
                        confirmButtonText: 'Editar',
                        cancelButtonText: 'Eliminar',
                        showDenyButton: true,
                        denyButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Editar evento
                            Swal.fire({
                                title: 'Editar evento',
                                html: `
                            <input id="swal-title" class="swal2-input" placeholder="Título" value="${info.event.title}">
                            <input id="swal-start" class="swal2-input" type="datetime-local" value="${formatDateForInput(info.event.start)}">
                            <input id="swal-end" class="swal2-input" type="datetime-local" value="${info.event.end ? formatDateForInput(info.event.end) : ''}">
                        `,
                                preConfirm: () => {
                                    return {
                                        title: document.getElementById('swal-title').value,
                                        start: document.getElementById('swal-start').value,
                                        end: document.getElementById('swal-end').value
                                    };
                                }
                            }).then((updateResult) => {
                                if (updateResult.isConfirmed) {
                                    fetch(`/TFG-MiguelRamirez/public/api/events/${info.event.id}`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                        },
                                        body: JSON.stringify(updateResult.value)
                                    }).then(response => response.json())
                                        .then(() => calendar.refetchEvents());
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Eliminar evento
                            Swal.fire({
                                title: '¿Eliminar evento?',
                                text: 'Esta acción no se puede deshacer',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, eliminar'
                            }).then((deleteResult) => {
                                if (deleteResult.isConfirmed) {
                                    fetch(`/TFG-MiguelRamirez/public/api/events/${info.event.id}`, {                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                        }
                                    }).then(() => calendar.refetchEvents());
                                }
                            });
                        }
                    });
                },

                // Al seleccionar un rango de fechas (crear evento)
                select: function(info) {
                    Swal.fire({
                        title: 'Nuevo evento',
                        html: `
                    <input id="swal-title" class="swal2-input" placeholder="Título">
                    <input id="swal-start" class="swal2-input" type="datetime-local" value="${formatDateForInput(info.start)}">
                    <input id="swal-end" class="swal2-input" type="datetime-local" value="${formatDateForInput(info.end)}">
                `,
                        preConfirm: () => {
                            return {
                                title: document.getElementById('swal-title').value,
                                start: document.getElementById('swal-start').value,
                                end: document.getElementById('swal-end').value
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed && result.value.title) {
                            fetch('/TFG-MiguelRamirez/public/api/events', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(result.value)
                            }).then(response => response.json())
                                .then(() => calendar.refetchEvents());
                        }
                    });
                }
            });

            calendar.render();
        });

        // Función auxiliar para formatear fechas
        function formatDateForInput(date) {
            let d = new Date(date);
            return d.toISOString().slice(0, 16);
        }
    </script>
</x-app-layout>

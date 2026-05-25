<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Currículum') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-end space-x-2 mb-6">
                        <a href="{{ route('cv.export') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Exportar PDF
                        </a>
                    </div>
                    {{-- Grid 4x2 del CV --}}
                    <div class="cv-container" style="width: 210mm; min-height: 297mm; margin: 0 auto; background: white; box-shadow: 0 0 15px rgba(0,0,0,0.1); padding: 0;">
                        <div class="cv-grid" style="display: grid; grid-template-columns: 1fr 2fr; gap: 0;">

                            {{-- Columna izquierda (1/3) --}}
                            <div class="cv-left" style="background: #f8fafc; padding: 30px 25px;">

                                {{-- Celda 1,1: Foto --}}
                                <div class="cv-section mb-6 text-center">
                                    @if($user->foto_perfil)
                                        <img src="{{ Storage::url($user->foto_perfil) }}" class="rounded-full w-32 h-32 object-cover mx-auto border-4 border-blue-500">
                                    @else
                                        <div class="rounded-full w-32 h-32 bg-gray-300 mx-auto flex items-center justify-center border-4 border-blue-500">
                                            <span class="text-gray-500 text-4xl">Sin foto</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Celda 2,1: Contacto --}}
                                <div class="cv-section mb-6">
                                    <h3 class="text-lg font-bold text-gray-800 border-b-2 border-blue-500 pb-2 mb-3">Contacto</h3>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-start">
                                            <span class="w-20 text-gray-600">Email:</span>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                        @if($user->telefono)
                                            <div class="flex items-start">
                                                <span class="w-20 text-gray-600">Teléfono:</span>
                                                <span>{{ $user->telefono }}</span>
                                            </div>
                                        @endif
                                        @if($user->direccion)
                                            <div class="flex items-start">
                                                <span class="w-20 text-gray-600">Dirección:</span>
                                                <span>{{ $user->direccion }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Celda 3,1: Certificaciones --}}
                                <div class="cv-section mb-6">
                                    <div class="flex justify-between items-center border-b-2 border-blue-500 pb-2 mb-3">
                                        <h3 class="text-lg font-bold text-gray-800">Certificaciones</h3>
                                        <button onclick="openCertificacionModal()" class="text-blue-500 hover:text-blue-700 text-sm">+ Añadir</button>
                                    </div>
                                    <div id="certificaciones-list" class="space-y-2">
                                        @foreach($user->certificaciones as $cert)
                                            <div class="bg-white p-2 rounded shadow-sm text-sm" data-id="{{ $cert->id }}">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <div class="font-semibold">{{ $cert->titulo }}</div>
                                                        <div class="text-gray-600 text-xs">{{ $cert->nombre_emisor }} • {{ \Carbon\Carbon::parse($cert->fecha_obtencion)->format('Y') }}</div>
                                                        @if($cert->descripcion)
                                                            <div class="text-gray-500 text-xs mt-1">{{ $cert->descripcion }}</div>
                                                        @endif
                                                    </div>
                                                    <button onclick="deleteCertificacion({{ $cert->id }})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Celda 4,1: Habilidades --}}
                                <div class="cv-section">
                                    <div class="flex justify-between items-center border-b-2 border-blue-500 pb-2 mb-3">
                                        <h3 class="text-lg font-bold text-gray-800">Habilidades</h3>
                                        <button onclick="openHabilidadModal()" class="text-blue-500 hover:text-blue-700 text-sm">+ Añadir</button>
                                    </div>
                                    <div id="habilidades-list" class="flex flex-wrap gap-2">
                                        @foreach($user->habilidades as $hab)
                                            <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm flex items-center" data-id="{{ $hab->id }}">
                                                <span>{{ $hab->nombre }}</span>
                                                <button onclick="deleteHabilidad({{ $hab->id }})" class="ml-2 text-red-500 hover:text-red-700">X</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Columna derecha (2/3) --}}
                            <div class="cv-right" style="padding: 30px 25px;">

                                {{-- Celda 1,2: Nombre y título --}}
                                <div class="cv-section mb-6">
                                    <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }} {{ $user->apellidos }}</h1>
                                    @if($user->titulo_profesional)
                                        <p class="text-blue-600 text-lg mt-1">{{ $user->titulo_profesional }}</p>
                                    @endif
                                </div>

                                {{-- Celda 2,2: Sobre mí --}}
                                <div class="cv-section mb-6">
                                    <h3 class="text-lg font-bold text-gray-800 border-b-2 border-blue-500 pb-2 mb-3">Sobre mí</h3>
                                    <div class="text-gray-700 text-sm leading-relaxed text-justify">
                                        @if($user->descripcion_personal)
                                            <p>{{ $user->descripcion_personal }}</p>
                                        @else
                                            <p class="text-gray-400 italic">Añade una descripción personal desde tu perfil.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Celda 3,2: Formación --}}
                                <div class="cv-section mb-6">
                                    <div class="flex justify-between items-center border-b-2 border-blue-500 pb-2 mb-3">
                                        <h3 class="text-lg font-bold text-gray-800">Formación académica</h3>
                                        <button onclick="openFormacionModal()" class="text-blue-500 hover:text-blue-700 text-sm">+ Añadir</button>
                                    </div>
                                    <div id="formaciones-list" class="space-y-3">
                                        @foreach($user->formaciones as $form)
                                            <div class="bg-gray-50 p-3 rounded" data-id="{{ $form->id }}">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <div class="font-semibold">{{ $form->titulo }}</div>
                                                        <div class="text-gray-600 text-sm">{{ $form->institucion }}</div>
                                                        <div class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($form->fecha_inicio)->format('Y') }} - {{ $form->fecha_fin ? \Carbon\Carbon::parse($form->fecha_fin)->format('Y') : 'Actualidad' }}</div>
                                                        @if($form->descripcion)
                                                            <div class="text-gray-500 text-sm mt-1">{{ $form->descripcion }}</div>
                                                        @endif
                                                    </div>
                                                    <button onclick="deleteFormacion({{ $form->id }})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Celda 4,2: Experiencia laboral --}}
                                <div class="cv-section">
                                    <div class="flex justify-between items-center border-b-2 border-blue-500 pb-2 mb-3">
                                        <h3 class="text-lg font-bold text-gray-800">Experiencia laboral</h3>
                                        <button onclick="openExperienciaModal()" class="text-blue-500 hover:text-blue-700 text-sm">+ Añadir</button>
                                    </div>
                                    <div id="experiencias-list" class="space-y-3">
                                        @foreach($user->experiencias as $exp)
                                            <div class="bg-gray-50 p-3 rounded" data-id="{{ $exp->id }}">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <div class="font-semibold">{{ $exp->puesto }}</div>
                                                        <div class="text-gray-600 text-sm">{{ $exp->empresa }}</div>
                                                        <div class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($exp->fecha_inicio)->format('Y') }} - {{ $exp->fecha_fin ? \Carbon\Carbon::parse($exp->fecha_fin)->format('Y') : 'Actualidad' }}</div>
                                                        @if($exp->descripcion)
                                                            <div class="text-gray-500 text-sm mt-1">{{ $exp->descripcion }}</div>
                                                        @endif
                                                    </div>
                                                    <button onclick="deleteExperiencia({{ $exp->id }})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Estilos para impresión --}}
                    <style>
                        @media print {
                            header, footer, aside, nav, .fixed, .py-12 > div > div:first-child, .flex.justify-end {
                                display: none !important;
                            }
                            .cv-container {
                                box-shadow: none;
                                margin: 0;
                                padding: 0;
                            }
                            body {
                                margin: 0;
                                padding: 0;
                            }
                            .cv-left {
                                background: #f8fafc !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                            button {
                                display: none !important;
                            }
                            a {
                                text-decoration: none;
                            }
                        }
                        /* Estilos en pantalla para simular A4 */
                        .cv-container {
                            width: 210mm;
                            min-height: 297mm;
                            margin: 2rem auto;
                            background: white;
                            box-shadow: 0 0 15px rgba(0,0,0,0.15);
                        }

                        /* Ajustes para impresión real */
                        @media print {
                            body, .cv-container, .cv-grid, .cv-left, .cv-right {
                                margin: 0 !important;
                                padding: 0 !important;
                                box-shadow: none !important;
                                width: 100% !important;
                            }
                            .cv-left, .cv-right {
                                break-inside: avoid;
                            }
                            button {
                                display: none !important;
                            }
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
    <!--modales-->
        <!--certificaciones-->
    <div id="certificacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Añadir certificación</h3>
                <button onclick="closeCertificacionModal()" class="text-gray-400 hover:text-gray-600">✖</button>
            </div>

            <form id="certificacionForm">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                    <input type="text" name="titulo" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Emisor *</label>
                    <input type="text" name="nombre_emisor" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de obtención *</label>
                    <input type="date" name="fecha_obtencion" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeCertificacionModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar</button>
                </div>
            </form>
        </div>
    </div>
        <!--habilidades-->
    {{-- Modal Añadir Habilidad --}}
    <div id="habilidadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Añadir habilidad</h3>
                <button onclick="closeHabilidadModal()" class="text-gray-400 hover:text-gray-600">✖</button>
            </div>

            <form id="habilidadForm">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                    <input type="text" name="nombre" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="2" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeHabilidadModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <!--formaciones-->
    <div id="formacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Añadir formación académica</h3>
                <button onclick="closeFormacionModal()" class="text-gray-400 hover:text-gray-600">✖</button>
            </div>

            <form id="formacionForm">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                    <input type="text" name="titulo" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Institución *</label>
                    <input type="text" name="institucion" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha inicio *</label>
                    <input type="date" name="fecha_inicio" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha fin</label>
                    <input type="date" name="fecha_fin" class="w-full border-gray-300 rounded-md shadow-sm">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío si es actualidad</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeFormacionModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <!--experiencia-->
    {{-- Modal Añadir Experiencia --}}
    <div id="experienciaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Añadir experiencia laboral</h3>
                <button onclick="closeExperienciaModal()" class="text-gray-400 hover:text-gray-600">✖</button>
            </div>

            <form id="experienciaForm">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Puesto *</label>
                    <input type="text" name="puesto" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Empresa *</label>
                    <input type="text" name="empresa" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha inicio *</label>
                    <input type="date" name="fecha_inicio" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha fin</label>
                    <input type="date" name="fecha_fin" class="w-full border-gray-300 rounded-md shadow-sm">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío si es actualidad</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeExperienciaModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    {{-- Modales y JavaScript para CRUD (implementación posterior) --}}
    <script>
        // Modal elementos
        const modal = document.getElementById('certificacionModal');
        const form = document.getElementById('certificacionForm');
        const certificacionesList = document.getElementById('certificaciones-list');

        function openCertificacionModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCertificacionModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            form.reset();
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch('{{ route("certificaciones.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // Añadir el nuevo elemento a la lista
                    const newElement = `
                <div class="bg-white p-2 rounded shadow-sm text-sm" data-id="${data.id}">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-semibold">${data.titulo}</div>
                            <div class="text-gray-600 text-xs">${data.nombre_emisor} • ${new Date(data.fecha_obtencion).getFullYear()}</div>
                            ${data.descripcion ? `<div class="text-gray-500 text-xs mt-1">${data.descripcion}</div>` : ''}
                        </div>
                        <button onclick="deleteCertificacion(${data.id})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                    </div>
                </div>
            `;
                    certificacionesList.insertAdjacentHTML('beforeend', newElement);
                    closeCertificacionModal();
                })
                .catch(error => {
                    alert('Error al guardar la certificación');
                });
        });

        function deleteCertificacion(id) {
            if (confirm('¿Eliminar esta certificación?')) {
                fetch(`/certificaciones/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(() => {
                        const elemento = document.querySelector(`#certificaciones-list div[data-id="${id}"]`);
                        if (elemento) elemento.remove();
                    });
            }
        }
        // Modal Habilidad
        const habilidadModal = document.getElementById('habilidadModal');
        const habilidadForm = document.getElementById('habilidadForm');
        const habilidadesList = document.getElementById('habilidades-list');

        window.openHabilidadModal = function() {
            habilidadModal.classList.remove('hidden');
            habilidadModal.classList.add('flex');
        }

        window.closeHabilidadModal = function() {
            habilidadModal.classList.add('hidden');
            habilidadModal.classList.remove('flex');
            if (habilidadForm) habilidadForm.reset();
        }

        if (habilidadForm) {
            habilidadForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(habilidadForm);

                fetch('{{ route("habilidades.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        const newElement = `
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm flex items-center" data-id="${data.id}">
                    <span>${data.nombre}</span>
                    <button onclick="deleteHabilidad(${data.id})" class="ml-2 text-red-500 hover:text-red-700">X</button>
                </div>
            `;
                        if (habilidadesList) {
                            habilidadesList.insertAdjacentHTML('beforeend', newElement);
                        }
                        window.closeHabilidadModal();
                    })
                    .catch(error => {
                        alert('Error al guardar la habilidad');
                    });
            });
        }

        window.deleteHabilidad = function(id) {
            if (confirm('¿Eliminar esta habilidad?')) {
                fetch(`/habilidades/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(() => {
                        const elemento = document.querySelector(`#habilidades-list div[data-id="${id}"]`);
                        if (elemento) elemento.remove();
                    });
            }
        }
        // Modal Formación
        const formacionModal = document.getElementById('formacionModal');
        const formacionForm = document.getElementById('formacionForm');
        const formacionesList = document.getElementById('formaciones-list');

        window.openFormacionModal = function() {
            formacionModal.classList.remove('hidden');
            formacionModal.classList.add('flex');
        }

        window.closeFormacionModal = function() {
            formacionModal.classList.add('hidden');
            formacionModal.classList.remove('flex');
            if (formacionForm) formacionForm.reset();
        }

        if (formacionForm) {
            formacionForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(formacionForm);

                fetch('{{ route("formaciones.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        const fechaFin = data.fecha_fin ? new Date(data.fecha_fin).getFullYear() : 'Actualidad';
                        const fechaInicio = new Date(data.fecha_inicio).getFullYear();

                        const newElement = `
                <div class="bg-gray-50 p-3 rounded" data-id="${data.id}">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-semibold">${data.titulo}</div>
                            <div class="text-gray-600 text-sm">${data.institucion}</div>
                            <div class="text-gray-500 text-xs">${fechaInicio} - ${fechaFin}</div>
                            ${data.descripcion ? `<div class="text-gray-500 text-sm mt-1">${data.descripcion}</div>` : ''}
                        </div>
                        <button onclick="deleteFormacion(${data.id})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                    </div>
                </div>
            `;
                        if (formacionesList) {
                            formacionesList.insertAdjacentHTML('beforeend', newElement);
                        }
                        window.closeFormacionModal();
                    })
                    .catch(error => {
                        alert('Error al guardar la formación');
                    });
            });
        }

        window.deleteFormacion = function(id) {
            if (confirm('¿Eliminar esta formación?')) {
                fetch(`/formaciones/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(() => {
                        const elemento = document.querySelector(`#formaciones-list div[data-id="${id}"]`);
                        if (elemento) elemento.remove();
                    });
            }
        }
        // Modal Experiencia
        const experienciaModal = document.getElementById('experienciaModal');
        const experienciaForm = document.getElementById('experienciaForm');
        const experienciasList = document.getElementById('experiencias-list');

        window.openExperienciaModal = function() {
            experienciaModal.classList.remove('hidden');
            experienciaModal.classList.add('flex');
        }

        window.closeExperienciaModal = function() {
            experienciaModal.classList.add('hidden');
            experienciaModal.classList.remove('flex');
            if (experienciaForm) experienciaForm.reset();
        }

        if (experienciaForm) {
            experienciaForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(experienciaForm);

                fetch('{{ route("experiencias.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        const fechaFin = data.fecha_fin ? new Date(data.fecha_fin).getFullYear() : 'Actualidad';
                        const fechaInicio = new Date(data.fecha_inicio).getFullYear();

                        const newElement = `
                <div class="bg-gray-50 p-3 rounded" data-id="${data.id}">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-semibold">${data.puesto}</div>
                            <div class="text-gray-600 text-sm">${data.empresa}</div>
                            <div class="text-gray-500 text-xs">${fechaInicio} - ${fechaFin}</div>
                            ${data.descripcion ? `<div class="text-gray-500 text-sm mt-1">${data.descripcion}</div>` : ''}
                        </div>
                        <button onclick="deleteExperiencia(${data.id})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                    </div>
                </div>
            `;
                        if (experienciasList) {
                            experienciasList.insertAdjacentHTML('beforeend', newElement);
                        }
                        window.closeExperienciaModal();
                    })
                    .catch(error => {
                        alert('Error al guardar la experiencia');
                    });
            });
        }

        window.deleteExperiencia = function(id) {
            if (confirm('¿Eliminar esta experiencia?')) {
                fetch(`/experiencias/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(() => {
                        const elemento = document.querySelector(`#experiencias-list div[data-id="${id}"]`);
                        if (elemento) elemento.remove();
                    });
            }
        }
    </script>
</x-app-layout>

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

                    {{--
<div class="flex justify-end space-x-2 mb-6">
    <a href="{{ route('cv.export') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Exportar PDF
    </a>
</div>
--}}
                    {{-- Grid 4x2 del CV --}}
                    <div class="cv-container" style="max-width: 1100px; margin: 0 auto; background: white; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
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
                    </style>
                </div>
            </div>
        </div>
    </div>

    {{-- Modales y JavaScript para CRUD (implementación posterior) --}}
    <script>
        function openCertificacionModal() { alert('Funcionalidad: Añadir certificación'); }
        function openHabilidadModal() { alert('Funcionalidad: Añadir habilidad'); }
        function openFormacionModal() { alert('Funcionalidad: Añadir formación'); }
        function openExperienciaModal() { alert('Funcionalidad: Añadir experiencia'); }
        function deleteCertificacion(id) { alert('Funcionalidad: Eliminar certificación ' + id); }
        function deleteHabilidad(id) { alert('Funcionalidad: Eliminar habilidad ' + id); }
        function deleteFormacion(id) { alert('Funcionalidad: Eliminar formación ' + id); }
        function deleteExperiencia(id) { alert('Funcionalidad: Eliminar experiencia ' + id); }
    </script>
</x-app-layout>

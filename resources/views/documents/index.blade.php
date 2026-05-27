<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($isOwner)
                Mi Portafolio
            @else
                Portafolio de {{ $user->name }} {{ $user->apellidos }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Solo para el dueño: mensajes y formulario --}}
                    @if($isOwner)
                        {{-- Mensajes de éxito/error --}}
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        {{-- Botón para copiar enlace público del portafolio --}}
                        <div class="mb-4 flex justify-end">
                            <button onclick="copyPublicPortfolioLink()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Copiar enlace de mi portafolio público
                            </button>
                        </div>

                        {{-- Formulario de subida --}}
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Subir nuevo documento</h3>
                            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Título (opcional)</label>
                                        <input type="text" name="titulo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Nombre personalizado">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Archivo *</label>
                                        <input type="file" name="archivo" required class="mt-1 block w-full">
                                        <p class="text-xs text-gray-500 mt-1">Máx. 50MB. No se permiten ejecutables.</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Visibilidad</label>
                                        <select name="visibilidad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="private">Privado (solo tú)</option>
                                            <option value="public">Público (cualquiera con enlace)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Subir documento
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    {{-- Tabla de documentos (visible para todos) --}}
                    @if($documents->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <p>No hay documentos en este portafolio.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    @if($isOwner)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visibilidad</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($documents as $doc)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $doc->titulo }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ strtoupper($doc->tipo_documento) }}
                                        </td>
                                        @if($isOwner)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <form action="{{ route('documents.visibility', $doc) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="visibilidad" value="{{ $doc->visibilidad === 'public' ? 'private' : 'public' }}">
                                                    <button type="submit" class="px-2 py-1 rounded text-xs font-semibold {{ $doc->visibilidad === 'public' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ $doc->visibilidad === 'public' ? 'Público' : 'Privado' }}
                                                    </button>
                                                </form>
                        </div>
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($doc->fecha_subida)->format('d/m/Y') }}
                </div>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <!-- descargar -->
                    @if($isOwner)
                        <a href="{{ route('documents.download', ['document' => $doc->id]) }}" class="text-blue-600 hover:text-blue-900 mr-3">Descargar</a>
                    @else
                        <a href="{{ route('documents.public', $doc->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Descargar</a>
                    @endif
                    <!-- eliminar -->
                    @if($isOwner)
                        <button type="button" onclick="confirmDelete({{ $doc->id }})" class="text-red-600 hover:text-red-900">Eliminar</button>
                        <form id="delete-form-{{ $doc->id }}" action="{{ route('documents.destroy', $doc) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                @endif
            </div>
            </tr>
            @endforeach
            </tbody>
        </div>
    </div>
    @endif

    </div>
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(documentId) {
            Swal.fire({
                title: 'Eliminar documento',
                text: 'Esta acción no se puede deshacer. El archivo se borrará permanentemente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + documentId).submit();
                }
            });
        }

        @if($isOwner)
        function copyPublicPortfolioLink() {
            const url = '{{ url("/portfolio/" . Auth::id()) }}';
            navigator.clipboard.writeText(url);
            Swal.fire({
                title: 'Enlace copiado',
                text: url,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
        @endif
    </script>
</x-app-layout>

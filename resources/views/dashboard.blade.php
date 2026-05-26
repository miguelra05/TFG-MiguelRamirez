<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bienvenido de nuevo, ') }}{{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tarjetas de acceso rápido --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Tarjeta CV --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-4 font-bold text-gray-400">CV</div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Mi CV</h3>
                            <p class="text-gray-600 text-sm mb-4">Gestiona tu currículum, añade formaciones, experiencias y habilidades.</p>
                            <a href="{{ url('/cv') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Acceder
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta Calendario --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-4 font-bold text-gray-400">CAL</div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Calendario</h3>
                            <p class="text-gray-600 text-sm mb-4">Organiza tus eventos, citas y reuniones importantes.</p>
                            <a href="{{ url('/calendar') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Acceder
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta Portafolio --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-4 font-bold text-gray-400">DOC</div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Portafolio</h3>
                            <p class="text-gray-600 text-sm mb-4">Sube y gestiona tus documentos profesionales.</p>
                            <a href="{{ url('/documents') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Acceder
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Próximos eventos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Próximos eventos</h3>

                    @if($upcomingEvents->count() > 0)
                        <div class="space-y-3">
                            @foreach($upcomingEvents as $event)
                                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $event->title }}</p>
                                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($event->start)->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <a href="{{ url('/calendar') }}" class="text-blue-500 hover:text-blue-700 text-sm">Ver en calendario</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">
                            No tienes eventos en los próximos 30 días.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

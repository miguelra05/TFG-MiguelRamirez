<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis empleados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Añadir empleado</h3>
                        <form action="{{ route('company.addEmployee') }}" method="POST" class="flex gap-4">
                            @csrf
                            <input type="email" name="email" placeholder="Email del empleado" required
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Añadir empleado
                            </button>
                        </form>
                    </div>
                    @if($employees->isEmpty())
                        <p class="text-gray-500">No tienes empleados asignados.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($employees as $employee)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $employee->name }}
                        </div>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $employee->email }}
                </div>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $employee->telefono ?? 'No disponible' }}
            </div>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <a href="{{ route('cv.public', $employee->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver CV</a>
                <a href="{{ route('company.calendar', $employee->id) }}" class="text-green-600 hover:text-green-900">Ver calendario</a>
            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
        @endif
    </div>
    </div>
    </div>
    </div>
</x-app-layout>

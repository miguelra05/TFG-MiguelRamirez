<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-700 to-blue-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div>
                <div class="flex justify-center">
                    <img src="{{ asset('logo.png') }}" alt="WorkSync" class="h-12 w-auto">
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Verifica tu correo electrónico
                </h2>
            </div>

            @if (session('resent'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    Se ha enviado un nuevo enlace de verificación a tu correo.
                </div>
            @endif

            <p class="text-gray-600 text-center">
                Antes de continuar, por favor revisa tu correo para el enlace de verificación.
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Reenviar correo de verificación
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('logout') }}" class="text-sm text-blue-600 hover:text-blue-500"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

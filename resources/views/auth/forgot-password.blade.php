<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-700 to-blue-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div>
                <div class="flex justify-center">
                    <img src="{{ asset('logo.png') }}" alt="WorkSync" class="h-12 w-auto">
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    ¿Olvidaste tu contraseña?
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Ingresa tu email y te enviaremos un enlace para restablecerla.
                </p>
            </div>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input id="email" type="email" name="email" required autofocus
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           value="{{ old('email') }}">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-500">
                        Volver al inicio de sesión
                    </a>
                    <button type="submit"
                            class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Enviar enlace
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

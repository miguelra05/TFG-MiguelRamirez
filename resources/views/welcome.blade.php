<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WorkSync') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen">
    <!-- Header simple sin login -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="WorkSync" class="h-10 w-auto">
                    <span class="ml-3 text-xl font-bold text-gray-800">WorkSync</span>
                </div>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">Registrarse</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    WorkSync
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Tu plataforma profesional todo en uno
                </p>
                <p class="text-lg max-w-2xl mx-auto mb-12 text-blue-50">
                    Organiza tu calendario, muestra tu portafolio y crea tu CV profesional. Todo en un mismo lugar.
                </p>
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition duration-200 text-lg shadow-lg">
                        Comenzar ahora
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 font-semibold py-3 px-8 rounded-lg transition duration-200 text-lg">
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Todo lo que necesitas</h2>
                <p class="text-gray-600 mt-2">Una plataforma completa para profesionales</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Calendario -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">📅</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Calendario</h3>
                    <p class="text-gray-600">Gestiona tus eventos, citas y reuniones de forma fácil e intuitiva.</p>
                </div>

                <!-- Portafolio -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">📁</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Portafolio</h3>
                    <p class="text-gray-600">Sube y organiza tus documentos profesionales. Controla quién los ve.</p>
                </div>

                <!-- CV -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">📄</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Generador de CV</h3>
                    <p class="text-gray-600">Crea tu currículum profesional, añade experiencia y exporta a PDF.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <p class="text-center text-sm text-gray-500">
                © {{ date('Y') }} WorkSync. TFG Miguel Ramírez. Todos los derechos reservados.
            </p>
        </div>
    </footer>
</div>
</body>
</html>

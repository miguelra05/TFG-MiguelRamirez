<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }} - Perfil público</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-container {
            max-width: 900px;
            margin: 2rem auto;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .profile-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            margin: 0 auto 1rem;
            background: white;
        }
        .profile-name {
            font-size: 1.875rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }
        .profile-title {
            font-size: 1rem;
            opacity: 0.9;
        }
        .profile-content {
            padding: 2rem;
        }
        .info-section {
            margin-bottom: 1.5rem;
        }
        .info-section h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 100px 1fr;
            gap: 0.75rem;
            font-size: 0.875rem;
        }
        .info-label {
            font-weight: 600;
            color: #475569;
        }
        .info-value {
            color: #334155;
        }
        .bio-text {
            color: #334155;
            font-size: 0.875rem;
            line-height: 1.5;
            text-align: justify;
        }
        .back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.875rem;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        @media (max-width: 640px) {
            .profile-content {
                padding: 1.5rem;
            }
            .info-grid {
                grid-template-columns: 1fr;
                gap: 0.25rem;
            }
            .info-label {
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="profile-container">
    {{-- Cabecera --}}
    <div class="profile-header">
        @if($user->foto_perfil)
            <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="profile-photo">
        @else
            <div class="profile-photo bg-white flex items-center justify-center text-gray-400 text-2xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
        @endif
        <div class="profile-name">{{ $user->name }} @if($user->apellidos) {{ $user->apellidos }} @endif</div>
        @if($user->titulo_profesional)
            <div class="profile-title">{{ $user->titulo_profesional }}</div>
        @endif
    </div>

    {{-- Contenido --}}
    <div class="profile-content">
        {{-- Contacto --}}
        @if($user->email || $user->telefono || $user->direccion)
            <div class="info-section">
                <h3>Contacto</h3>
                <div class="info-grid">
                    @if($user->email)
                        <div class="info-label">Email:</div>
                        <div class="info-value">{{ $user->email }}</div>
                    @endif
                    @if($user->telefono)
                        <div class="info-label">Teléfono:</div>
                        <div class="info-value">{{ $user->telefono }}</div>
                    @endif
                    @if($user->direccion)
                        <div class="info-label">Dirección:</div>
                        <div class="info-value">{{ $user->direccion }}</div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Sobre mí --}}
        @if($user->biografia)
            <div class="info-section">
                <h3>Sobre mí</h3>
                <div class="bio-text">{{ $user->biografia }}</div>
            </div>
        @endif

        {{-- Enlace para volver --}}
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="back-link">← Volver a WorkSync</a>
        </div>
    </div>
</div>

</body>
</html>

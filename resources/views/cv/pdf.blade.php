<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - {{ $user->name }} {{ $user->apellidos }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            padding: 20px;
            font-size: 12px;
        }
        .cv-container {
            width: 100%;
            margin: 0 auto;
        }
        /* Usar tabla en lugar de grid para DOMPDF */
        .cv-table {
            width: 100%;
            border-collapse: collapse;
        }
        .cv-table td {
            vertical-align: top;
            padding: 0;
        }
        .col-left {
            width: 33%;
            background: #f8fafc;
            padding: 20px;
        }
        .col-right {
            width: 67%;
            padding: 20px;
        }
        .cv-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .cv-section h3 {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .foto {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3b82f6;
            margin: 0 auto 15px;
            display: block;
        }
        .foto-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #64748b;
            font-size: 12px;
        }
        .nombre {
            font-size: 22px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 5px;
        }
        .titulo {
            color: #3b82f6;
            font-size: 15px;
            margin-bottom: 15px;
        }
        .texto {
            font-size: 12px;
            line-height: 1.4;
            color: #334155;
            text-align: justify;
        }
        .contacto-item {
            margin-bottom: 8px;
            font-size: 11px;
        }
        .contacto-label {
            font-weight: 600;
            width: 65px;
            display: inline-block;
        }
        .habilidad {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
            margin: 3px 3px 0 0;
        }
        .item {
            background: #f1f5f9;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .item-titulo {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 2px;
        }
        .item-subtitulo {
            color: #475569;
            font-size: 11px;
            margin-bottom: 2px;
        }
        .item-fecha {
            color: #64748b;
            font-size: 10px;
            margin-bottom: 5px;
        }
        .item-descripcion {
            font-size: 11px;
            color: #334155;
            margin-top: 5px;
        }
        .texto-vacio {
            font-size: 11px;
            color: #94a3b8;
            font-style: italic;
        }
        /* Evitar saltos de página dentro de secciones */
        .cv-section {
            page-break-inside: avoid;
        }
        /* Forzar que quepa en una página */
        html, body {
            height: auto;
        }
    </style>
</head>
<body>
<div class="cv-container">
    <table class="cv-table">
        <tr>
            {{-- Columna izquierda --}}
            <td class="col-left">
                @if($user->foto_perfil)
                    <img src="{{ public_path('storage/' . $user->foto_perfil) }}" class="foto">
                @else
                    <div class="foto-placeholder">Sin foto</div>
                @endif

                <div class="cv-section">
                    <h3>Contacto</h3>
                    <div class="contacto-item"><span class="contacto-label">Email:</span> {{ $user->email }}</div>
                    @if($user->telefono)
                        <div class="contacto-item"><span class="contacto-label">Teléfono:</span> {{ $user->telefono }}</div>
                    @endif
                    @if($user->direccion)
                        <div class="contacto-item"><span class="contacto-label">Dirección:</span> {{ $user->direccion }}</div>
                    @endif
                </div>

                <div class="cv-section">
                    <h3>Certificaciones</h3>
                    @forelse($user->certificaciones as $cert)
                        <div class="item">
                            <div class="item-titulo">{{ $cert->titulo }}</div>
                            <div class="item-subtitulo">{{ $cert->nombre_emisor }}</div>
                            <div class="item-fecha">{{ \Carbon\Carbon::parse($cert->fecha_obtencion)->format('Y') }}</div>
                            @if($cert->descripcion)
                                <div class="item-descripcion">{{ $cert->descripcion }}</div>
                            @endif
                        </div>
                    @empty
                        <div class="texto-vacio">No hay certificaciones</div>
                    @endforelse
                </div>

                <div class="cv-section">
                    <h3>Habilidades</h3>
                    <div>
                        @forelse($user->habilidades as $hab)
                            <span class="habilidad">{{ $hab->nombre }}</span>
                        @empty
                            <div class="texto-vacio">No hay habilidades</div>
                        @endforelse
                    </div>
                </div>
            </td>

            {{-- Columna derecha --}}
            <td class="col-right">
                <div class="nombre">{{ $user->name }} {{ $user->apellidos }}</div>
                @if($user->titulo_profesional)
                    <div class="titulo">{{ $user->titulo_profesional }}</div>
                @endif

                <div class="cv-section">
                    <h3>Sobre mí</h3>
                    <div class="texto">{{ $user->descripcion_personal ?? 'Sin descripción' }}</div>
                </div>

                <div class="cv-section">
                    <h3>Formación académica</h3>
                    @forelse($user->formaciones as $form)
                        <div class="item">
                            <div class="item-titulo">{{ $form->titulo }}</div>
                            <div class="item-subtitulo">{{ $form->institucion }}</div>
                            <div class="item-fecha">{{ \Carbon\Carbon::parse($form->fecha_inicio)->format('Y') }} - {{ $form->fecha_fin ? \Carbon\Carbon::parse($form->fecha_fin)->format('Y') : 'Actualidad' }}</div>
                            @if($form->descripcion)
                                <div class="item-descripcion">{{ $form->descripcion }}</div>
                            @endif
                        </div>
                    @empty
                        <div class="texto-vacio">No hay formación</div>
                    @endforelse
                </div>

                <div class="cv-section">
                    <h3>Experiencia laboral</h3>
                    @forelse($user->experiencias as $exp)
                        <div class="item">
                            <div class="item-titulo">{{ $exp->puesto }}</div>
                            <div class="item-subtitulo">{{ $exp->empresa }}</div>
                            <div class="item-fecha">{{ \Carbon\Carbon::parse($exp->fecha_inicio)->format('Y') }} - {{ $exp->fecha_fin ? \Carbon\Carbon::parse($exp->fecha_fin)->format('Y') : 'Actualidad' }}</div>
                            @if($exp->descripcion)
                                <div class="item-descripcion">{{ $exp->descripcion }}</div>
                            @endif
                        </div>
                    @empty
                        <div class="texto-vacio">No hay experiencia</div>
                    @endforelse
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>

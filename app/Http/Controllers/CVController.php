<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CVController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cargar las relaciones
        $user->load(['formaciones', 'experiencias', 'certificaciones', 'habilidades']);

        return view('cv.index', compact('user'));
    }
    // certificaciones
    public function storeCertificacion(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'nombre_emisor' => 'required|string|max:255',
            'fecha_obtencion' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);

        $certificacion = Auth::user()->certificaciones()->create([
            'titulo' => $request->titulo,
            'nombre_emisor' => $request->nombre_emisor,
            'fecha_obtencion' => $request->fecha_obtencion,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($certificacion);
    }

    public function destroyCertificacion($id)
    {
        $certificacion = Auth::user()->certificaciones()->findOrFail($id);
        $certificacion->delete();

        return response()->json(['success' => true]);
    }
    //habilidades
    public function storeHabilidad(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $habilidad = Auth::user()->habilidades()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($habilidad);
    }

    public function destroyHabilidad($id)
    {
        $habilidad = Auth::user()->habilidades()->findOrFail($id);
        $habilidad->delete();

        return response()->json(['success' => true]);
    }
    //formaciones
    public function storeFormacion(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'institucion' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
        ]);

        $formacion = Auth::user()->formaciones()->create([
            'titulo' => $request->titulo,
            'institucion' => $request->institucion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($formacion);
    }

    public function destroyFormacion($id)
    {
        $formacion = Auth::user()->formaciones()->findOrFail($id);
        $formacion->delete();

        return response()->json(['success' => true]);
    }
    // experiencia
    public function storeExperiencia(Request $request)
    {
        $request->validate([
            'puesto' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
        ]);

        $experiencia = Auth::user()->experiencias()->create([
            'puesto' => $request->puesto,
            'empresa' => $request->empresa,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($experiencia);
    }

    public function destroyExperiencia($id)
    {
        $experiencia = Auth::user()->experiencias()->findOrFail($id);
        $experiencia->delete();

        return response()->json(['success' => true]);
    }
    //exportar a pdf
    public function exportPdf()
    {
        $user = Auth::user();
        $user->load(['formaciones', 'experiencias', 'certificaciones', 'habilidades']);

        $pdf = Pdf::loadView('cv.pdf', compact('user'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('CV_' . $user->name . '_' . ($user->apellidos ?? 'Usuario') . '.pdf');
    }
}

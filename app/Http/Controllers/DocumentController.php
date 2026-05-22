<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Documento::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|max:51200',
            'titulo' => 'nullable|string|max:255',
        ]);

        $file = $request->file('archivo');
        $extension = $file->getClientOriginalExtension();

        // Crear carpeta si no existe
        $uploadPath = storage_path('app/public/documentos');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Generar nombre único
        $fileName = time() . '_' . rand(1000, 9999) . '.' . $extension;
        $fullPath = $uploadPath . '/' . $fileName;

        // Mover el archivo manualmente
        if (move_uploaded_file($file->getPathname(), $fullPath)) {
            $path = 'documentos/' . $fileName;

            Documento::create([
                'user_id' => Auth::id(),
                'titulo' => $request->titulo ?? $file->getClientOriginalName(),
                'tipo_documento' => $extension,
                'ruta' => $path,
                'fecha_subida' => now(),
                'visibilidad' => 'private',
            ]);

            return redirect()->route('documents.index')->with('success', 'Documento subido.');
        }

        return back()->withErrors(['archivo' => 'Error al mover el archivo.']);
    }

    public function destroy(Documento $document)
    {
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($document->ruta);
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Documento eliminado.');
    }

    public function download(Documento $document)
    {
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        $path = storage_path('app/public/' . $document->ruta);
        return response()->download($path, $document->titulo . '.' . $document->tipo_documento);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Documento::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $isOwner = true;
        $user = Auth::user();

        return view('documents.index', compact('documents', 'isOwner', 'user'));
    }
    public function publicIndex($userId)
    {
        $user = User::findOrFail($userId);

        // Solo mostrar documentos públicos
        $documents = Documento::where('user_id', $userId)
            ->where('visibilidad', 'public')
            ->orderBy('created_at', 'desc')
            ->get();

        $isOwner = Auth::check() && Auth::id() == $user->id;

        return view('documents.index', compact('user', 'documents', 'isOwner'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|max:51200',
            'titulo' => 'nullable|string|max:255',
            'visibilidad' => 'sometimes|in:public,private'
        ]);

        $file = $request->file('archivo');
        $extension = $file->getClientOriginalExtension();
        $visibilidad = $request->visibilidad ?? 'private';

        // Carpeta base según visibilidad
        $baseFolder = $visibilidad === 'public' ? 'public' : 'private';
        $userFolder = $baseFolder . '/portfolio/user_' . Auth::id();

        // Crear carpeta si no existe
        $uploadPath = storage_path('app/' . $userFolder);
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Generar nombre único
        $fileName = time() . '_' . rand(1000, 9999) . '.' . $extension;
        $fullPath = $uploadPath . '/' . $fileName;

        // Mover el archivo manualmente
        if (move_uploaded_file($file->getPathname(), $fullPath)) {
            $path = $userFolder . '/' . $fileName;

            Documento::create([
                'user_id' => Auth::id(),
                'titulo' => $request->titulo ?? $file->getClientOriginalName(),
                'tipo_documento' => $extension,
                'ruta' => $path,
                'fecha_subida' => now(),
                'visibilidad' => $visibilidad
            ]);

            return redirect()->route('documents.index')->with('success', 'Documento subido correctamente.');
        }

        return back()->withErrors(['archivo' => 'Error al guardar el archivo.']);
    }

    public function destroy(Documento $document)
    {
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        $fullPath = storage_path('app/' . $document->ruta);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Documento eliminado correctamente.');
    }

    public function download(Documento $document)
    {
        if ($document->user_id !== Auth::id() && $document->visibilidad !== 'public') {
            abort(403);
        }

        $fullPath = storage_path('app/public/' . $document->ruta);

        if (!file_exists($fullPath)) {
            $fullPath = storage_path('app/private/' . $document->ruta);
        }

        if (!file_exists($fullPath)) {
            abort(404, 'El archivo no existe.');
        }

        return response()->download($fullPath, $document->titulo . '.' . $document->tipo_documento);
    }
    public function updateVisibility(Request $request, Documento $document)
    {
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'visibilidad' => 'required|in:public,private'
        ]);

        $oldVisibility = $document->visibilidad;
        $newVisibility = $request->visibilidad;

        if ($oldVisibility !== $newVisibility) {
            // Construir rutas antiguas y nuevas
            $oldPath = $document->ruta;

            // Extraer el nombre del archivo (ej: documentos/1734567890_1234.pdf)
            $fileName = basename($oldPath);

            // Construir nueva ruta según visibilidad
            if ($newVisibility === 'public') {
                $newPath = 'portfolio/user_' . Auth::id() . '/' . $fileName;
                $oldFullPath = storage_path('app/private/portfolio/user_' . Auth::id() . '/' . $fileName);
                $newFullPath = storage_path('app/public/' . $newPath);
            } else {
                $newPath = 'portfolio/user_' . Auth::id() . '/' . $fileName;
                $oldFullPath = storage_path('app/public/portfolio/user_' . Auth::id() . '/' . $fileName);
                $newFullPath = storage_path('app/private/' . $newPath);
            }

            // Crear directorio destino si no existe
            $destDir = dirname($newFullPath);
            if (!file_exists($destDir)) {
                mkdir($destDir, 0777, true);
            }

            // Mover el archivo físicamente
            if (file_exists($oldFullPath)) {
                rename($oldFullPath, $newFullPath);
                $document->ruta = $newPath;
            }
        }

        $document->visibilidad = $newVisibility;
        $document->save();

        return redirect()->route('documents.index')->with('success', 'Visibilidad actualizada correctamente.');
    }
    public function publicDownload($id)
    {
        $document = Documento::findOrFail($id);

        if ($document->visibilidad !== 'public') {
            abort(403, 'Este documento no es público.');
        }

        // Intentar encontrar el archivo en public o private
        $fullPath = storage_path('app/public/' . $document->ruta);

        if (!file_exists($fullPath)) {
            $fullPath = storage_path('app/private/' . $document->ruta);
        }

        if (!file_exists($fullPath)) {
            abort(404, 'El archivo no existe.');
        }

        return response()->download($fullPath, $document->titulo . '.' . $document->tipo_documento);
    }
}

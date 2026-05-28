<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EventsController extends Controller
{
    // Obtener todos los eventos del usuario autenticado
    public function index()
    {
        $events = Event::where('user_id', Auth::id())->get();
        return response()->json($events);
    }

    // Crear un nuevo evento
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'user_id' => Auth::id(),
            'ubicacion' => $request->ubicacion,
            'detalles_evento' => $request->detalles_evento,
            'estado_evento' => $request->estado_evento ?? 'pendiente',
            'color_evento' => $request->color_evento ?? '#3788d8',
            'notificacion' => $request->notificacion ?? false,
            'mora' => $request->mora,
        ]);

        return response()->json($event, 201);
    }

    // Mostrar un evento específico
    public function show(Event $event)
    {
        // Verificar que el evento pertenece al usuario
        if ($event->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        return response()->json($event);
    }

    // Actualizar un evento
    public function update(Request $request, Event $event)
    {
        // Verificar que el evento pertenece al usuario
        if ($event->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'start' => 'sometimes|date',
            'end' => 'nullable|date|after_or_equal:start',
        ]);

        $event->update($request->only([
            'title', 'start', 'end', 'ubicacion', 'detalles_evento',
            'estado_evento', 'color_evento', 'notificacion', 'mora'
        ]));

        return response()->json($event);
    }

    // Eliminar un evento
    public function destroy(Event $event)
    {
        // Verificar que el evento pertenece al usuario
        if ($event->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $event->delete();
        return response()->json(['message' => 'Evento eliminado']);
    }
    public function employeeEvents($id)
    {
        $employee = User::findOrFail($id);

        // Verificar que la empresa tiene acceso a este empleado
        if (auth()->user()->role === 'empresa' && $employee->empresa_id !== auth()->id()) {
            abort(403);
        }

        $events = Event::where('user_id', $id)->get();
        return response()->json($events);
    }
}

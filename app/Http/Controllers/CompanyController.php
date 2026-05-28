<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;

class CompanyController extends Controller
{
    public function employees()
    {
        $employees = User::where('empresa_id', auth()->id())->get();
        return view('company.employees', compact('employees'));
    }
    public function addEmployee(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $employee = User::where('email', $request->email)->first();

        if ($employee->role === 'empresa') {
            return back()->withErrors(['email' => 'No puedes añadir otra empresa como empleado.']);
        }

        $employee->empresa_id = auth()->id();
        $employee->save();

        return redirect()->route('company.employees')->with('success', 'Empleado añadido correctamente.');
    }
    public function viewEmployeeCalendar($employeeId)
    {
        $employee = User::where('empresa_id', auth()->id())->findOrFail($employeeId);
        return view('company.calendar', compact('employee'));
    }
    public function storeEmployeeEvent(Request $request, $employeeId)
    {
        $employee = User::where('empresa_id', auth()->id())->findOrFail($employeeId);

        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'user_id' => $employee->id,
            'estado_evento' => 'pendiente_confirmacion',
        ]);

        return response()->json($event);
    }
}

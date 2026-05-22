<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CVController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cargar las relaciones
        $user->load(['formaciones', 'experiencias', 'certificaciones', 'habilidades']);

        return view('cv.index', compact('user'));
    }
}

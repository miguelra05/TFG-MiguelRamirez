<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Próximos eventos (máximo 3, los más cercanos)
        $upcomingEvents = Event::where('user_id', $user->id)
            ->where('start', '>=', now())
            ->orderBy('start', 'asc')
            ->limit(3)
            ->get();

        return view('dashboard', compact('user', 'upcomingEvents'));
    }
}

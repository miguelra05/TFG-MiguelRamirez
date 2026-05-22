<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Datos básicos (validados por ProfileUpdateRequest)
        $user->fill($request->validated());

        // Campos adicionales
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;
        $user->biografia = $request->biografia;

        // Foto de perfil
        if ($request->hasFile('foto_perfil')) {
            // Borrar foto anterior si existe
            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }

            $path = $request->file('foto_perfil')->store('profile_photos', 'public');
            $user->foto_perfil = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->foto_perfil) {
            Storage::disk('public')->delete($user->foto_perfil);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

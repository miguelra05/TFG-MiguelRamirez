<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

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

        // Datos básicos
        $user->fill($request->validated());

        // Campos adicionales
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;
        $user->biografia = $request->biografia;

        // Foto de perfil
        if ($request->hasFile('foto_perfil')) {
            $file = $request->file('foto_perfil');
            $extension = $file->getClientOriginalExtension();

            // Borrar foto anterior si existe
            if ($user->foto_perfil) {
                $oldPath = storage_path('app/public/' . $user->foto_perfil);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Crear carpeta si no existe
            $uploadPath = storage_path('app/public/profile_photos');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generar nombre único y mover archivo
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $extension;
            $fullPath = $uploadPath . '/' . $fileName;

            if (move_uploaded_file($file->getPathname(), $fullPath)) {
                $user->foto_perfil = 'profile_photos/' . $fileName;
            }
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
            $oldPath = storage_path('app/public/' . $user->foto_perfil);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    //metodo para la vista pública
    public function showPublic($id)
    {
        $user = User::findOrFail($id);
        return view('profile.public', compact('user'));
    }
}

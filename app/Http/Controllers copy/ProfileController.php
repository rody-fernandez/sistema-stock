<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        // Puedes pasar el usuario a la vista si querés
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        // stub simple para no romper
        // aquí luego validás y guardás cambios
        return back()->with('status', 'Perfil actualizado');
    }

    public function destroy(Request $request)
    {
        // stub simple para no romper
        return redirect()->route('login');
    }
}
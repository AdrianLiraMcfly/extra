<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VerificationController extends Controller
{

    public function showVerificationForm()
    {
        return Inertia::render('Auth/Verify');
    }


    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|size:6',
        ]);

        $user = User::where('id', Auth::id())
            ->where('verification_code', $request->verification_code)
            ->first();

        if ($user) {
            // El código de verificación es correcto, por lo que iniciamos sesión al usuario
            Auth::login($user);

            // Limpiamos el código de verificación ya que ya no lo necesitamos
            $user->verification_code = null;
            $user->save();

            // Redirigimos al usuario a la página de inicio
            return redirect()->route('dashboard');
        } else {
            // El código de verificación es incorrecto
            return back()->withErrors([
                'verification_code' => 'The verification code is incorrect.',
            ]);
        }
    }
}
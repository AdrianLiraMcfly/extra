<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Correo;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

     public function store(Request $request): RedirectResponse
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
             'password' => ['required', 'confirmed', Rules\Password::defaults()],
         ]);
 
         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'role_id' => 2,
             'is_active' => false,
         ]);
 
         $signedUrl = URL::temporarySignedRoute(
             'activate',
             now()->addMinutes(60),
             ['user' => $user->id]
         );
 
         Mail::to($user->email)->send(new Correo($signedUrl));
 
         return redirect('/')->with('status', 'Se ha enviado un correo electrónico de verificación a su dirección de correo electrónico.');
     }
 
     public function activate(User $user)
     {
         $user->update(['is_active' => true]);
         return redirect('/login')->with('status', 'Su cuenta ha sido activada. Puede iniciar sesión ahora.');
     }
}

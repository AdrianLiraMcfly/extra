<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Canal;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CanalesController extends Controller
{
    public function index()
    {
        $canales = Canal::all();
        $usuarios = User::all();
        return Inertia::render('Forum/canales', [
            'canales' => $canales,
            'usuarios' => $usuarios,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $canal = new Canal($request->all());
        $canal->user_id = auth()->user()->id;
        $canal->save();

        return redirect()->route('canales.index')->with('message', 'Canal creado.');
    }

    public function show(Canal $canales): Response
    {
        return Inertia::render('Canales/Show', [
            'canal' => $canales,
            'usuarios' => Auth::user(),
        ]);
    }


    public function update(Request $request, Canal $canales)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $request->merge(['user_id' => auth()->user()->id]);

        $canales->update($request->all());

        return redirect()->route('canales.index')->with('message', 'Canal actualizado.');
    }

    public function destroy(Canal $canales)
    {
        if($canales->is_active == false){
            $canales->is_active = true;
            $canales->save();
            return to_route('canales.index')->with('message', 'Canal activado.');
        }
        else{
        $canales->is_active = false;
        $canales->save();
        return to_route('canales.index')->with('message', 'Canal desactivado.');
        }
    }
}

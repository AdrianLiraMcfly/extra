<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Canales;
use Inertia\Inertia;
use Inertia\Response;

class CanalesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Canales/Index', [
            'canales' => Canales::all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Canales/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            

        ]);

        Canales::create($request->all());

        return redirect()->route('canales.index');
    }

    public function edit(Canales $canales): Response
    {
        return Inertia::render('Canales/Edit', [
            'canales' => $canales,
        ]);
    }

    public function update(Request $request, Canales $canales)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $canales->update($request->all());

        return redirect()->route('canales.index');
    }

    public function destroy(Canales $canales)
    {
        $canales->delete();

        return redirect()->route('canales.index');
    }
}

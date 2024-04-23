<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\User;
use App\Models\Canal;
use Inertia\Inertia;

class TemasController extends Controller
{

    public function show(Canal $canal)
    {
        $temas = $canal->temas()->with('user')->get();
        return Inertia::render('Canal/Show', [
            'canal' => $canal,
            'temas' => $temas,
        ]);
    }

    public function store(Request $request, Canal $canal)
    {
        $request->validate([
            'titulo' => 'required',
        ]);

        $tema = new Tema($request->all());
        $tema->user_id = auth()->user()->id;
        $tema->canal_id = $canal->id;
        $tema->save();

        return redirect()->route('canal.show', $canal)->with('message', 'Tema creado.');
    }

    public function update(Request $request, Canal $canal, Tema $tema)
    {
        $request->validate([
            'titulo' => 'required',
        ]);

        $request->merge(['user_id' => auth()->user()->id]);
        $request->merge(['canal_id' => $canal->id]);
        $tema->update($request->all());

        return redirect()->route('canal.show', $canal)->with('message', 'Tema actualizado.');
    }


    public function destroy(Canal $canal, Tema $tema)
    {
        if($tema->is_active == true){
            $tema->is_active = false;
            $tema->save();
            return redirect()->route('canal.show', $canal)->with('message', 'Tema desactivado.');
        }
        else{
            $tema->is_active = true;
            $tema->save();
            return redirect()->route('canal.show', $canal)->with('message', 'Tema activado.');
        }
    }
 
}

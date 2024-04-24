<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\User;
use App\Models\Canal;
use Inertia\Inertia;

class TemasController extends Controller
{

    //lo deje asi por que asi se muestra los temas de un canal especifico, ya que con el show tu vas a mandar tu id en el boton de ver
    public function show(int $canal)
    {
        $canal = Canal::find($canal);
        $temas = $canal->temas()->with('user')->get();
        return Inertia::render('Forum/temas', [
            'canal' => $canal,
            'temas' => $temas,
        ]);
    }

    // y pues aqui vas a poner el id del canal en el boton de crear
    public function store(Request $request, Canal $canal)
    {
        $request->validate([
            'titulo' => 'required',
        ]);

        $tema = new Tema($request->all());
        $tema->user_id = auth()->user()->id;
        $tema->canal_id = $canal->id;
        $tema->save();

        return redirect()->route('canales.show', $canal)->with('message', 'Tema creado.');
    }

    public function update(Request $request, Int $canal, Int $tema)
    {
        $request->validate([
            'titulo' => 'required',
        ]);
        $canal = Canal::find($canal);
        $tema = Tema::find($tema);
        $request->merge(['user_id' => auth()->user()->id]);
        $request->merge(['canal_id' => $canal->id]);
        $tema->update($request->all());

        return redirect()->route('canales.show', $canal)->with('message', 'Tema actualizado.');
    }


    public function destroy(Canal $canal, Tema $tema)
    {
        if($tema->is_active == true){
            $tema->is_active = false;
            $tema->save();
            return redirect()->route('canales.show', $canal)->with('message', 'Tema desactivado.');
        }
        else{
            $tema->is_active = true;
            $tema->save();
            return redirect()->route('canal.show', $canal)->with('message', 'Tema activado.');
        }
    }
 
}

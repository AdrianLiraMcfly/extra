<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\User;
use App\Models\Tema;
use Inertia\Inertia;

class ComentariosController extends Controller
{
    public function show(int $tema)
    {
        $tema = Tema::find($tema);
        if($tema == null){
            return redirect()->route('canales.index')->with('message', 'Tema no encontrado.');
        }
        $comentarios = $tema->comentarios()->with('user')->get();
        return Inertia::render('Forum/comentarios', [
            'tema' => $tema,
            'comentarios' => $comentarios,
        ]);
    }

    public function store(Request $request, Tema $tema)
    {
        $request->validate([
            'comentario' => 'required',
        ]);

        $comentario = new Comentario($request->all());
        $comentario->user_id = auth()->user()->id;
        $comentario->tema_id = $tema->id;
        $comentario->save();

        return redirect()->route('tema.show', $tema)->with('message', 'Comentario creado.');
    }

    public function update(Request $request, Tema $tema, Comentario $comentario)
    {
        $request->validate([
            'comentario' => 'required',
        ]);

        $request->merge(['user_id' => auth()->user()->id]);
        $request->merge(['tema_id' => $tema->id]);
        $comentario->update($request->all());

        return redirect()->route('tema.show', $tema)->with('message', 'Comentario actualizado.');
    }

    public function destroy(Tema $tema, Comentario $comentario)
{
    $comentario->delete(); // Delete the comment instead of modifying its status
    return redirect()->route('tema.show', $tema)->with('message', 'Comentario eliminado.'); // Update the success message
}

public function getComentarios(int $tema)
{
    $tema = Tema::find($tema);
    if ($tema == null) {
        return redirect()->back()->withErrors(['error' => 'Tema no encontrado']);
    }
    $comentarios = $tema->comentarios()->with('user')->get();
    return Inertia::render('Forum/comentarios', [
        'tema' => $tema,
        'comentarios' => $comentarios,
    ]);
}

}
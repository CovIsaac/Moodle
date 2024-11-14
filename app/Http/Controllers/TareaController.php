<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Grupo;

class TareaController extends Controller
{
    // Mostrar las tareas de un grupo
    public function show($grupoId)
    {
        $tareas = Tarea::where('grupo_id', $grupoId)->get();
        $grupo = Grupo::findOrFail($grupoId);
        $grupos = Grupo::where('profesores_id', auth()->user()->id)->with('materia')->get();
        return view('teacher-dashboard', compact('tareas', 'grupo', 'grupos'));
    }

    // Guardar una nueva tarea
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_entrega' => 'required|date',
            'descripcion' => 'nullable|string',
            'grupo_id' => 'required|exists:grupos,id'
        ]);

        Tarea::create([
            'nombre' => $request->nombre,
            'fecha_entrega' => $request->fecha_entrega,
            'descripcion' => $request->descripcion,
            'grupo_id' => $request->grupo_id,
        ]);

        return redirect()->route('tareas.show', $request->grupo_id)->with('success', 'Tarea creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_entrega' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);
        $tarea = Tarea::findOrFail($id);
        $tarea->update([
            'nombre' => $request->nombre,
            'fecha_entrega' => $request->fecha_entrega,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('tareas.show', $tarea->grupo_id)->with('success', 'Tarea actualizada correctamente');
    }

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $grupoId = $tarea->grupo_id;
        $tarea->delete();

        return redirect()->route('tareas.show', $grupoId)->with('success', 'Tarea Eliminada correctamente');

    }
}

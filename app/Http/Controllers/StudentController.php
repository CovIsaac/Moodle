<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Tarea;

class StudentController extends Controller
{
    // Mostrar los grupos inscritos del alumno
    public function index()
    {
        $alumnoId = auth()->user()->id;
        $inscripciones = Inscripcion::where('estudiantes_id', $alumnoId)->with('grupo.materia')->get();
        return view('dashboard', compact('inscripciones'));
    }

    // Mostrar las tareas de un grupo específico
    public function showGrupo($grupoId)
    {
        $alumnoId = auth()->user()->id;
        $inscripciones = Inscripcion::where('estudiantes_id', $alumnoId)->with('grupo.materia')->get();
        $tareas = Tarea::where('grupo_id', $grupoId)->get();
        return view('dashboard', compact('inscripciones', 'tareas', 'grupoId'));
    }

    // Subir una tarea (placeholder, no funcional aún)
    public function uploadTarea(Request $request, $tareaId)
    {
        // Aquí manejaríamos la lógica para subir archivos
        return redirect()->back()->with('success', 'Tarea subida correctamente (placeholder)');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Grupo; // Asegúrate de importar el modelo Grupo

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirigir según el rol del usuario
            switch (Auth::user()->rol) {
                case 'profesor':
                    return redirect()->intended('teacher-dashboard');
                default:
                    return redirect()->intended('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellidoP' => $request->apellidoP,
            'apellidoM' => $request->apellidoM,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'clave_unica' => uniqid(),
            'rol' => 'alumno', // O el rol que desees por defecto
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado con éxito');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showTeacherDashboard()
    {
        $teacherId = Auth::user()->id;
        $grupos = Grupo::where('profesores_id', $teacherId)->with('materia')->get();
        return view('teacher-dashboard', compact('grupos'));
    }

    public function showMaterias($grupoId)
    {
        $grupo = Grupo::with('materia', 'tareas')->findOrFail($grupoId);
        return view('materia_tareas', compact('grupo'));
    }



}

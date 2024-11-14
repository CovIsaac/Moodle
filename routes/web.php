<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use App\Models\Grupo;

// Rutas de Autenticación
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Ruta de Bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas Protegidas
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->rol === 'alumno') {
            return app(StudentController::class)->index();
        } elseif ($user->rol === 'profesor') {
            return app(AuthController::class)->showTeacherDashboard();
        } elseif ($user->rol === 'admin') {
            return view('admin_dashboard');
        }
        return redirect('/');
    })->name('dashboard');

    Route::get('/dashboard/grupo/{grupoId}', [StudentController::class, 'showGrupo'])->name('dashboard.showGrupo');
    Route::post('/dashboard/tarea/{tareaId}/upload', [StudentController::class, 'uploadTarea'])->name('dashboard.uploadTarea');
    
    Route::get('/teacher-dashboard', function () {
        if (Auth::user()->rol === 'profesor') {
            return app(AuthController::class)->showTeacherDashboard();
        }
        return redirect('/');
    })->name('teacher_dashboard');

    Route::get('/teacher-dashboard/grupo/{grupoId}', [AuthController::class, 'showMaterias']);

    Route::get('/tareas/{grupo}', [TareaController::class, 'show'])->name('tareas.show');
    Route::post('/tareas', [TareaController::class, 'store'])->name('tareas.store');
    Route::put('/tareas/{tarea}', [TareaController::class, 'update'])->name('tareas.update');
    Route::delete('/tareas/{tarea}', [TareaController::class, 'destroy'])->name('tareas.destroy');
});

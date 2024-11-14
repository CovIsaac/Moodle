<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Alumno</title>
    <!-- Enlace CDN para Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('layouts.navbar')
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h4 class="sidebar-heading">Grupos</h4>
                    @if(isset($inscripciones) && $inscripciones->count() > 0)
                        @foreach ($inscripciones as $inscripcion)
                            <div class="card">
                                <div class="card-body">
                                    @if ($inscripcion->grupo->materia)
                                        <h5 class="card-title">Materia: {{ $inscripcion->grupo->materia->nombreMateria }}</h5>
                                    @else
                                        <h5 class="card-title">Materia: No disponible</h5>
                                    @endif
                                    <p class="card-text">Hora: {{ $inscripcion->grupo->horaInicio }} - {{ $inscripcion->grupo->horaFin }}</p>
                                    <a href="{{ route('dashboard.showGrupo', $inscripcion->grupo->id) }}" class="btn btn-primary">Ver Tareas</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No estás inscrito en ningún grupo.</p>
                    @endif
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <h1 class="mt-4">Bienvenido a tu Dashboard</h1>
                <!-- Sección para mostrar las tareas -->
                @isset($tareas)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Tareas del Grupo</h3>
                    </div>
                    @foreach ($tareas as $tarea)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $tarea->nombre }}</h5>
                                <p class="card-text">Fecha de Subida: {{ $tarea->created_at->format('Y-m-d') }}</p>
                                <p class="card-text">Fecha de Entrega: {{ $tarea->fecha_entrega }}</p>
                                <button class="btn btn-info" data-toggle="modal" data-target="#modalSubirTarea-{{ $tarea->id }}">Subir Tarea</button>
                            </div>
                        </div>

                        <!-- Modal Subir Tarea -->
                        <div class="modal fade" id="modalSubirTarea-{{ $tarea->id }}" tabindex="-1" aria-labelledby="modalSubirTareaLabel-{{ $tarea->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalSubirTareaLabel-{{ $tarea->id }}">Subir Tarea</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('dashboard.uploadTarea', $tarea->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="archivoTarea-{{ $tarea->id }}">Archivo de la Tarea</label>
                                                <input type="file" class="form-control" id="archivoTarea-{{ $tarea->id }}" name="archivo_tarea" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Subir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </main>
        </div>
    </div>
    <!-- Enlace CDN para Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

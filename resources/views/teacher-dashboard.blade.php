<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodle</title>
    <!-- Enlace CDN para Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #dee2e6;
        }
        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            height: calc(100vh - 56px); /* 56px es la altura aproximada de la barra de navegación */
            overflow-y: auto;
        }
        .card {
            margin-bottom: 15px;
            transition: transform 0.3s; /* Transición suave */
        }
        .card:hover {
            transform: scale(1.05); /* Aumentar tamaño al pasar el mouse */
        }
        .main-content {
            padding: 20px;
        }
        .sidebar-heading {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    @include('layouts.navbar')
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h4 class="sidebar-heading">Grupos</h4>
                    @foreach ($grupos as $grupo)
                        <div class="card">
                            <div class="card-body">
                                @if ($grupo->materia)
                                    <h5 class="card-title">Materia: {{ $grupo->materia->nombreMateria }}</h5>
                                @else
                                    <h5 class="card-title">Materia: No disponible</h5>
                                @endif
                                <p class="card-text">Hora: {{ $grupo->horaInicio }} - {{ $grupo->horaFin }}</p>
                                <a href="{{ route('tareas.show', $grupo->id) }}" class="btn btn-primary">Ver Tareas</a>
                                </div>
                        </div>
                    @endforeach
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                @isset($tareas)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Tareas del Grupo</h3>
                        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarTarea">Agregar Tarea</button>
                    </div>
                    @foreach ($tareas as $tarea)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $tarea->nombre }}</h5>
                                <p class="card-text">Fecha de Subida: {{ $tarea->created_at->format('Y-m-d') }}</p>
                                <p class="card-text">Fecha de Entrega: {{ $tarea->fecha_entrega }}</p>
                                <button class="btn btn-info" data-toggle="modal" data-target="#modalVerDetalles-{{ $tarea->id }}">Ver Detalles</button>
                                <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditarTarea-{{ $tarea->id }}">Editar</button>
                                <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Ver Detalles -->
                        <div class="modal fade" id="modalVerDetalles-{{ $tarea->id }}" tabindex="-1" aria-labelledby="modalVerDetallesLabel-{{ $tarea->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalVerDetallesLabel-{{ $tarea->id }}">Detalles de la Tarea</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>Nombre de la Tarea: {{ $tarea->nombre }}</h5>
                                        <p>Fecha de Subida: {{ $tarea->created_at->format('Y-m-d') }}</p>
                                        <p>Fecha de Entrega: {{ $tarea->fecha_entrega }}</p>
                                        <p>Descripción: {{ $tarea->descripcion }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar Tarea -->
                        <div class="modal fade" id="modalEditarTarea-{{ $tarea->id }}" tabindex="-1" aria-labelledby="modalEditarTareaLabel-{{ $tarea->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditarTareaLabel-{{ $tarea->id }}">Editar Tarea</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('tareas.update', $tarea->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="nombreTarea-{{ $tarea->id }}">Nombre de la Tarea</label>
                                                <input type="text" class="form-control" id="nombreTarea-{{ $tarea->id }}" name="nombre" value="{{ $tarea->nombre }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="fechaEntrega-{{ $tarea->id }}">Fecha de Entrega</label>
                                                <input type="date" class="form-control" id="fechaEntrega-{{ $tarea->id }}" name="fecha_entrega" value="{{ $tarea->fecha_entrega }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion-{{ $tarea->id }}">Descripción</label>
                                                <textarea class="form-control" id="descripcion-{{ $tarea->id }}" name="descripcion" rows="3">{{ $tarea->descripcion }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset

                <!-- Modal para agregar tareas -->
                <div class="modal fade" id="modalAgregarTarea" tabindex="-1" aria-labelledby="modalAgregarTareaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAgregarTareaLabel">Agregar Nueva Tarea</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('tareas.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                    <div class="form-group">
                                        <label for="nombreTarea">Nombre de la Tarea</label>
                                        <input type="text" class="form-control" id="nombreTarea" name="nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fechaEntrega">Fecha de Entrega</label>
                                        <input type="date" class="form-control" id="fechaEntrega" name="fecha_entrega" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


    <!-- Enlace CDN para Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

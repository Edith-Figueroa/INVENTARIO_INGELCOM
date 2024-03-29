@extends('layouts/layoutMaster')

@section('title', 'Usuarios')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lista de Categorias</h4>
                    <form method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre">Nombre de Categoria</label>
                                <input type="text" class="form-control" id="nombre" name="nameFilter" value="{{ old('nameFilter') }}">
                            </div>
                        </div>
                        <!-- Agregado: Selector de tipo de fecha -->
                        <div class="col-md-3 date-selector-container">
                            <div class="form-group">
                                <label for="dateType">Buscar por</label>
                                <select class="form-control" id="dateType" name="dateType">
                                    <option value="created_at">Fecha de Creación</option>
                                    <option value="updated_at">Fecha de Actualización</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="startDateFilter">Fecha de inicio</label>
                                <input type="date" class="form-control" id="startDateFilter" name="startDateFilter" value="{{ old('startDateFilter') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="endDateFilter">Fecha de fin</label>
                                <input type="date" class="form-control" id="endDateFilter" name="endDateFilter" value="{{ old('endDateFilter') }}">
                            </div>
                        </div>
                    </div>
                </form>

                    
                   
                </div>
                 <!-- TABLA CON INFORMACIÓN DE BASE DE DATOS -->
                <div class="card-body">
                    <a href="{{route ('pages-usuarios-create')}}" class="btn btn-primary">Añadir nuevo usuario</a>
                    <a href="{{route ('pages-usuarios-export')}}" class="btn btn-success">Exportar a Excel</a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="Table">
                   <!-- ENCABEZADOS DE TABLA -->
                   <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre de empleado</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Firma</th>                        
                        <th>Rol</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <!-- INFORMACIÓN DE BASE DE DATOS EN TABLA -->
                <tbody>                    
                    @foreach ($users as $user)
                    <tr  class="DataRow">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->Estado == 'Activo')
                                <span class="badge bg-success">{{ $user->Estado}}</span>
                            @else
                                <span class="badge bg-danger">{{ $user->Estado}}</span>
                            @endif
                        </td>
                        <td> <img style="width: 200px; height: auto" src="data:image/jpeg;base64,{{ base64_encode($user->firma) }}"  alt="Firma Digital"></td>                        
                        <td>{{ $user->role }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('pages-usuarios-show', $user->id) }}">
                                        <i class="bx bx-edit-alt me-2"></i> Editar
                                    </a>
                                    @role('Administrador')
                                    <a class="dropdown-item" href="{{ route('pages-usuarios-destroy', $user->id) }}">
                                        <i class="bx bx-trash me-2"></i> Eliminar
                                    </a>
                                    @endrole
                                    @if ($user->Estado == 'Activo')
                                    <a class="dropdown-item" href="{{ route('pages-usuarios-switch', $user->id) }}">
                                        <i class="bx bx-toggle-left me-2"></i> Desactivar
                                    </a>
                                    @else
                                    <a class="dropdown-item" href="{{ route('pages-usuarios-switch', $user->id) }}">
                                        <i class="bx bx-toggle-right me-2"></i> Activar
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>



    <script>
window.addEventListener('load', function () {
    const Table = document.getElementById("Table");
    const DataRows = document.querySelectorAll(".DataRow");

    document.getElementById("nombre").addEventListener("keyup", function () {
        const searchText = this.value.toLowerCase();

        DataRows.forEach(row => {
            const Name = row.querySelector("td:nth-child(2)").textContent.toLowerCase();

            // BUSQUEDA POR NOMBRE
            if (Name.includes(searchText)) {
                row.style.display = ""; // Mostrar la fila si coincide con el texto de búsqueda
            } else {
                row.style.display = "none"; // Ocultar la fila si no coincide
            }
        });
    });

    const startDateFilter = document.getElementById("startDateFilter");
    const endDateFilter = document.getElementById("endDateFilter");
    const dateTypeFilter = document.getElementById("dateType");

    startDateFilter.addEventListener("change", filterTable);
    endDateFilter.addEventListener("change", filterTable);
    dateTypeFilter.addEventListener("change", filterTable);

    function filterTable() {
        const startDate = startDateFilter.value ? new Date(startDateFilter.value + "T00:00:00.000Z") : null;
        const endDate = endDateFilter.value ? new Date(endDateFilter.value + "T23:59:59.999Z") : null;
        const selectedDateType = dateTypeFilter.value;

        // Ajustar la zona horaria de las fechas si es necesario
        if (startDate) {
            startDate.setHours(0, 0, 0, 0);
        }
        if (endDate) {
            endDate.setHours(23, 59, 59, 999);
        }

        DataRows.forEach(row => {
            const dateField = (selectedDateType === 'created_at') ? 5 : 6;
            const dateValue = new Date(row.querySelector(`td:nth-child(${dateField})`).textContent);

            if ((!startDate || dateValue >= startDate) && (!endDate || dateValue <= endDate)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
});
</script>
@endsection
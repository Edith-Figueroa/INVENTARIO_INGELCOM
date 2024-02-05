
@extends('layouts/layoutMaster')

@section('title', 'Home')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
@csrf
<div class="container">
    <h4>Resumen de información</h4>
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('pages-usuarios') }}">
                        <div class="avatar avatar-md mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-user fs-3"></i></span>
                        </div>
                        <span class="d-block mb-1 text-nowrap">Usuarios</span>
                        <h2 class="mb-0">{{ $n_users }}</h2> 
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('pages-categorias') }}">
                        <div class="avatar avatar-md mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-cube fs-3"></i></span>
                        </div>
                        <span class="d-block mb-1 text-nowrap">Categorías</span>
                        <h2 class="mb-0">{{ $n_categorias }}</h2>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 ">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('pages-productos') }}">
                        <div class="avatar avatar-md mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-cube fs-3"></i></span>
                        </div>
                        <span class="d-block mb-1 text-nowrap">Productos</span>
                        <h2 class="mb-0">{{ $n_productos }}</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <h4>Productos en inventario</h4>
            <select id="categoria-select" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->IdCategoria }}" {{ $selectedCategoryId == $categoria->IdCategoria ? 'selected' : '' }}>
                        {{ $categoria->NombreC }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <!-- El elemento canvas donde se dibujará el gráfico -->
            <canvas id="barChart" class="chartjs" data-height="400"></canvas>
        </div>
    </div>
</div>

@include('sweetalert::alert')
     

<script>
var ctx = document.getElementById('barChart').getContext('2d');
var labels = [];

@foreach ($inventario as $item)
    labels.push('{{ $item->NombreP }} - {{ $item->NombreC }}');
@endforeach

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Cantidad de Productos',
            data: [
                @foreach ($inventario as $item)
                {{ $item->cantidad }},
                @endforeach
            ],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

 // Manejo de eventos al seleccionar una categoría
 document.getElementById('categoria-select').addEventListener('change', function() {
        var selectedCategoryId = this.value;
        window.location.href = '{{ route("pages-home") }}?categoria=' + selectedCategoryId;
    });

    
</script>
@endsection




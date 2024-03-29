@extends('layouts/layoutMaster')

@section('title', 'Entradas')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de entradas al inventario</h3>
                <a href="{{ route('pages-inventario-createentradas') }}" class="btn btn-primary">Añadir nueva entrada</a>
                <a href="{{ route('pages-inventario-exportentradas') }}" class="btn btn-success">Exportar a Excel</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Detalle Recepción</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Notas</th>
                                <th>Cantidad</th>
                                <th>Fecha de Creación</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entradas as $IdRegistro => $entradasGroup)
                            @foreach ($entradasGroup as $index => $entrada)
                            <tr>
                                @if ($index === 0)                                 
                                <td style="text-align: center" rowspan="{{ count($entradasGroup) }}">                                                                                                                 

                                {{ $entrada->IdRegistro }}

                                <form action="{{ route('pages-inventario-verentradas', ['idRegistro' => $entrada->IdRegistro, 'edicion' => 1]) }}" 
                                method="GET">
                                @csrf
                                <button type="submit" class="btn btn-primary">ver</button>
                                
                                </form>  

                                </td>

                                <td style="text-align: center" rowspan="{{ count($entradasGroup) }}">
                                    @foreach ($recepciones as $recepcion)
                                        @if ($recepcion->id == $entrada->IdRegistro)
                                            {{ $recepcion->Detalle }}
                                        @endif
                                    @endforeach
                                </td>
                                
                                @endif


            
                                @forelse ($productos as $producto)
                                    @if ($producto->IdProducto == $entrada->IdProducto)
                                        <td>{{ $producto->NombreP }}</td>
                                        @forelse ($categorias as $categoria)
                                            @if ($categoria->IdCategoria == $producto->IdCategoria)
                                                <td>{{ $categoria->NombreC }}</td>
                                            @endif
                                        @empty
                                            <td>No hay categorías disponibles</td>
                                        @endforelse
                                    @endif
                                @empty
                                    <td>No hay productos disponibles</td>
                                @endforelse
                                
                                <td>{{ $entrada->Notas }}</td>
                                <td>{{ $entrada->Cantidad }}</td>
                                <td>{{ $entrada->created_at }}</td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

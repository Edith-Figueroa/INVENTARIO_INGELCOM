@extends('layouts/layoutMaster')

@section('title', 'Inventario')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de salidas de inventario</h3>
                    <a href="{{route ('pages-inventario-createsalidas')}}" class="btn btn-primary">Añadir nueva salida</a>
                    <a href="{{route ('pages-inventario-exportsalidas')}}" class="btn btn-success">Exportar a Excel</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Detalle Requisición</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Notas</th>
                                    <th>Cantidad</th>
                                    <th>Creado</th>
                                    <th>Actualizado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salidas as $IdRegistro => $salidasGroup)
                                @foreach ($salidasGroup as $index => $salida)
                                <tr>
                                    @if ($index === 0) 
                                    <td style="text-align: center" rowspan="{{ count($salidasGroup) }}">{{ $salida->IdRegistro }} 
                                        <a href="{{ route('pages-inventario-versalidas', ['IdRegistro' => $salida->IdRegistro]) }}" class="btn btn-danger">Ver</a>
                                    </td>
                                    <td style="text-align: center" rowspan="{{ count($salidasGroup) }}">
                                        @foreach ($requisiciones as $requisicion)
                                            @if ($requisicion->id == $salida->IdRegistro)
                                                {{ $requisicion->Detalle }}
                                            @endif
                                        @endforeach
                                    </td>
                                        @endif
                                  
                                    @forelse ($productos as $producto)
                                        @if ($producto->IdProducto == $salida->IdProducto)
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
    
                                    <td>{{ $salida->Notas }}</td>
                                    <td>{{ $salida->Cantidad }}</td>
                                    <td>{{ $salida->created_at }}</td>
                                    <td>{{ $salida->updated_at }}</td>
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

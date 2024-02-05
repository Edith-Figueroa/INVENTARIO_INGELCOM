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
                <h4 style="text-align: center">RECEPCIÓN DE INVENTARIO</h4>
                <a href="{{ route('pages-inventario-pdfrecepcion', ['IdRegistro' => $entradas->first()->IdRegistro]) }}" class="btn btn-danger">Exportar a pdf</a>
                <a href="{{ route('pages-inventario-exportrecepcion') }}" class="btn btn-success">Exportar a excel</a>
            </div>
            <div class="card-body">
                @if ($entradas->isNotEmpty())
                <div class="align-horizontal">
                    <h6 class="align-left">Número de registro: {{ $entradas->first()->IdRegistro }}</h6>
                    <h6 class="align-right">La Ceiba, {{ $entradas->first()->created_at->format('d-m-Y') }}</h6>
                </div>
                @endif
        
                <div class="mb-3">
                    <label for="detalle" class="form-label">Detalle de recepción</label>
                </div>
                @php
                $Detalle = explode(', ', $recepciones->first()->Detalle);
                @endphp
        
                <div class="mb-3 checkbox-group">
                    @foreach(['Equipo', 'Material', 'Insumos para MP', 'Insumos para MC', 'Repuestos', 'Otros'] as $value)
                    @php
                    $checked = in_array($value, $Detalle) ? 'checked' : '';
                    @endphp
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="detalle[]" value="{{ $value }}" id="{{ strtolower(str_replace(' ', '', $value)) }}" {{ $checked }} disabled>
                        <label class="form-check-label" for="{{ strtolower(str_replace(' ', '', $value)) }}">
                            {{ $value }}
                        </label>
                        <span class="check-indicator"></span>
                    </div>
                    @endforeach
                </div>
        
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                    <thead>
                <tr>
                    <th>Item</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Notas</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entradas as $index => $entrada)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    
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
                </tr>
                @endforeach
            </tbody>
                    </table>
                
                </div>
               <div class="mb-3 mt-3">
                <a href="{{ route('pages-inventario-entradas') }}" class="btn btn-primary">Regresar</a>
                <a href="{{ route('pages-inventario-entradas') }}" class="btn btn-primary">Editar</a>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection

    

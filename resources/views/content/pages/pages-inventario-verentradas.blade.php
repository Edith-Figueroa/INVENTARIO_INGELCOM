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
                

                @if ($role == 2 || $role == 1)                                                       
                    @if ($edicion != 2)
                    <form   
                    action="{{ route('pages-inventario-verentradas', ['idRegistro' => $entradas->first()->IdRegistro, 'edicion' => 2]) }}"
                        method="GET">

                        <a href="{{ route('pages-entradas-editar-Product', $entradas->first()->IdRegistro) }}" class="btn btn-outline-primary">Agregar más productos</a>                        
                        @csrf

                        <button type="submit" class="btn btn-outline-primary">Editar</button>                                                                                                                                        
                        <a href="{{ route('pages-inventario-pdfrecepcion', ['IdRegistro' => $entradas->first()->IdRegistro]) }}" class="btn btn-outline-danger">Exportar a pdf</a>
                        <a href="{{ route('pages-inventario-exportrecepcion') }}" class="btn btn-outline-success">Exportar a excel</a>                        
                    @endif                
                    </form>                             
                                                         
                @endif                

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
                    @if ($edicion == 2)
                    <th>Opciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            <form id="GuardadoGeneral"  method="POST" action="{{ route('pages-inventario-verentradas-Guardado', ['idRegistro' => $entradas->first()->IdRegistro])  }}"> 
                @csrf                     
                @foreach ($entradas as $index => $entrada)
                <tr>
                    <input type="hidden" name="idProduct[]" value="{{$entrada->IdProducto}}">
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
                    
                    
                    @if ($edicion == 2)
                        <td style="display:flex; justify-content:center; height:100px; align-items:center;">
                            <input style="width: 40px; text-align: center;" type="text" name="Cantidad[]" value="{{ $entrada->Cantidad }}">
                        </td>

                        <td style="width:10px;">                                                
                            <input type="hidden" name="Eliminar[{{ $index }}]" id="Eliminar{{ $index  }}" value="0">
                            <button type="button" class="btn btn-danger eliminarBtn" onclick="cambiarEstado(this, {{ $index }})">Eliminar</button>
                        </td>

                    @else
                        <td style="display:flex; justify-content:center; height:100px; align-items:center;">
                            {{ $entrada->Cantidad }}
                    	</td>
                    @endif                                                          
                </tr>
                @endforeach
            </tbody>
                    </table>
                
                </div>
               <div class="mb-3 mt-3">
                    <a href="javascript:history.back()" class="btn btn-outline-primary">Regresar</a>                                                                                                      
                     @if ($edicion == 2)
                        <button style="margin-left: 1%;" type="submit" class="btn btn-outline-success">Guardar</button>    
                    @endif
                </form>                                           
               </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function cambiarEstado(boton, index) {
        var inputHidden = document.getElementById('Eliminar' + index);

        if (boton.textContent === "Eliminar") {
            boton.textContent = "Cancelar";
            boton.classList.remove("btn-danger");
            boton.classList.add("btn-secondary");
            inputHidden.value = "1";
        } else {
            boton.textContent = "Eliminar";
            boton.classList.remove("btn-secondary");
            boton.classList.add("btn-danger");
            inputHidden.value = "0";
        }

    }
</script>


    

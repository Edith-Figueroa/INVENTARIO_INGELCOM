@extends('layouts/layoutMaster')

@section('title', 'salidas')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 style="text-align: center">DETALLE REQUISICIÓN</h4>
                @if ($role == 2 || $role == 1)                                                
                                             
                    @if ($edicion != 2)
                    <form   
                    action="{{ route('pages-inventario-versalidas', ['idRegistro' => $salidas->first()->IdRegistro, 'edicion' => 2]) }}"
                        method="GET">
                        <a href="{{ route('pages-salidas-editar-Product', $salidas->first()->IdRegistro) }}" class="btn btn-outline-primary">Agregar más productos</a>
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">Editar</button>                        
                        
                        <a href="{{ route('page-email-Enviar', $salidas->first()->IdRegistro) }}" class="btn btn-outline-warning">Enviar Correo</a>                                                                      
                        
                        @if ($Mostrar == true)                    
                            <a href="{{ route('pages-inventario-pdfrequisicion', ['IdRegistro' => $salidas->first()->IdRegistro]) }}" class="btn btn-outline-danger">Exportar a pdf</a>
                            <a href="{{ route('pages-inventario-exportrecepcion') }}" class="btn btn-outline-success">Exportar a excel</a>                                                                      
                        @endif   
                    @endif                
                    </form>                             
                                                         
                @endif                
                <h6 class="align-left">Número de registro: {{ $salidas->first()->IdRegistro }}</h6>
            </div>            
            <div class="card-body">
                @if ($salidas->isNotEmpty())
                <div class="align-horizontal">
                    
                </div>
                @endif
                        
                @php
$Detalle = explode(', ', $requisiciones->first()->Detalle);
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
                        <th>Acciones</th> 
                    @endif
                </tr>
            </thead>
            <tbody>                     
                <form id="GuardadoGeneral"  method="POST" action="{{ route('pages-inventario-versalidas-Guardado', ['idRegistro' => $salidas->first()->IdRegistro])  }}"> 
                @csrf                     
                @foreach ($salidas as $index => $salida)
                <tr>                
                    <td>
                    {{ $index + 1 }}                                                                   
                    <input type="hidden" name="idProduct[]" value="{{$salida->IdProducto}}">
                    </td>
                    
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
                    
                    @if ($edicion == 2)
                        <td style="display:flex; justify-content:center; height:100px; align-items:center;">
                            <input style="width: 40px; text-align: center;" type="text" name="Cantidad[]" value="{{ $salida->Cantidad }}">
                        </td>

                        <td style="width:10px;">                                                
                            <input type="hidden" name="Eliminar[{{ $index }}]" id="Eliminar{{ $index  }}" value="0">
                            <button type="button" class="btn btn-danger eliminarBtn" onclick="cambiarEstado(this, {{ $index }})">Eliminar</button>
                        </td>
                        
                    @else
                        <td style="display:flex; justify-content:center; height:100px; align-items:center;">
                            {{ $salida->Cantidad }}
                    	</td>
                    @endif                
                </tr>                
                @endforeach      
                                  
            </tbody>
                    </table>
                
                </div>
                <br><br><br>                
                <div style="display:flex;">
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


    

    

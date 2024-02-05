<html>
<head>
    <style>
    
        {!! $css !!}
        
    </style>      
<img src="assets/img/illustrations/Logo.png" alt="LOGO">
</head>

<body>
    <h3 class="card-title">REQUISICIÓN DE INVENTARIO</h3>

        @if ($entradas->isNotEmpty())
        <div class="align-horizontal">
            <h5 class="align-left">Registro: {{ $entradas->first()->id }}</h5>
            <h5 class="align-right">La Ceiba, {{ $entradas->first()->created_at->format('d-m-Y') }}</h5>
            
        </div>
        
        @endif

        <div class="mb-3">
            <label for="detalle" class="form-label">Detalle de recepción</label>
        </div>
   

        <div class="mb-3 checkbox-group">
           
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="detalle[]" value="Equipo" id="equipo">
                <label class="form-check-label" for="equipo">
                    Equipo
                </label>
                <span class="check-indicator"></span>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="detalle[]" value="Material" id="material">
                <label class="form-check-label" for="material">
                    Material
                </label>
                <span class="check-indicator"></span>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="detalle[]" value="Insumos para MP" id="mp">
                <label class="form-check-label" for="mp">
                    Insumos para MP
                </label>
                <span class="check-indicator"></span>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="detalle[]" value="Insumos para MC" id="mc">
                <label class="form-check-label" for="mc">
                    Insumos para MC
                </label>
                <span class="check-indicator"></span>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="detalle[]" value="Repuestos" id="repuestos">
                <label class="form-check-label" for="repuestos">
                    Repuestos
                </label>
                <span class="check-indicator"></span>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="detalle[]" value="Otros" id="otros">
                <label class="form-check-label" for="otros">
                    Otros
                </label>
                <span class="check-indicator"></span>
            </div>
        </div>
        
        
    <table class="center-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Notas</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Costo Unitario</th>
                <th>Precio de Inventario</th>
                <th>Costo de Inventario</th>
                <th>Creado</th>
                <th>Actualizado</th>
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
                @forelse ($productos as $producto)
                @if ($producto->IdProducto == $entrada->IdProducto)
                <td>{{ $producto->PrecioUnitario }}</td>
                <td>{{ $producto->CostoUnitario }}</td>
                <td>{{ $producto->PrecioInventario }}</td>
                <td>{{ $producto->CostoInventario }}</td>
                @endif
                @empty
                <td>No hay productos disponibles</td>
                @endforelse
                <td>{{ $entrada->created_at }}</td>
                <td>{{ $entrada->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
 
    </table>

    <p>Nota: El receptor que firma este documento donde se detalla todo lo anteriormente
        descrito en cada uno de los elementos de esta REQUISICIÓN se hace responsable de
        presentar la evidencia correspondiente de dónde y cuándo fue instalado y utilizado.
        También es responsable del cuidado, el uso correcto y prudente de lo entregado.
        En caso de no justificar de manera correcta en el OWS de Huawei y con su supervisor,
        será responsable de responder por los daños ocasionados a la empresa ante
        los rechazos y reclamos de nuestro cliente.

        CC. Archivo
    </p>

   

</body>

</html>
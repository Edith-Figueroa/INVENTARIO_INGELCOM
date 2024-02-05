<html>
<head>
    <style>    
        {!! $css !!}
    </style>      
<img src="assets/img/illustrations/Logo.png" alt="LOGO">
</head>

<body>
    <h3 class="card-title">RECEPCIÓN DE INVENTARIO</h3>

        @if ($entradas->isNotEmpty())
        <div class="align-horizontal">
            <h5 class="align-left">Registro: {{ $entradas->first()->IdRegistro }}</h5>
            <h5 class="align-right">La Ceiba, {{ $entradas->first()->created_at->format('d-m-Y') }}</h5>
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
                <input class="form-check-input" type="checkbox" name="detalle[]" value="{{ $value }}" id="{{ strtolower(str_replace(' ', '', $value)) }}" {{ $checked }}>
                <label class="form-check-label" for="{{ strtolower(str_replace(' ', '', $value)) }}">
                    {{ $value }}
                </label>
                <span class="check-indicator"></span>
            </div>
            @endforeach
        </div>

    <table class="center-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Producto</th>
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
    <p>Nombre y firma de quien lo entrega: </p>
    <p>Nombre y firma del receptor responsable: </p>
    <p>Nombre y firma del supervisor que autoriza: </p>
    <p>Firma de RRHH: </p>
    <p>Firma de Administración</p>

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
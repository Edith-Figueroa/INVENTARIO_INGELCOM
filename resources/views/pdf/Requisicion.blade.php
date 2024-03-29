<html>

<head>
    <style>
        {

            @page {
                margin-top: 0;
            }

            .firma {
                width: 100%;
                height: 100px;
                1
            }

            .firma p {
                position: relative;
                width: 85%;
                height: 10%;
                /* margin: 5% 0%; */
            }

            .firma img {
                position: relative;
                width: 115px;
                height: auto;
                z-index: 5;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
            }

            th {
                background-color: #F4B084;
                font-weight: bold;
                text-align: center;
                border: 1px solid #000;
                padding: 5px;
            }

            td {
                background-color: #FFF2CC;
                text-align: center;
                border: 1px solid #000;
                padding: 5px;
            }

            .center-table {
                margin: 0 auto;
            }

            h3 {
                text-align: center;
                margin-top: 10%;
            }

            p {
                margin-top: 20px;
                text-align: justify;
                font-size: 12px;
            }

            .Logo {
                position: absolute;
                top: 0;
                left: 85%;
                max-width: 20%;
                margin: 0;
            }

            .align-horizontal {
                display: flex;
                align-items: center;
            }

            .align-left {
                display: inline-block;
                vertical-align: middle;
                margin-right: 20px;
            }

            .align-right {
                display: inline-block;
                vertical-align: middle;
            }

            .checkbox-group .form-check {
                display: inline-block;
                margin-right: 5px;
                margin-top: 10px;
                margin-bottom: 8px;
            }
        }
    </style>
    <img class="Logo" src="assets/img/illustrations/logo.png" alt=".
</head>

<body>
    <h3 class=" card-title">REQUISICIÓN DE INVENTARIO</h3>

    @if ($salidas->isNotEmpty())
    <div class="align-horizontal">
        <h5 class="align-left">Registro: {{ $salidas->first()->IdRegistro }}</h5>
        <h5 class="align-right">La Ceiba, {{ $salidas->first()->created_at->format('d-m-Y') }}</h5>
    </div>
    @endif

    <div class="mb-3">
        <label for="detalle" class="form-label">Detalle de recepción</label>
    </div>
    @php
    $Detalle = explode(', ', $requisiciones->first()->Detalle);
    @endphp

    <div class="mb-3 checkbox-group">
        @foreach(['Equipo', 'Material', 'Insumos', 'Insumos para MC', 'Repuestos', 'Otros'] as $value)
        @php
        $checked = in_array($value, $Detalle) ? 'checked' : '';
        @endphp
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="detalle[]" value="{{ $value }}"
                id="{{ strtolower(str_replace(' ', '', $value)) }}" {{ $checked }}>
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
            @foreach ($salidas as $index => $salida)
            <tr>
                <td>{{ $index + 1 }}</td>

                @forelse ($productos as $producto)
                @if ($producto->IdProducto == $salida->IdProducto)
                <td>{{ $producto->NombreP }}</td>
                @endif
                @empty
                <td>No hay productos disponibles</td>
                @endforelse


                <td>{{ $salida->Notas }}</td>
                <td>{{ $salida->Cantidad }}</td>

            </tr>
            @endforeach
        </tbody>

    </table>
    <br>

    <div class="firma">
        <p>Nombre y firma de quien lo entrega: <b>{{$NameEntrega}} </b></p>
        @if ($Entrega)
        <img src="data:image/jpeg;base64,{{ base64_encode($Entrega) }}" alt=".">    
        @endif
        
    </div>

    <div class="firma">
        <p>Nombre y firma del receptor responsable: <b>{{$NameReceptor}} </b></p>

        @if ($Receptor)
        <img src="data:image/jpeg;base64,{{ base64_encode($Receptor) }}" alt=".">
        @endif
    </div>

    <div class="firma">
        <p>Nombre y firma del supervisor que autoriza: <b>{{$NameSupervisor}}</b></p>
        @if ($Supervisor)
        <img src="data:image/jpeg;base64,{{ base64_encode($Supervisor) }}" alt=".">    
        @endif
        
    </div>
    <div class="firma">
        <p>Firma de RRHH: <b>{{$NameRRHH}}</b></p>
        @if ($RRHH)
        <img src="data:image/jpeg;base64,{{ base64_encode($RRHH) }}" alt=".">    
        @endif
        
    </div>
    <div class="firma">
        <p>Firma de Administración <b>{{$NameAdministracion}}</b></p>
        @if ($Administracion)
        <img src="data:image/jpeg;base64,{{ base64_encode($Administracion) }}" alt=".">    
        @endif
        
    </div>

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
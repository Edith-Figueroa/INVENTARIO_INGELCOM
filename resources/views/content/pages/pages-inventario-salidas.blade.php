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
                @if ($role == 1 || $role == 2)
                <a href="{{route ('pages-inventario-createsalidas')}}" class="btn btn-primary">Añadir nueva salida</a>
                <a href="{{route ('pages-inventario-exportsalidas')}}" class="btn btn-success">Exportar a Excel</a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">CODIGO</th>
                                <th scope="col">DETALLE</th>
                                <th scope="col">ENTREGA</th>
                                <th scope="col">RECEPTOR</th>
                                <th scope="col">SUPERVISOR</th>
                                <th scope="col">RRHH</th>
                                <th scope="col">ADMINISTRACIÓN</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">ESTADO</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($SalidaJoin as $SalidJoins)
                            <tr>
                                <th scope="row">
                                    {{$SalidJoins->id}}
                                    <br>                      
                                    <form
                                        action="{{ route('pages-inventario-versalidas', ['idRegistro' => $SalidJoins->id, 'edicion' => 1]) }}"
                                        method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">ver</button>
                                    </form>                                                                         
                                </th>

                                <td>{{$SalidJoins->Detalle }}</td>
                                <td>
                                    <a href="{{ $SalidJoins->Email_Entrega }}"
                                        onmouseover="buscarUsuario('{{ $SalidJoins->Email_Entrega }}')">{{ $SalidJoins->Email_Entrega }}</a>
                                </td>
                                <td>
                                <a href="{{ $SalidJoins->Email_Receptor }}"
                                        onmouseover="buscarUsuario('{{ $SalidJoins->Email_Receptor }}')">{{ $SalidJoins->Email_Receptor }}</a>
                                </td>
                                <td>{{$SalidJoins->Supervisor }}</td>
                                <td>{{$SalidJoins->RRHH }}</td>
                                <td>{{$SalidJoins->Administracion }}</td>
                                <td>{{$SalidJoins->Fecha }}</td>

                                <td>
                                    @if ($SalidJoins->Supervisor == "si" && $SalidJoins->Administracion == "si" &&
                                    $SalidJoins->RRHH == "si")
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960"
                                        width="40" fill="green">
                                        <path d="M379.333-244 154-469.333 201.666-517l177.667 177.667 378.334-378.334L805.333-670l-426 426Z" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" height="40"
                                        viewBox="0 -960 960 960" fill="red" width="40">
                                        <path d="m251.333-204.667-46.666-46.666L433.334-480 204.667-708.667l46.666-46.666L480-526.666l228.667-228.667 46.666 46.666L526.666-480l228.667 228.667-46.666 46.666L480-433.334 251.333-204.667Z" />
                                    </svg>
                                    @endif
                                </td>                            
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Define la función buscarUsuario
    function buscarUsuario(correo) {
    $.ajax({
        type: 'GET',
        url: '/buscar-usuario/' + encodeURIComponent(correo),
        success: function (response) {
            if (response.usuario) {
                var nombreUsuarioDiv = '<div class="nombre-usuario-temporal">' + response.usuario.name + '</div>';
                $('a[href="' + correo + '"]').parent('td').append(nombreUsuarioDiv);
                                
                setTimeout(function() {
                    $('.nombre-usuario-temporal').fadeOut(1000, function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        },
        error: function () {
            alert('Error al buscar el usuario');
        }
    });
}

$(document).ready(function () {
    $('.usuario-correo').mouseover(function () {
        var correo = $(this).attr('href');
        buscarUsuario(correo);
    });
});

</script>

@endsection
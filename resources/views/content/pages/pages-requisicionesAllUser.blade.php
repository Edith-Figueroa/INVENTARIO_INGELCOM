@extends('layouts/layoutMaster')

@section('title', 'Requisiciones Usuarios')

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')

<body>
    <h1>REQUISICIONES POR USUARIO</h1>
    <div class="Contenedor" style="width: 90%; position: relative;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">CODIGO</th>
                    <th scope="col">CATEGORÍA</th>
                    <th scope="col">ENTREGA</th>
                    <th scope="col">RECEPTOR</th>
                    <th scope="col">FECHA</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisicions as $requisicion)
                <tr>
                    <td>
                        {{$requisicion->id}}
                        <br>
                        <form action="{{ route('pages-inventario-versalidas', ['idRegistro' => $requisicion->id, 'edicion' => 1]) }}"
                            method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Ver</button>
                        </form>
                    </td>
                    <td>{{$requisicion->Detalle}} </td>
                    <td>{{$requisicion->Email_Entrega}}</td>
                    <td>{{$requisicion->Email_Receptor}}</td>
                    <td>{{$requisicion->Fecha}}</td>
                    <td>
                        @if ($requisicion->Estado == 1)
                        <p>Aprobado</p>
                        @elseif ($requisicion->Estado == 0)
                        <p>Denegado</p>                        
                        @endif
                    </td>
                    @if ($role == 3 || $role == 4 || $role == 5)
                    <td>
                        <form
                            action="{{ route('actualizar_estado_requisicion', ['id' => $requisicion->id, 'valor' => 1]) }}"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </form>
                        <br>
                        <form
                            action="{{ route('actualizar_estado_requisicion', ['id' => $requisicion->id , 'valor' => 0]) }}"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">Denegar</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
    @endsection
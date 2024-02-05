@extends('layouts/layoutMaster')

@section('title', 'Crear categoria')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
    <!-- Register Card -->
    <h4 class="mb-0" style="text-aling: center">Creando una nueva categoría</h4><br>
    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('pages-categorias-store') }}" >
        @csrf
        <div class="mb-3">
            <label for="NombreC" class="form-label">Nombre de la categoría</label>
            <input type="text" class="form-control" id="NombreC" name="NombreC" placeholder="Producto" autofocus value="{{ old('NombreC') }}" />
            <div id="nombreCError" class="text-danger"></div>
        </div>
        <div class="mb-3">
            <label for="DescripcionC" class="form-label">Descripción de la categoría</label>
            <textarea class="form-control" id="DescripcionC" name="DescripcionC" placeholder="Descripción"  value="{{ old('DescripcionC') }}"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button> <!--BOTÓN ENVIAR -->
          <a href="{{route ('pages-categorias')}}" class="btn btn-primary">Regresar</a> <!--BOTÓN REGRESAR -->
    </form>

    {{-- VALIDACIONES DEL FORMULARIO --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#formAuthentication').submit(function(e) {
                var nombreC = $('#NombreC').val();
                if (nombreC === '') {
                    $('#nombreCError').text('El campo Nombre de la categoría es obligatorio.');
                    e.preventDefault(); // Evita que el formulario se envíe si hay errores.
                } else {
                    $('#nombreCError').text(''); // Limpia el mensaje de error si el campo es válido.
                }
            });
        });
    </script>
@endsection
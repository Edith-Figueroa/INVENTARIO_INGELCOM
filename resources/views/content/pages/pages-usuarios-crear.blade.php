@extends('layouts/layoutMaster')

@section('title', 'Crear Usuario')

@section('page-style')
<!-- ESTILO CSS -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}"> 
@endsection

@section('content')
    <h4>Creando un nuevo usuario</h4>
    <!-- Register Card -->
    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('pages-usuarios-store') }}" enctype="multipart/form-data">
        @csrf <!-- TOKEN DE SEGURIDAD -->
        <div class="mb-3">
          <label for="IdCategoria" class="form-label">Rol</label>
          <select class="form-select categoria-select" name="IdCategoria" id="IdCategoria">
              <option value="">Selecciona un rol</option>
              @foreach ($roles as $role)
                  <option value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
          </select>
          <div id="rolError" class="text-danger"></div>
      </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="nombre" name="name" placeholder="johndoe" autofocus value="{{ old('name') }}" />
            <div id="nombreError" class="text-danger"></div>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="text" class="form-control" id="correo" name="email" placeholder="john@example.com" value="{{ old('email') }}" />
            <div id="correoError" class="text-danger"></div>
        </div>
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="contraseña">Contraseña</label>
            <div class="input-group input-group-merge">
                <input type="password" id="contraseña" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="contraseña" />
                <span class="input-group-text cursor-pointer">
                    <i class="bx bx-hide"></i>
                </span>
            </div>
            <div id="contraseñaError" class="text-danger"></div>
        </div>
        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="confirmar-contraseña">Confirmar contraseña</label>
            <div class="input-group input-group-merge">
                <input type="password" id="confirmar-contraseña" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7" aria-describedby="contraseña" />
                <span class="input-group-text cursor-pointer">
                    <i class="bx bx-hide"></i>
                </span>
            </div>
        </div>

<input type="hidden" name="firma_source" id="firma_source" />
<div class="mb-3">
<div class="text-center"> <!-- Centra el contenido -->
                    <div id="signature-pad" class="signature-pad mx-auto d-inline-block">
                        <div class="border p-2">
                            <canvas width="300" height="150"></canvas>
                            <input type="hidden" name="firma_canvas" id="firma_canvas" />
                        </div>
                    </div>
                </div>
</div>

        <div class="mb-3">
            <button type="button" class="btn btn-secondary" onclick="limpiarFirma()">Limpiar Firma</button>
        </div>

<div class="mb-3">
    <label for="firma_file" class="form-label">O Cargar Firma desde Archivo</label>
    <input type="file" class="form-control" id="firma_file" name="firma_file" accept="image/*">
</div>

            
           
        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="mb-1">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms" name="terms" />
                <label class="form-check-label" for="terms">
                    I agree to the
                    <a href="{{ route('terms.show') }}" target="_blank">
                        terms_of_service
                    </a> and
                    <a href="{{ route('policy.show') }}" target="_blank">
                        privacy_policy
                    </a>
                </label>
            </div>
        </div>
        @endif
        <button type="submit" class="btn btn-primary">Guardar</button> <!--BOTÓN ENVIAR -->
        <a href="{{ route('pages-usuarios') }}" class="btn btn-primary">Regresar</a>  {{-- BOTÓN REGRESAR --}}
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    $(document).ready(function() {
      $('#formAuthentication').submit(function(e) {
        var rol = $('#IdCategoria');
        var nombre = $('#nombre').val();
        var correo = $('#correo').val();
        var contraseña = $('#contraseña').val();
        var confirmarContraseña = $('#confirmar-contraseña').val();

        if (rol.prop('selectedIndex') === -1) {
            $('#rolError').text('El campo Rol es obligatorio.');
            e.preventDefault();
        } else {
            $('#rolError').text('');
        }

        if (nombre.trim() === '') {
            $('#nombreError').text('El campo Nombre de usuario es obligatorio.');
            e.preventDefault();
        } else {
            $('#nombreError').text('');
        }

        if (correo.trim() === '') {
            $('#correoError').text('El campo Correo electrónico es obligatorio.');
            e.preventDefault();
        } else {
            $('#correoError').text('');
            if (!isValidEmail(correo)) {
                $('#correoError').text('El correo electrónico no es válido.');
                e.preventDefault();
            } else {
                $('#correoError').text('');
            }
        }

        if (contraseña.trim() === '' || confirmarContraseña.trim() === '') {
            $('#contraseñaError').text('Los campos de contraseña son obligatorios.');
            $('#confirmarContraseñaError').text('Los campos de contraseña son obligatorios.');
            e.preventDefault();
        } else if (contraseña !== confirmarContraseña) {
            $('#contraseñaError').text('Las contraseñas no coinciden.');
            $('#confirmarContraseñaError').text('');
            e.preventDefault();
        } else {
            $('#contraseñaError').text('');
            $('#confirmarContraseñaError').text('');
        }
    });

    function isValidEmail(email) {
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailRegex.test(email);
    }
});

   </script>
    @endsection

    @section('page-script')
<script src="https://unpkg.com/signature_pad"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
var canvas = document.querySelector("canvas");
var signaturePad = new SignaturePad(canvas);

document.getElementById('formAuthentication').addEventListener('submit', function () {
// Determine la fuente de la firma (canvas o archivo) y actualice el campo oculto
if (signaturePad.isEmpty()) {
document.getElementById('firma_source').value = 'archivo';
} else {
document.getElementById('firma_source').value = 'canvas';
document.getElementById('firma_canvas').value = signaturePad.toDataURL();
}
});

 // Función para limpiar la firma en el canvas
 window.limpiarFirma = function () {
      signaturePad.clear();
    };
});
</script>
@endsection
@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Registro')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')

<div class="authentication-wrapper authentication-cover">
  <div class="authentication-inner row m-0">


    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
      <div class="w-px-400 mx-auto">
        <!-- Logo -->
        <div class="app-brand justify-content-center mb-4">
          <a href="{{ url('/') }}" class="app-brand-link gap-2 mb-2 custom-logo-container">
            <img src="{{ asset('assets/img/illustrations/Logo.png') }}" alt="" class="custom-logo">
          </a>
        </div>
        <!-- /Logo -->

        <!-- Register Card -->
        <h4 class="mb-2">Registrate</h4>
        <!-- <p class="mb-4">Make your app management easy and fun!</p> -->

        <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="hidden" id="idRole" name="idRole" value="6">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="name"
              placeholder="johndoe" autofocus value="{{ old('name') }}" />
            @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
              placeholder="john@example.com" value="{{ old('email') }}" />
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Contraseña</label>
            <div class="input-group input-group-merge @error('password') is-invalid @enderror">
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password" />
              <span class="input-group-text cursor-pointer">
                <i class="bx bx-hide"></i>
              </span>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password-confirm">Confirmar contraseña</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password-confirm" class="form-control" name="password_confirmation"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password" />
              <span class="input-group-text cursor-pointer">
                <i class="bx bx-hide"></i>
              </span>
            </div>
          </div>
          <div class="mb-3">
            <label for="firma" class="form-label">Firma Digital</label>
            <div id="signature-pad" class="signature-pad">
              <div class="border p-2">
                <canvas></canvas>
                <input type="hidden" name="firma" id="firma" />
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="firma_file" class="form-label">O Cargar Firma desde Archivo</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
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
          <button type="submit" class="btn btn-primary d-grid w-100">Crear</button>
        </form>

        <p class="text-center mt-2">
          <span>¿Ya tienes una cuenta?</span>
          @if (Route::has('login'))
          <a href="{{ route('login') }}">
            <span>Inicia Sesión</span>
          </a>
          @endif
        </p>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>


@endsection




@section('page-script')
<script src="https://unpkg.com/signature_pad"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var canvas = document.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas);

    document.getElementById('formAuthentication').addEventListener('submit', function () {
      // Al enviar el formulario, convierte la firma en formato base64 y guárdala en el campo oculto
      document.getElementById('firma').value = signaturePad.toDataURL();
    });
  });
</script>
@endsection
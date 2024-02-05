@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover">
  <div class="authentication-inner row m-0">    
    <!-- Forgot Password -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
      <div class="w-px-400 mx-auto">
       <!-- Logo -->
       <div class="app-brand justify-content-center mb-4">
          <a href="{{ url('/') }}" class="app-brand-link gap-2 mb-2 custom-logo-container">
            <img src="{{ asset('assets/img/illustrations/Logo.png') }}" alt="" class="custom-logo"  > 
          </a>
        </div>
        <h4 class="mb-2">Bienvenido  👋</h4>

        <!-- SECCIÓN PARA INICIO DE SESIÓN -->
        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
          @csrf
          <div class="mb-3">
              <label for="login-email" class="form-label">Correo</label>
              <input type="text" class="form-control" id="login-email" name="email" placeholder="john@example.com" autofocus value="{{ old('email') }}">
              <div id="emailError" class="text-danger"></div>
          </div>
          <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                  <label class="form-label" for="login-password">Contraseña</label>
                  @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}">
                    <small>¿Olvidaste tu contraseña?</small>
                  </a>
                  @endif
              </div>
              <div class="input-group input-group-merge">
                  <input type="password" id="login-password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              <div id="passwordError" class="text-danger"></div>
          </div>
      
          <div id="generalError" class="text-danger"></div>
      
          <div class="mb-3">
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="form-check-label" for="remember-me">
                      Recuérdame
                  </label>
              </div>
          </div>

          <p class="text-center">
          <span>¿Eres nuevo?</span>
          @if (Route::has('register'))
          <a href="{{ route('register') }}">
            <span>Crear cuenta</span>
          </a>
          @endif
        </p>

          <button class="btn btn-primary d-grid w-100" type="submit">Iniciar Sesión</button>
        </form>
      

        @include('sweetalert::alert')



  </div>
</div>
</div>
</div>

<!-- VALIDACIONES DE FORMULARIO -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
      $('#formAuthentication').submit(function(e) {
          // Validar el campo de correo
          var email = $('#login-email').val();
          if (email === '') {
              $('#emailError').text('El campo Correo es obligatorio.');
              e.preventDefault();
          } else {
              $('#emailError').text('');
          }
          
          // Validar el campo de contraseña
          var password = $('#login-password').val();
          if (password === '') {
              $('#passwordError').text('El campo Contraseña es obligatorio.');
              e.preventDefault();
          } else {
              $('#passwordError').text('');
          }
      });
  });
</script>

@endsection
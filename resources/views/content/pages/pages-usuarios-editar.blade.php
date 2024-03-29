@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Actualizar Usuario')

@section('vendor-style')
<!-- Vendor -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('page-style')
<!-- ESTILO CSS -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<h4>Editando un usuario</h4>
<!-- Register Card -->
<form id="formAuthentication" class="mb-3" method="POST" action="{{ route('pages-usuarios-update') }}"
  enctype="multipart/form-data">
  @csrf <!-- TOKEN DE SEGURIDAD -->
  <input type="hidden" name="user_id" value="{{$user->id}}">
  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre de usuario</label>
    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="name"
      value="{{$user->name}}" placeholder="johndoe" autofocus value="{{ old('name') }}" />
    @error('nombre')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  <div class="mb-3">
    <label for="correo" class="form-label">Correo electronico</label>
    <input type="text" class="form-control @error('correo') is-invalid @enderror" id="correo" name="email"
      value="{{$user->email}}" placeholder="john@example.com" value="{{ old('email') }}" />
    @error('correo')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  <div class="mb-3 form-password-toggle">
    <label class="form-label" for="confirmar-contraseña">Contraseña</label>
    <div class="input-group input-group-merge">
      <input type="password" id="confirmar-contraseña" class="form-control" name="new_password"
        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
        aria-describedby="contraseña" />
      <span class="input-group-text cursor-pointer">
        <i class="bx bx-hide"></i>
      </span>
    </div>
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
  <div class="mb-3">
    <label for="imagen" class="form-label">O Cargar Firma desde Archivo</label>
    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button> <!--BOTÓN ENVIAR -->
  <a href="{{route ('pages-usuarios')}}" class="btn btn-primary">Regresar</a> <!--BOTÓN REGRESAR -->
</form>
@endsection
@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Reset Password')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-Login.css')) }}">
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover">
  <div class="authentication-inner row m-0">

    <!-- Reset Password -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
      <div class="w-px-400 mx-auto">
        <!-- Logo -->
        <div class="app-brand justify-content-center mb-4">
          <a href="{{ url('/') }}" class="app-brand-link gap-2 mb-2 custom-logo-container">
            <img src="{{ asset('assets/img/illustrations/Logo.png') }}" alt="" class="custom-logo custom-logo-small"> <!-- Agrega la clase custom-logo-small -->
          </a>
          
        </div>
        
        <!-- /Logo -->
        <h4 class="mb-2">Resetear contraseña 🔒</h4>
        <form id="formAuthentication" class="mb-3" action="{{ route('password.update') }}" method="POST">
          @csrf
          <input type="hidden" name="token" value="{{ $request->route('token') }}">

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('correo') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" value="{{Request()->email}}" readonly />
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">New Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autofocus />
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
            <label class="form-label" for="confirm-password">Confirm Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="confirm-password" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
              <span class="input-group-text cursor-pointer">
                <i class="bx bx-hide"></i>
              </span>
            </div>
          </div>
          <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
            Set new password
          </button>
          <div class="text-center">
            @if (Route::has('login'))
            <a href="{{ route('login') }}">
              <i class="bx bx-chevron-left scaleX-n1-rtl"></i>
              Back to login
            </a>
            @endif
          </div>
        </form>
      </div>
    </div>
    <!-- /Reset Password -->
  </div>
</div>
@endsection
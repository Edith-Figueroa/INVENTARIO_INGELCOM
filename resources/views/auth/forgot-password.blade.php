@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Forgot Password')

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
      <a href="{{url('/')}}" class="app-brand-link gap-2 mb-2">
        <span class="app-brand-text demo h3 mb-0 fw-bold">{{config('variables.templateName')}}</span>
      </a>
    </div>
    <!-- /Logo -->
    <h4 class="mb-2">¿Olvidaste tu contraseña
      ? 🔒</h4>
    <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>

    @if (session('status'))
    <div class="mb-1 text-success">
      {{ session('status') }}
    </div>
    @endif

    <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
    </form>
    <div class="text-center">
      @if (Route::has('login'))
      <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
        <i class="bx bx-chevron-left scaleX-n1-rtl"></i>
        Back to login
      </a>
      @endif
    </div>
  </div>
</div>
<!-- /Forgot Password -->
  </div>
</div>
@endsection
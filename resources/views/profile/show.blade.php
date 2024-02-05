@extends('layouts.layoutMaster')

@php
$breadcrumbs = [['link' => 'home', 'name' => 'Home'], ['link' => 'javascript:void(0)', 'name' => 'User'], ['name' => 'Profile']];
@endphp

@section('title', 'Perfil')


@section('content')
 {{-- Actualizar información --}}
  @if (Laravel\Fortify\Features::canUpdateProfileInformation())
   <div class="mb-4">
      @livewire('profile.update-profile-information-form')
   </div>
  @endif

  {{-- Actualizar contraseña --}}
  @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
    <div class="mb-4">
      @livewire('profile.update-password-form')
    </div>
  @endif

  <!-- Apartado de dispositivos en los que se ha iniciado sesiones -->
  <div class="mb-4">
    @livewire('profile.logout-other-browser-sessions-form')
  </div>

@endsection

@php
// OBTENER LA CONFIGURACIÓN DE LA APLICACIÓN
$configData = Helper::appClasses();
@endphp

{{-- ESTILO DEL MENÚ --}}
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

<!-- ENCABEZADO DEL MENU -->
@if(!isset($navbarFull))
<div class="app-brand demo">
  <a href="{{url('/')}}" class="app-brand-link">
    <span class="app-brand-logo demo">
      <img src="{{ asset('assets/img/favicon/favicon.ico') }}" alt="" class="custom-logo img-fluid"  > 
    </span>
    <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
  </a>

  <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
    <i class="bx bx-menu d-none d-xl-block fs-4 align-middle"></i>{{-- ICONO DEL MENÚ --}}
    <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>{{-- ICONO PARA QUE CUANDO SE USE EN MOVIL APAREZCA X DE CERRAR EL MENÚ --}}
  </a>
</div>
@endif

  <!-- !LINEA DIVISORA DEL MENÚ -->
  @if(!isset($navbarFull))
  <div class="menu-divider mt-0 ">
  </div>
  @endif

  {{-- PERMITE EXTENDER EL MENÚ --}}
  <div class="menu-inner-shadow"></div>

  {{-- PERMITE REDUCIR EL MENÚ --}}
  <ul class="menu-inner py-1">
  
  @foreach ($menuData[0]->menu as $menu)
   {{-- ENCABEZADOS DE MENÚ --}}
    @if (isset($menu->menuHeader))
    {{-- <li class="menu-header small text-uppercase">
      <span class="menu-header-text">{{ $menu->menuHeader }}</span>
    </li> --}}
    @else
    
    {{-- método de menú activo --}}
    @php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    }
    elseif (isset($menu->submenu)) {
    if (gettype($menu->slug) === 'array') {
    foreach($menu->slug as $slug){
    if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }
    else{
    if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }
    @endphp

    {{-- MENU PRINCIPAL--}}
    <li class="menu-item {{$activeClass}}">
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
        <i class="{{ $menu->icon }}"></i>  {{-- ICONOS DE ITEMS MENÚ --}}
        @endisset
        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>{{-- NOMBRE DE ITEMS DEL MENÚ --}}
      </a>

      {{-- SUBMENÚS--}}
      @isset($menu->submenu)
      @include('layouts.sections.menu.submenu',['menu' => $menu->submenu]){{-- AGREGA INFORMACIÓN DE SUB MENÚ Y PERMITE NAVEGAR EN ELLOS --}}
      @endisset
    </li>
    @endif
    @endforeach
  </ul>
</aside>
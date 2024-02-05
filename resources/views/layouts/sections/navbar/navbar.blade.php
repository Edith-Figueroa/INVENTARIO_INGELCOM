@php
// CONTENEDOR DE NAVEGACIÓN, PUEDE SER 'CONTAINER-FULL' POR DEFECTO
$containerNav = $containerNav ?? 'container-fluid';

// NOMBRES DE ROLES PARA MOSTRAR EN EL MENÚ
$roleNames = [
    'Administrador' => 'Administrador',
    'JefeInventario' => 'Jefe de Inventario',
    'RRHH' => 'Recursos Humanos',
    'Administracion' => 'Administración',
    'Supervisor' => 'Supervisor',
    'Usuario' => 'Usuario',
];
@endphp

<!-- INICIO: BARRA DE NAVEGACIÓN -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="{{$containerNav}}">

    <!-- DEMO DE LA MARCA (VISIBLE SOLO PARA NAVBAR-FULL Y OCULTA EN DISPOSITIVOS INFERIORES A XL) -->
    @if(isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
      <a href="{{url('/')}}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">
        </span>
        <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
      </a>

      @if(isset($menuHorizontal))
        <!-- MOSTRAR ÍCONO DE CIERRE DEL MENÚ SOLO PARA HORIZONTAL-MENU CON NAVBAR-FULL -->
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
        <i class="bx bx-x bx-sm align-middle"></i>
      </a>
      @endif
    </div>
    @endif

    @if(!isset($navbarHideToggle))
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>
    @endif

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

       <!-- SELECTOR DE ESTILO -->
      <div class="navbar-nav align-items-center">
        <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
          <i class='bx bx-sm'></i>
          Oscuro
        </a>
      </div>
      <!--/ SELECTOR DE ESTILO -->

      <div class="navbar-nav align-items-center">
        <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
          NOTIFICACIONES
        </a>
      </div> 

      <ul class="navbar-nav flex-row align-items-center ms-auto">

 <!-- USUARIO -->
<li class="nav-item navbar-dropdown dropdown-user dropdown">
  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
      <div class="d-flex align-items-center">
          <div class="flex-grow-1 d-flex align-items-center"> <!--centrar verticalmente -->
            <span class="fw-semibold d-block ">
              @if (Auth::check())
              {{ Auth::user()->name }}
              &ensp;&ensp;<i class="avatar avatar-online"></i>
              @else
              User
              @endif
          </span>
          
          
                </div>
              </div>
          </a>

          <ul class="dropdown-menu dropdown-menu-end">
              <!-- Contenido del menú desplegable aquí -->
             
              <li class="d-flex justify-content-start align-items-center px-3">
                <div class="d-flex flex-column align-items-start">
                    <span>{{ Auth::user()->name }}</span>
                    @if (Auth::check())
                        <small class="text-muted">
                            @foreach(Auth::user()->role as $role)
                                {{ $roleNames[$role->name] }} {{-- Esto mostrará el nombre personalizado del rol --}}
                            @endforeach
                        </small>
                    @endif
                </div>
            </li>
            
            
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="{{ Route::has('profile.show') ? route('profile.show') : 'javascript:void(0);' }}">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">Mi Perfil</span>|
              </a>
            </li>

            <li>
              <div class="dropdown-divider"></div>
            </li>

            @if (Auth::check())
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class='bx bx-power-off me-2'></i>
                <span class="align-middle">Cerrar Sesión</span>
              </a>
            </li>
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
              @csrf
            </form>
            @else
            <li>
              <a class="dropdown-item" href="{{ Route::has('login') ? route('login') : 'javascript:void(0)' }}">
                <i class='bx bx-log-in me-2'></i>
                <span class="align-middle">Inicio de Sesión</span>
              </a>
            </li>
            @endif
          </ul>
        </li>
         <!--/ USUARIO -->
      </ul>
    </div>
  </div>
</nav>
<!-- / BARRA DE NAVEGACIÓN -->
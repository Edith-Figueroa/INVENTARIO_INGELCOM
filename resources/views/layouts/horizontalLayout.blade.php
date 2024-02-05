@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/commonMaster' )
@php

$menuHorizontal = true;
$navbarFull = true;

/* Display elements */
$isNavbar = ($isNavbar ?? true);
$isMenu = ($isMenu ?? true);
$isFlex = ($isFlex ?? false);
$isFooter = ($isFooter ?? true);
$customizerHidden = ($customizerHidden ?? '');
$pricingModal = ($pricingModal ?? false);

/* HTML Classes */
$menuFixed = (isset($configData['menuFixed']) ? $configData['menuFixed'] : '');
$navbarFixed = (isset($configData['navbarFixed']) ? $configData['navbarFixed'] : '');
$footerFixed = (isset($configData['footerFixed']) ? $configData['footerFixed'] : '');
$menuCollapsed = (isset($configData['menuCollapsed']) ? $configData['menuCollapsed'] : '');

/* Content classes */
$container = ($container ?? 'container-xxl');
$containerNav = ($containerNav ?? 'container-xxl');

@endphp

{{-- SECCIÓN 'LAYOUTCONTENT' --}}
@section('layoutContent')
    {{-- CONTENEDOR PRINCIPAL DE LA PÁGINA --}}
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">

            <!-- NAVBAR -->
            @if ($isNavbar)
                @include('layouts/sections/navbar/navbar')
            @endif
            <!-- FIN DE LA NAVBAR -->

            <!-- PÁGINA DEL DISEÑO -->
            <div class="layout-page">

                <!-- ENVOLTORIO DEL CONTENIDO -->
                <div class="content-wrapper">

                    <!-- MENÚ HORIZONTAL -->
                    @if ($isMenu)
                        @include('layouts/sections/menu/horizontalMenu')
                    @endif
                    <!-- FIN DEL MENÚ HORIZONTAL -->

                    <!-- CONTENIDO -->
                    @if ($isFlex)
                        <div class="{{$container}} d-flex align-items-stretch flex-grow-1 p-0">
                    @else
                        <div class="{{$container}} flex-grow-1 container-p-y">
                    @endif

                        @yield('content') {{-- SECCIÓN DONDE SE INYECTA EL CONTENIDO ESPECÍFICO DE CADA PÁGINA --}}

                        <!-- MODAL DE PRECIOS -->
                        @if ($pricingModal)
                            @include('_partials/_modals/modal-pricing')
                        @endif
                        <!-- FIN DEL MODAL DE PRECIOS -->

                    </div>
                    <!-- FIN DEL CONTENIDO -->

                    <!-- FOOTER -->
                    @if ($isFooter)
                        @include('layouts/sections/footer/footer')
                    @endif
                    <!-- FIN DEL FOOTER -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- / ENVOLTORIO DEL CONTENIDO -->
            </div>
            <!-- / PÁGINA DEL DISEÑO -->
        </div>
        <!-- / CONTENEDOR DEL DISEÑO -->

        @if ($isMenu)
            <!-- OVERLAY -->
            <div class="layout-overlay layout-menu-toggle"></div>
        @endif
        <!-- ÁREA DE DESTINO DE ARRASTRE PARA DESLIZAR EL MENÚ EN PANTALLAS PEQUEÑAS -->
        <div class="drag-target"></div>
    </div>
    <!-- / ENVOLTORIO DEL DISEÑO -->
@endsection

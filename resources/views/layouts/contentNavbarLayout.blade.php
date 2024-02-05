@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/commonMaster' )

@php
/* ELEMENTOS A MOSTRAR */
$contentNavbar = ($contentNavbar ?? true);
$isNavbar = ($isNavbar ?? true);
$isMenu = ($isMenu ?? true);
$isFlex = ($isFlex ?? false);
$isFooter = ($isFooter ?? true);
$customizerHidden = ($customizerHidden ?? '');
$pricingModal = ($pricingModal ?? false);

/* CLASES HTML */
$menuFixed = (isset($configData['menuFixed']) ? $configData['menuFixed'] : '');
$navbarFixed = (isset($configData['navbarFixed']) ? $configData['navbarFixed'] : '');
$footerFixed = (isset($configData['footerFixed']) ? $configData['footerFixed'] : '');
$menuCollapsed = (isset($configData['menuCollapsed']) ? $configData['menuCollapsed'] : '');

/* CLASES DE CONTENIDO */
$container = ($container ?? 'container-xxl');
@endphp

<!-- SECCIÓN DEL CONTENIDO -->

@section('layoutContent')
    <div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
        <div class="layout-container">

            @if ($isMenu)
                @include('layouts/sections/menu/verticalMenu') <!-- INCLUYE EL MENÚ VERTICAL -->
            @endif

            <!-- PÁGINA DE DISEÑO -->
            <div class="layout-page">
                <!-- INICIO: BARRA DE NAVEGACIÓN -->
                @if ($isNavbar)
                    @include('layouts/sections/navbar/navbar') <!-- INCLUYE LA BARRA DE NAVEGACIÓN -->
                @endif
                <!-- FIN: BARRA DE NAVEGACIÓN -->

                <!-- CONTENEDOR DE CONTENIDO -->
                <div class="content-wrapper">

                    <!-- CONTENIDO -->
                    @if ($isFlex)
                        <div class="{{$container}} d-flex align-items-stretch flex-grow-1 p-0">
                    @else
                        <div class="{{$container}} flex-grow-1 container-p-y">
                    @endif

                        @yield('content') <!-- MUESTRA EL CONTENIDO DE LA SECCIÓN ACTUAL -->

                        <!-- MODAL DE PRECIOS -->
                        @if ($pricingModal)
                            @include('_partials/_modals/modal-pricing') <!-- INCLUYE EL MODAL DE PRECIOS -->
                        @endif
                        <!--/ MODAL DE PRECIOS -->

                    </div>
                    <!-- / CONTENIDO -->

                    <!-- PIE DE PÁGINA -->
                    @if ($isFooter)
                        @include('layouts/sections/footer/footer') <!-- INCLUYE EL PIE DE PÁGINA -->
                    @endif
                    <!-- / PIE DE PÁGINA -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ CONTENEDOR DE CONTENIDO -->
            </div>
            <!-- / PÁGINA DE DISEÑO -->

            @if ($isMenu)
                <!-- OVERLAY -->
                <div class="layout-overlay layout-menu-toggle"></div>
            @endif
            <!-- ÁREA DE DESTINO PARA DESLIZAR EL MENÚ EN PANTALLAS PEQUEÑAS -->
            <div class="drag-target"></div>
        </div>
        <!-- / CONTENEDOR DE DISEÑO -->
    @endsection

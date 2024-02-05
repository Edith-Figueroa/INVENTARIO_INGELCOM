@isset($pageConfigs)

/* Actualiza la configuración de la página utilizando el método updatePageConfig de la clase Helper */
{!! Helper::updatePageConfig($pageConfigs) !!}

@endisset

<!-- Bloque PHP para definir la variable $configData, que almacena las clases de la aplicación  -->
@php
$configData = Helper::appClasses();

/* Elementos para mostrar */
$customizerHidden = ($customizerHidden ?? '');

@endphp

<!-- Extiende la plantilla 'layouts/commonMaster' -->
@extends('layouts/commonMaster' )

<!-- Define la sección 'layoutContent' -->
@section('layoutContent')

<!-- Content -->
@yield('content')
<!--/ Content -->

@endsection

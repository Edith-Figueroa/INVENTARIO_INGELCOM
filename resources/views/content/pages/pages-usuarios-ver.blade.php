@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Detalles de Usuario')

@section('vendor-style') 
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
@endsection 

@section('page-style')
    <!-- ESTILO CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}"> 
    <style>
        /* Estilos adicionales para centrar y aplicar un borde alrededor */
        .user-details-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: left;
        }

        .user-details-container img {
            max-width: 100px;
            height: 100px;
            display: block;
            margin: auto; /* Centrar la imagen */
        }

        /* Estilos para centrar el botón de regreso fuera del recuadro */
        .back-button-container {
            text-align: center; /* Alinear el contenido al centro */
            margin-top: 20px;
        }

        .back-button {
            display: inline-block; /* Hacer que el botón ocupe solo el ancho necesario */
        }

        /* Estilos para encabezados en negrita dentro del contenedor user-details-container */
        .user-details-container .mb-3 label {
            font-weight: bold;
        }

        /* Estilos para evitar negrita en la información */
        .user-details-container .mb-3 span {
            font-weight: normal;
        }
    </style>
@endsection

@section('content')
    <h4 class="page-title">Detalles de usuario</h4>
    
    <div class="user-details-container">
        <!-- Detalles del Usuario -->
        <div class="mb-3">
            <label for="IdCategoria" class="form-label">Rol: <span>{{ $user->getRoleNames()->implode(', ') }}</span></label>
        </div>
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario: <span>{{ $user->name }}</span></label>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico: <span>{{ $user->email }}</span></label>
        </div>

        <!-- No mostrar campos de contraseña en la vista de detalles -->
        
        <!-- Firma Digital -->
        <div class="mb-3">
            <label for="firma">Firma Digital</label>
            @if ($user->firma_source === 'imagen' && $user->firma)
                <img src="{{ asset('storage/' . $user->firma) }}" alt="Firma Digital (Archivo)">
            @elseif ($user->firma_source === 'canvas' && $user->firma)
                <img src="{{ $user->firma }}" alt="Firma Digital (Canvas)">
            @else
                <p>No se encontró firma</p>
            @endif
        </div>
    </div>

    <div class="back-button-container">
        <a href="{{ route('pages-usuarios') }}" class="btn btn-primary back-button">Regresar</a> <!--BOTÓN REGRESAR -->
    </div>
@endsection

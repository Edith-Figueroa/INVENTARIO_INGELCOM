@extends('layouts/layoutMaster')

@section('title', 'Actualizar Categoria')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
    <!-- Register Card -->
    <h4 class="mb-0">Editando una categoría</h4><br>
    <form id="formAuthentication" class="mb-3" action="{{ route('pages-categorias-update') }}" method="POST">
        @csrf  <!-- TOKEN DE SEGURIDAD -->
        <input type="hidden" name="IdCategoria" value="{{$categoria->IdCategoria}}">
        <div class="mb-3">
            <label for="NombreC" class="form-label">Nombre de la categoria</label>
            <input type="text" class="form-control @error('NombreC') is-invalid @enderror" id="NombreC" name="NombreC" value="{{$categoria->NombreC}}" placeholder="Categoria" autofocus />
            @error('NombreC')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="DescripcionC" class="form-label">Descripción de la categoria</label>
            <textarea  type="text" class="form-control @error('DescripcionC') is-invalid @enderror" id="DescripcionC" name="DescripcionC" value="{{$categoria->DescripcionC}}" placeholder="Descripción"></textarea>
            @error('DescripcionC')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="mb-1">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms" name="terms" />
                <label class="form-check-label" for="terms">
                    Acepto los
                    <a href="{{ route('terms.show') }}" target="_blank">
                        términos de servicio
                    </a> y la
                    <a href="{{ route('policy.show') }}" target="_blank">
                        política de privacidad
                    </a>
                </label>
            </div>
        </div>
        @endif
        <button type="submit" class="btn btn-primary">Guardar</button> <!--BOTÓN ENVIAR -->
          <a href="{{route ('pages-categorias')}}" class="btn btn-primary">Regresar</a> <!--BOTÓN REGRESAR -->
    </form>
@endsection
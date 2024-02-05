@extends('layouts/layoutMaster')

@section('title', 'Actualizar Producto')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
    <!-- Register Card -->
    
    <h4 class="mb-0" style="text-aling: center">Editando un producto</h4><br>
    <form id="formAuthentication" class="mb-3" action="{{ route('pages-productos-update') }}" method="POST">
        @csrf  <!-- TOKEN DE SEGURIDAD -->
        <input type="hidden" name="IdProducto" value="{{$producto->IdProducto}}">
        <div class="mb-3">
            <label for="NombreP" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control @error('NombreP') is-invalid @enderror" id="NombreP" name="NombreP" value="{{$producto->NombreP}}" placeholder="Producto" autofocus />
            @error('NombreP')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="DescripcionP" class="form-label">Descripción del Producto</label>
            <textarea  type="text" class="form-control @error('DescripcionP') is-invalid @enderror" id="DescripcionP" name="DescripcionP" value="{{$producto->DescripcionP}}" placeholder="Descripción"></textarea>
            @error('DescripcionP')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="PrecioUnitario" class="form-label">Precio Unitario</label>
            <input type="text" class="form-control @error('PrecioUnitario') is-invalid @enderror" id="PrecioUnitario" name="PrecioUnitario" placeholder="Precio Unitario" value="{{ $producto->PrecioUnitario}}" />
           
            @error('PrecioUnitario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="CostoUnitario" class="form-label">Costo Unitario</label>
            <input type="text" class="form-control @error('CostoUnitario') is-invalid @enderror" id="CostoUnitario" name="CostoUnitario" placeholder="Costo Unitario" value="{{ $producto->CostoUnitario}}" />
            @error('CostoUnitario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="CostoInventario" class="form-label">Costo de Inventario</label>
            <input type="text" class="form-control @error('CostoInventario') is-invalid @enderror" id="CostoInventario" name="CostoInventario" placeholder="Costo de Inventario" value="{{ $producto->CostoInventario}}" />
            @error('CostoInventario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="PrecioInventario" class="form-label">Precio de Inventario</label>
            <input type="text" class="form-control @error('PrecioInventario') is-invalid @enderror" id="PrecioInventario" name="PrecioInventario" placeholder="Precio de Inventario" value="{{ $producto->PrecioInventario}}" />
            @error('PrecioInventario')
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
          <a href="{{route ('pages-productos')}}" class="btn btn-primary">Regresar</a> <!--BOTÓN REGRESAR -->
    </form>
@endsection
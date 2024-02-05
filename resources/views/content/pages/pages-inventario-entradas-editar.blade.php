@extends('layouts/layoutMaster')

@section('title', 'Agregar inventario')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
    <h4 class="mb-0" style="text-aling: center">Agregando entradas al inventario</h4><br>
    <form id="inventoryForm" class="mb-3" action="{{ route('pages-inventario-storeentradas') }}" method="POST">
        @csrf
       <!-- Producto -->
        <div class="mb-3">
            <label for="IdProducto" class="form-label">Nombre del Producto</label>
            <select class="form-select @error('IdProducto') is-invalid @enderror" id="IdProducto" name="IdProducto">
                <option value="" disabled selected>Selecciona un producto</option>
                @forelse ($productos as $producto)
                    <option value="{{ $producto->IdProducto}}">{{ $producto->NombreP }}</option>
                    @empty
                @endforelse
            </select>
            @error('IdProducto')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Categoría -->
        <div class="mb-3">
            <label for="IdCategoria" class="form-label">Categoría</label>
            <select class="form-select @error('IdCategoria') is-invalid @enderror" id="IdCategoria" name="IdCategoria">
                <option value="" disabled selected>Selecciona una categoría</option>
                @forelse ($categorias as $categoria)
                    <option value="{{ $categoria->IdCategoria }}">{{ $categoria->NombreC }}</option>
                    @empty
                @endforelse
            </select>
            @error('IdCategoria')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="Notas" class="form-label">Notas</label>
            <textarea class="form-control" id="Notas" name="Notas" placeholder="Notas">{{ old('Notas') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="Cantidad" class="form-label">Cantidad</label>
            <input type="text" class="form-control @error('Cantidad') is-invalid @enderror form-control numeral-mask" id="Cantidad" name="Cantidad" placeholder="Cantidad" value="{{ old('Cantidad') }}" />
            @error('Cantidad')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="PrecioUnitario" class="form-label">Precio Unitario</label>
            <input type="text" class="form-control @error('PrecioUnitario') is-invalid @enderror" id="PrecioUnitario" name="PrecioUnitario" placeholder="Precio Unitario" value="{{ old('PrecioUnitario') }}" />
            @error('PrecioUnitario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="CostoUnitario" class="form-label">Costo Unitario</label>
            <input type="text" class="form-control @error('CostoUnitario') is-invalid @enderror" id="CostoUnitario" name="CostoUnitario" placeholder="Costo Unitario" value="{{ old('CostoUnitario') }}" />
            @error('CostoUnitario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="CostoInventario" class="form-label">Costo de Inventario</label>
            <input type="text" class="form-control @error('CostoInventario') is-invalid @enderror" id="CostoInventario" name="CostoInventario" placeholder="Costo de Inventario" value="{{ old('CostoInventario') }}" />
            @error('CostoInventario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="PrecioInventario" class="form-label">Precio de Inventario</label>
            <input type="text" class="form-control @error('PrecioInventario') is-invalid @enderror" id="PrecioInventario" name="PrecioInventario" placeholder="Precio de Inventario" value="{{ old('PrecioInventario') }}" />
            @error('PrecioInventario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <!-- Resto del formulario (otros campos, botón de guardar, etc.) -->

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection


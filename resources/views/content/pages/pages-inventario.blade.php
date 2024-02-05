@extends('layouts/layoutMaster')

@section('title', 'Inventario')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lista de Productos en inventario</h4>
                    <form method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nombre">Nombre o categoría del Producto</label>
                                    <input type="text" class="form-control" id="nombre" name="nameFilter" value="{{ old('nameFilter') }}">
                                </div>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('pages-inventario-export') }}" class="btn btn-success">Exportar a Excel</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="Table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Notas</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Costo Unitario</th>
                                    <th>Precio de Inventario</th>
                                    <th>Costo de Inventario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventario as $inventario)
                                <tr class="DataRow">
                                    <td>{{ $inventario->id }}</td>
                                    @forelse ($productos as $producto)
                                        @if ($producto->IdProducto == $inventario->IdProducto)
                                            <td>{{ $producto->NombreP }}</td>

                                            @forelse ($categorias as $categoria)
                                            @if ($categoria->IdCategoria == $producto->IdCategoria)
                                                <td>{{ $categoria->NombreC }}</td>
                                            @endif
                                            @empty
                                            <td>No hay categorías disponibles</td>
                                            @endforelse
                                        @endif
                                        @empty
                                        <td>No hay productos disponibles</td>
                                    @endforelse

                                    <td>{{ $inventario->Notas }}</td>
                                    <td>{{ $inventario->Cantidad }}</td>

                                    @forelse ($productos as $producto)
                                    @if ($producto->IdProducto == $inventario->IdProducto)
                                        <td>{{ $producto->PrecioUnitario }}</td>
                                        <td>{{ $producto->CostoUnitario }}</td>
                                        <td>{{ $producto->PrecioInventario }}</td>
                                        <td>{{ $producto->CostoInventario }}</td>
                                    @endif
                                    @empty
                                    <td>No hay productos disponibles</td>
                                    @endforelse

                        
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {
            const Table = document.getElementById("Table");
            const DataRows = document.querySelectorAll(".DataRow");

            document.getElementById("nombre").addEventListener("keyup", function () {
                const searchText = this.value.toLowerCase();

                DataRows.forEach(row => {
                    const Name = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
                    const Category = row.querySelector("td:nth-child(3)").textContent.toLowerCase();

                    // Búsqueda por nombre o categoría
                    if (Name.includes(searchText) || Category.includes(searchText)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
    
        });
    </script>
@endsection

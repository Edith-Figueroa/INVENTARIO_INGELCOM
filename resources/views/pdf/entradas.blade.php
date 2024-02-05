<h1>Entradas</h1>
<table>
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
                                    <th>Creado</th>
                                    <th>Actualizado</th>
                                </tr>
                            </thead>
                            <tbody>

    @foreach ($entrada as $entrada)
        <tr>
            <td>{{ $entrada->id }}</td>

            <!-- OBTENER EL NOMBRE DEL PRODUCTO POR MEDIO DEL ID -->
            @forelse ($productos as $producto)
                @if ($producto->IdProducto == $entrada->IdProducto)
                    <td>{{ $producto->NombreP }}</td>
                @endif
            @empty
                <td>No hay productos disponibles</td>
            @endforelse

            <!-- OBTENER EL NOMBRE DE LA CATEGORIA POR MEDIO DEL ID -->
            @forelse ($categorias as $categoria)
                @if ($categoria->IdCategoria == $entrada->IdCategoria)
                    <td>{{ $categoria->NombreC }}</td>
                @endif
            @empty
                <td>No hay categorías disponibles</td>
            @endforelse
            <td>{{ $entrada->Notas}}</td>
            <td>{{ $entrada->Cantidad}}</td>

            @forelse ($productos as $producto)
                @if ($producto->IdProducto == $entrada->IdProducto)
                    <td>{{ $producto->PrecioUnitario }}</td>
                    <td>{{ $producto->CostoUnitario }}</td>
                    <td>{{ $producto->PrecioInventario }}</td>
                    <td>{{ $producto->CostoInventario }}</td>
                @endif
            @empty
                <td>No hay productos disponibles</td>
            @endforelse
    
            <td>{{ $entrada->created_at}}</td>
            <td>{{ $entrada->updated_at}}</td>
        </tr>
    @endforeach
</tbody>

                        </table>
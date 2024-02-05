<table>
    <thead>
        <tr>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 100%;">Id</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 250%;">Producto</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 250%;">Categoría</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 300%;">Notas</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 100%;">Cantidad</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 200%;">Precio Unitario</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 200%;">Costo Unitario</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 200%;">Precio Inventario</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 200%;">Costo Inventario</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 250%;">Fecha de Creación</th>
            <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 250%;">Fecha de Actualización</th>
        </tr>
    </thead>
    <tbody>
        @php
            $previousId = null;
        @endphp

        @foreach ($entradas as $entrada)
            <tr>
                @if ($previousId !== $entrada->id)
                    <td rowspan="{{ count($entradas->where('id', $entrada->id)) }}" style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                        {{ $entrada->id }}
                    </td>
                    @php
                        $previousId = $entrada->id;
                    @endphp
                @endif

                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    @forelse ($productos as $producto)
                        @if ($producto->IdProducto == $entrada->IdProducto)
                            {{ $producto->NombreP }}
                        @endif
                    @empty
                        No hay productos disponibles
                    @endforelse
                </td>

                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    @forelse ($categorias as $categoria)
                        @if ($categoria->IdCategoria == $entrada->IdCategoria)
                            {{ $categoria->NombreC }}
                        @endif
                    @empty
                        No hay categorías disponibles
                    @endforelse
                </td>

                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    {{ $entrada->Notas ?? 'No hay notas disponibles' }}
                </td>
                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    {{ $entrada->Cantidad ?? 'No hay productos disponibles' }}
                </td>

                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    @forelse ($productos as $producto)
                        @if ($producto->IdProducto == $entrada->IdProducto)
                            {{ $producto->PrecioUnitario }}
                        @endif
                    @empty
                        No hay productos disponibles
                    @endforelse
                </td>

                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    @forelse ($productos as $producto)
                        @if ($producto->IdProducto == $entrada->IdProducto)
                            {{ $producto->CostoUnitario }}
                        @endif
                    @empty
                        No hay productos disponibles
                    @endforelse
                </td>

                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    @forelse ($productos as $producto)
                        @if ($producto->IdProducto == $entrada->IdProducto)
                            {{ $producto->PrecioInventario }}
                        @endif
                    @empty
                        No hay productos disponibles
                    @endforelse
                </td>

                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    @forelse ($productos as $producto)
                        @if ($producto->IdProducto == $entrada->IdProducto)
                            {{ $producto->CostoInventario }}
                        @endif
                    @empty
                        No hay productos disponibles
                    @endforelse
                </td>

                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    {{ $entrada->created_at ?? 'Fecha no disponible' }}
                </td>
                <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">
                    {{ $entrada->updated_at ?? 'Fecha no disponible' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

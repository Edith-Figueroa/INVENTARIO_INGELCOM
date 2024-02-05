@if ($entradas->isNotEmpty())
<h6>Número de registro: {{ $entradas->first()->id }}</h6>
@endif
<table>
                    <thead>
                <tr>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 50%;">Item</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 250%;">Producto</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 250%;">Categoría</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 300%;">Notas</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 100%;">Cantidad</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 200%;">Precio Unitario</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 200%;">Costo Unitario</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 200%;">Precio de Inventario</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 200%;">Costo de Inventario</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 250%;">Creado</th>
                    <th style="border: 1px solid #000; background-color: #F4B084; font-weight: bold; text-align: center; width: 250%;">Actualizado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entradas as $index => $entrada)
                <tr>
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $index + 1 }}</td>
                   
                    @forelse ($productos as $producto)
                    @if ($producto->IdProducto == $entrada->IdProducto)
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $producto->NombreP }}</td>
                    @endif
                    @empty
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">No hay productos disponibles</td>
                    @endforelse

                    @forelse ($categorias as $categoria)
                    @if ($categoria->IdCategoria == $entrada->IdCategoria)
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $categoria->NombreC }}</td>
                    @endif
                    @empty
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">No hay categorías disponibles</td>
                    @endforelse
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $entrada->Notas }}</td>
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $entrada->Cantidad }}</td>
                    @forelse ($productos as $producto)
                    @if ($producto->IdProducto == $entrada->IdProducto)
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $producto->PrecioUnitario }}</td>
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $producto->CostoUnitario }}</td>
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $producto->PrecioInventario }}</td>
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $producto->CostoInventario }}</td>
                    @endif
                    @empty
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">No hay productos disponibles</td>
                    @endforelse
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $entrada->created_at }}</td>
                    <td style="background-color: #FFF2CC; border: 1px solid #000; text-align: center;">{{ $entrada->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
                    </table>
                
@extends('layouts/layoutMaster')

@section('title', 'Crear Producto')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
    <!-- Register Card -->
    <h4 class="mb-0" style="text-align: center">Creando nuevos productos</h4><br>
    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('pages-productos-store') }}">
        @csrf

        <div id="productos-container">
            <!-- Campo para agregar un producto por defecto -->
            <div class="producto">
                <h5>Producto 1</h5>
                <div class="mb-3">
                    <label for="NombreP[]" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" name="NombreP[]" placeholder="Producto" autofocus value="{{ old('NombreP[]') }}" />
                    <div class="text-danger" id="NombrePError"></div>
                </div>
                <div class="mb-3">
                    <label for="IdCategoria[]" class="form-label">Categoría</label>
                    <select class="form-select categoria-select" name="IdCategoria[]">
                        <option value="" disabled selected>Selecciona una categoría</option>
                        @forelse ($categorias as $categoria)
                            <option value="{{ $categoria->IdCategoria }}">{{ $categoria->NombreC }}</option>
                        @empty
                        @endforelse
                    </select>
                    <div class="text-danger" id="IdCategoriaError"></div>
                </div>

                <div class="mb-3">
                    <label for="DescripcionP[]" class="form-label">Descripción del Producto</label>
                    <textarea class="form-control" name="DescripcionP[]" placeholder="Descripción" value="{{ old('DescripcionP[]') }}"></textarea>
                    <div class="text-danger" id="DescripcionPError"></div>
                </div>
                <div class="mb-3">
                    <label for="PrecioUnitario[]" class="form-label">Precio Unitario</label>
                    <input type="text" class="form-control" name="PrecioUnitario[]" placeholder="Precio Unitario" value="{{ old('PrecioUnitario[]') }}" />
                    <div class="text-danger" id="PrecioUnitarioError"></div>
                </div>
                <div class="mb-3">
                    <label for="CostoUnitario[]" class="form-label">Costo Unitario</label>
                    <input type="text" class="form-control" name="CostoUnitario[]" placeholder="Costo Unitario" value="{{ old('CostoUnitario[]') }}" />
                    <div class="text-danger" id="CostoUnitarioError"></div>
                </div>
                <div class="mb-3">
                    <label for="CostoInventario[]" class="form-label">Costo de Inventario</label>
                    <input type="text" class="form-control" name="CostoInventario[]" placeholder="Costo de Inventario" value="{{ old('CostoInventario[]') }}" />
                    <div class="text-danger" id="CostoInventarioError"></div>
                </div>
                <div class="mb-3">
                    <label for="PrecioInventario[]" class="form-label">Precio de Inventario</label>
                    <input type="text" class="form-control" name="PrecioInventario[]" placeholder="Precio de Inventario" value="{{ old('PrecioInventario[]') }}" />
                    <div class="text-danger" id="PrecioInventarioError"></div>
                </div>
            </div>
        </div>
        <div class="text-danger" id="NuevoPError"></div>

        <button type="button" id="agregar-producto" class="btn btn-primary mx-auto d-block mt-3">Agregar Producto</button>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('pages-productos') }}" class="btn btn-primary">Regresar</a>
    </form>

 <script>
    document.addEventListener('DOMContentLoaded', function () {
    const productosContainer = document.getElementById('productos-container');
    const agregarProductoButton = document.getElementById('agregar-producto');
    const formAuthentication = document.getElementById('formAuthentication');
    let productoCount = 1;

    //ACCIONES DEL BOTÓN AGREGAR OTRO PRODUCTO 
    agregarProductoButton.addEventListener('click', function () {
        // Obtener el último producto agregado
        const ultimoProducto = document.querySelector(`.producto:nth-child(${productoCount})`);

        // Verificar si los campos obligatorios están llenos en el último producto
        const nombre = ultimoProducto.querySelector('[name^="NombreP"]').value.trim();
        const categoria = ultimoProducto.querySelector('[name^="IdCategoria"]').value.trim();
        const precioUnitario = ultimoProducto.querySelector('[name^="PrecioUnitario"]').value.trim();
        const costoUnitario = ultimoProducto.querySelector('[name^="CostoUnitario"]').value.trim();
        const costoInventario = ultimoProducto.querySelector('[name^="CostoInventario"]').value.trim();
        const precioInventario = ultimoProducto.querySelector('[name^="PrecioInventario"]').value.trim();

        if (nombre === '' || categoria === '') {
            $('#NuevoPError').text('Debes llenar los campos necesarios para agregar un nuevo producto.');
            return;
        } else {
            $('#NuevoPError').text('');
           
            if (!(precioUnitario || costoUnitario || costoInventario || precioInventario)) {
                $('#NuevoPError').text('Debes llenar al menos uno de los campos (Precio Unitario, Costo Unitario, Costo de Inventario, Precio de Inventario).');
                return;
            } else {
                $('#NuevoPError').text('');
            }
        }

        

        // Clonar el campo de producto
        const producto = document.querySelector('.producto');
        const productoClone = producto.cloneNode(true);

        // Incrementar el contador y establecer el título
        productoCount++;
        productoClone.querySelector('h5').textContent = `Producto ${productoCount}`;

        // Actualizar los nombres de los campos clonados
        productoClone.querySelectorAll('[name]').forEach(field => {
            const name = field.getAttribute('name');
            field.setAttribute('name', `${name}_${productoCount}`);
        });

        // Limpiar los valores seleccionados en el campo clonado
        productoClone.querySelector('.categoria-select').selectedIndex = 0;
        productoClone.querySelector('textarea').value = '';
        productoClone.querySelectorAll('input').forEach(input => {
            input.value = '';
        });

        // Agregar el campo clonado al contenedor
        productosContainer.appendChild(productoClone);

        // Agregar el botón "Eliminar" solo a los productos clonados
        if (productoCount > 1) {
            const eliminarButton = document.createElement('button');
            eliminarButton.type = 'button';
            eliminarButton.className = 'btn btn-danger btn-sm eliminar-producto';
            eliminarButton.style.marginTop = '10px'; // Añade margen superior
            eliminarButton.textContent = 'Eliminar';
            productoClone.appendChild(eliminarButton);
        }
    });

    // Agregar funcionalidad para eliminar productos
    productosContainer.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('eliminar-producto')) {
            if (productoCount > 1) {
                event.target.parentNode.remove();
                productoCount--;
            }
        }
    });

    //funcionalidad para validar al enviar el formulario
    formAuthentication.addEventListener('submit', function (e) {
        // Obtener el último producto agregado
        const ultimoProducto = document.querySelector(`.producto:nth-child(${productoCount})`);

        // Verificar si los campos obligatorios están llenos en el último producto
        const nombre = ultimoProducto.querySelector('[name^="NombreP"]').value.trim();
        const categoria = ultimoProducto.querySelector('[name^="IdCategoria"]').value.trim();
        const precioUnitario = ultimoProducto.querySelector('[name^="PrecioUnitario"]').value.trim();
        const costoUnitario = ultimoProducto.querySelector('[name^="CostoUnitario"]').value.trim();
        const costoInventario = ultimoProducto.querySelector('[name^="CostoInventario"]').value.trim();
        const precioInventario = ultimoProducto.querySelector('[name^="PrecioInventario"]').value.trim();

        if (nombre === '' || categoria === '') {
        $('#NuevoPError').text('Debes llenar los campos necesarios para agregar un nuevo producto.');
        e.preventDefault();
        } else {
            $('#NuevoPError').text('');

            if (!(precioUnitario || costoUnitario || costoInventario || precioInventario)) {
            $('#NuevoPError').text('Debes llenar al menos uno de los campos (Precio Unitario, Costo Unitario, Costo de Inventario, Precio de Inventario).');
            e.preventDefault();
            } else {
                $('#NuevoPError').text('');
            }
        }        
    });
});

 </script>
@endsection

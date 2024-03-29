@extends('layouts/layoutMaster')

@section('title', 'Salida inventario')

@section('page-style')
<style>
    /* {{-- Agrega tus estilos de página aquí --}} */
    <link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
</style>
@endsection    
@section('content')

<h4 class="mb-0" style="text-align: center">Salida Editar</h4><br>

<form id="inventoryForm" class="mb-3" action="{{ route('pages-salidas-editar') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="detalle" class="form-label">Detalle de entrega</label>
    </div>
    <input type="hidden" id="id" name="id" value="{{session('id')}}">

    <div id="productos-container">        
        <div class="producto">
            <h5>Producto 1</h5>
            <div class="mb-3">
                <label for="IdProducto[]" class="form-label">Nombre del Producto</label>
                <select class="form-select producto-select" name="IdProducto[]">
                    <option value="" disabled selected>Selecciona un producto</option>
                    @forelse ($productos as $producto)
                    <option value="{{ $producto->IdProducto }}">{{ $producto->NombreP }}</option>
                    @empty
                    @endforelse
                </select>
                <div class="text-danger" id="NombrePError_1"></div>
            </div>
            <div class="mb-3">
                <label for="Notas" class="form-label">Notas</label>
                <textarea class="form-control descripcion" name="Notas"
                    placeholder="Opcional"></textarea>
            </div>
            <div class="mb-3">
                <label for="Cantidad" class="form-label">Cantidad</label>
                <input type="text" class="form-control cantidad" name="Cantidad[]" placeholder="Cantidad"
                    value="{{ old('Cantidad') }}" />
                <div class="text-danger" id="CantidadError_1"></div>
            </div>
        </div>
    </div>

    <button type="button" id="agregar-producto" class="btn btn-primary mx-auto d-block mt-3">Agregar Producto</button>    
    
    <a href="javascript:history.back()" class="btn btn-primary">Regresar</a>
                
    <button type="submit" class="btn btn-success">Guardar</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productosContainer = document.getElementById('productos-container');
        const agregarProductoButton = document.getElementById('agregar-producto');
        const inventoryForm = document.getElementById('inventoryForm');
        let productoCount = 1;

        agregarProductoButton.addEventListener('click', function () {
            // Obtener el último producto agregado
            const ultimoProducto = document.querySelector(`.producto:nth-child(${productoCount})`);

            // Verificar si los campos obligatorios están llenos en el último producto
            const nombre = ultimoProducto.querySelector('[name^="IdProducto"]').value.trim();
            const cantidad = ultimoProducto.querySelector('[name^="Cantidad"]').value.trim();

            if (nombre === '') {
                $(`#NombrePError_${productoCount}`).text('Debes seleccionar un producto.');
                return;
            } else {
                $(`#NombrePError_${productoCount}`).text('');
            }

            if (cantidad === '') {
                $(`#CantidadError_${productoCount}`).text('Debes ingresar la cantidad.');
                return;
            } else {
                $(`#CantidadError_${productoCount}`).text('');
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
            productoClone.querySelector('.producto-select').selectedIndex = 0;
            productoClone.querySelector('.cantidad').value = '';
            productoClone.querySelector('.descripcion').value = '';

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
        inventoryForm.addEventListener('submit', function (e) {
            // Obtener el último producto agregado
            const ultimoProducto = document.querySelector(`.producto:nth-child(${productoCount})`);

            // Verificar si los campos obligatorios están llenos en el último producto
            const nombre = ultimoProducto.querySelector('[name^="IdProducto"]').value.trim();
            const cantidad = ultimoProducto.querySelector('[name^="Cantidad"]').value.trim();

            if (nombre === '') {
                $(`#NombrePError_${productoCount}`).text('Debes seleccionar un producto.');
                e.preventDefault();
            } else {
                $(`#NombrePError_${productoCount}`).text('');
            }

            if (cantidad === '') {
                $(`#CantidadError_${productoCount}`).text('Debes ingresar la cantidad.');
                e.preventDefault();
            } else {
                $(`#CantidadError_${productoCount}`).text('');
            }

            // Validaciones adicionales para los campos de nombres
            const entrega = document.getElementById('entrega').value.trim();
            const receptor = document.getElementById('receptor').value.trim();
            const supervisor = document.getElementById('supervisor').value.trim();

            // Validar el campo de detalle
            const detalleCheckboxes = document.querySelectorAll('[name^="detalle[]"]');
            let detalleSeleccionado = false;

            detalleCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    detalleSeleccionado = true;
                }
            });

            if (!detalleSeleccionado) {
                $('#DetalleError').text('Debes seleccionar al menos un detalle.');
                e.preventDefault();
            } else {
                $('#DetalleError').text('');
            }

            if (entrega === '') {
                $('#EntregaError').text('Debes ingresar el nombre de quien lo entrega.');
                e.preventDefault();
            } else {
                $('#EntregaError').text('');
            }

            if (receptor === '') {
                $('#ReceptorError').text('Debes ingresar el nombre del receptor responsable.');
                e.preventDefault();
            } else {
                $('#ReceptorError').text('');
            }

            if (supervisor === '') {
                $('#SupervisorError').text('Debes ingresar el nombre del supervisor que autoriza.');
                e.preventDefault();
            } else {
                $('#SupervisorError').text('')
            }
        });
    });
</script>

@endsection
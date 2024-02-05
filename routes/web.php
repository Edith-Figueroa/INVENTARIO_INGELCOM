<?php
use Illuminate\Support\Facades\Route;

$controller_path = 'App\Http\Controllers';

Route:: middleware([
	'auth:sanctum',
	config('jetstream.auth_session'),
	'verified'
]) -> group(function () {
	$controller_path = 'App\Http\Controllers';

	//HOME
	Route:: get('/', $controller_path. '\pages\HomePage@index') -> name('pages-home');
	Route:: get('/pages2', $controller_path. '\pages\page2@index') -> name('pages-pages2');

	//PRODUCTOS
	Route:: get('/productos', $controller_path. '\pages\Productos@index') -> name('pages-productos');
	Route:: get('/productos/create', $controller_path. '\pages\Productos@create') -> name('pages-productos-create');
	Route:: post('/productos/store', $controller_path. '\pages\Productos@store') -> name('pages-productos-store');
	Route:: get('/productos/show/{IdProducto}', $controller_path. '\pages\Productos@show') -> name('pages-productos-show');
	Route:: post('/productos/update', $controller_path. '\pages\Productos@update') -> name('pages-productos-update');
	Route:: get('/productos/destroy/{IdProducto}', $controller_path. '\pages\Productos@destroy') -> name('pages-productos-destroy');
	Route:: get('/productos/switch/{IdProducto}', $controller_path. '\pages\Productos@switch') -> name('pages-productos-switch');
	Route:: get('/productos/export', $controller_path. '\pages\Productos@export') -> name('pages-productos-export');


	//CATEGORIAS
	Route:: get('/categorias', $controller_path. '\pages\Categorias@index') -> name('pages-categorias');
	Route:: get('/categorias/create', $controller_path. '\pages\Categorias@create') -> name('pages-categorias-create');
	Route:: post('/categorias/store', $controller_path. '\pages\Categorias@store') -> name('pages-categorias-store');
	Route:: get('/categorias/show/{IdCategoria}', $controller_path. '\pages\Categorias@show') -> name('pages-categorias-show');
	Route:: post('/categorias/update', $controller_path. '\pages\Categorias@update') -> name('pages-categorias-update');
	Route:: get('/categorias/destroy/{IdCategoria}', $controller_path. '\pages\Categorias@destroy') -> name('pages-categorias-destroy');
	Route:: get('/categorias/switch/{IdCategoria}', $controller_path. '\pages\Categorias@switch') -> name('pages-categorias-switch');
	Route:: get('/categorias/export', $controller_path. '\pages\Categorias@export') -> name('pages-categorias-export');

	//INVENTARIO
	Route:: get('/inventario', $controller_path. '\pages\CInventario@index') -> name('pages-inventario');
	Route:: get('/inventario/export', $controller_path. '\pages\CInventario@export') -> name('pages-inventario-export');


	//INVENTARIO ENTRADAS
	Route:: get('/entradas', $controller_path. '\pages\Entradas@index') -> name('pages-inventario-entradas');
	Route:: get('/entradas/create', $controller_path. '\pages\Entradas@create') -> name('pages-inventario-createentradas');
	Route:: post('/entradas/store', $controller_path. '\pages\Entradas@store') -> name('pages-inventario-storeentradas');
	Route:: get('/entradas/export', $controller_path. '\pages\Entradas@export') -> name('pages-inventario-exportentradas');
	Route:: get('/entradas/pdf', $controller_path. '\pages\Entradas@pdf') -> name('pages-inventario-pdfentradas');

	//INVENTARIO ENTRADAS RECEPCIÓN
	Route:: get('/entradas/verentradas/{IdRegistro}', $controller_path. '\pages\Entradas@verentradas') -> name('pages-inventario-verentradas');
	Route:: get('/entradas/exportrecepcion', $controller_path. '\pages\entradas@exportrecepcion') -> name('pages-inventario-exportrecepcion');
	Route:: get('/entradas/pdfrecepcion/{IdRegistro}', $controller_path. '\pages\entradas@pdfrecepcion') -> name('pages-inventario-pdfrecepcion');


	//INVENTARIO SALIDAS
	Route:: get('/salidas', $controller_path. '\pages\Salidas@index') -> name('pages-inventario-salidas');
	Route:: get('/salidas/create', $controller_path. '\pages\Salidas@create') -> name('pages-inventario-createsalidas');
	Route:: post('/salidas/store', $controller_path. '\pages\salidas@store') -> name('pages-inventario-storesalidas');
	Route:: get('/salidas/export', $controller_path. '\pages\salidas@export') -> name('pages-inventario-exportsalidas');

	//INVENTARIO SALIDAS REQUISICIÓN
	Route:: get('/salidas/versalidas/{IdRegistro}', $controller_path. '\pages\salidas@versalidas') -> name('pages-inventario-versalidas');
	Route:: get('/salidas/pdfrequisicion/{IdRegistro}', $controller_path. '\pages\salidas@pdfrequisicion') -> name('pages-inventario-pdfrequisicion');



	//USUARIOS
	Route:: get('/usuarios', $controller_path. '\pages\Usuarios@index') -> name('pages-usuarios');
	Route:: get('/usuarios/create', $controller_path. '\pages\Usuarios@create') -> name('pages-usuarios-create');
	Route:: post('/usuarios/store', $controller_path. '\pages\Usuarios@store') -> name('pages-usuarios-store');
	Route:: get('/usuarios/show/{user_id}', $controller_path. '\pages\Usuarios@show') -> name('pages-usuarios-show');
	Route:: post('/usuarios/update', $controller_path. '\pages\Usuarios@update') -> name('pages-usuarios-update');
	Route:: get('/usuarios/switch/{id}', $controller_path. '\pages\usuarios@switch') -> name('pages-usuarios-switch');
	Route:: get('/usuarios/destroy/{user_id}', $controller_path. '\pages\Usuarios@destroy') -> name('pages-usuarios-destroy');
	Route:: get('/usuarios/export', $controller_path. '\pages\Usuarios@export') -> name('pages-usuarios-export');
	Route:: get('/salidas/verusuarios/{user_id}', $controller_path.  '\pages\Usuarios@verusuarios') -> name('pages-usuarios-ver');

});
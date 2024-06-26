<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'IdProducto',
        'IdCategoria',
        'Notas',
        'Cantidad',
        'PrecioUnitario',
        'CostoUnitario',
        'CostoInventario',
        'PrecioInventario'
    ];

    
}


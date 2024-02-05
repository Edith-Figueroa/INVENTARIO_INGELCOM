<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $table = 'entradas';

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

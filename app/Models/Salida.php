<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Salida extends Model
{
    use HasFactory;

    protected $table = 'salidas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'IdRegistro',
        'IdProducto',
        'Notas',
        'Cantidad',
    ];
}

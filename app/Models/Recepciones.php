<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recepciones extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'recepciones';

    // Nombre de la columna de clave primaria
    protected $primaryKey = 'id';

    // Define si la tabla tiene las columnas created_at y updated_at
    public $timestamps = true;

    // Nombres de los campos que se pueden llenar masivamente 
    protected $fillable = [
        'Detalle',
        'Receptor',
        'Supervisor',
    ];

}

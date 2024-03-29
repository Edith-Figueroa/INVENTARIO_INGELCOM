<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisiciones extends Model
{
    protected $table = 'requisiciones';    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'Detalle',
        'Email_Entrega',
        'Email_Receptor',
        'Email_Sup',
        'Email_RRHH',
        'Email_Adminis',
        'Administracion',
        'RRHH',
        'Administracion',
        'Supervisor',
        'Estado',
        'Fecha',
        'updated_at',
        'created_at',
    ];
}

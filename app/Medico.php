<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $fillable = array('codMedico', 'nombre', 'Especialidades_id','Sedes_id');
	protected $table = 'medicos';
	protected $dates = ['deleted_at'];
}

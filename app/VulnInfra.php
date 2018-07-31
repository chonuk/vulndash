<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VulnInfra extends Model
{
    use Sortable;

   	protected $table = 'vulnsinfra';

    protected $fillable = ['plugin', 'nombre', 'criticidad_id', 'protocolo', 'exploit','resumen','descripcion','solucion','referencias','cve','salida_parche'];

    public $sortable = ['plugin', 'nombre', 'criticidad_id', 'protocolo', 'exploit','cve','salida_parche'];

    public function activos()
    {
        #return $this->belongsToMany('App\Activo', 'ocurrenciasinfra', 'vulnsinfra_id', 'activos_id')->withPivot('puerto', 'primer_deteccion','ultima_deteccion', 'estados_id')->withTimestamps();
        return $this->belongsToMany('App\Activo','vulnerabilidades','vulnsinfra_id','activos_id')->using('App\Vulnerabilidad')->withPivot('puerto','primer_deteccion','ultima_deteccion','estados_id')->withTimestamps();
    }

    public function criticidad()
    {
        return $this->belongsTo('App\Criticidad');
    }

    public function vulnerabilidades()
    {
        return $this->hasMany('App\Vulnerabilidad','vulnsinfra_id');
    }
}

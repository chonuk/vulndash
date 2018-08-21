<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Vulnerabilidad extends Model
{
    use Sortable;

   	protected $table = 'vulnerabilidades';

    protected $fillable = ['plugin', 'nombre', 'criticidad_id', 'protocolo', 'exploit','resumen','descripcion','solucion','referencias','cve','salida_parche'];

    public $sortable = ['plugin', 'nombre', 'criticidad_id', 'protocolo', 'exploit','cve','salida_parche'];

    protected $dates = ['created_at','updated_at','salida_parche'];

    public function activos()
    {
        return $this->belongsToMany('App\Activo','ocurrencias','vulnerabilidades_id','activos_id')->using('App\Ocurrencia')->withPivot('puerto','primer_deteccion','ultima_deteccion','estados_id')->withTimestamps();
    }

    public function criticidad()
    {
        return $this->belongsTo('App\Criticidad');
    }

    public function ocurrencias()
    {
        return $this->hasMany('App\Ocurrencia','vulnerabilidades_id');
    }

}

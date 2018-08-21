<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Kyslik\ColumnSortable\Sortable;

class Ocurrencia extends Pivot
{
    use Sortable;

   	protected $table = 'ocurrencias';

    protected $fillable = ['activos_id', 'vulnerabilidades_id', 'puerto', 'primer_deteccion', 'ultima_deteccion','estados_id'];

    public $sortable = ['activos_id', 'vulnerabilidades_id', 'puerto', 'primer_deteccion', 'ultima_deteccion','estados_id'];

    protected $dates = ['created_at','updated_at','primer_deteccion','ultima_deteccion'];

    public function activos()
    {
    	return $this->belongsTo('App\Activo','activos_id');
    }

    public function vulnerabilidades()
    {
    	return $this->belongsTo('App\Vulnerabilidad','vulnerabilidades_id');
    }

    public function estados()
    {
    	return $this->belongsTo('App\Estado');
    }
}

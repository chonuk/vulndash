<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Kyslik\ColumnSortable\Sortable;

class Vulnerabilidad extends Pivot
{
    use Sortable;

   	protected $table = 'vulnerabilidades';

    protected $fillable = ['activos_id', 'vulnsinfra_id', 'puerto', 'primer_deteccion', 'ultima_deteccion','estados_id'];

    public $sortable = ['activos_id', 'vulnsinfra_id', 'puerto', 'primer_deteccion', 'ultima_deteccion','estados_id'];

    protected $dates = ['created_at','updated_at','primer_deteccion','ultima_deteccion'];

    public function activos()
    {
    	return $this->belongsTo('App\Activo','activos_id');
    }

    public function vulnsinfra()
    {
    	return $this->belongsTo('App\VulnInfra','vulnsinfra_id');
    }

    public function estados()
    {
    	return $this->belongsTo('App\Estado');
    }

    // public function activosvulnerables()
    // {
    //     return $this->belongsTo('App\Activo','activos_id');
    // }

    // public function vulnerabilidadesInfra()
    // {
    //     return $this->belongsTo('App\VulnInfra','vulnsinfra_id');
    // }


}

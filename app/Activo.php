<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Activo extends Model
{
	use Sortable;

    protected $table = 'activos';

    protected $fillable = ['ip', 'hostname', 'os'];

    public $sortable = ['ip','hostname', 'os'];

    public function plataformas()
    {
        return $this->belongsToMany('App\Plataforma');
    }

    public function vulnsinfra()
    {
        return $this->belongsToMany('App\VulnInfra','vulnerabilidades','activos_id','vulnsinfra_id')->using('App\Vulnerabilidad')->withPivot('puerto','primer_deteccion','ultima_deteccion','estados_id')->withTimestamps();
    }

    public function vulnerabilidades()
    {
        return $this->hasMany('App\Vulnerabilidad','activos_id');
    }

}

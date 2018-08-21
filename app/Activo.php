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

    public function vulnerabilidades()
    {
        return $this->belongsToMany('App\Vulnerabilidad','ocurrencias','activos_id','vulnerabilidades_id')->using('App\Ocurrencia')->withPivot('puerto','primer_deteccion','ultima_deteccion','estados_id')->withTimestamps();
    }

    public function ocurrencias()
    {
        return $this->hasMany('App\Ocurrencia','activos_id');
    }

}

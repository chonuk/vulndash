<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Kyslik\ColumnSortable\Sortable;

class Plataforma extends Model
{
	use Sortable;

    protected $table = 'plataformas';

    protected $fillable = [
        'nombre', 'responsable'
    ];

    public $sortable = ['id','nombre', 'responsable'];

    public $sortableAs = ['vulnerabilidades','activos'];

    public function activos()
    {
        return $this->belongsToMany('App\Activo');
    }

    // public function vulnerabilidadesSortable($query, $direction)
    // {
    //     return $query->join('activo_plataforma','plataformas.id','=','activo_plataforma.plataforma_id')
    //                     ->join('vulnerabilidades','activo_plataforma.activo_id','=','vulnerabilidades.activos_id')
    //                         ->groupBy('plataformas.nombre','plataformas.responsable')
    //                         ->select('plataformas.nombre','plataformas.responsable')
    //                     ->selectRaw('count(vulnerabilidades.vulnsinfra_id) as vulnerabilidades')
    //                     ->orderBy('vulnerabilidades', $direction);
    // }

}

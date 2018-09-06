<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Kyslik\ColumnSortable\Sortable;
use App\Ocurrencia;

class Plataforma extends Model
{
	use Sortable;

    protected $table = 'plataformas';

    protected $fillable = [
        'nombre', 'responsable'
    ];

    public $sortable = ['id','nombre', 'responsable'];

    public $sortableAs = ['ocurrencias','activos'];

    public function activos()
    {
        return $this->belongsToMany('App\Activo');
    }

}

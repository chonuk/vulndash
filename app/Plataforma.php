<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Plataforma extends Model
{
	use Sortable;

    protected $table = 'plataformas';

    protected $fillable = [
        'nombre', 'tipo', 'responsable'
    ];

    public $sortable = ['id','nombre', 'tipo', 'responsable'];

    public function activos()
    {
        return $this->hasMany('App\Activo');
    }
}

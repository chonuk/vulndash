<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Vulnerabilidad extends Model
{
	use Sortable;

	protected $table = 'vulnerabilidades';

    protected $fillable = ['titulo', 'criticidad_id', 'descripcion', 'remediacion', 'referencias'];

    public $sortable = ['id','titulo', 'criticidad_id', 'descripcion', 'remediacion', 'referencias'];

    public function criticidad()
    {
        return $this->belongsTo('App\Criticidad');
    }
}

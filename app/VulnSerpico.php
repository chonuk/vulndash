<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VulnSerpico extends Model
{
	use Sortable;

	protected $table = 'vulnsserpico';

    protected $fillable = ['titulo', 'criticidad_id', 'descripcion', 'remediacion', 'referencias'];

    public $sortable = ['id','titulo', 'criticidad_id', 'descripcion', 'remediacion', 'referencias'];

    public function criticidad()
    {
        return $this->belongsTo('App\Criticidad');
    }
}

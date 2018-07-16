<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vulnerabilidad extends Model
{
	protected $table = 'vulnerabilidades';

    protected $fillable = [
        'titulo', 'criticidad_id', 'descripcion', 'remediacion', 'referencias'
    ];

    public function criticidad()
    {
        return $this->belongsTo('App\Criticidad');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criticidad extends Model
{
	protected $table = 'criticidades';

    public function vulnerabilidad()
    {
        return $this->hasMany('App\Vulnerabilidad');
    }
}

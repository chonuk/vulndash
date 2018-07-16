<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    protected $table = 'plataformas';

    protected $fillable = [
        'nombre', 'tipo'
    ];

    public function activos()
    {
        return $this->hasMany('App\Activo');
    }
}

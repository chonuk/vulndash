<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Estado extends Model
{
    Use Sortable;
	
	protected $table = 'estados';

	public $sortable = ['id','texto'];

    public function ocurrencias()
    {
        return $this->hasMany('App\Ocurrencia');
    }
}

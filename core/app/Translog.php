<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translog extends Model
{
    protected $table = 'translogs';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

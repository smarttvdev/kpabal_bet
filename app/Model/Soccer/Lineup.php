<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    protected $table = "lineups";
    public $timestamps = false;

    protected $casts=[
        'competitor1'=>'array',
        'competitor2'=>'array'
    ];

}

<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class MatchFun extends Model
{
    protected $table = "match_funs";
    public $timestamps = false;

    protected $casts=[
        'funs'=>'array'
    ];

}

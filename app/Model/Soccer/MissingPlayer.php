<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class MissingPlayer extends Model
{
    protected $table = "missing_players";
    public $timestamps = false;

    protected $casts=[
        'players'=>'array',
    ];

}

<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TeamResult extends Model
{
    protected $table = "team_results";
    public $timestamps = false;

    protected $casts=[
        'results'=>'array',
    ];

}

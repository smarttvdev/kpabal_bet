<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TournamentResult extends Model
{
    protected $table = "tournament_results";
    public $timestamps = false;

    protected $casts=[
        'results'=>'array',
    ];

}

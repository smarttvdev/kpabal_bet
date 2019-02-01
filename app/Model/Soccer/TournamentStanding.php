<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TournamentStanding extends Model
{
    protected $table = "tournament_standings";
    public $timestamps = false;

    protected $casts=[
        'season'=>'array',
        'standings'=>'array',
        'notes'=>'array',
    ];

}

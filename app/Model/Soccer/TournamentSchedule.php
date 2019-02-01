<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TournamentSchedule extends Model
{
    protected $table = "tournament_schedules";
    public $timestamps = false;

    protected $casts=[
        'sport_events'=>'array',
    ];

}

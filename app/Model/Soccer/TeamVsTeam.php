<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TeamVsTeam extends Model
{
    protected $table = "team_vs_teams";
    public $timestamps = false;

    protected $casts=[
        'last_meetings'=>'array',
    ];

}

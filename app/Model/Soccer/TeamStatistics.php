<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TeamStatistics extends Model
{
    protected $table = "team_statistics";
    public $timestamps = false;

    protected $casts=[
        'team_season_coverage'=>'array',
        'team_statistics'=>'array',
        'player_statistics'=>'array',
        'goaltime_statistics'=>'array',

    ];

}

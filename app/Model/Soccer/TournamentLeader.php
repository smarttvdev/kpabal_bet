<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TournamentLeader extends Model
{
    protected $table = "tournament_leaders";
    public $timestamps = false;

    protected $casts=[
        'season_coverage_info'=>'array',
        'top_points'=>'array',
        'top_goals'=>'array',
        'top_assists'=>'array',
        'top_cards'=>'array',
        'top_own_goals'=>'array',
    ];

}

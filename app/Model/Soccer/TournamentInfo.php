<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TournamentInfo extends Model
{
    protected $table = "tournament_infos";
    public $timestamps = false;

    protected $casts=[
        'round'=>'array',
        'season_coverage_info'=>'array',
        'coverage_info'=>'array',
        'groups'=>'array',
    ];

}

<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TeamProfile extends Model
{
    protected $table = "team_profiles";
    public $timestamps = false;

    protected $casts=[
        'jerseys'=>'array',
        'manager'=>'array',
        'players'=>'array',
        'statistics'=>'array',
    ];

}

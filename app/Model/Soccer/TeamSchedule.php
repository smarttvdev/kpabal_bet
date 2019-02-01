<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class TeamSchedule extends Model
{
    protected $table = "team_schedules";
    public $timestamps = false;

    protected $casts=[
        'schedule'=>'array',
    ];

}

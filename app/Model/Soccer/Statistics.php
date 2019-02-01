<?php

namespace App\Model\Soccer;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $table = "statistics";
    public $timestamps = false;

    protected $casts=[
        'competitor1'=>'array',
        'competitor2'=>'array'
    ];

}

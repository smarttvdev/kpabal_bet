<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{
    protected  $table = "commission_logs";

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}

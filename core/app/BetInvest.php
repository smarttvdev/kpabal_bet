<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetInvest extends Model
{
    protected $guarded = [];

    public function match()
    {
        return $this->belongsTo('App\Match');
    }
    public function question()
    {
        return $this->belongsTo('App\BetQuestion');
    }
    public function betoption()
    {
        return $this->belongsTo('App\BetOption');
    }

}

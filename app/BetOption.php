<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetOption extends Model
{
    protected $table = "bet_options";

    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo('App\BetQuestion');
    }
    public function invests()
    {
        return $this->hasMany('App\BetInvest', 'betoption_id');
    }

    public function match()
    {
        return $this->belongsTo('App\Match');
    }

}

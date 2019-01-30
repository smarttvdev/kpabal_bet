<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetQuestion extends Model
{
    protected $table = "bet_questions";

    protected $guarded = [];

    public function options()
    {
        return $this->hasMany('App\BetOption','question_id');
    }
    public function match()
    {
        return $this->belongsTo('App\Match');
    }
}

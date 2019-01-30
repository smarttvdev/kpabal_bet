<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Match extends Model
{
    protected $guarded = [];
    protected  $table = "matches";

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function questions()
    {
        return $this->hasMany('App\BetQuestion','match_id');
    }
    public function questionsEndTime()
    {
        $now = Carbon::now();
        return $this->hasMany('App\BetQuestion','match_id')->whereStatus(1)->where('end_time','>=', $now);
    }
    public function options()
    {
        return $this->hasMany('App\BetOption','match_id');
    }
    public function betInvests()
    {
        return $this->hasMany('App\BetInvest','match_id');
    }



}

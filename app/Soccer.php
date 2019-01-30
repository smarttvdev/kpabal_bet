<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soccer extends Model
{
    protected $guarded = [];

    protected $table = "soccers";

    protected $fillable = ['id','match_id','scheduled','season','venue','tournament','competitors','tournament_round','status','created_at','updated_at','tournament_name','tournament_id','start_date','end_date']; 
}
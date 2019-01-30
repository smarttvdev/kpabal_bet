<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawLog extends Model
{
    protected $table = 'withdraw_logs';

    protected $fillable = ['user_id','transaction_id','method_id','amount','charge','send_details','message','status','net_amount','message'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function method()
    {
        return $this->belongsTo('App\WithdrawMethod')->withDefault();
    }

}

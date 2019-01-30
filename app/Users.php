<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
//    protected $fillable = [
//    'name', 'email', 'mac', 'mac_id', 'mobile', 'country', 'city', 'address', 'zip', 'balance', 'status',
//    ];
    protected $guarded = [];

    protected $table = 'users';



}

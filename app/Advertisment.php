<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisment extends Model
{
    protected $table = 'ads';
    protected $guarded = ['id'];
}

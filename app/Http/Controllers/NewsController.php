<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class NewsController extends Controller{

    public function feed(){
        return view('news.feed');
    }


}
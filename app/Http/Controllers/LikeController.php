<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like_message(Request $request){

    }
}

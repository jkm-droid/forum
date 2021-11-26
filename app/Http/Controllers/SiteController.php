<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function show_welcome_page(){
        return view('site.welcome');
    }
}

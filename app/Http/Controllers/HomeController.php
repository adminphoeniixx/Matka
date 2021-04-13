<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class HomeController extends Controller
{
    public function command(){

    	Artisan::call('install:passport');

    }
}

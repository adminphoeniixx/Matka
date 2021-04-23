<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class HomeController extends Controller
{
    public function command(){

    	Artisan::call('install:passport');

    }


    public function aboutus(){
    	return view('aboutus');
    }



     public function howtoplay(){
    	return view('howtoplay');
    }


    public function termsandconditions(){
    	return view('termsandconditions');
    }


    
}

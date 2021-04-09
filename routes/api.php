<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



// User Api's


Route::prefix('/user')->group(function (){


// Fetch All Available States

Route::get('/get-states','api\v1\LoginController@states');


Route::post('/login','api\v1\LoginController@login');

Route::post('/register','api\v1\LoginController@register');

Route::post('/verify-otp','api\v1\LoginController@verifyotp');

Route::post('/resend-otp','api\v1\LoginController@resendotp');

Route::middleware('auth:api')->get('/all','api\v1\LoginController@index');


});




Route::prefix('/betting')->group(function (){

Route::post('/placebet','api\v1\BettingController@store');

Route::middleware('auth:api')->get('/all','api\v1\LoginController@index');



});
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

Route::post('/send-otp','api\v1\LoginController@sendotp');

Route::post('/verify-otp','api\v1\LoginController@verifyotp');


Route::post('/login-with-otp','api\v1\LoginController@loginwithotp');

Route::post('/verify-login-with-otp','api\v1\LoginController@verifyloginwithotp');


Route::post('/resend-otp','api\v1\LoginController@resendotp');

Route::post('/forget-password','api\v1\LoginController@forgetpassword');


Route::middleware('auth:api')->post('/home','api\v1\HomeController@index');

Route::middleware('auth:api')->post('/get-wallet','api\v1\HomeController@wallet');

Route::middleware('auth:api')->post('/add-cash','api\v1\HomeController@addcash');

Route::middleware('auth:api')->post('/play-jodi-game','api\v1\BettingController@playjodigame');

Route::middleware('auth:api')->post('/play-crossing-game','api\v1\BettingController@playcrossinggame');

Route::middleware('auth:api')->post('/withdraw-request','api\v1\UserController@withdrawrequest');

Route::middleware('auth:api')->post('/withdraw-history','api\v1\UserController@withdrawhistory');

Route::middleware('auth:api')->post('/transaction-history','api\v1\UserController@transactionhistory');


Route::middleware('auth:api')->post('/get-commision','api\v1\UserController@getcommision');

Route::middleware('auth:api')->post('/exchange-commision','api\v1\UserController@exchangecommision');


Route::middleware('auth:api')->post('/my-matches','api\v1\UserController@mymatches');
Route::middleware('auth:api')->post('/match-details','api\v1\UserController@matchdetails');

Route::middleware('auth:api')->post('/edit-profile','api\v1\UserController@editprofile');

Route::middleware('auth:api')->post('/new-password','api\v1\UserController@newpassword');

Route::middleware('auth:api')->post('/get-chart','api\v1\UserController@getchart');

});



Route::prefix('/home')->group(function (){

Route::get('/index','api\v1\LoginController@index');

});




Route::prefix('/betting')->group(function (){

Route::post('/placebet','api\v1\BettingController@store');

Route::middleware('auth:api')->get('/all','api\v1\LoginController@index');



});
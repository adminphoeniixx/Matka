<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationsController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {

	Route::get('posts/publish','Voyager\PostController@publish')->name('posts.publish');
	Route::get('home','PostController@home')->name('home');
    Voyager::routes();


     Route::get('betting/{id}/{sort?}/{order?}', [BettingController::class, 'betting'])->name('betting');
     Route::get('allbets/{id}/{number}', [BettingController::class, 'allbets'])->name('allbets');
     Route::get('showallbets', [BettingController::class, 'showallbets'])->name('showallbets');
     Route::get('winningnumber/{id}', [BettingController::class, 'winningnumber'])->name('winningnumber');

     Route::post('addwinningnumber', [BettingController::class, 'addwinningnumber'])->name('addwinningnumber');

     Route::get('user', [UserController::class, 'index'])->name('user');
     Route::get('adduser', [UserController::class, 'create'])->name('adduser');
     Route::post('adduser', [UserController::class, 'store'])->name('adduser');
     Route::get('userdata', [UserController::class, 'userdata'])->name('userdata');
     Route::get('edituser/{id}', [UserController::class, 'edit'])->name('edituser');
     Route::post('updateuser', [UserController::class, 'update'])->name('updateuser');
     Route::get('deleteuser/{id}', [UserController::class, 'destroy'])->name('deleteuser');
     Route::get('wallet/{id}', [UserController::class, 'wallet'])->name('wallet');
     Route::get('ledger/{id}', [UserController::class, 'ledger'])->name('ledger');
     Route::get('ledgerdata', [UserController::class, 'ledgerdata'])->name('ledgerdata');





     Route::get('withdrawal', [UserController::class, 'withdrawal'])->name('withdrawal');
     Route::get('withdrawaldata', [UserController::class, 'withdrawaldata'])->name('withdrawaldata');
     Route::get('withdrawalapprove/{id}', [UserController::class, 'withdrawalapprove'])->name('withdrawalapprove');
     Route::post('withdrawalstatus', [UserController::class, 'withdrawalstatus'])->name('withdrawalstatus');


     Route::get('deposit', [UserController::class, 'deposit'])->name('deposit');
     Route::get('depositdata', [UserController::class, 'depositdata'])->name('depositdata');
     Route::get('withdraw', [UserController::class, 'withdraw'])->name('withdraw');
     Route::get('withdrawdata', [UserController::class, 'withdrawdata'])->name('withdrawdata');


     Route::get('notifications', [NotificationsController::class, 'index'])->name('notifications');
     Route::get('notificationsdata', [NotificationsController::class, 'notificationsdata'])->name('notificationsdata');
     Route::get('addnotification', [NotificationsController::class, 'create'])->name('addnotification');
     Route::post('addnotification', [NotificationsController::class, 'store'])->name('addnotification');
     Route::get('destroynotification/{id}', [NotificationsController::class, 'destroy'])->name('destroynotification');

});

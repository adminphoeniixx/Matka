<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Wallet;
use App\Transaction;

class LoginController extends Controller
{




	 public function index(){

    	return User::all();
    }




    public function login(Request $request){

    	$login = $request->validate([
    		'email'=>'required|string',
    		'password'=>'required|string'
    	]);

    	if(!(Auth::attempt($login))){
    		return response(['message'=>'Invalid login credentials.']);
    	}


    	$accessToken  = Auth::user()->createToken('Token Name')->accessToken;


    	return response(['message'=>'Login Successful.','user'=>Auth::user(), 'access_token'=>$accessToken]);

    }






    public function register(Request $request){



    	$validator = $request->validate([
    		'name'=>'required|string',
            'mobile_number'=>'required|string',
            'email_address'=>'required|string|unique:users,email',
            'password'=>'required|string',
            'state_id'=>'required|integer', 

        ]);


                    date_default_timezone_set('Asia/Kolkata');

                    $date=date("Y-m-d");
                    $time=date("H:m:s");
 

			       $data = new User;
			       $data->name = $request->name;
			       $data->email = $request->email_address;
			       $data->password = bcrypt($request->password);
			       $data->role_id = 2;
			       $data->state_id  = $request->state_id;
			       $data->referral_code = uniqid();
			       $data->referral_code_used = $request->referral_code;
			       $data->save();

			       $wallet = new Wallet;
			       $wallet->user_id = $data->id;
			       $wallet->bonus_balance +=setting('admin.joining_bonus') ;
			       $wallet->save();


                    $transaction = new Transaction;
                    $transaction->transaction_type = 1;
                    $transaction->user_id = $data->id;
                    $transaction->amount = setting('admin.joining_bonus') ;
                    $transaction->date = $date;
                    $transaction->time = $time;
                    $transaction->description ="Signup Bonus.";
                    $transaction->current_balance = $wallet->deposit_balance + $wallet->winning_balance + $wallet->bonus_balance ;
                    $transaction->save();


			       return response(['message'=>'Registration Successfull.']);

    	

    }





}

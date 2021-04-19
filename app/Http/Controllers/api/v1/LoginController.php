<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Wallet;
use App\Transaction;
use App\State;
use App\LiveGame;
use App\Events\Registration;
use Str;
use Illuminate\Support\Facades\Password;
class LoginController extends Controller
{




	 public function index(){

    	return User::all();
    }




    public function states(){

        $data= State::all();
        return response(['status'=>'success','message'=>'States fetched successfully.', 'states'=>$data]);
    }





    public function login(Request $request){

    	$login = $request->validate([
    		'email'=>'required|string',
    		'password'=>'required|string'
    	]);

    	if(!(Auth::attempt($login))){
    		return response(['status'=>'error','message'=>'Invalid login credentials.']);


    	}else{
        $accessToken  = Auth::user()->createToken('Token Name')->accessToken;
        return response(['status'=>'success','message'=>'Login Successful.','user'=>Auth::user(), 'access_token'=>$accessToken]);
      }


    	


    	

    }






    public function register(Request $request){



    	$validator = $request->validate([
    		'name'=>'required|string',
            'mobile_number'=>'required|string|unique:users,mobile',
            'email_address'=>'required|string|unique:users,email',
            'password'=>'required|string',
            'state_id'=>'required|integer', 

        ]);


                   date_default_timezone_set('Asia/Kolkata');

                    $date=date("Y-m-d");
                    $time=date("H:m:s");
                    

                    $otp= rand(100000,999999);

                    

			       $data = new User;
			       $data->name = $request->name;
			       $data->email = $request->email_address;
             $data->mobile = $request->mobile_number;
			       $data->password = bcrypt($request->password);
			       $data->role_id = 2;
                  
			       $data->state_id  = $request->state_id;
			       $data->referral_code = uniqid();
			       $data->referral_code_used = $request->referral_code;
			       $data->save();


                    //event(new Registration($data->mobile));

			       


                   if(setting('admin.joining_bonus')>0){



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

                   }
                   


			       return response(['status'=>'success','message'=>'Registration Successfull.','user'=>$data]);

    	

    }





    public function sendotp(Request $request){


      $validator = $request->validate([
            'mobile_number'=>'required|string|unique:users,mobile',
        ]);



       event(new Registration($request->mobile_number));

       return response(['status'=>'success','message'=>'OTP sent successfully.']);

    }





    public function verifyotp(Request $request){

        $validator = $request->validate([
            'mobile_number'=>'required|string',
            'otp'=>'required|string',
        ]);

      

      

                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://api.msg91.com/api/v5/otp/verify?authkey=357859AufIJss760659e28P1&mobile=".urlencode($request->mobile_number)."&otp=".$request->otp."",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                      if ($err) {
                        //echo "cURL Error #:" . $err;
                          return response(['status'=>'error','message'=>'Something went wrong.']);
                      } else {
                        //echo $response;
                       $status= json_decode($response);
                       if($status->type=="error"){
                      return response(['status'=>'error','message'=>$status->message]);
                       }else{
                       
                      return response(['status'=>'success','message'=>'OTP verified successfully']);
                       }

                      }


        

       

        

    }





    public function resendotp(Request $request){

         $validator = $request->validate([
            'mobile_number'=>'required|string',
        ]);


    


             $curl = curl_init();

              curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.msg91.com/api/v5/otp/retry?authkey=357859AufIJss760659e28P1&retrytype=text&mobile=".urlencode($request->mobile_number)."",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              return response(['status'=>'error','message'=>'Something went wrong.']);
            } else {
              //echo $response;
             $status= json_decode($response);
             if($status->type=='error'){
            return response(['status'=>'error','message'=>$status->message]);
             }else{
            return response(['status'=>'success','message'=>$status->message]);
             }

            }




    }




    public function forgetpassword(Request $request){

   
        $request->validate(['email' => 'required|email']);

         $status = Password::sendResetLink(
                        $request->only('email')
                    );

         dd($status);

     




    }



}

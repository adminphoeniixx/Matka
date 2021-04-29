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
use App\WithdrawalRequest;
use App\Betting;
use App\Company;
use App\Events\Registration;
use Validator;

class UserController extends Controller
{
    public function withdrawrequest(Request $request){

        $validator = Validator::make($request->all(), [
            'amount'=>'required|string',
            'account_number'=>'required|string',
            'name'=>'required|string',
            'mobile_number'=>'required|string',
            'ifsc_code'=>'required|string',
            'user_id'=>'required|integer', 

        ]);



        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }


        $wallet = Wallet::where('user_id',$request->user_id)->first();

        if ($wallet) {

            if ($wallet->winning_balance >= $request->amount) {


                $data = new WithdrawalRequest;

                $data->user_id = $request->user_id;
                $data->amount_requested = $request->amount;
                $data->account_number = $request->account_number;
                $data->ifsc_code = $request->ifsc_code;
                $data->name = $request->name;
                $data->mobile_number = $request->mobile_number;
                $data->bank_name = $request->bank_name;
                $data->save();


                return response(['status'=>true,'message'=>'Request sent successfully.']);

                
            }else{

                return response(['status'=>false,'message'=>'insufficient balance in wallet.']);

            }
            
        }else{

            return response(['status'=>false,'message'=>'User wallet not found.']);

        }


        


    }



    public function withdrawhistory(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id'=>'required|integer', 
        ]);


        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }

        $data = WithdrawalRequest::join('withdraw_status','withdraw_status.id','withdrawal_requests.status')
        ->where('withdrawal_requests.user_id',$request->user_id)
        ->select('withdrawal_requests.*','withdraw_status.request_status')
        ->latest()
        ->get();

        return response(['status'=>true,'message'=>'Data fetched successfully.','history'=>$data]);


    }



     public function transactionhistory(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id'=>'required|integer', 
        ]);



        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }

        $data = Transaction::join('transaction_types','transaction_types.id','transactions.transaction_type')
        ->where('transactions.user_id',$request->user_id)
        ->select('transactions.*','transaction_types.name as transaction_type')
        ->latest()
        ->get();

        return response(['status'=>true,'message'=>'Data fetched successfully.','history'=>$data]);


    }




    




    public function getcommision(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id'=>'required|integer', 
        ]);


        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }

        $user = User::join('wallet','wallet.user_id','users.id')->where('users.id',$request->user_id)->select('users.referral_code','wallet.*')->first();

        if ($user) {
            
            $total_people_added = User::where('referral_code_used','=',$user->referral_code)->count();
            $invitation_link= "https://matkacompany.com/invite/".$user->referral_code;

             return response(['status'=>true,'message'=>'Data fetched successfully.','commision'=>$user->bonus_balance,'total_people_added'=>$total_people_added,'invitation_link'=>$invitation_link]);

        }else{ 
            return response(['status'=>false,'message'=>'User not found.']);
        }
    }





     public function exchangecommision(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id'=>'required|integer', 
        ]);



        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }



       $user = User::join('wallet','wallet.user_id','users.id')
       ->where('users.id',$request->user_id)
       ->select('wallet.id as wid')
       ->first();

        if ($user) {
            
            $wallet = Wallet::find($user->wid);

            $wallet->deposit_balance += $wallet->bonus_balance;
            $wallet->bonus_balance =0; 
            $wallet->save();

             return response(['status'=>true,'message'=>'Commision exchanged successfully.']);

        }else{ 
            return response(['status'=>false,'message'=>'User not found.']);
        }

       
    }




    public function mymatches(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id'=>'required|integer', 
        ]);


        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }


        $matches = Betting::join('live_games','live_games.id','bettings.live_game_id')
        ->join('companies','companies.id','live_games.company')
        ->join('game_types','game_types.id','live_games.game_type')
        ->leftJoin('winners','winners.betting_id','bettings.id')
        ->leftJoin('game_status','game_status.id','live_games.status')
        ->where('bettings.user',$request->user_id)
        ->select('companies.name as company_name','companies.image','game_types.name as game_type','bettings.created_at','winners.amount as winning_amount','game_status.name as game_status')
        ->get();


        return response(['status'=>true,'message'=>'Data fetched successfully.','matches'=>$matches]);


    }







       public function editprofile(Request $request){

        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'mobile_number'=>'required|string|unique:users,mobile',
            'email_address'=>'required|string|unique:users,email',
            'state_id'=>'required|integer',
            'user_id'=>'required|integer', 
        ]);


        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }



                   date_default_timezone_set('Asia/Kolkata');

                    $date=date("Y-m-d");
                    $time=date("H:m:s");              

                    $otp= rand(100000,999999);                

                   $data =  User::find($request->user_id);

                   if ($data) {
                   $data->name = $request->name;
                   $data->email = $request->email_address;
                   $data->mobile = $request->mobile_number;
                  // $data->password = bcrypt($request->password);                  
                   $data->state_id  = $request->state_id;
                   $data->save();

                   return response(['status'=>true,'message'=>'Profile updated successfully.']);
                   }else{
                    return response(['status'=>false,'message'=>'User not found.']);
                   }
                  

        

    }


       public function newpassword(Request $request){

        $validator = Validator::make($request->all(), [
            'password'=>'required|string',
            'confirm_password'=>'required|string',
            'user_id'=>'required|integer', 
        ]);


        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }


                   date_default_timezone_set('Asia/Kolkata');

                    $date=date("Y-m-d");
                    $time=date("H:m:s");                        

                   $data =  User::find($request->user_id);

                   if ($data) {

                  $data->password = bcrypt($request->confirm_password);                  

                   $data->save();

                   return response(['status'=>true,'message'=>'Password updated successfully.']);
                   }else{
                    return response(['status'=>false,'message'=>'User not found.']);
                   }
                  

        

    }





    public function getchart(Request $request){

        $validator = Validator::make($request->all(), [
            'date'=>'required|string',
   
        ]);

    

        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }

        $companies = Company::leftJoin('live_games','live_games.company','companies.id')
        ->leftJoin('winning_number','winning_number.live_game_id','live_games.id')
        ->whereDate('live_games.created_at',$request->date)
        ->select('companies.name as company_name','companies.image','winning_number.number')
        ->get();

         return response(['status'=>true,'message'=>'Data fetched successfully.','chart'=>$companies]);

    }



}

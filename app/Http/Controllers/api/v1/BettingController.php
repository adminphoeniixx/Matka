<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Betting;
use App\Wallet;
use App\User;
use App\Transaction;
use App\LiveGame;
use Validator;
use App\Firebase;

class BettingController extends Controller
{
    
    public function index()
    {
        
    }

   
    public function create()
    {
        
    }

    




    public function playjodigame(Request $request)
    {
        $validator =Validator::make($request->all(), [
            'live_game_id'=>'required|integer',
            'number'=>'required',
            'user'=>'required|integer',       
        ]);


        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }


         $user = User::find($request->user);

         if (!$user) {
             return response(['status'=>false,'message'=>'User not found.']);
         }

       

        //$numbers=json_decode($request->number,true);
         $numbers=$request->number;
        $total_amount = array_sum($numbers);




         $current_balance = Wallet::where('user_id',$request->user)->first();

        if ($current_balance->deposit_balance < $total_amount) {
          
          return response(['status'=>false,'message'=>'Insufficient balance in wallet.']);
        }




        $check_game = LiveGame::find($request->live_game_id);

        if ($check_game) {

            if ($check_game->status!=1) {

                return response(['status'=>false,'message'=>'This game is unavailable.']);
            }
            
        }else{

            return response(['status'=>false,'message'=>'This game is unavailable.']);

        }
         


        date_default_timezone_set('Asia/Kolkata');

        $date=date("Y-m-d");
        $time=date("H:m:s");



        foreach ($numbers as $key => $value) {
            $betting = new Betting;
            $betting->live_game_id = $request->live_game_id;
            $betting->number = $key;
            $betting->amount = $value;
            $betting->user = $request->user;
            $betting->type = 1;
            $betting->save();

        }
  

            // Placing Bet

            

            // updating user wallet

            $user_wallet = Wallet::find($current_balance->id);
            if ($user_wallet) {
                $user_wallet->deposit_balance -= $total_amount;
                $user_wallet->save();
            }




            $game = LiveGame::leftJoin('companies','companies.id','live_games.company')
            ->leftJoin('game_types','game_types.id','live_games.game_type')
            ->select('companies.name as companyname','game_types.name as gamename')
            ->where('live_games.id',$request->live_game_id)
            ->first();


            // Transaction Log

            $transaction = new Transaction;
            $transaction->transaction_type = 2;
            $transaction->user_id = $request->user;
            $transaction->amount = $request->amount;
            $transaction->date = $date;
            $transaction->time = $time;
            $transaction->current_balance = $user_wallet->deposit_balance + $user_wallet->winning_balance + $user_wallet->bonus_balance ;


            if (!empty($game->companyname) && !empty($game->gamename)) {
               $transaction->description = $game->gamename." game for ".$game->companyname;
            }
            
            $transaction->save();
            

    
                if (!empty($user->referral_code_used)) {


                    //calculating refferal percentage

                    $referral_percentage = setting('admin.referral_bonus_percentage');
                    $referral_bonus = ($referral_percentage / 100) * $total_amount;
                    

                    // find referral user account
                    $find_user = User::where('referral_code',$user->referral_code_used)->first();

                    if($find_user){

                    // updating refferal wallet    

                    $wallet_search= Wallet::where('user_id',$find_user->id)->first();

                        if($wallet_search){
                            $wallet = Wallet::find($wallet_search->id);
                            $wallet->bonus_balance+=$referral_bonus;
                            $wallet->save();


                        $firebase = new Firebase;
                        $title="Congratulations, You have received referral bonus.";
                        $body ="Congratulations, You have received referral bonus of ".$referral_bonus." ₹ .";
                        $firebase->send($title,$body,$find_user->id);

                                // Transaction Log 

                                $transaction = new Transaction;
                                $transaction->transaction_type = 1;
                                $transaction->user_id = $find_user->id;
                                $transaction->amount = $referral_bonus;
                                $transaction->description = "Referral Bonus Deposited.";
                                $transaction->date = $date;
                                $transaction->time = $time;
                                $transaction->current_balance = $wallet->deposit_balance + $wallet->winning_balance + $wallet->bonus_balance ;
                                $transaction->save();

            if (!empty($game->companyname) && !empty($game->gamename)) {
               $transaction->description = $game->gamename." game for ".$game->companyname;
            }
            

                        }

                    }

                    

                }
            
               
            

        return response(['status'=>true,'message'=>'Bet Placed Successfully.']);



    }






















  public function playcrossinggame(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'live_game_id'=>'required|integer',
            'numbers'=>'required|array|min:4',
            'amount'=>'required|integer',
            'user'=>'required|integer',       
        ]);


        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }


         $user = User::find($request->user);

         if (!$user) {
             return response(['status'=>false,'message'=>'User not found.']);
         }


         $total_amount = ($request->amount)*4;

        $current_balance = Wallet::where('user_id',$request->user)->first();

        if ($current_balance->deposit_balance<$total_amount) {
          
          return response(['status'=>false,'message'=>'Insufficient balance in wallet.']);
        }


        $check_game = LiveGame::find($request->live_game_id);

        if ($check_game) {

            if ($check_game->status!=1) {

                return response(['status'=>false,'message'=>'This game is unavailable.']);
            }
            
        }else{

            return response(['status'=>false,'message'=>'This game is unavailable.']);

        }


        date_default_timezone_set('Asia/Kolkata');

        $date=date("Y-m-d");
        $time=date("H:m:s");
  

            // Placing Bet


        foreach ($request->numbers as $key => $value) {



            $betting = new Betting;
            $betting->live_game_id = $request->live_game_id;
            $betting->number = $value;
            $betting->amount = $request->amount;
            $betting->user = $request->user;
            $betting->type = 2;
            $betting->save();


            // updating user wallet

            $user_wallet = Wallet::find($current_balance->id);
            if ($user_wallet) {
                $user_wallet->deposit_balance -= $request->amount;
                $user_wallet->save();
            }




            $game = LiveGame::leftJoin('companies','companies.id','live_games.company')
            ->leftJoin('game_types','game_types.id','live_games.game_type')
            ->select('companies.name as companyname','game_types.name as gamename')
            ->where('live_games.id',$request->live_game_id)
            ->first();



            // Transaction Log

            $transaction = new Transaction;
            $transaction->transaction_type = 2;
            $transaction->user_id = $request->user;
            $transaction->amount = $request->amount;
            $transaction->date = $date;
            $transaction->time = $time;
            $transaction->current_balance = $user_wallet->deposit_balance + $user_wallet->winning_balance + $user_wallet->bonus_balance ;


            if (!empty($game->companyname) && !empty($game->gamename)) {
               $transaction->description = $game->gamename." game for ".$game->companyname;
            }
            
            $transaction->save();

            
        }

            


    
                if (!empty($user->referral_code_used)) {


                    //calculating refferal percentage

                    $referral_percentage = setting('admin.referral_bonus_percentage');
                    $referral_bonus = ($referral_percentage / 100) * ($request->amount*4);
                    

                    // find referral user account
                    $find_user = User::where('referral_code',$user->referral_code_used)->first();

                    if($find_user){

                    // updating refferal wallet    

                    $wallet_search= Wallet::where('user_id',$find_user->id)->first();

                        if($wallet_search){
                            $wallet = Wallet::find($wallet_search->id);
                            $wallet->bonus_balance+=$referral_bonus;
                            $wallet->save();

                             $firebase = new Firebase;
                        $title="Congratulations, You have received referral bonus.";
                        $body ="Congratulations, You have received referral bonus of ".$referral_bonus." ₹ .";
                        $firebase->send($title,$body,$find_user->id);

                                // Transaction Log 

                                $transaction = new Transaction;
                                $transaction->transaction_type = 1;
                                $transaction->user_id = $find_user->id;
                                $transaction->amount = $referral_bonus;
                                $transaction->description = "Referral Bonus Deposited.";
                                $transaction->date = $date;
                                $transaction->time = $time;
                                $transaction->current_balance = $wallet->deposit_balance + $wallet->winning_balance + $wallet->bonus_balance ;
                                $transaction->save();

            if (!empty($game->companyname) && !empty($game->gamename)) {
               $transaction->description = $game->gamename." game for ".$game->companyname;
            }
            

                        }

                    }

                    

                }
            
               
            

        return response(['status'=>true,'message'=>'Bet Placed Successfully.']);



    }
























   
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        //
    }
}

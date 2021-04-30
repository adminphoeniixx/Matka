<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Wallet;
use App\Transaction;
use App\State;
use App\Events\Registration;
use App\Company;
use App\LiveGame;
use App\WinningNumber;
use Validator;

class HomeController extends Controller
{
    public function index(Request $request){


        $validator = Validator::make($request->all(), [
            'user_id'=>'required|string'
        ]);



        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }

        

        date_default_timezone_set('Asia/Kolkata');
        $date=date("Y-m-d");
        $time=date("H:m:s");



        $companies = Company::all();
        $live_games = LiveGame::join('companies','companies.id','live_games.company')
                       ->select('live_games.*','companies.name',\DB::raw('(SELECT COUNT(*) FROM bettings WHERE bettings.live_game_id = live_games.id) as players')) 
                      ->where('live_games.status',1)
                      ->where('live_games.is_result_declared',0)
                      ->first();

        $live_results= LiveGame::join('companies','companies.id','live_games.company')
                       ->join('winning_number','live_games.id','winning_number.live_game_id')
                       ->where('live_games.is_result_declared',1)
                       ->whereDate('live_games.created_at', '=', $date)
                      // ->orderBy('users.id','ASC')
                       ->first();             
    

        $upcoming_games = LiveGame::join('companies','companies.id','live_games.company')
                              ->where('live_games.status',0)
                              ->select('live_games.*','companies.name','companies.image','companies.bet_end_time','companies.bet_result_time')
                              ->where('live_games.is_result_declared',0)
                              ->whereDate('live_games.created_at', '=', $date)
                              ->whereTime('companies.bet_end_time','>',$time)
                              ->get();

        $is_holiday=setting('admin.holiday');

        $wallet = Wallet::where('user_id',$request->user_id)->first();
        $app_url = config('app.url');

       

                return response(['status'=>true,'message'=>'data fetched successfully.', 'companies'=>$companies,'live_game'=>$live_games,'live_results'=>$live_results,'upcoming_games'=>$upcoming_games,'is_holiday'=>$is_holiday,'wallet'=>$wallet,'app_url'=>$app_url]);             

    }




    public function wallet(Request $request){


        $validator = Validator::make($request->all(), [
            'user_id'=>'required|string'
        ]);



        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }


        $wallet = Wallet::where('user_id',$request->user_id)->first();

        if ($wallet) {
                return response(['status'=>true,'message'=>'data fetched successfully.', 'wallet'=>$wallet]);       
        }else{
            return response(['status'=>false,'message'=>'User wallet not found']);      
        }

    }





    public function addcash(Request $request){


        $validator = Validator::make($request->all(), [
            'user_id'=>'required|string',
            'amount'=>'required|string'
        ]);


        if ($validator->fails()) {

          return response(['status'=>false,'message'=>$validator->errors()->first()]);
         
        }

        $wallet = Wallet::where('user_id',$request->user_id)->first();

        if ($wallet) {

            $wallet_update = Wallet::find($wallet->id); 
            $wallet_update->deposit_balance += $request->amount;
            $wallet_update->save();

            return response(['status'=>true,'message'=>'Wallet updated successfully.', 'wallet'=>$wallet_update]);      
        }else{
            return response(['status'=>false,'message'=>'User wallet not found.']);     
        }

    }





    public function command(){
        
    }





}

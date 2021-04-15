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

class HomeController extends Controller
{
    public function index(Request $request){

    	date_default_timezone_set('Asia/Kolkata');
		$date=date("Y-m-d");
        $time=date("H:m:s");

    	$companies = Company::all();
    	$live_games = LiveGame::join('companies','companies.id','live_games.company')
    				  ->where('live_games.status',1)->first();
	

    	$upcoming_games = LiveGame::join('companies','companies.id','live_games.company')
    						  ->where('live_games.status',0)
    						  ->select('live_games.*','companies.name','companies.image','companies.bet_end_time','companies.bet_result_time')
    						  ->whereDate('live_games.created_at', '<=', $date)
    						  ->whereTime('companies.bet_end_time','>',$time)
    						  ->get();

        $is_holiday=setting('admin.holiday');

    			return response(['status'=>'success','message'=>'data fetched successfully.', 'companies'=>$companies,'live_game'=>$live_games,'upcoming_games'=>$upcoming_games,'is_holiday'=>$is_holiday]);			 

    }




    public function wallet(Request $request){


    	$login = $request->validate([
    		'user_id'=>'required|string'
    	]);

    	$wallet = Wallet::where('user_id',$request->user_id)->first();

    	if ($wallet) {
    			return response(['status'=>'success','message'=>'data fetched successfully.', 'wallet'=>$wallet]);		
    	}else{
    		return response(['status'=>'error','message'=>'User wallet not found.']);		
    	}

    }





    public function addcash(Request $request){


    	$login = $request->validate([
    		'user_id'=>'required|string',
    		'amount'=>'required|string'
    	]);

    	$wallet = Wallet::where('user_id',$request->user_id)->first();

    	if ($wallet) {

    		$wallet_update = Wallet::find($wallet->id); 
    		$wallet_update->deposit_balance += $request->amount;
    		$wallet_update->save();

    		return response(['status'=>'success','message'=>'Wallet updated successfully.', 'wallet'=>$wallet_update]);		
    	}else{
    		return response(['status'=>'error','message'=>'User wallet not found.']);		
    	}

    }





}

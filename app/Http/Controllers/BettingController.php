<?php

namespace App\Http\Controllers;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Models\Post;
use App\Http\Controllers\Controller;
use App\Betting;
use App\WinningNumber;
use Illuminate\Http\Request;
use Datatables;
use App\Winner;
use App\MasterDatum;
use App\Wallet;
use App\User;
use App\Transaction;
use App\LiveGame;

class BettingController extends Controller
{

    public function betting($id, Request $request){
        
    	return view('betting.index',['livegameid'=>$id,'sort'=>$request->sort,'order'=>$request->order]);
    }

    public function allbets($id,$number){

    	return view('betting.allbets',['livegameid'=>$id,'number'=>$number]);
    }


    public function showallbets(Request $request){
    	

    	 $data = Betting::leftJoin('users','bettings.user','users.id')
    	 ->select('bettings.*','users.name as uname')
    	 ->where('bettings.number',$request->number)
    	 ->where('bettings.live_game_id',$request->id)
    	 ->orderBy('bettings.id')
         ->get();
        return Datatables::of($data)
           ->escapeColumns([])
           ->make(true);
    }


    public function winningnumber($id){
    	$check = WinningNumber::where('live_game_id',$id)->count();

    	if ($check>0) {
    		$numbercheck=WinningNumber::where('live_game_id',$id)->first();
    		$number=$numbercheck->number;
    	}else{
    		$number="";
    	}

    	return view('betting.winningnumber',['livegameid'=>$id,'check'=>$check,'number'=>$number]);
    }






    public function addwinningnumber(Request $request){

        date_default_timezone_set('Asia/Kolkata');

        $date=date("Y-m-d");
        $time=date("H:m:s");
  

    	$data = new WinningNumber;
    	$data->number = $request->number;
    	$data->live_game_id = $request->id;
    	$data->save();


        $live_game = LiveGame::find($request->id);
        if ($live_game) {
            $live_game->is_result_declared=1;
            $live_game->result_declare_time = $date." ".$time;
            $live_game->status =0;
            $live_game->save();
        }

    	$betting_data = Betting::leftJoin('live_games','live_games.id','bettings.live_game_id')
        ->leftJoin('game_types','game_types.id','live_games.game_type')
    	->select('bettings.*','game_types.name as gametypename','game_types.id as gametypeid','live_games.company as companyid' )
    	->where('live_game_id',$request->id)
        ->where('number',$request->number)
    	->get();


    	foreach ($betting_data as $key => $value) {
    		$winner = new Winner;
    		$winner->live_game_id = $value->live_game_id;
    		$winner->user_id = $value->user;
    		$winner->amount = $value->amount;
    		$winner->number = $value->number;
            $winner->betting_id = $value->id;
    	
    		$profit=0;


    		if ($value->gametypeid==1) {
    		$profit = ($value->amount * setting('admin.jodi_winning_percentage_value'));
		
    		}elseif($value->gametypeid==2){
    			$profit = ($value->amount * setting('admin.crossing_winning_percentage_value'));
    		}




    		$wallet_search = Wallet::where('user_id',$value->user)->first();
    		if ($wallet_search) {
    			$wallet_update = Wallet::find($wallet_search->id);
    			$wallet_update->winning_balance +=  $profit;
    			$wallet_update->save();
    		}


                                $transaction = new Transaction;
                                $transaction->transaction_type = 1;
                                $transaction->user_id = $value->user;
                                $transaction->amount = $profit;
                                $transaction->description = "Winning Amount.";
                                $transaction->date = $date;
                                $transaction->time = $time;
                               // $transaction->is_winning_amount = 1;
                                $transaction->current_balance = $wallet_update->deposit_balance + $wallet_update->winning_balance + $wallet_update->bonus_balance ;
                                $transaction->save();



    		$winner->profit = $profit;
    		$winner->save();


    	}


   

    	return back()->with('success','Winning number added successfully.');

    }

}
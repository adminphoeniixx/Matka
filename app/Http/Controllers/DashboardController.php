<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use League\Flysystem\Util;
use TCG\Voyager\Facades\Voyager;
use App\User;
use App\Betting;
use App\Transaction;
use App\Winner;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(Request $request){

              $fromdate=Carbon::today()
                 ->startOfDay()        // 2018-09-29 00:00:00.000000
                 ->toDateTimeString();


              $todate=Carbon::today()
                 ->endOfDay()        // 2018-09-29 00:00:00.000000
                 ->toDateTimeString(); 


              $fromdate_input=date("Y-m-d");
              $todate_input=date("Y-m-d");  

                 

              if (isset($request->todate)) {
                $todate =Carbon::parse($request->todate)
                 ->endOfDay()        
                 ->toDateTimeString(); 

                $todate_input=$request->todate;
              }

              if (isset($request->fromdate)) {
                $fromdate =Carbon::parse($request->fromdate)
                 ->startOfDay()       
                 ->toDateTimeString();
                $fromdate_input=$request->fromdate;
              }






              $user_count= User::whereBetween('created_at', [$fromdate, $todate])->count();
              $betting_count_jodi= Betting::join('live_games','live_games.id','bettings.live_game_id')
              ->where('live_games.game_type',1)
              ->whereBetween('bettings.created_at', [$fromdate, $todate])
              ->count();
              $betting_count_crossing= Betting::join('live_games','live_games.id','bettings.live_game_id')
              ->where('live_games.game_type',2)
              ->whereBetween('bettings.created_at', [$fromdate, $todate])
              ->count();
              $deposit_count= Transaction::where('is_winning_amount',0)->where('transaction_type',1)->whereBetween('created_at', [$fromdate, $todate])->sum('amount');

              $winnners_count= Winner::whereBetween('created_at', [$fromdate, $todate])->count();
              $winnners_amount= Transaction::where('is_winning_amount',1)->whereBetween('created_at', [$fromdate, $todate])->sum('amount');

              $user_referral_count= User::where('referral_code_used','!=',"")->whereBetween('created_at', [$fromdate, $todate])->count();

              $user_referral_amount = $user_referral_count*setting('admin.joining_bonus') ;
            

  

  

        return Voyager::view('voyager::index',['fromdate'=>$fromdate,'todate'=>$todate,'user_count'=>$user_count,'betting_count_crossing'=>$betting_count_crossing,'betting_count_jodi'=>$betting_count_jodi,'deposit_count'=>$deposit_count,'winnners_count'=>$winnners_count,'winnners_amount'=>$winnners_amount,'user_referral_count'=>$user_referral_count,'user_referral_amount'=>$user_referral_amount,'fromdate_input'=>$fromdate_input,'todate_input'=>$todate_input]);
    }
}

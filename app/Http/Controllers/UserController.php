<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ReflectionClass;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Database\Schema\Table;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Events\BreadDeleted;
use TCG\Voyager\Events\BreadUpdated;
use TCG\Voyager\Facades\Voyager;
use Datatables;
use App\User;
use App\Wallet;
use App\WithdrawalRequest;
use App\Transaction;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;


use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataRestored;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;

use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;




class UserController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{

  use BreadRelationshipParser;


    public function index()
    {
       return view('users.index');
    }


    public function userdata()
    {
        $users = User::join('roles','users.role_id','roles.id')->select('users.*','roles.display_name')->orderBy('users.id','ASC')
        ->get();
        return Datatables::of($users)
           ->addColumn('action', function ($users) {
            $deleteroute =route('deleteuser',['id'=>$users->id]);
            $editroute =route('edituser',['id'=>$users->id]);
            $walletroute =route('wallet',['id'=>$users->id]);
            $ledgerroute =route('ledger',['id'=>$users->id]);
               return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
                <a style="margin-right:5px;" class="btn btn-success" href="'.$editroute.'">edit</a> 
                <a style="margin-right:5px;" class="btn btn-danger" href="'.$deleteroute.'">Delete</a>
                <a style="margin-right:5px;" class="btn btn-warning" href="'.$walletroute.'">Wallet</a>
                <a class="btn btn-primary" href="'.$ledgerroute.'">Ledger</a>
                </div>';
           })
           ->escapeColumns([])
           ->make(true);
    }

   
    public function create(Request $request)
    {
        
        return view('users.add');
    }

    

   
    public function store(Request $request)
    {


      date_default_timezone_set('Asia/Kolkata');

        $date=date("Y-m-d");
        $time=date("H:m:s");

       $data = new User;
       $data->name = $request->name;
       $data->email = $request->email;
       $data->password = bcrypt($request->password);
       $data->role_id = $request->role;
       $data->referral_code = $request->code;
       $data->save();

       $wallet = new Wallet;
       $wallet->user_id = $data->id;
       $wallet->deposit_balance = 1000;
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


       return  redirect()->route('user')->with('success','New user information added successfully.'); ;
    }




    public function edit($id)
    {
        $data = User::find($id);

        return view('users.edit',['data'=>$data]);
    }

   
    public function update(Request $request)
    {
        $data = User::find($request->id);
       $data->name = $request->name;
       $data->email = $request->email;
       if (!empty($request->password)) {
          $data->password = bcrypt($request->password);
       }
       
       $data->role_id = $request->role;
       $data->save();

       return redirect()->route('user')->with('success','User information updated successfully.');
    }

    
    public function destroy($id)
    {
        $remove = User::destroy($id);
        return  redirect()->route('user')->with('success','User information removed successfully.');
    }

  
   
   public function wallet($id){

    $data = Wallet::leftJoin('users','wallet.user_id','users.id')->select('wallet.*','users.name')->where('user_id',$id)->first();

    if ($data) {

        return view('users.wallet',['data'=>$data]);

    }else{

        return back()->with(['message' => "This user has no wallet.", 'alert-type' => 'error']);
        
    }

    

   }




public function custom($id, Request $request){

       // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];

        $searchNames = [];
        if ($dataType->server_side) {
            $searchable = SchemaManager::describeTable(app($dataType->model_name)->getTable())->pluck('name')->toArray();
            $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->get();
            foreach ($searchable as $key => $value) {
                $field = $dataRow->where('field', $value)->first();
                $displayName = ucwords(str_replace('_', ' ', $value));
                if ($field !== null) {
                    $displayName = $field->getTranslatedAttribute('display_name');
                }
                $searchNames[$value] = $displayName;
            }
        }

        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', $dataType->order_direction);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
                $query = $model->{$dataType->scope}();
            } else {
                $query = $model::select('*');
            }

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model)) && Auth::user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
                $query->where($search->key, $search_filter, $search_value);
            }

            if ($orderBy && in_array($orderBy, $dataType->fields())) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($model);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'browse', $isModelTranslatable);

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        // Actions
        $actions = [];
        if (!empty($dataTypeContent->first())) {
            foreach (Voyager::actions() as $action) {
                $action = new $action($dataType, $dataTypeContent->first());

                if ($action->shouldActionDisplayOnDataType()) {
                    $actions[] = $action;
                }
            }
        }

        // Define showCheckboxColumn
        $showCheckboxColumn = false;
        if (Auth::user()->can('delete', app($dataType->model_name))) {
            $showCheckboxColumn = true;
        } else {
            foreach ($actions as $action) {
                if (method_exists($action, 'massAction')) {
                    $showCheckboxColumn = true;
                }
            }
        }

        // Define orderColumn
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
            $orderColumn = [[$index, $sortOrder ?? 'desc']];
        }

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'actions',
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortOrder',
            'searchNames',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted',
            'showCheckboxColumn'
        ));
    
}






   public function ledger(Request $request, $id){

  $user = User::find($id);

  $fromdate= $date=date("Y-m-d");
  $todate= $date=date("Y-m-d");
  if (isset($request->todate)) {
    $todate =$request->todate;
  }

  if (isset($request->fromdate)) {
    $fromdate =$request->fromdate;
  }


  return view('users.ledger',['fromdate'=>$fromdate,'todate'=>$todate,'username'=>$user->name,'userid'=>$user->id]);

   }





    public function ledgerdata(Request $request){


     $users = Transaction::join('users','users.id','transactions.user_id')
     ->select('transactions.*','users.name','users.id as uid')
     ->where('user_id',$request->userid)
      ->whereBetween('transactions.date', [$request->fromdate, $request->todate])
     ->orderBy('transactions.id')
     ->get();

        return Datatables::of($users)

         ->addColumn('increase', function ($users) {
           if ($users->transaction_type==1) {
             return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
              <span class="label label-success">₹ '.$users->amount.'</span>

                </div>';
           }elseif($users->transaction_type==2){
            return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
               <span class="label label-success"></span>
             
                </div>';
              }
               
           })


          ->addColumn('decrease', function ($users) {
           if ($users->transaction_type==1) {
             return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
             
              <span class="label label-success"></span>
                </div>';
           }elseif($users->transaction_type==2){
            return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">

              <span class="label label-success">₹ '.$users->amount.'</span>
                </div>';
              }
               
           })


         ->addColumn('balance', function ($users) {
         
            return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
               <span class="label label-success"></span>
              <span class="label label-success">₹ '.$users->current_balance.'</span>
                </div>';    
               
           })


           ->escapeColumns([])
           ->make(true);

 }









   public function withdrawal(){
     return view('wallet.requests');
   }


   public function withdrawaldata(Request $request){

     $users = WithdrawalRequest::join('users','users.id','withdrawal_requests.user_id')->select('withdrawal_requests.*','users.name')->orderBy('withdrawal_requests.id')
        ->get();
        return Datatables::of($users)

         ->addColumn('currentstatus', function ($users) {
           if ($users->status==1) {
             return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
              <span class="label label-warning">Pending</span>
                </div>';
           }elseif($users->status==2){
            return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
              <span class="label label-success">Approved</span>
                </div>';
              }elseif($users->status==0){
                return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
              <span class="label label-danger">Declined</span>
                </div>';
              }
               
           })

           ->addColumn('action', function ($users) {
            $withdrawalapprove =route('withdrawalapprove',['id'=>$users->id]);
               return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
                <a style="margin-right:5px;" class="btn btn-primary" href="'.$withdrawalapprove.'">Approve/Decline</a> 
                </div>';
           })
           ->escapeColumns([])
           ->make(true);

   }



   public function withdrawalapprove($id){

    $withdrawal = WithdrawalRequest::join('users','users.id','withdrawal_requests.user_id')
    ->select('withdrawal_requests.*','users.name as username','users.id as userid')
    ->where('withdrawal_requests.id',$id)
    ->first();

    if ($withdrawal) {
      return view('wallet.aprove',['data'=>$withdrawal]);
    }else{
      return back()->with(['message' => "Something went wrong.", 'alert-type' => 'error']);;
    }


    



   }




   public function withdrawalstatus(Request $request){

    $date=date("Y-m-d");
    $time=date("H:i:s");

    $withdrawal = WithdrawalRequest::find($request->id);
    $withdrawal->status = $request->status;
    $withdrawal->save();


    if ($request->status==2) {
      $wallet_search = Wallet::where('user_id',$request->userid)->first();


      if ($wallet_search->winning_balance>=$request->amount) {


         if ($wallet_search) {
         $wallet_update = Wallet::find($wallet_search->id);
         $wallet_update->winning_balance -=  $request->amount;
         $wallet_update->save();
        }



        $transaction = new Transaction;
        $transaction->transaction_type = 2;
        $transaction->user_id = $request->userid ;
        $transaction->amount = $request->amount ;
        $transaction->date = $date;
        $transaction->time = $time;
        $transaction->description = "Withdrawal.";
        $transaction->current_balance = $wallet->deposit_balance + $wallet->winning_balance + $wallet->bonus_balance ;
        $transaction->save();


       
      }else{

        return back()->with(['message' => "Insufficient balance in the wallet.", 'alert-type' => 'error']);;

      }


       



    }

      
  return back()->with(['message' => "Request status changed successfully.", 'alert-type' => 'success']);

    

   }





 public function withdraw(Request $request){

  $fromdate= $date=date("Y-m-d");
  $todate= $date=date("Y-m-d");
  if (isset($request->todate)) {
    $todate =$request->todate;
  }

  if (isset($request->fromdate)) {
    $fromdate =$request->fromdate;
  }



  return view('transactions.withdraw',['fromdate'=>$fromdate,'todate'=>$todate]);
 }









 public function withdrawdata(Request $request){


     $users = Transaction::leftJoin('users','users.id','transactions.user_id')
     ->select('transactions.*','users.name')
     ->where('transaction_type',2)
     ->whereBetween('transactions.date', [$request->fromdate, $request->todate])
     ->orderBy('transactions.id')
     ->get();

        return Datatables::of($users)

         ->addColumn('transactiontype', function ($users) {
           if ($users->transaction_type==1) {
             return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
              <span class="label label-success">Deposit</span>
                </div>';
           }elseif($users->transaction_type==2){
            return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
              <span class="label label-warning">Withdrawal</span>
                </div>';
              }
               
           })


           ->escapeColumns([])
           ->make(true);

 }







 public function deposit(Request $request){

   $fromdate= $date=date("Y-m-d");
  $todate= $date=date("Y-m-d");
  if (isset($request->todate)) {
    $todate =$request->todate;
  }

  if (isset($request->fromdate)) {
    $fromdate =$request->fromdate;
  }

  return view('transactions.deposit',['fromdate'=>$fromdate,'todate'=>$todate]);

 }


 public function depositdata(Request $request){


     $users = Transaction::join('users','users.id','transactions.user_id')
     ->select('transactions.*','users.name')
     ->where('transaction_type',1)
      ->whereBetween('transactions.date', [$request->fromdate, $request->todate])
     ->orderBy('transactions.id')
     ->get();

        return Datatables::of($users)

         ->addColumn('transactiontype', function ($users) {
           if ($users->transaction_type==1) {
             return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
              <span class="label label-success">Deposit</span>
                </div>';
           }elseif($users->transaction_type==2){
            return '
               <div class="btn-group btn-group-sm text-center" role="group" aria-label="Basic example">
              <span class="label label-warning">Withdrawal</span>
                </div>';
              }
               
           })


           ->escapeColumns([])
           ->make(true);

 }
   
}
@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i> User Wallet
        </h1>
       
            
    </div>
@stop


@section('content')
 <div class="page-content browse container-fluid">

 	<div class="row">
 		<div class="col-md-12">
 			<div id="" class="table-responsive">
              <table class="table table-bordered" >
               <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>  
                    <th>Deposit Balance</th> 
                    <th>Winning Balance</th>      
                    <th>Bonus Balance</th>
                  </tr>
               </thead>
               <tbody>
                 <tr>
                   <td>1</td>
                   <td>{{$data->name}}</td>
                   <td>{{$data->deposit_balance}}</td>
                   <td>{{$data->winning_balance}}</td>
                   <td>{{$data->bonus_balance}}</td>
                  
                 </tr>
               </tbody>
            </table>
 		</div>
 	</div>



 </div>

  


 @stop
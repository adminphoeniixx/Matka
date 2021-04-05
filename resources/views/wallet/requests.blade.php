@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i> Withdrawal Requests
        </h1>
               
    </div>
@stop


@section('content')
 <div class="page-content browse container-fluid">

 	<div class="row">
 		<div class="col-md-12">
 			<div id="" class="table-responsive">
              <table class="table table-bordered" id="withdrawaltable">
               <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>  
                    <th>Requested Amount</th> 
                    <th>Status</th>      
                    <th>Action</th>
                  </tr>
               </thead>
            </table>
 		</div>
 	</div>



 </div>

  


 @stop
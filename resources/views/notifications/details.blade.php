@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i> Transactions (Deposit)
        </h1>
     
        
    </div>
@stop


@section('content')
 <div class="page-content browse container-fluid">

 	<div class="row">
 		<div class="col-md-12">
 			<div id="" class="table-responsive">
              <table class="table table-bordered" id="deposittable">
               <thead>
                  <tr>
                    <th>#</th>
                    <th>Title</th>  
                    <th>Message</th> 
                    <th>Created At</th>      
                    <th>Actions</th>
                  </tr>
               </thead>
            </table>
 		</div>
 	</div>



 </div>

  


 @stop
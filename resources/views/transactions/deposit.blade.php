@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i> Transactions (Deposit)
        </h1>


          <div class="row">
          <form action="{{route('deposit')}}" method="get" >
          <div class="col-md-4 form-group">
            <label> From Date: </label>
            <input type="date" value="{{$fromdate}}" required="true" class="form-control" name="fromdate">
          </div>

          <div class="col-md-4 form-group">
            <label> To Date: </label>
            <input type="date" value="{{$todate}}" required="true" class="form-control" name="todate">
          </div>

          <div class="col-md-4 form-group">
            <label>Action</label>
            <input type="submit" name="submit" class="form-control btn btn-primary">
          </div>

          </form>
        </div>
       
        
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
                    <th>User Name</th>  
                    <th>Transaction Type</th> 
                    <th>Amount</th>      
                    <th>Date</th>
                    <th>Time</th>
                  </tr>
               </thead>
            </table>
 		</div>
 	</div>



 </div>

  


 @stop
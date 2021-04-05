@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i> Users
        </h1>
       
            <a href="{{route('adduser')}}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>Add User</span>
            </a>


    
       
      
     
        
    </div>
@stop


@section('content')
 <div class="page-content browse container-fluid">

 	<div class="row">
 		<div class="col-md-12">
 			<div id="" class="table-responsive">
              <table class="table table-bordered" id="table">
               <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>  
                    <th>User Email</th> 
                    <th>User Role</th>      
                     <th >Action</th>
                  </tr>
               </thead>
            </table>
 		</div>
 	</div>



 </div>

  


 @stop
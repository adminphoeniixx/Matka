@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i>Push Notifications Management
        </h1>
      <a href="{{route('addpushnotification')}}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>Add Push Notifiction</span>
            </a>
        
    </div>
@stop


@section('content')
 <div class="page-content browse container-fluid">

 	<div class="row">
 		<div class="col-md-12">
 			<div id="" class="table-responsive">
              <table class="table table-bordered" id="notificationstable">
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

  </div>


 @stop
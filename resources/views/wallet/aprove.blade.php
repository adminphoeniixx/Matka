@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i>Withdrawal Request Action
        </h1>    
        
    </div>
@stop


@section('content')
 <div class="page-content browse container-fluid">

 	<div class="row">
 		<div class="col-md-12">
 			@include('partials.alerts.alert')
 		</div>
 	</div>



<form action="{{route('withdrawalstatus')}}" method="post">
	@csrf
	<input type="hidden" name="id" value="{{$data->id}}">
	<input type="hidden" name="userid" value="{{$data->userid}}">
	<div class="row">

		<div class="col-md-6 form-group">
			<label>User Name *</label>
			<input type="text" name="username"  placeholder="User Name" readonly="true" value="{{$data->username}}"  class="form-control">
		</div>

		<div class="col-md-6 form-group">
			<label>Requested Amount *</label>
			<input type="number" name="amount"  placeholder="Requested Amount" readonly="true" value="{{$data->amount_requested}}"  class="form-control">
		</div>

		<div class="col-md-6 form-group">
			<label>Action *</label>
			<select class="form-control" name="status" required="true">
				<option value="">Select Option</option>
				<option @if($data->status==2) selected @endif value="2">Approve</option>
				<option @if($data->status==0) selected @endif value="0">Decline</option>
			</select>
		</div>


		<div class="col-md-6 form-group">
			<label>&nbsp;</label>
			<input type="submit" class="form-control btn btn-primary" value="Submit">
		</div>

	</div>
</form>

 </div>


 @stop
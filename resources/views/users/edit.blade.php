@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i>Update Users
        </h1>
       
            

    
       
      
     
        
    </div>
@stop


@section('content')
 <div class="page-content browse container-fluid">

<form action="{{route('updateuser')}}" method="post">
	@csrf
	<input type="hidden" name="id" value="{{$data->id}}">
	<div class="row">
		<div class="col-md-6 form-group">
			<label>User Name *</label>
			<input type="text" name="name" value="{{$data->name}}" placeholder="User Name" required="true" class="form-control">
		</div>

		<div class="col-md-6 form-group">
			<label>User Email *</label>
			<input type="email" name="email" value="{{$data->email}}" placeholder="User Email" required="true" class="form-control">
		</div>

		<div class="col-md-6 form-group">
			<label>Password (Leave empty for no change.)  </label>
			<input type="password" name="password"  placeholder="User Password"  class="form-control">
		</div>

		<div class="col-md-6 form-group">
			<label>Role *</label>
			@php
			$roles = \DB::table('roles')->get();
			@endphp
			<select class="form-control" name="role" required="true" >
				<option value="">Select Option</option>
				@foreach($roles as $role)
				<option @if($data->role_id==$role->id) selected @endif value="{{$role->id}}">{{$role->display_name}}</option>
	            @endforeach		
			</select>
		</div>

		<div class="col-md-6 form-group">
			<label>Referral Code</label>
			<input type="text" name="code" value="{{$data->referral_code}}" placeholder="Referral Code" readonly="true" class="form-control">
		</div>

		<div class="col-md-6 form-group">
			<label>&nbsp;</label>
			<input type="submit" class="form-control btn btn-primary" value="Submit">
		</div>

	</div>
</form>

 </div>


 @stop
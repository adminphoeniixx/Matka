@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i>Add Winning Number
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


@if($check<1)
<form action="{{route('addwinningnumber')}}" method="post">
	@csrf
	<input type="hidden" name="id" value="{{$livegameid}}">
	<div class="row">
		<div class="col-md-6 form-group">
			<label>Winning Number *</label>
			<input type="number" name="number" max="99" placeholder="Winning Number" required="true" class="form-control">
		</div>


		<div class="col-md-6 form-group">
			<label>&nbsp;</label>
			<input type="submit" class="form-control btn btn-primary" value="Submit">
		</div>

	</div>
</form>
@else
<div class="row">
	<div class="col-md-4"></div>
	<div style="border: solid 1px #595959" class="col-md-4 text-center">
		<h3>Winning number for this game is:</h3>
		<h1>{{$number}}</h1>
	</div>
	<div class="col-md-4"></div>
</div>
@endif
 </div>


 @stop
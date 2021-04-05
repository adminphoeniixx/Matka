@extends('voyager::master')


@section('content')
 <div class="page-content browse container-fluid">
 	@php

 		 $numbers = array('00','01','02','03','04','05','06','07','08','09','10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '80', '81', '82', '83', '84', '85', '86', '87', '88', '89', '90', '91', '92', '93', '94', '95', '96', '97', '98', '99');
 		 $betting_data = [];
 		 $collection = collect([]);
foreach ($numbers as $key => $value) {
	$data = \DB::table('bettings')->where('live_game_id',$livegameid)->where('number',$value)->sum('amount');
	$betting_data[]=[$value=>$data];
	$collection->put($value,$data);
	
}



if (!empty($sort)) {
	if ($sort==1) {

		if (!empty($order)) {
			if ($order==1) {
				$collection=$collection->sortKeys();
			}else{
				$collection=$collection->sortKeysDesc();
			}
		}else{
			$collection=$collection->sortKeys();
		}

		
	}elseif($sort==2){

		if (!empty($order)) {
			if ($order==1) {
				$collection=$collection->sort();
			}else{
				$collection=$collection->sortDesc();
			}
		}else{
			$collection=$collection->sort();
		}
	
	
	}
	
}

 	@endphp
<div style="padding-top: 20px;" class="row  text-center pt-2">


	<div class="col-md-12">

	<form action="{{route('betting',['id'=>$livegameid])}}" method="get">
		<select name="sort">
			<option value="">Sort By</option>
			<option @if($sort==1) selected @endif value="1">Numbers</option>
			<option  @if($sort==2) selected @endif value="2">Amount</option>

		</select>

		<select name="order">
			<option value="">Order</option>
			<option  @if($order==1) selected @endif value="1">Ascending</option>
			<option  @if($order==2) selected @endif value="2">Descending</option>

		</select>

		<input class="btn btn-primary" type="submit" name="submit">
	</form>
		
	</div>
	

	@foreach($collection as $x => $number)
    <div style="border: solid 1px #808080; " class="col-3 col-md-3">
    	@php
    

    		$data = \DB::table('bettings')->where('live_game_id',$livegameid)->where('number',$number)->sum('amount');
  
    	@endphp
	  <h3> <strong> {{$x}}</strong></h3>	
	  <h5>Total Amount: {{$number}} ₹</h5>
	  <h6><a href="{{route('allbets',['id'=>$livegameid,'number'=>$x])}}">View Details</a></h6>
	</div>
	@endforeach

	
</div>
</div>
@stop
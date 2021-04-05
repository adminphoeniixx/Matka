@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i>Add Notification
        </h1>
       
           

    
       
      
     
        
    </div>
@stop


@section('content')
 <div class="page-content browse container">

<form action="{{route('addnotification')}}" method="post">
	@csrf
	<div class="row">

		<div class="col-md-12">
			<input type="radio" id="all" checked="true" name="sendtype" required="true" value="all">
			<label for="all"><b>Send To All</b> </label> &nbsp;  &nbsp; &nbsp;
			<input type="radio" id="selected" name="sendtype" value="selected">
			<label for="selected"><b>Select Users</b> </label><br>
		</div>


		<div id="usersbox" class="col-md-12">

			<div class="form-group">
				<label >Select Users</label>
				<select class="form-control" name="users[]" id="users" multiple="true" >
					@foreach($users as $user)
					<option value="{{$user->id}}" >{{$user->name}}</option>
					@endforeach
				</select>
			</div>
			
		</div>



		<div class="col-md-12 form-group">
			<label>Title *</label>
			<textarea class="form-control" name="title" required="true"></textarea>
		</div>

		<div class="col-md-12 form-group">
			<label>Message *</label>
			<textarea class="form-control richTextBox" name="messagebody" required="true"></textarea>
		</div>

		

		

		

		<div class="col-md-6 form-group">
			<label>&nbsp;</label>
			<input type="submit" class="form-control btn btn-primary" value="Submit">
		</div>

	</div>
</form>

 </div>

@push('javascript')
    <script>
        $(document).ready(function() {
            var additionalConfig = {
            	min_height: 200,
                selector: 'textarea.richTextBox[name="message"]',
            }

            $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? '{}') !!})

            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
        });
    </script>
@endpush



 @stop
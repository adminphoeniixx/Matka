@if(Session::has('success'))
<div class="alert alert-success">
  <strong>Success!</strong> {{Session::get('success')}}
</div>

@elseif(Session::has('error'))
<div class="alert alert-danger">
  <strong>Error!</strong> {{Session::get('error')}}
</div>
@endif
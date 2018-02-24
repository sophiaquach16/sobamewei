@if (Session::has('success_msg'))
<div class="alert alert-success alert-dismissable topMess rectangular"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ Session::get('success_msg') }}</div>
@endif

@if (Session::has('error_msg'))
<div class="alert alert-danger alert-dismissable topMess rectangular"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ Session::get('error_msg') }}</div>
@endif

@if ( !empty($success_msg))
<div class="alert alert-success alert-dismissable topMess rectangular"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $success_msg }}</div>
@endif

@if ( !empty($error_msg))
<div class="alert alert-danger alert-dismissable topMess rectangular"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error_msg }}</div>
@endif
<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>

<body>
	@include('includes.nav')

	@unless ( empty($success_msg) )
    <div class="alert alert-success alert-dismissable topMess rectangular"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $success_msg }}</div>
	@endunless

	@unless ( empty($error_msg) )
    <div class="alert alert-danger alert-dismissable topMess rectangular"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>error_msg</div>
	@endunless

	@yield('content')
</body>
</html>
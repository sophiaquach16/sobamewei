@extends('layouts.default')
@section('content')
<div class="pageContainer container-fluid">
    <div class="text-center"><span class="logo">conUshop</span></div>

    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 panel" id="loginForm">

            <form class="panel-body" action=" /login" method="post">
                <div class="text-center"><h2>Log In</h2></div>
                <div class="form-group">

                    <label for="email">Email:</label>
                    <input type="email" id="email" class="form-control" name="email" value="" placeholder="Enter email" />
                </div>
				@unless ( empty($errors->first('email')) )
				<div class="alert alert-danger alert-dismissable topMess rectangular"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('email') }}</div>
				<br />
				@endunless
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" class="form-control" name="password" value="" placeholder="Enter password" />
                </div>
				@unless ( empty($errors->first('password')) )
				<div class="alert alert-danger alert-dismissable topMess rectangular"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('password') }}</div>
				<br />
				@endunless

				<input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <button type="submit" class="btn btn-success btn-block">Log In</button>

            </form>
        </div>

        <div class="col-sm-4"></div>
    </div>
</div>
@stop
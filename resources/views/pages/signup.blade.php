@extends('layouts.default')
@section('content')

<script type="text/javascript" src="{{ URL::asset('js/registrationvalidation.js') }}"></script>
<div class="pageContainer container-fluid">
	<form method="post" action=" /signup" name="signupForm" id = "signupForm">
		<div class ="form-group">
			<label for="firstName">First name:</label>
			<input type="text" class ="form-control" id="firstName" placeholder="John" name="firstName">
		</div>
		<div class ="form-group">
			<label for="lastName">Last name:</label>
			<input type="text" class ="form-control" id="lastName" placeholder="Doe" name="lastName">
		</div>
		<div class ="form-group">
			<label for="email">Email address:</label>
			<input type="email" class ="form-control" id="email" placeholder="123@example.com" name="email">
		</div>
		<div class ="form-group">
			<label for="password">Password:</label>
			<input type="password" class ="form-control" id="email" placeholder="Enter password here..." name="password">
		</div>
		<div class ="form-group">
			<label for="phone">Phone number:</label>
			<input type="text" class ="form-control" id="phone" placeholder="123-456-7890" name="phone">
		</div>
		<div class ="form-group">
			<label for="physicalAddress">Address:</label>
			<input type="text" class ="form-control" id="physicalAddress" placeholder="123 Avenue" name="physicalAddress">
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>
@stop

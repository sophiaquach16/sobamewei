@extends('layouts.default')
@section('content')

<script src="/js/registration-validation.js" type="text/javascript"></script>


<div class="pageContainer container-fluid">
  <div class="text-center"><h3>Registration Form</h3>
  </div>

    <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4" id="registerForm">

      <form method="post" action="/registration" name="registration" id = "registerForm">
        {{ csrf_field() }}
        <div class ="form-group">
  			       <label for="firstName">First name</label>
  			          <input type="text" class ="form-control" id="firstName" placeholder="John" name="firstName">

        </div>
  		  <div class ="form-group">
  			   <label for="lastName">Last name</label>
  			      <input type="text" class ="form-control" id="lastName" placeholder="Doe" name="lastName">
  		  </div>

  		    <div class ="form-group">
  			       <label for="email">Email address</label>
  			          <input type="email" class ="form-control" id="email" placeholder="123@example.com" name="email">
  		   </div>

         <div class ="form-group">
  			      <label for="password">Password</label>
  			         <input type="password" class ="form-control" id="password" placeholder="Enter password here..." name="password">
  		  </div>

  		  <div class ="form-group">
  			     <label for="phone">Phone number</label>
  			        <input type="text" class ="form-control" id="phone" placeholder="514-123-4567" name="phone">
  		  </div>

          <div class ="form-group">
  			       <label for="physicalAddress">Address</label>
  			          <input type="text" class ="form-control" id="physicalAddress" placeholder="123 Avenue" name="physicalAddress">
  		    </div>

            <button type="submit" class="btn btn-info btn-block">Register</button>
          </br>
          <div class="text-center">
            <a href="/login">Existing User?</a>
          </div>
  	</form>
  </div>

  </div>

</div>
@stop

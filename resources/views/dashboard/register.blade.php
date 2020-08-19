@extends('layout',[ 'title' => "Register", 'route' => $route ?? '' ])

@section('bodyDashboard')

<div style="margin-top: 5%;" class="jumbotron">
    <center><h3> Register Component </h3></center>
                
          @if( $errors )
						@foreach( $errors->all() as $error )
						<div class="alert alert-danger">
							{{ $error }}
						</div>
						@endforeach
					@endif
<form action="/auth/register" method="POST">
    @csrf
  
  <div class="form-group">
    <label for="exampleInputPassword1">Fullname</label>
    <input name="fullname" value="{{ old('fullname') }}" type="text" class="form-control" id="exampleInputPassword1" placeholder="Fullname">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input name="email" value="{{ old('email') }}" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input name="password" value="{{ old('password') }}" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password Reset</label>
    <input name="password2" value="{{ old('password2') }}" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password Reset">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Birth Date</label>
    <input name="birth_date" value="{{ old('birth_date') }}" type="date" class="form-control" id="exampleInputPassword1" placeholder="Birth">
  </div>
  
  <button type="submit" class="btn btn-primary">Register</button>
  <div class="registration">
		                If you have an account, please  
		                <a class="" href="/login">
		                    Sign in
		                </a>
 </div>
</form>
</div>
 
@endsection('bodyDashboard')
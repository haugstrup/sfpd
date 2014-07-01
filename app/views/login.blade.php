@extends("layout")
@section("content")
	{{ Form::open(array('url' => 'login', 'role' => 'form')) }}
		<h1>Login</h1>

		<!-- if there are login errors, show them here -->
		<p>
			{{ $errors->first('email') }}
			{{ $errors->first('password') }}
		</p>

		<div class="form-group">
			{{ Form::label('email', 'Email Address') }}
			{{ Form::text('email', Input::old('email'), array('placeholder' => 'yourself@example.com', 'class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password', array('class' => 'form-control')) }}
		</div>

		<div class="form-group">{{ Form::submit('Login', array('class' => 'btn btn-primary')) }}</div>
	{{ Form::close() }}
@stop

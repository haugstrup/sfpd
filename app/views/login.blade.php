@extends("layout")
@section("content")
	{{ Form::open(array('url' => 'login')) }}
		<h1>Login</h1>

		<!-- if there are login errors, show them here -->
		<p>
			{{ $errors->first('email') }}
			{{ $errors->first('password') }}
		</p>

		<div>
			{{ Form::label('email', 'Email Address') }}
			{{ Form::text('email', Input::old('email'), array('placeholder' => 'yourself@example.com')) }}
		</div>

		<div>
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password') }}
		</div>

		<p>{{ Form::submit('Login') }}</p>
	{{ Form::close() }}
@stop

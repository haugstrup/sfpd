@extends("layout")
@section("title")
	@if ($_ENV['LEAGUE'] == 'sfpd')
		SFPD
	@else
		Belles and Chimes
	@endif
@stop
@section("content")
	{{ Form::open(array('url' => 'login', 'role' => 'form')) }}
		<h2>Login</h2>

		<div class="form-group">
			{{ Form::label('email', 'Email Address') }}
			{{ Form::email('email', Input::old('email'), array('placeholder' => 'yourself@example.com', 'class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password', array('class' => 'form-control')) }}
		</div>

		<div class="form-group">{{ Form::submit('Login', array('class' => 'btn btn-primary')) }}</div>
	{{ Form::close() }}
@stop

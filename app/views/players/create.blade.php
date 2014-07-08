@extends("layout")
@section("content")
<h2>Add Player</h2>

{{ Form::model($player, array('route' => array('admin.players.store'), 'method' => 'post')) }}

  @include('players.form', array('player' => $player))

  {{ Form::submit('Add player', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.players.index') }}">Cancel</a>
{{ Form::close() }}

@stop

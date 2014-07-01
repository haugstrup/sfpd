@extends("layout")
@section("content")
<h1>Edit {{{ $player->name }}}</h1>

{{ Form::model($player, array('route' => array('admin.players.update', $player->player_id), 'method' => 'put')) }}

  @include('players.form', array('player' => $player))

  {{ Form::submit('Update player', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.players.index') }}">Cancel</a>
{{ Form::close() }}

@stop

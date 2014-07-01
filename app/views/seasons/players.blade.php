@extends("layout")
@section("content")
<h1>Players in {{{$season->name}}}</h1>

{{ Form::open(array('route' => array('admin.seasons.update_players', $season->season_id), 'method' => 'put')) }}
<table class="table table-bordered">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Name</th>
      <th>Initials</th>
      <th>IFPA No.</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($players as $player)
      <tr class="state-">
        <td>
          {{ Form::checkbox("players[]", $player->player_id, $season->has_player($player), array('id' => "player-{$player->player_id}")) }}
        </td>
        <td>{{ Form::label("player-{$player->player_id}", $player->display_name) }}</td>
        <td>{{ Form::label("player-{$player->player_id}", $player->initials ? $player->initials : '&nbsp;') }}</td>
        <td>@if ($player->ifpa_id) <a href="http://www.ifpapinball.com/player.php?player_id={{{ $player->ifpa_id }}}">{{{ $player->ifpa_id }}}</a>@endif</td>
      </tr>
    @endforeach
  </tbody>
</table>
{{ Form::submit('Save changes', array('class' => 'btn btn-success')) }}

{{ Form::close() }}

@stop

@extends("layout")
@section("content")
<h2>Players in {{{$season->name}}}</h2>

{{ Form::open(array('route' => array('admin.seasons.update_players', $season->season_id), 'method' => 'put')) }}
<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th class="text-center">Initials</th>
      <th class="text-center">IFPA No.</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($players as $player)
      <tr class="state-">
        <td>
          {{ Form::checkbox("players[]", $player->player_id, $season->has_player($player), array('id' => "player-{$player->player_id}")) }}
          {{ Form::label("player-{$player->player_id}", $player->display_name) }}</td>
        <td class="text-center">{{ Form::label("player-{$player->player_id}", $player->initials ? $player->initials : '&nbsp;') }}</td>
        <td class="text-center">@if ($player->ifpa_id) <a href="http://www.ifpapinball.com/player.php?player_id={{{ $player->ifpa_id }}}">{{{ $player->ifpa_id }}}</a>@endif</td>
      </tr>
    @endforeach
  </tbody>
</table>
{{ Form::submit('Save changes', array('class' => 'btn btn-success')) }}

{{ Form::close() }}

@stop

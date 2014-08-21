@extends("layout")
@section("content")

@include('seasons.menu')

<h2>Players in {{{$season->name}}}</h2>

{{ Form::open(array('route' => array('admin.seasons.update_players', $season->season_id), 'method' => 'put')) }}
<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th class="text-center">Rookie?</th>
      <th class="text-center">Guest?</th>
      <th class="text-center">Final position</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($players as $player)
      <tr class="state-">
        <td>
          {{ Form::checkbox("players[]", $player->player_id, $season->has_player($player), array('id' => "player-{$player->player_id}")) }}
          {{ Form::label("player-{$player->player_id}", $player->display_name) }}</td>
        <td class="text-center">{{ Form::checkbox("rookies[]", $player->player_id, $season->is_rookie($player), array('id' => "rookie-{$player->player_id}")) }}</td>
        <td class="text-center">{{ Form::checkbox("guests[]", $player->player_id, $season->is_guest($player), array('id' => "guest-{$player->player_id}")) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
{{ Form::submit('Save changes', array('class' => 'btn btn-success')) }}

{{ Form::close() }}

@stop

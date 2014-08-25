@extends("layout")
@section("content")
<h2>Edit {{{$group->heat->season->name}}}, {{{$group->heat->name()}}}, {{{$group->name()}}}</h2>

<h2 style="color:red;">Per do not use this! Per do not use this! Per do not use this!</h2>

<h3>Players</h3>
{{ Form::model($group, array('route' => array('admin.groups.update_players', $group->group_id), 'method' => 'put')) }}
  @for($i=0;$i<=3;$i++)
    <div class="form-group">
      {{ Form::label('players[]', 'Player '.($i+1)) }}:
      {{Form::select('players[]', $players, isset($group->players[$i]) ? $group->players[$i]->player_id : null) }}
    </div>
  @endfor
  {{ Form::submit('Update players', array('class' => 'btn btn-primary')) }}
{{ Form::close() }}

{{ Form::model($group, array('route' => array('admin.groups.update_results', $group->group_id), 'method' => 'put')) }}
<h3>Games</h3>

  @for($i=0;$i<=3;$i++)
    <div class="form-group">
      {{ Form::label('machines[]', 'Game '.($i+1)) }}<br>
      {{Form::select('machines[]', $machines, isset($group->games[$i]) ? $group->games[$i]->machine->machine_id : null) }}
    </div>

    @foreach($group->players as $player)
      <div class="form-group">
        {{Form::select('results['.$i.']['.$player->player_id.']', array(
          '' => '-- no result --',
          1 => $points_map[count($group->players)][1] . ' points',
          2 => $points_map[count($group->players)][2] . ' points',
          3 => $points_map[count($group->players)][3] . ' points',
          4 => $points_map[count($group->players)][4] . ' points',
          0 => 'Disqualified',
          -1 => 'Tardy'
        ), isset($group->games[$i]) ? $group->games[$i]->result_for_player($player)->position : null) }}
        {{ Form::label('results['.$i.']['.$player->player_id.']', $player->name) }}
        {{ Form::checkbox('bonus['.$i.']['.$player->player_id.']', 'bonus', isset($group->games[$i]) && $group->games[$i]->result_for_player($player)->bonus_points ? true : false) }} Bonus
      </div>
    @endforeach
      <hr>
  @endfor

  {{ Form::submit('Update results', array('class' => 'btn btn-primary')) }}
{{ Form::close() }}

@stop

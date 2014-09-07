@extends("layout")
@section("content")

@include('seasons.menu')

<h2>Final positions for {{{$season->name}}}</h2>

<div class="alert alert-warning">
  Don't set final positions until the season is over.
</div>

{{ Form::open(array('route' => array('admin.seasons.update_positions', $season->season_id), 'method' => 'put')) }}
<table class="table table-striped table-vertical-center">
  <thead>
    <tr>
      <th>Name</th>
      <th class="text-center">Adj. points</th>
      <th class="text-center">Regular season finish</th>
      <th class="text-center">Final position</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($points as $point)
      <?php $player = $season->get_player_by_id($point['player_id']) ?>
      <tr>
        <td>{{{$player->name}}}</td>
        <td class="text-center">{{{$point['adjusted_points']}}}</td>
        <td class="text-center">{{{$point['position']}}}</td>
        <td class="text-center">
          {{ Form::text("players[".$player->player_id."]", $player->final_position ? $player->final_position : $point['position'], array("class" => 'form-control input-table-small')) }}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
{{ Form::submit('Save final positions', array('class' => 'btn btn-success')) }}

{{ Form::close() }}

@stop

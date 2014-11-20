@extends("layout_public")
@section("content")

<h2>{{{$player->display_name}}}</h2>

@if ($group)
<div class="section">
  <h3>Last result: {{{$group->heat->season->name}}}, {{{$group->heat->name}}}</h3>
  @include('public.groups.group', array('group' => $group))
</div>
@endif

@if ($machines && count($machines) > 0)
<div class="section">
  <h3>Machine choices</h3>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th class="text-center">Count</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($machines as $machine)
      <tr>
        <td>{{{$machine->name}}}</td>
        <td class="text-center">{{{$machine->count}}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

@if($seasons && count($seasons) > 0)
<div class="section" ng-if="seasons.length > 0">
  <h3>Seasons</h3>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Season</th>
        <th class="text-center">Final position</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($seasons as $season)
      <tr>
        <td>
          {{{$season->name}}}
          @if ($season->pivot->guest)
            <span class="player-icon glyphicon glyphicon-user" title="Guest"></span>
          @endif
          @if ($season->pivot->rookie)
            <span class="player-icon glyphicon glyphicon-tower" title="Rookie"></span>
          @endif
        </td>
        <td class="text-center">
          @if ($season->pivot->final_position)
            {{{$season->pivot->final_position}}}
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

@stop

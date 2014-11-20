@extends("layout_public")
@section("title")
  Standings {{{$season['name']}}}
@stop
@section("content")

<div class="landscape-tip alert alert-info"><b>Tip:</b> Rotate your phone to landscape mode for a better view.</div>

<ol class="breadcrumb">
  <li class="active dropdown">
    <a class="dropdown-toggle" href="3" data-toggle="dropdown" aria-expanded="false">{{{$season['name']}}}<span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
      @foreach($seasons as $s)
        <li role="presentation"><a role="menuitem" href="{{URL::route('standings.show', $s->season_id)}}">{{{$s->name}}}</a></li>
      @endforeach
    </ul>
  </li>
</ol>

<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Round:</th>
      @foreach ($season['heats'] as $heat)
        <th class="text-center">
          @if($heat['status'] !== 'inactive')
            <a href="{{URL::route('results.show', $heat['heat_id'])}}">#{{{isset($heat['delta']) ? $heat['delta']+1 : '0'}}}</a>
          @else
            #{{{isset($heat['delta']) ? $heat['delta']+1 : '0'}}}
          @endif
        </th>
      @endforeach
      @if ($season['should_adjust_score'])
        <th class="text-center">Adj.</th>
      @endif
      <th class="text-center">Tot.</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($season['points'] as $season_point)
      <tr>
        <td class="index-cell">{{{$season_point['position']}}}</td>
        <td>
          <a href="{{{URL::route('players.show', $season_point['player_id'])}}}">
            {{{$season['players'][$season_point['player_id']]['display_name'] }}}
            {{$season['players'][$season_point['player_id']]['icon']}}
          </a>
        </td>
        @foreach ($season['heats'] as $heat)
          <td class="text-center">
            @if(!empty($heat['points'][$season_point['player_id']]))
              <a href="{{{URL::route('groups.public', $heat['points'][$season_point['player_id']]['group_id'])}}}">{{{$heat['points'][$season_point['player_id']]['points']}}}</a>
            @else
              0
            @endif
          </td>
        @endforeach
        @if ($season['should_adjust_score'])
          <td class="text-center"><b>{{{$season_point['adjusted_points']}}}</b></td>
        @endif
        <td class="text-center">
          @if ($season['should_adjust_score'])
            <span>{{$season_point['points']}}</span>
          @else
            <b>{{$season_point['points']}}</b>
          @endif
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

@stop

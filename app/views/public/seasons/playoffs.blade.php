@extends("layout_public")
@section("title")
  Playoffs {{{$season->name}}}
@stop
@section("content")

<ol class="breadcrumb">
  <li>Playoffs</li>
  <li class="active dropdown"><a class="dropdown-toggle" href="3" data-toggle="dropdown" aria-expanded="false">{{{$season['name']}}}<span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
      @foreach($seasons as $s)
        <li role="presentation"><a role="menuitem" href="{{URL::route('standings.show', $s->season_id)}}">{{{$s->name}}}</a></li>
      @endforeach
    </ul>
  </li>
  <li class="breadcrumb-right"><a href="{{{URL::route('standings.show', $season->season_id)}}}">Reg. season</a></li>
</ol>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Player</th>
      <th class="text-center">Finish</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($results as $result)
      <tr>
        <td>
          <a href="{{{URL::route('players.show', $result->player_id)}}}">
            {{{$result->display_name }}}
            @if ($result->rookie)
              <span class="player-icon glyphicon glyphicon-tower" title="Rookie"></span>
            @endif
          </a>
        </td>
        <td class="text-center">{{{$result->final_position}}}{{{date('S',mktime(1,1,1,1,( (($result->final_position>=10)+($result->final_position>=20)+($result->final_position==0))*10 + $result->final_position%10) ))}}}</td>
      </tr>
    @endforeach
  </tbody>
</table>

@stop

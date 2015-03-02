@extends("layout")
@section("content")

@include('seasons.menu')

<h2>IFPA results for {{{$season->name}}}</h2>

<p>
  <a href="{{{URL::route('admin.seasons.ifpa', array($season->season_id))}}}">Final positions</a> |
  <a href="{{{URL::route('admin.seasons.ifpa', array($season->season_id, 'filter' => 'top5'))}}}">First 5 rounds</a> |
  <a href="{{{URL::route('admin.seasons.ifpa', array($season->season_id, 'filter' => 'bottom5'))}}}">Last 5 rounds</a>
</p>

<p>
  <b>{{{$message}}}</b>
</p>

<textarea class="form-control" cols="30" rows="80">
@foreach($ifpa as $player)
{{{$player['position']}}},{{{$player['name']}}}{{{$player['ifpa_id'] ? ','.$player['ifpa_id'] : ''}}}{{{"\n"}}}
@endforeach
</textarea>

@stop

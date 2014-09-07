@extends("layout")
@section("content")

@include('seasons.menu')

<h2>IFPA results for {{{$season->name}}}</h2>

<textarea class="form-control" cols="30" rows="80">
@foreach($ifpa as $player)
{{{$player['position']}}},{{{$player['name']}}}{{{$player['ifpa_id'] ? ','.$player['ifpa_id'] : ''}}}{{{"\n"}}}
@endforeach
</textarea>

@stop

@extends("layout_public")
@section("title")
  Notes
@stop
@section("content")
<h2>Notes</h2>
<p>Find below notes about why a game was removed in a given round</p>
@foreach ($heats as $heat)
<h3>{{{$heat->season->name}}}, {{{$heat->name}}}</h3>
<div>
  <?php print nl2br(htmlentities($heat->notes)); ?>
</div>
<hr>
@endforeach

@stop

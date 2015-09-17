@extends("layout_public")
@section("title")
  Notes
@stop
@section("content")
<h2>Notes</h2>
<p>Find below notes about why a game was removed in a given round</p>
<div><b>Permanently out</b></div>
<div>
  Bride of Pinbot (unsuitable rules)<br>
  <!-- Police Force (unsuitable rules)<br> -->
  Super Mario Bros (unsuitable rules)<br>
  Super Mario Bros. Mushroom World (unfair to tall people)<br>
  <!-- Black Knight (always breaks down)<br> -->
  <!-- Black Knight 2000 (always breaks down)<br> -->
  Captain Fantastic (playfield protector catches ball)<br>
  <!-- Checkpoint (display always goes out)<br> -->
  <!-- Cyclone (scoop kicks ball SDTM)<br> -->
  <!-- Fireball 2 (no tilt bob)<br> -->
  High-Speed (no tilt bob)<br>
  <!-- Popeye (confuses locks)<br> -->
  Terminator 3 (ends balls prematurely)
  <!-- Tommy (multiball problems) -->
</div>
@foreach ($heats as $heat)
<h3>{{{$heat->season->name}}}, {{{$heat->name}}}</h3>
<div>
  <?php print nl2br(htmlentities($heat->notes)); ?>
</div>
<hr>
@endforeach

@stop

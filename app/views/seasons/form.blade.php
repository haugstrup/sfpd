<div class="form-group">
  {{ Form::label('name', 'Name') }}
  {{ Form::text('name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('status', 'Status') }}
  {{Form::select('status', array('inactive' => 'Inactive', 'complete' => 'Complete', 'active' => 'Active'), null, array('class' => 'form-control'))}}
</div>

<div class="form-group">
  {{ Form::label('game_count', 'Number of games per round') }}
  {{Form::select('game_count', array("3" => "3 games", "4" => "4 games", "5" => "5 games"), null, array('class' => 'form-control'))}}
</div>

<div class="form-group">
  {{ Form::label('adjust_points', 'Adjust points after round number') }}
  {{Form::select('adjust_points', array('' => "Don't adjust", "7" => "Round 7"), null, array('class' => 'form-control'))}}
</div>

<div class="form-group">
  {{ Form::label('points_map', 'Points Map') }}
  {{Form::select('points_map', array(
    '{"4":{"1":7,"2":5,"3":3,"4":1},"3":{"1":7,"2":4,"3":1,"4":0} }' => 'SFPD Season 5 (7/5/3/1)',
    '{"4":{"1":4.5,"2":3,"3":2,"4":1},"3":{"1":4.5,"2":2.5,"3":1,"4":0} }' => 'SFPD Season 4 (4.5/3/2/1)',
    '{"4":{"1":5,"2":3,"3":2,"4":1},"3":{"1":4.5,"2":2.5,"3":1.5,"4":0} }' => 'SFPD Legacy (5/3/2/1)',
    '{"4":{"1":4,"2":3,"3":2,"4":1},"3":{"1":3.5,"2":2.5,"3":1.5,"4":0} }' => 'SFPD Legacy (4/3/2/1)',
    '{"4":{"1":4,"2":3,"3":2,"4":1},"3":{"1":4,"2":2.5,"3":1,"4":0} }' => 'Belles and Chimes (4/3/2/1)',
  ), null, array('class' => 'form-control'))}}
</div>

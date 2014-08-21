<div class="form-group">
  {{ Form::label('name', 'Name') }}
  {{ Form::text('name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('status', 'Status') }}
  {{Form::select('status', array('complete' => 'Complete', 'active' => 'Active'), null, array('class' => 'form-control'))}}
</div>

<div class="form-group">
  {{ Form::label('points_map', 'Points Map') }}
  {{Form::select('points_map', array('{"4":{"1":4.5,"2":3,"3":2,"4":1},"3":{"1":4.5,"2":2.5,"3":1,"4":0} }' => '4.5 / 3 / 2 / 1', '{"4":{"1":5,"2":3,"3":2,"4":1},"3":{"1":4.5,"2":2.5,"3":1.5,"4":0} }' => '5 / 3 / 2 / 1'), null, array('class' => 'form-control'))}}
</div>

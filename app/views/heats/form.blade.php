<div class="form-group">
  {{ Form::label('html5_date', 'Date') }}
  {{ Form::input('date', 'html5_date', $heat->html5_date, array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('html5_time', 'Time') }}
  {{ Form::input('time', 'html5_time', $heat->html5_time, array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('status', 'Status') }}
  {{Form::select('status', array('inactive' => 'Inactive', 'active' => 'Active', 'completed' => 'Completed'), $heat->status, array('class' => 'form-control'))}}
</div>

{{Form::hidden('season_id', $heat->season_id)}}

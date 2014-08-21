<div class="form-group">
  {{ Form::label('name', 'Name') }}
  {{ Form::text('name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('status', 'Status') }}
  {{Form::select('status', array('complete' => 'Complete', 'active' => 'Active'), null, array('class' => 'form-control'))}}
</div>

<div class="form-group">
  {{ Form::label('name', 'Name') }}
  {{ Form::text('name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('shortname', 'Short Name') }}
  {{ Form::text('shortname', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('status', 'Status') }}
  {{Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), null, array('class' => 'form-control'))}}
</div>

<div class="form-group">
  {{ Form::label('type', 'Type') }}
  {{Form::select('type', array('' => '-- No value --', 'dmd' => 'DMD', 'ss' => 'Solid State', 'em' => 'Electro Mechanical'), null, array('class' => 'form-control'))}}
</div>

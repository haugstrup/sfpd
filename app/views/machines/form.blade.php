<div>
  {{ Form::label('name', 'Name') }}
  {{ Form::text('name') }}
</div>

<div>
  {{ Form::label('shortname', 'Short Name') }}
  {{ Form::text('shortname') }}
</div>

<div>
  {{ Form::label('status', 'Status') }}
  {{Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'))}}
</div>

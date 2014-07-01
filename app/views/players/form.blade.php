<div class="form-group">
  {{ Form::label('name', 'Full name (for IFPA)') }}
  {{ Form::text('name', Input::get('name'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('display_name', 'Name to display') }}
  {{ Form::text('display_name', Input::get('display_name'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('ifpa_id', 'IFPA player number') }}
  {{ Form::text('ifpa_id', Input::get('ifpa_id'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
  {{ Form::label('initials', 'Initials') }}
  {{ Form::text('initials', Input::get('initials'), array('class' => 'form-control')) }}
</div>

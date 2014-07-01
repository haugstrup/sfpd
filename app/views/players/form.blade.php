<div>
  {{ Form::label('name', 'Full name (for IFPA)') }}
  {{ Form::text('name') }}
</div>

<div>
  {{ Form::label('display_name', 'Name to display') }}
  {{ Form::text('display_name') }}
</div>

<div>
  {{ Form::label('ifpa_id', 'IFPA player number') }}
  {{ Form::text('ifpa_id') }}
</div>

<div>
  {{ Form::label('initials', 'Initials') }}
  {{ Form::text('initials') }}
</div>

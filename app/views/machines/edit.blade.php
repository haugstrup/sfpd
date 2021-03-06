@extends("layout")
@section("content")
<h2>Edit {{{ $machine->name }}}</h2>

{{ Form::model($machine, array('route' => array('admin.machines.update', $machine->machine_id), 'method' => 'put')) }}

  @include('machines.form', array('machine' => $machine))

  {{ Form::submit('Update machine', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.machines.index') }}">Cancel</a>
{{ Form::close() }}

@stop

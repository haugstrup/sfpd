@extends("layout")
@section("content")
<h2>Add machine</h2>

{{ Form::model($machine, array('route' => array('admin.machines.store'), 'method' => 'post')) }}

  @include('machines.form', array('machine' => $machine))

  {{ Form::submit('Add machine', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.machines.index') }}">Cancel</a>
{{ Form::close() }}

@stop

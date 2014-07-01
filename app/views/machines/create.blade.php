@extends("layout")
@section("content")
<h1>Add machine</h1>

{{ Form::model($machine, array('route' => array('admin.machines.store'), 'method' => 'post')) }}

  @include('machines.form', array('machine' => $machine))

  {{ Form::submit('Add machine', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.machines.index') }}">Cancel</a>
{{ Form::close() }}

@stop

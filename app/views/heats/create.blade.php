@extends("layout")
@section("content")
<h2>Add round</h2>

{{ Form::model($heat, array('route' => array('admin.heats.store'), 'method' => 'post')) }}

  @include('heats.form', array('heat' => $heat))

  {{ Form::submit('Add round', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.seasons.show', $heat->season_id) }}">Cancel</a>
{{ Form::close() }}

@stop

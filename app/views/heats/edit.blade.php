@extends("layout")
@section("content")
<h2>Edit {{{ $heat->name() }}}</h2>

{{ Form::model($heat, array('route' => array('admin.heats.update', $heat->heat_id), 'method' => 'put')) }}

  @include('heats.form', array('heat' => $heat))

  {{ Form::submit('Update round', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.seasons.show', $heat->season_id) }}">Cancel</a>
{{ Form::close() }}

@stop

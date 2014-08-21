@extends("layout")
@section("content")
@include('seasons.menu')

<h2>Edit {{{ $season->name }}}</h2>

{{ Form::model($season, array('route' => array('admin.seasons.update', $season->season_id), 'method' => 'put')) }}

  @include('seasons.form', array('season' => $season))

  {{ Form::submit('Update season', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.machines.index') }}">Cancel</a>
{{ Form::close() }}

@stop

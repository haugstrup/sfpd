@extends("layout")
@section("content")
@include('seasons.menu_index')

<h2>Add Season</h2>

{{ Form::model($season, array('route' => array('admin.seasons.store'), 'method' => 'post')) }}

  @include('seasons.form', array('season' => $season))

  {{ Form::submit('Add season', array('class' => 'btn btn-primary')) }} <a class="btn btn-cancel" href="{{ URL::route('admin.seasons.index') }}">Cancel</a>
{{ Form::close() }}

@stop

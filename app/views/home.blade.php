@extends("layout")
@section("content")

@if ($season)
  <h1>Season: {{{ $season->name }}}</h1>

  <h2>Heats</h2>
  <table class="table table-striped table-vertical-center">
    <thead>
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($season->heats as $heat)
        <tr class="{{$heat->status === 'active' ? 'info' : ''}}">
          <td><a href="{{ URL::route('admin.heats.show', $heat->heat_id) }}">{{$heat->name()}}</a></td>
          <td><a href="{{ URL::route('admin.heats.show', $heat->heat_id) }}">{{$heat->formatted_date()}}</a></td>
          <td class="text-center">
            @if ($heat->status === 'inactive')
              {{ Form::open(array('route' => array('heats.activate', $heat->heat_id))) }}
                {{ Form::submit('Activate', array('class' => 'btn btn-success')) }}
              {{ Form::close() }}
            @else
              {{ Form::open(array('route' => array('heats.deactivate', $heat->heat_id))) }}
                {{ Form::submit('Close', array('class' => 'btn btn-default')) }}
              {{ Form::close() }}
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

{{ Form::open(array('route' => array('admin.seasons.store_heat', $season->season_id), 'method' => 'post', 'class' => 'form-inline')) }}
  {{ Form::input('date', 'date', '', array('class' => 'form-control')) }}
  {{ Form::input('time', 'time', '', array('class' => 'form-control')) }}
  {{ Form::submit('Add heat', array('class' => 'btn btn-success')) }}
{{ Form::close() }}

<hr>

<h2>Players</h2>
<ul class="unstyled">
  <li><a href="{{ URL::route('admin.seasons.players', array($season->season_id)) }}">View/Modify players for this season</a></li>
</ul>


@endif

@stop

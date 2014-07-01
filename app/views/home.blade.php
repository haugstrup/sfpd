@extends("layout")
@section("content")

@if ($season)
  <h1>Season: {{{ $season->name }}}</h1>
  <h2>Players</h2>
  <ul class="unstyled">
    <li><a href="{{ URL::route('admin.seasons.players', array($season->season_id)) }}">View/Modify players for this season</a></li>
  </ul>
  <h2>Heats</h2>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($season->heats as $heat)
        <tr class="state-{{$heat->status}}">
          <td><a href="{{ URL::route('admin.heats.show', $heat->heat_id) }}" class="state-{{$heat->status}}">{{$heat->name()}}</a></td>
          <td><a href="{{ URL::route('admin.heats.show', $heat->heat_id) }}" class="state-{{$heat->status}}">{{$heat->formatted_date()}}</a></td>
          <td>
            @if ($heat->status === 'inactive')
              {{ Form::open(array('route' => array('heats.activate', $heat->heat_id))) }}
                {{ Form::submit('Activate', array('class' => 'btn btn-success')) }}
              {{ Form::close() }}
            @else
              {{ Form::open(array('route' => array('heats.deactivate', $heat->heat_id))) }}
                {{ Form::submit('Close', array('class' => 'btn')) }}
              {{ Form::close() }}
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

<hr>

{{ Form::open(array('route' => array('admin.seasons.store_heat', $season->season_id), 'method' => 'post', 'class' => 'form-inline')) }}
  {{ Form::input('date', 'date', '') }}
  {{ Form::input('time', 'time', '') }}
  {{ Form::submit('Add heat', array('class' => 'btn btn-success')) }}
{{ Form::close() }}


@endif

@stop

@extends("layout")
@section("content")

@include('seasons.menu')

@if ($season)
  <h2>{{{ $season->name }}} <a href="{{ URL::route('admin.heats.create', array('season_id' => $season->season_id)) }}" class="btn btn-primary">Add round</a></h2>

  <table class="table table-striped table-vertical-center">
    <thead>
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th class="text-center">Status</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($season->heats as $heat)
        <tr class="{{$heat->status === 'active' ? 'info' : ''}}">
          <td><a href="{{ URL::route('admin.heats.show', $heat->heat_id) }}">{{$heat->name()}}</a></td>
          <td><a href="{{ URL::route('admin.heats.show', $heat->heat_id) }}">{{$heat->formatted_date()}}</a></td>
          <td class="text-center">{{{$heat->status}}}</td>
          <td class="text-center">
            <a href="{{ URL::route('admin.heats.edit', $heat->heat_id) }}" class="btn btn-link">edit</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

@endif

@stop

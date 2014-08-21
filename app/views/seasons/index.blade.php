@extends("layout")
@section("content")

@include('seasons.menu_index')

<h2>All seasons</h2>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($seasons as $season)
      <tr>
        <td>{{{ $season->season_id }}}</td>
        <td><a href="{{ URL::route('admin.seasons.show', $season->season_id) }}">{{{ $season->name }}}</a></td>
        <td>{{{ ucfirst($season->status) }}}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@stop

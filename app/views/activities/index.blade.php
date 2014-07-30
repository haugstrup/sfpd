@extends("layout")
@section("content")

  <h2>Activity log</h2>
  <table class="table table-striped table-vertical-center">
    <thead>
      <tr>
        <th>Action</th>
        <th>ID no.</th>
        <th>Date</th>
        <th>Data</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($activities as $activity)
        <tr>
          <td>{{ $activity->actionFormatted() }}</td>
          <td>{{ $activity->ref_id }}</td>
          <td>{{ $activity->created_at }}</td>
          <td><textarea cols="45" rows="1">{{{ $activity->data }}}</textarea></td>
        </tr>
      @endforeach
    </tbody>
  </table>

@stop

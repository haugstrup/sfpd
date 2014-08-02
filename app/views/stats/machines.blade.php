@extends("layout")
@section("content")

  @include('stats.menu')

  <h2>Most popular machines</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Machine</th>
        <th class="text-center">Games played</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{{ $item->name }}}</td>
          <td class="text-center">{{{ $item->aggregate }}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

@stop

@extends("layout")
@section("content")

  @include('stats.menu')

  <h2>Popularity by type</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Type</th>
        <th class="text-center">Games played</th>
        <th class="text-center">Percentage</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($type_popular as $item)
        <tr>
          <td>{{{ $type_map[$item->type] }}}</td>
          <td class="text-center">{{{ $item->aggregate }}}</td>
          <td class="text-center">{{{ $item->percentage }}} %</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <h2>Most popular machines</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Machine</th>
        <th class="text-center">Games played</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list_popular as $item)
        <tr>
          <td>{{{ $item->name }}}</td>
          <td class="text-center">{{{ $item->aggregate }}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

@stop

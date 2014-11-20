@extends("layout_public")
@section("content")

  <ol class="breadcrumb">
    <li>Stats</li>
    <li class="active dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">{{{$current_filter_name}}}<span class="caret"></span></a>
      <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
        @foreach($filters as $key => $filter)
          <li role="presentation"><a role="menuitem" href="{{URL::route('stats.index', array('filter' => $key))}}">{{{$filter}}}</a></li>
        @endforeach
      </ul>
    </li>
  </ol>

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

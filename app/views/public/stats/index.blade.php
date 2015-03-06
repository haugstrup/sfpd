@extends("layout_public")
@section("title")
  Machine stats
@stop
@section("content")

  <ol class="breadcrumb">
    <li>Stats</li>
    <li class="active dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">Machine stats<span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li role="presentation"><a role="menuitem" href="{{URL::route('statistics.index')}}">Machine stats</a></li>
        <li role="presentation"><a role="menuitem" href="{{URL::route('statistics.players')}}">Player stats</a></li>
      </ul>
    </li>
    <li class="active dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">{{{$current_filter_name}}}<span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        @foreach($filters as $key => $filter)
          <li role="presentation"><a role="menuitem" href="{{URL::route('statistics.index', array('filter' => $key))}}">{{{$filter}}}</a></li>
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
          <td><a href="{{{ URL::route('statistics.machine', array($item->machine_id, 'filter' => $raw_filter)) }}}">{{{ $item->name }}}</a></td>
          <td class="text-center">{{{ $item->aggregate }}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

@stop

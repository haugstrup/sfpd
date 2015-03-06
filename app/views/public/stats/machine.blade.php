@extends("layout_public")
@section("title")
  {{{$machine->name}}} stats
@stop
@section("content")

<ol class="breadcrumb">
  <li><a href="{{{ URL::route('statistics.index', array('filter' => Input::get('filter'))) }}}">« Back to stats</a></li>
  <li class="active dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">{{{$current_filter_name}}}<span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
      @foreach($filters as $key => $filter)
        <li role="presentation"><a role="menuitem" href="{{URL::route('statistics.machine', array($machine->machine_id, 'filter' => $key))}}">{{{$filter}}}</a></li>
      @endforeach
    </ul>
  </li>
</ol>

<h2>Picks for {{{$machine->name}}}</h2>
@if ($picks && count($picks) > 0)
  <p>The table below shows how many times a player has picked this machine
  @if ($current_filter_name !== 'Add filter')
    in <b>{{{$current_filter_name}}}</b>
  @endif
  </p>

  <div class="section">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th class="text-center">Count</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($picks as $pick)
        <tr>
          <td><a href="{{{URL::route('players.show', $pick->player_id)}}}">{{{$pick->display_name}}}</a></td>
          <td class="text-center">{{{$pick->count}}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@else
  <p>No one has picked this machine
  @if ($current_filter_name !== 'Add filter')
    in <b>{{{$current_filter_name}}}</b>
  @endif
  </p>
@endif


@stop

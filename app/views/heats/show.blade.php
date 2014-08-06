@extends("layout")
@section("content")
<h2>{{{$heat->season->name}}}: {{$heat->name()}} <a href="{{ URL::route('admin.heats.print', $heat->heat_id) }}" class="btn btn-primary" target="_blank">Print groups</a></h2>
<p>There are currently {{$heat->player_count()}} players in this round.</p>
@if ($heat->groups)
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Group</th>
        <th>No.</th>
        <th>Games</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($heat->groups as $group)
        <tr>
          <td><a href="{{ $group->url() }}" target="_blank">{{{ $group->name() }}}</a></td>
          <td>{{{ count($group->players) }}}</td>
          <td>
            @foreach ($group->games as $game)
              <span class="glyphicon {{$game->status === 'completed' ? 'glyphicon-ok text-success' : 'glyphicon-minus text-info'}}" title="Last update: {{$game->local_updated_at()}}"></span>
            @endforeach
            @for ($i = 0; $i < (4-count($group->games)); $i++)
              <span class="glyphicon glyphicon-minus text-muted"></span>
            @endfor
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endif

<hr>

{{ Form::open(array('route' => array('admin.heats.store_groups', $heat->heat_id), 'method' => 'post', 'class' => 'form-inline')) }}
  Create {{ Form::text('count', '20', array('class' => 'input-sm form-control', 'size' => 2)) }} fresh groups {{ Form::submit('Go!', array('class' => 'btn btn-success btn-sm')) }}
{{ Form::close() }}

<hr>

{{ Form::open(array('route' => array('admin.heats.destroy_groups', $heat->heat_id), 'method' => 'delete')) }}
  {{ Form::submit('Delete unused groups', array('class' => 'btn btn-danger')) }} (will delete any group that has no players)
{{ Form::close() }}

@stop

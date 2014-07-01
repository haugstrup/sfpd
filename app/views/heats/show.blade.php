@extends("layout")
@section("content")
<h1>{{{$heat->season->name}}}: {{$heat->name()}}</h1>

<hr>
{{ Form::open(array('route' => array('admin.heats.store_groups', $heat->heat_id), 'method' => 'post', 'class' => 'form-inline')) }}
  Create {{ Form::text('count', '20', array('class' => 'input-mini')) }} fresh groups {{ Form::submit('Go!', array('class' => 'btn btn-success')) }}
{{ Form::close() }}
<hr>

<h2>Groups <a href="{{ URL::route('admin.heats.print', $heat->heat_id) }}" class="btn btn-primary" target="_blank">Print groups</a></h2>
@if ($heat->groups)
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Code</th>
        <th>Players</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($heat->groups as $group)
        <tr>
          <td>{{{ $group->name() }}}</td>
          <td><a href="{{ $group->url() }}">{{{ $group->code }}}</a></td>
          <td>{{{ count($group->players) }}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endif

<hr>

{{ Form::open(array('route' => array('admin.heats.destroy_groups', $heat->heat_id), 'method' => 'delete')) }}
  {{ Form::submit('Delete unused groups', array('class' => 'btn btn-danger')) }} (will delete any group that has no players)
{{ Form::close() }}

@stop

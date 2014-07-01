@extends("layout")
@section("content")
<h1>All machines <a href="{{ URL::route('admin.machines.create') }}" class="btn btn-primary">Add machine</a></h1>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Short</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($machines as $machine)
      <tr class="state-{{{ $machine->status }}}">
        <td><a href="{{ URL::route('admin.machines.edit', $machine->machine_id) }}">{{{ $machine->name }}}</a></td>
        <td>{{{ $machine->shortname }}}</td>
        <td>
          @if ($machine->status === 'inactive')
            {{ Form::open(array('route' => array('machines.activate', $machine->machine_id))) }}
              {{ Form::submit('Activate', array('class' => 'btn btn-success')) }}
            {{ Form::close() }}
          @else
            {{ Form::open(array('route' => array('machines.deactivate', $machine->machine_id))) }}
              {{ Form::submit('Deactivate', array('class' => 'btn')) }}
            {{ Form::close() }}
          @endif
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@stop

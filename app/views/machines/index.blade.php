@extends("layout")
@section("content")
<h2>All {{{ count($machines) }}} machines <a href="{{ URL::route('admin.machines.create') }}" class="btn btn-primary">Add machine</a></h2>
<table class="table table-striped table-vertical-center">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th class="text-center">Short</th>
      <th class="text-center">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($machines as $machine)
      <tr class="{{{ $machine->status == 'inactive' ? 'info' : '' }}}">
        <td>{{{ $machine->machine_id }}}</td>
        <td><a href="{{ URL::route('admin.machines.edit', $machine->machine_id) }}">{{{ $machine->name }}}</a></td>
        <td class="text-center">{{{ $machine->shortname }}}</td>
        <td class="text-center">
          @if ($machine->status === 'inactive')
            {{ Form::open(array('route' => array('machines.activate', $machine->machine_id))) }}
              {{ Form::submit('Activate', array('class' => 'btn btn-success')) }}
            {{ Form::close() }}
          @else
            {{ Form::open(array('route' => array('machines.deactivate', $machine->machine_id))) }}
              {{ Form::submit('Deactivate', array('class' => 'btn btn-default')) }}
            {{ Form::close() }}
          @endif
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@stop

@extends("layout")
@section("content")
<h2>{{{$group->heat->season->name}}}: {{{$group->heat->name()}}}, {{{$group->name()}}} <a href="{{{$group->url()}}}" target="_blank" class="btn btn-primary">Open in public app</a></h2>

<h3>Players</h3>
@if ($group->players)
  <ul>
    @foreach ($group->players as $player)
      <li>{{{$player->name}}}</li>
    @endforeach
  </ul>
@endif

<h3>Games</h3>
@if ($group->games)
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Machine</th>
        <th>Status</th>
        <th>Created</th>
        <th>Updated</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($group->games as $game)
        <tr>
          <td>{{{ $game->machine->name }}}</td>
          <td>{{{ ucfirst($game->status) }}}</td>
          <td>{{{ $game->local_created_at() }}}</td>
          <td>{{{ $game->local_updated_at() }}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endif
<a href="{{ URL::route('admin.groups.edit', $group->group_id) }}" class="btn btn-danger btn-sm">Per don't click this</a>

@stop

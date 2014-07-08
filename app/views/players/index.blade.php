@extends("layout")
@section("content")
<h2>All players <a href="{{ URL::route('admin.players.create') }}" class="btn btn-primary">Add player</a></h2>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Display name</th>
      <th>Full Name</th>
      <th>Initials</th>
      <th>IFPA No.</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($players as $player)
      <tr class="state-">
        <td><a href="{{ URL::route('admin.players.edit', $player->player_id) }}">{{{ $player->display_name }}}</a></td>
        <td>{{{ $player->name }}}</td>
        <td>{{{ $player->initials }}}</td>
        <td>@if ($player->ifpa_id) <a href="http://www.ifpapinball.com/player.php?player_id={{{ $player->ifpa_id }}}">{{{ $player->ifpa_id }}}</a>@endif</td>
      </tr>
    @endforeach
  </tbody>
</table>
@stop

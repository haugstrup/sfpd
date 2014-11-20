<table class="table table-scores">
  <thead>
    <tr>
      <th>{{{$group->name}}}</th>
      @foreach($group->games as $game)
        <th class="text-center" title="{{{$game->machine->name}}}">{{{$game->machine->shortname}}}</th>
      @endforeach
      <th class="text-center"><b>Total</b></th>
    </tr>
  </thead>
  <tbody>
    @foreach($group->players as $player)
    <tr>
      <td><a href="{{{URL::route('players.show', $player->player_id)}}}">{{{$player->display_name}}}</a></td>
      @foreach($group->games as $game)
      <td class="text-center {{{ $player->player_id === $game->player_id ? 'active' : '' }}}">
        {{{ $game->result_for_player($player)->points }}}
      </td>
      @endforeach
      <td class="text-center">
        <b>{{{ $group->points_for_player($player) }}}</b>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

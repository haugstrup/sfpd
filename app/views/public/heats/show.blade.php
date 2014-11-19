@extends("layout_public")
@section("content")

<h2>
  {{{$season->name}}} {{{$heat->name}}}
  <div class="dropdown dropdown-right">
    <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
      Change round
      <span class="caret"></span>
    </button>

    <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
      @foreach($heats as $h)
        <li role="presentation"><a role="menuitem" href="{{URL::route('results.show', $h->heat_id)}}">{{{$season->name}}} {{{$h->name}}}</a></li>
      @endforeach
    </ul>
  </div>
</h2>

<ul class="list-unstyled">
  @foreach($heat->groups as $group)
    @if(count($group->games) > 0)
    <li>
      <table class="table table-scores table-condensed">
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
            <td><a href="/#/player/{{{$player->player_id}}}">{{{$player->display_name}}}</a></td>
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
    </li>
    @endif
  @endforeach
</ul>

@stop

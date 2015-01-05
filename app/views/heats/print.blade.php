@extends("layout_print")
@section("content")
@if ($heat->groups)
  @foreach ($heat->groups as $group)
  <div class="sheet">
    <div class="scores">
      <div class="code-cell">
        Code:
        <b>{{{$group->code}}}</b>
      </div>
      <table>
        <thead>
          <tr class="fake-header">
            <th colspan="4">SFPD {{{$heat->season->name}}}, {{{$heat->name()}}}</th>
            <th colspan="2" class="name">{{{$group->name()}}}</th>
          </tr>
          <tr>
            <th class="player-name">Player</th>
            @for ($i = 0; $i < $heat->season->game_count; $i++)
              <th>Pin:</th>
            @endfor
          </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < 4; $i++)
            <tr>
              <td class="player-name">&nbsp;</td>
              @for ($j = 0; $j < $heat->season->game_count; $j++)
              <td>
                <table class="positions">
                  <tr>
                    <td class="small">1st</td>
                    <td class="small">2nd</td>
                    <td class="small">3rd</td>
                    <td class="small">4th</td>
                  </tr>
                </table>
              </td>
              @endfor
            </tr>
          @endfor
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" class="small">Circle the <b>finishing position</b> for each player. Use the mobile app: <b>{{url('/')}}</b></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  @endforeach
@endif

@stop

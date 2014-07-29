@extends("layout_print")
@section("content")
@if ($heat->groups)
  @foreach ($heat->groups as $group)
  <div class="sheet">
    <div class="mobile">
      {{ QrCode::size(100)->generate($group->url()); }}<br>
      Code:<br><b class="code">{{{$group->code}}}</b>
    </div>
    <div class="scores">
      <table>
        <thead>
          <tr class="fake-header">
            <th colspan="3"><img src="/img/ball-19.png" alt="" width="18" height="19">SFPD Score Sheet, {{{$group->name()}}}</th>
            <th colspan="3" class="name">{{{$heat->season->name}}}, {{{$heat->name()}}}</th>
          </tr>
          <tr>
            <th>Player Name</th>
            <th>Pin:</th>
            <th>Pin:</th>
            <th>Pin:</th>
            <th>Pin:</th>
          </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < 4; $i++)
            <tr>
              <td>&nbsp;</td>
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
            </tr>
          @endfor
        </tbody>
        <tfoot>
          <tr>
            <td colspan="6" class="small">Circle the <b>finishing position</b> for each player. Use the mobile app: <b>{{url('/')}}</b></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  @endforeach
@endif

@stop

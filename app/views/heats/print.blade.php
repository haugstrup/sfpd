@extends("layout_print")
@section("content")
@if ($heat->groups)
  @foreach ($heat->groups as $group)
  <div class="sheet">
    <div class="mobile">
      {{ QrCode::size(100)->generate($group->url()); }}<br>
      Code:<br><b>{{{$group->code}}}</b>
    </div>
    <div class="scores">
      <table>
        <thead>
          <tr class="fake-header">
            <th colspan="3">SFPD Score Sheet, {{{$group->name()}}}</th>
            <th colspan="3" class="name">{{{$heat->season->name}}}, {{{$heat->name()}}}</th>
          </tr>
          <tr>
            <th>Player Name</th>
            <th>Pin:</th>
            <th>Pin:</th>
            <th>Pin:</th>
            <th>Pin:</th>
            <th class="total">Total</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="6">Fill in the <b>points</b> each player earned. Use the mobile app: <b>{{url('/')}}</b></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  @endforeach
@endif

@stop

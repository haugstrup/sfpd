@extends("layout_public")
@section("title")
  Guest stats
@stop
@section("content")
<h2>Guests per round</h2>
@foreach ($data as $season_id => $v)
<h3>{{{$seasons[$season_id]}}}</h3>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Round</th>
        <th class="text-center">Non-rookie members</th>
        <th class="text-center">Rookies</th>
        <th class="text-center">Guests</th>
        <th class="text-center">Guest %</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($v as $value)
        <tr>
          <td>{{{$value['name']}}}</td>
          <td class="text-center">{{{$value['member_count']}}}</td>
          <td class="text-center">{{{$value['rookie_count']}}}</td>
          <td class="text-center">{{{$value['guest_count']}}}</td>
          <td class="text-center">{{{ $value['guest_percentage'] }}}%</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endforeach

@stop

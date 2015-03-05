@extends("layout_public")
@section("title")
  Player stats
@stop
@section("content")
<ol class="breadcrumb">
  <li>Stats</li>
  <li class="active dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">Player stats<span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
      <li role="presentation"><a role="menuitem" href="{{URL::route('statistics.index')}}">Machine stats</a></li>
      <li role="presentation"><a role="menuitem" href="{{URL::route('statistics.players')}}">Player stats</a></li>
    </ul>
  </li>
</ol>

<h2>Players per round</h2>

<script src="/Chart.min.js"></script>
<canvas id="myChart" style="width:100%;" height="150"></canvas>
<script>
  var data = {
      labels: [],
      datasets: [
          {
              label: "Players",
              data: []
          }
      ]
  };
  @foreach ($players_per_round as $round => $count)
    @if ($count > 0)
      data.labels.push("{{{$round}}}");
      data.datasets[0].data.push({{{$count}}});
    @endif
  @endforeach

  var ctx = document.getElementById("myChart").getContext("2d");
  var myBarChart = new Chart(ctx).Bar(data, {responsive: true, scaleBeginAtZero: false});
</script>

<h2>Average strength of schedule</h2>

<p>Table below shows the average opponent strength for each player. Only the current season is taken into account and only players who have played in more than two rounds are shown.</p>

<table class="table table-striped">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Player</th>
      <th class="text-right">Average opponent strength</th>
    </tr>
  </thead>
  <tbody>
    <?php $count = 1; ?>
    @foreach ($players_by_sos as $player_id => $sos)
      <tr>
        <td class="index-cell">{{{$count}}}</td>
        <td>{{{ $points['players'][$player_id]['display_name'] }}}</td>
        <td class="text-right">{{{ $sos['average'] }}}</td>
      </tr>
      <?php $count++; ?>
    @endforeach
  </tbody>
</table>

@stop

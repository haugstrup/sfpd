@extends("layout_public")
@section("title")
  {{{$player->display_name}}}
@stop
@section("content")

<h2>Latest games for {{{$player->display_name}}}</h2>

<p>This table lists machines played for the latest 50 games for {{{$player->display_name}}}. The <em>average position</em> shows the average position obtained on that machine (lower is better), <em>games played</em> is the number of games played on that machine (of the latest 50 games) and <em>results</em> are the actual results (1 = 1st; 4 = 4th).</p>

@if ($games)
<div class="section">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Machine</th>
        <th class="text-center">Average position</th>
        <th class="text-center">Games played</th>
        <th class="text-center">Results</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($aggregated_results as $machine_id => $r)
      <tr>
        <td><a href="{{{URL::route('statistics.machine', $machine_id)}}}">{{{$r['name']}}}</a></td>
        <td class="text-center">{{{$r['average']}}}</td>
        <td class="text-center">{{{count($r['results'])}}}</td>
        <td class="text-center">{{{join(', ', $r['results'])}}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

@stop

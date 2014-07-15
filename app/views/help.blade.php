@extends("layout")
@section("content")

<div class="navbar navbar-default">
  <div class="navbar-inner">
    <a class="navbar-brand" href="{{ url('/') }}"><img src="/img/logo64.png" alt="SFPD" width="32" height="32"></a>
    <ul class="nav navbar-nav">

      <li class="{{ substr(Request::path(), 6, 8) == 'players' ? 'active' : '' }}">
        <a href="{{ url('/') }}">Go Back</a>
      </li>

    </ul>
  </div>
</div>

<h2>An overview</h2>

<h3>Finding your group</h3>

<h3>Adding players</h3>

<h3>Choosing a game</h3>

<h3>Entering results</h3>

<h3>Viewing results</h3>

@stop

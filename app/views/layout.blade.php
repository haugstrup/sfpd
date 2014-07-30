<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>@if (!Auth::check()) @yield("title") @else SFPD Admin @endif</title>
  <link rel="apple-touch-icon" href="/img/touch-icon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/admin.css">
</head>
<body>

  <div class="container">

    @if (Auth::check())
    <div class="navbar navbar-default">
      <div class="navbar-inner">
        <a class="navbar-brand" href="{{ URL::route('admin.index') }}"><img src="/img/logo64.png" alt="SFPD" width="32" height="32"></a>
        <ul class="nav navbar-nav">

          <li class="{{ substr(Request::path(), 6, 8) == 'players' ? 'active' : '' }}">
            <a href="{{ URL::route('admin.players.index') }}">Players</a>
          </li>

          <li class="{{ substr(Request::path(), 6, 8) == 'machines' ? 'active' : '' }}">
            <a href="{{ URL::route('admin.machines.index') }}">Machines</a>
          </li>

          <li class="{{ substr(Request::path(), 6, 8) == 'activities' ? 'active' : '' }}">
            <a href="{{ URL::route('admin.activities.index') }}">Activity Log</a>
          </li>

          <li class="divider-vertical"></li>
          <li><a href="{{ URL::route('logout') }}">Logout</a></li>
        </ul>
      </div>
    </div>
    @endif

    @if(Session::get('success'))<div class="alert alert-success">{{ Session::get('success') }}</div>@endif
    @if(Session::get('error'))<div class="alert alert-danger">{{ Session::get('error') }}</div>@endif
    @if(Session::get('errors'))
      <div class="alert alert-danger">
        @foreach (Session::get('errors')->all() as $message)
          {{{ $message }}}<br>
        @endforeach
      </div>
    @endif

    @yield("content")

  </div>

</body>
</html>

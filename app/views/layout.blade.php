<!doctype html>
<html>
<head>
  <title>SFPD Awesome Admin Area</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{ HTML::style('css/bootstrap.css') }}
  {{ HTML::style('css/bootstrap-responsive.css') }}
  {{ HTML::style('css/admin.css') }}
</head>
<body>

  @if (Auth::check())
  <div class="navbar">
    <div class="navbar-inner">
      <a class="brand" href="{{ URL::route('admin.index') }}">SFPD</a>
      <ul class="nav">

        <li class="{{ substr(Request::path(), 6, 8) == 'players' ? 'active' : '' }}">
          <a href="{{ URL::route('admin.players.index') }}">Players</a>
        </li>

        <li class="{{ substr(Request::path(), 6, 8) == 'machines' ? 'active' : '' }}">
          <a href="{{ URL::route('admin.machines.index') }}">Machines</a>
        </li>

        <li class="divider-vertical"></li>
        <li><a href="{{ URL::route('logout') }}">Log out</a></li>
      </ul>
    </div>
  </div>
  @endif

  @if(Session::get('success'))<div class="alert alert-success">{{ Session::get('success') }}</div>@endif
  @if(Session::get('error'))<div class="alert alert-error">{{ Session::get('error') }}</div>@endif
  @if(Session::get('errors'))
    <div class="alert alert-error">
      @foreach (Session::get('errors')->all() as $message)
        {{{ $message }}}<br>
      @endforeach
    </div>
  @endif

  @yield("content")

</body>
</html>

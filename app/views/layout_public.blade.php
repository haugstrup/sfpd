<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      @if(trim($__env->yieldContent('title')))
        @yield("title") |
      @endif
      {{{$_ENV['LEAGUE'] == 'sfpd' ? 'San Francisco Pinball Department' : 'Belles and Chimes'}}}
    </title>
    <link rel="apple-touch-icon" href="/img/{{{$_ENV['LEAGUE']}}}-touch-icon.png">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <link rel="stylesheet" href="/css/main.css?g=pinbot">
  </head>
  <body>
    <div class="header navbar navbar-default navbar-static-top">
      <div class="navbar-inner">
        <a class="navbar-brand" href="/"><img src="/img/{{{$_ENV['LEAGUE']}}}-logo64.png" alt="{{{$_ENV['LEAGUE']}}}" width="32" height="32"></a>
        <ul class="nav navbar-nav">
          <li class="{{ substr(Request::path(), 0, 9) == 'standings' ? 'active' : '' }}">
            <a href="{{ URL::route('standings.index') }}">Standings</a>
          </li>
          <li class="{{ substr(Request::path(), 0, 7) == 'results' ? 'active' : '' }}">
            <a href="{{ URL::route('results.index') }}">Results</a>
          </li>
          <li class="{{ substr(Request::path(), 0, 5) == 'stats' ? 'active' : '' }}">
            <a href="{{ URL::route('statistics.index') }}">Stats</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="container">

      @yield("content")


      <hr>

      <div class="footer text-muted">
        <p><small><a href="{{URL::route('help')}}">View online help</a> • Comments or complaints? <a target="_blank" href="https://podio.com/webforms/8656053/642967">Get in touch</a>.</small></p>
      </div>

    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="/bootstrap.min.js"></script>
    @include('ga')

  </body>
</html>

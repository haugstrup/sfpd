<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>San Francisco Pinball Department</title>
    <link rel="apple-touch-icon" href="/img/touch-icon.png">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <link rel="stylesheet" href="/css/main.css?foo=bar">
  </head>
  <body>
    <div class="header navbar navbar-default navbar-static-top">
      <div class="navbar-inner">
        <a class="navbar-brand" href="/"><img src="/img/logo64.png" alt="SFPD" width="32" height="32"></a>
        <ul class="nav navbar-nav">
          <li class="{{ substr(Request::path(), 0, 9) == 'standings' ? 'active' : '' }}">
            <a href="{{ URL::route('standings.index') }}">Standings</a>
          </li>
          <li class="{{ substr(Request::path(), 0, 7) == 'results' ? 'active' : '' }}">
            <a href="{{ URL::route('results.index') }}">Results</a>
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

  </body>
</html>

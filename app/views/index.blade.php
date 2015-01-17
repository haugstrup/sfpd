<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{{$_ENV['LEAGUE'] == 'sfpd' ? 'San Francisco Pinball Department' : 'Belles and Chimes'}}}</title>
    <link rel="apple-touch-icon" href="/img/{{{$_ENV['LEAGUE']}}}-touch-icon.png">
    <link rel="shortcut icon" href="/{{{$_ENV['LEAGUE']}}}-favicon.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <link rel="stylesheet" href="/css/main.css?g=pinbot">
  </head>
  <body ng-app="sfpdApp">
    <div loading-indicator class="loading-indicator-wrapper-wrapper"></div>

    @if (!$embed)
    <div class="header navbar navbar-default navbar-static-top" ng-controller="HeaderCtrl">
      <div class="navbar-inner">
        <a class="navbar-brand" href="/"><img src="/img/{{{$_ENV['LEAGUE']}}}-logo64.png" alt="{{{$_ENV['LEAGUE']}}}" width="32" height="32"></a>
        <ul class="nav navbar-nav">
          <li><a href="/standings">Standings</a></li>
          <li><a href="/results">Results</a></li>
          <li><a href="/statistics">Stats</a></li>
        </ul>
      </div>
    </div>
    @endif

    <div class="container">

        <div ng-view=""></div>

        @if (!$embed)
        <hr>

        <div class="footer text-muted">
          <p><small><a href="{{URL::route('help')}}">View online help</a> • Comments or complaints? <a target="_blank" href="https://podio.com/webforms/8656053/642967">Get in touch</a>.</small></p>
        </div>
        @endif

    </div>

    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular.min.js"></script>
    <script src="/js/scripts.min.js"></script>
    @include('ga')

</body>
</html>

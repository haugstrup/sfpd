<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>San Francisco Pinball Department</title>
    <link rel="apple-touch-icon" href="/img/touch-icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ stylesheet('main.css') }}
  </head>
  <body ng-app="sfpdApp">

    <div class="container">

        <div class="header navbar navbar-default" ng-controller="HeaderCtrl">
          <div class="navbar-inner">
            <a class="navbar-brand" href="/"><img src="/img/logo64.png" alt="SFPD" width="32" height="32"></a>
            <ul class="nav navbar-nav">
              <li ng-class="{ active: isActive('/standings')}"><a ng-href="#/standings">Standings</a></li>
              <li  ng-class="{ active: isActive('/results')}"><a ng-href="#/results">Results</a></li>
            </ul>
          </div>
        </div>

        <div ng-view=""></div>

        <hr>

        <div class="footer text-muted">
          <p><small>Comments or complaints? <a target="_blank" href="https://podio.com/webforms/8656053/642967">Get in touch</a>.</small></p>
        </div>
    </div>

    {{ script('vendor/jquery.js') }}
    {{ script('vendor/angular.js') }}
    {{ script('vendor/angular-resource.js') }}
    {{ script('vendor/angular-sanitize.js') }}
    {{ script('vendor/angular-route.js') }}

    {{ script('app.js') }}

    {{ script('services/game.js') }}
    {{ script('services/group.js') }}
    {{ script('controllers/main.js') }}
    {{ script('controllers/game.js') }}
    {{ script('controllers/group.js') }}
    {{ script('controllers/heats_list.js') }}
    {{ script('controllers/standings.js') }}

</body>
</html>

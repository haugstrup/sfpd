<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>San Francisco Pinball Department</title>
    <meta name="viewport" content="width=device-width">
    {{ stylesheet('main.css') }}
  </head>
  <body ng-app="sfpdApp">

    <div class="container">

        <div class="header navbar navbar-default" ng-controller="HeaderCtrl">
          <div class="navbar-inner">
            <a class="navbar-brand" href="/"><img src="/img/logo.png" alt="SFPD" width="32" height="32"></a>
            <ul class="nav navbar-nav">
              <li ng-class="{ active: isActive('/')}"><a ng-href="#/">Home</a></li>
              <li ng-class="{ active: isActive('/standings')}"><a ng-href="#/standings">Standings</a></li>
              <li  ng-class="{ active: isActive('/results')}"><a ng-href="#/results">Results</a></li>
            </ul>
          </div>
        </div>

        <div ng-view=""></div>

        <hr>

        <div class="footer text-muted">
          <p><small>Comments or complaints? Get in touch with Andreas.</small></p>
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

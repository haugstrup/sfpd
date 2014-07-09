<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>San Francisco Pinball Department</title>
    <link rel="apple-touch-icon" href="/img/touch-icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <body ng-app="sfpdApp">

    <div class="container">

        <div class="header navbar navbar-default" ng-controller="HeaderCtrl">
          <div class="navbar-inner">
            <a class="navbar-brand" href="/"><img src="/img/logo64.png" alt="SFPD" width="32" height="32"></a>
            <ul class="nav navbar-nav">
              <li ng-class="{ active: isActive('/standings')}"><a ng-href="#/standings">Standings</a></li>
              <li ng-class="{ active: isActive('/results')}"><a ng-href="#/results">Results</a></li>
            </ul>
          </div>
          <div loading-indicator class="loading-indicator-wrapper"></div>
        </div>

        <div ng-view=""></div>

        <hr>

        <div class="footer text-muted">
          <p><small>Comments or complaints? <a target="_blank" href="https://podio.com/webforms/8656053/642967">Get in touch</a>.</small></p>
        </div>

    </div>

    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular.min.js"></script>
    <script src="/js/scripts.min.js"></script>

</body>
</html>

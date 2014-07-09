angular
  .module('sfpdApp', [
    'ngResource',
    'ngSanitize',
    'ngRoute',
    'groupService',
    'gameService'
  ])
  .config(function ($routeProvider, $httpProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'public/views/main.html',
        controller: 'MainCtrl'
      })
      .when('/standings', {
        templateUrl: 'public/views/standings.html',
        controller: 'StandingsCtrl',
        resolve: {
          response: function($http) {
            return $http.get('/api/seasons'); // Just for active season
          }
        }
      })
      .when('/results', {
        templateUrl: 'public/views/results.html',
        controller: 'HeatsListCtrl',
        resolve: {
          response: function($http) {
            return $http.get('/api/heats'); // Just for active season
          }
        }
      })
      .when('/group/:code', {
        templateUrl: 'public/views/group.html',
        controller: 'GroupCtrl',
        resolve: {
          group: function($route, Groups) {
            return Groups.get({code: $route.current.params.code});
          }
        }
      })
      .when('/game/:code', {
        templateUrl: 'public/views/game.html',
        controller: 'GameCtrl',
        resolve: {
          game: function($route, Games) {
            return Games.get({code: $route.current.params.code});
          }
        }
      })
      .otherwise({
        redirectTo: '/'
      });

    $httpProvider.interceptors.push(function($q, $rootScope) {
      var count = 0;
      return {
        'request': function(config) {
          if (config.url.indexOf('/api/') !== -1) {
            count++;
            $rootScope.$broadcast('loading-started');
          }
          return config || $q.when(config);
        },
        'response': function(response) {
          if (response.config.url.indexOf('/api/') !== -1) {
            count--;
            if (count <= 0) {
              $rootScope.$broadcast('loading-complete');
            }
          }
          return response || $q.when(response);
        }
      };
    });

  })
  .directive("loadingIndicator", function() {
    return {
      restrict : "A",
      template: "<div class='loading-indicator'><div class='bar-1'></div><div class='bar-2'></div><div class='bar-3'></div><div class='bar-4'></div><div class='bar-5'></div><div class='bar-6'></div><div class='bar-7'></div><div class='bar-8'></div></div>",
      link : function(scope, element, attrs) {
        scope.$on("loading-started", function(e) {
          element.css({"display" : ""});
        });

        scope.$on("loading-complete", function(e) {
          element.css({"display" : "none"});
        });
      }
    };
  });

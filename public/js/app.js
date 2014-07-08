angular
  .module('sfpdApp', [
    'ngResource',
    'ngSanitize',
    'ngRoute',
    'groupService',
    'gameService'
  ])
  .config(function ($routeProvider) {
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
  });

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
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/group/:code', {
        templateUrl: 'views/group.html',
        controller: 'GroupCtrl',
        resolve: {
          group: function($route, Groups) {
            return Groups.get({code: $route.current.params.code});
          }
        }
      })
      .when('/game/:game_id', {
        templateUrl: 'views/game.html',
        controller: 'GameCtrl',
        resolve: {
          game: function($route, Games) {
            return Games.get({game_id: $route.current.params.game_id});
          }
        }
      })
      .otherwise({
        redirectTo: '/'
      });
  });

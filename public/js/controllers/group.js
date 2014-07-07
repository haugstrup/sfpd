'use strict';

angular.module('sfpdApp')
  .controller('GroupCtrl', function ($scope, $location, group, $http) {
    $scope.group = group;
    $scope.group.newPlayer = null;
    $scope.buttonDisabled = false;

    $scope.addPlayer = function() {
      if ($scope.group.newPlayer && $scope.group.players.indexOf($scope.group.newPlayer) === -1) {
        $scope.group.players.push($scope.group.newPlayer);

        $scope.group.$update();
      }
      $scope.group.newPlayer = null;
    };

    $scope.removePlayer = function(player) {
      var index = $scope.group.players.indexOf(player);
      if (index !== -1) {
        $scope.group.players.splice(index, 1);
        $scope.group.$update();
      }
    };

    $scope.roomForPlayers = function() {
      if (!$scope.group.players) {
        return true;
      }
      return $scope.group.players.length < 4;
    };

    $scope.startGame = function() {
      $scope.buttonDisabled = true;

      var url = '/api/groups/'+$scope.group.code+'/games';
      $http.post(url, {
        machine: $scope.group.nextMachine,
        player: $scope.group.nextPlayerPick,
        status: 'active'
      }).success(function(group){
        $scope.group.games = group.games;

        angular.forEach(group.games, function(game) {
          if (game.status === 'active') {
            $location.path('/game/'+game.code);
            return;
          }
        });

      });

    };

  });

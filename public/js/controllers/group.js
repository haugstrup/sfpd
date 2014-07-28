angular.module('sfpdApp')
  .controller('GroupCtrl', function ($scope, $location, group, $http, $filter) {
    $scope.group = group;
    $scope.group.newPlayer = null;
    $scope.buttonDisabledState = false;

    $scope.buttonDisabled = function() {
      return $scope.buttonDisabledState || !$scope.group.nextMachine;
    };

    $scope.availableMachines = function() {
      return $scope.group.machines;
      // var machinesPlayed = $scope.group.games.map(function(game) {
      //   return game.machine.machine_id;
      // });

      // return $filter('filter')($scope.group.machines, function(machine) {
      //   return machinesPlayed.indexOf(machine.machine_id) === -1;
      // });
    };

    $scope.pointsForPlayer = function(pointsList, playerId) {
      var points = $filter('filter')(pointsList, {player_id: playerId}, true)[0];
      return points ? points.points : "0";
    };

    $scope.gamePicked = function(player) {
      var games = $filter('filter')($scope.group.games, {player_id: player.player_id}, true);
      var names = games.map(function(game) {
        return game.machine.name;
      });

      return names.length ? " picked "+names.join(', ') : '';
    };

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

    $scope.nextPlayer = function() {
      if (!$scope.group.players) {
        return null;
      }

      if ($scope.group.games.length >= 4) {
        return null;
      }

      // 3 player group, last game. Worst player picks
      if ($scope.group.games.length === 3 && $scope.group.players.length === 3) {

        var worstPlayer = null;

        angular.forEach($scope.group.players, function(player) {
          var currentPoints = $scope.pointsForPlayer($scope.group.points, player.player_id);
          if (!worstPlayer || worstPlayer.totalPoints > currentPoints) {
            worstPlayer = player;
            worstPlayer.totalPoints = currentPoints;
          }
        });

        return worstPlayer;
      }

      // Normal play. Just pick the next player who hasn't picked a game yet
      var playersWhoHavePicked = $scope.group.games.map(function(game) {
        return game.player.player_id;
      });

      var availablePlayers = $filter('filter')($scope.group.players, function(player) {
        return playersWhoHavePicked.indexOf(player.player_id) === -1;
      });

      return availablePlayers[0];
    };

    $scope.startGame = function() {
      $scope.buttonDisabledState = true;

      var url = '/api/groups/'+$scope.group.code+'/games';
      $http.post(url, {
        machine: $scope.group.nextMachine,
        player: $scope.nextPlayer(),
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

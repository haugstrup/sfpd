angular.module('sfpdApp')
  .controller('PlayerCtrl', function ($scope, $filter, response) {
    $scope.player = response.data.player;
    $scope.seasons = response.data.seasons;
    $scope.group = response.data.group;
    $scope.machines = response.data.machines;

    $scope.pointsForPlayer = function(pointsList, playerId) {
      var points = $filter('filter')(pointsList, {player_id: playerId}, true)[0];
      return points ? points.points : "0";
    };

    $scope.highlightRow = function(player) {
      return player.player_id === $scope.player.player_id ? 'info' : '';
    };

  });

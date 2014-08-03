angular.module('sfpdApp')
  .controller('StandingsCtrl', function ($scope, $filter, $sanitize, response) {
    $scope.season = response.data;

    $scope.pointsForPlayerForHeat = function(pointsList, playerId) {
      var points = $filter('filter')(pointsList, {player_id: playerId}, true)[0];

      return points ? points.points : "0";
    };

    $scope.nameForPlayer = function(playerId) {
      var player = $filter('filter')($scope.season.players, {player_id: playerId}, true)[0];
      return $sanitize(player.display_name) + ' ' + player.icon;
    };

  });

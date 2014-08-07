angular.module('sfpdApp')
  .controller('StandingsCtrl', function ($scope, $filter, $sanitize, response) {
    $scope.season = response.data;
    $scope.firstRookie = false;
    $scope.position = 1;
    $scope.positionPoints = null;

    $scope.pointsForPlayerForHeat = function(pointsList, playerId) {
      var points = $filter('filter')(pointsList, {player_id: playerId}, true)[0];

      return points ? points.points : "0";
    };

    $scope.isFirstRookie = function(playerId) {
      if ($scope.firstRookie === playerId) {
        return 'first-rookie';
      } else if (!$scope.firstRookie) {
        var player = $filter('filter')($scope.season.players, {player_id: playerId}, true)[0];
        if (player.rookie) {
          $scope.firstRookie = playerId;
          return 'first-rookie';
        }
      }
      return 'not-first-rookie';
    };

    $scope.nameForPlayer = function(playerId) {
      var player = $filter('filter')($scope.season.players, {player_id: playerId}, true)[0];
      return $sanitize(player.display_name) + ' ' + player.icon;
    };

    $scope.getPosition = function(index, points) {
      index = index+1;
      console.log('testing', $scope.positionPoints, points);
      if ($scope.positionPoints === points) {
        return ' ';
      } else {
        $scope.position = index;
        $scope.positionPoints = points;
        return index;
      }
    };

  });

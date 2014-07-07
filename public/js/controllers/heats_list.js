angular.module('sfpdApp')
  .controller('HeatsListCtrl', function ($scope, $filter, response) {
    $scope.heats = response.data.heats;
    $scope.season = response.data.season;

    $scope.hasGamesFilter = function(group) {
      return group.games.length > 0;
    };

    $scope.pointsForPlayer = function(pointsList, playerId) {
      var points = $filter('filter')(pointsList, {player_id: playerId}, true)[0];
      return points ? points.points : "0";
    };

  });

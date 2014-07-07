angular.module('sfpdApp')
  .controller('StandingsCtrl', function ($scope, $filter, response) {
    $scope.season = response.data;

    $scope.pointsForPlayerForHeat = function(pointsList, playerId) {
      var points = $filter('filter')(pointsList, {player_id: playerId}, true)[0];

      return points ? points.points : "0";
    };

  });

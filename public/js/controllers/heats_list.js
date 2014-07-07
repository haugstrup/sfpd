angular.module('sfpdApp')
  .controller('HeatsListCtrl', function ($scope, response) {
    $scope.heats = response.data.heats;
    $scope.season = response.data.season;

    $scope.hasGamesFilter = function(group) {
      return group.games.length > 0;
    };

  });

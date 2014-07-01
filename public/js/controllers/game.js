'use strict';

angular.module('sfpdApp')
  .controller('GameCtrl', function ($scope, $location, game) {
    $scope.game = game;

    $scope.positions = [
      {id: 1, title: '1st'},
      {id: 2, title: '2nd'},
      {id: 3, title: '3rd'},
      {id: 4, title: '4th'},
      {id: 0, title: 'D.Q.'}
    ];

    $scope.storeResults = function() {

      // Make sure that each position is only used once
      var usedPositions = [];
      var resultsValid = true;
      angular.forEach($scope.game.results, function(result) {
        if (result.position === null || (result.position > 0 && usedPositions.indexOf(result.position) !== -1)) {
          resultsValid = false;
          return;
        } else {
          usedPositions.push(result.position);
        }
      });

      if (!resultsValid) {
        return;
      }

      // Mark game as completed and submit to API
      $scope.buttonDisabled = true;
      $scope.game.status = 'completed';
      $scope.game.$update(function() {
        $location.path('/group/'+game.group.code);
      });

    };

  });

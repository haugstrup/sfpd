angular.module('sfpdApp')
  .controller('GameCtrl', function ($scope, $location, game) {
    $scope.game = game;
    $scope.removeButtonDisabled = false;
    $scope.saveButtonDisabledState = false;

    $scope.positions = [
      {id: 1, title: '1st'},
      {id: 2, title: '2nd'},
      {id: 3, title: '3rd'},
      {id: 4, title: '4th'},
      {id: 0, title: 'Disqualified'},
      {id: -1, title: 'Tardy player'}
    ];

    $scope.canDelete = function() {
      var canDelete = true;

      angular.forEach($scope.game.results, function(result) {
        if (result.position !== null) {
          canDelete = false;
        }
      });

      return canDelete;
    };

    $scope.removeGame = function() {
      var groupUrl = '/group/'+$scope.game.group.code;
      $scope.removeButtonDisabled = true;
      $scope.game.$delete(function() {
        $location.path(groupUrl);
      });
    };

    $scope.saveButtonDisabled = function() {
      return $scope.saveButtonDisabledState || !$scope.resultsValid();
    };

    $scope.resultsValid = function() {
      // Make sure that each position is only used once
      var usedPositions = [];
      var resultsValid = true;
      var allNull = true;
      angular.forEach($scope.game.results, function(result) {

        if (allNull && result.position !== null) {
          allNull = false;
        }

        if (result.position === null || (result.position > 0 && usedPositions.indexOf(result.position) !== -1)) {
          resultsValid = false;
          return;
        } else {
          usedPositions.push(result.position);
        }
      });

      if (allNull) {
        resultsValid = true;
      }

      return resultsValid;
    };

    $scope.storeResults = function() {

      if (!$scope.resultsValid()) {
        return;
      }

      // Mark game as completed and submit to API
      $scope.saveButtonDisabledState = true;
      $scope.game.status = 'completed';
      $scope.game.$update(function() {
        $location.path('/group/'+game.group.code);
      });

    };

  });

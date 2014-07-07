'use strict';

angular.module('sfpdApp')
  .controller('MainCtrl', function ($scope, $location) {

    $scope.goToGroup = function() {
      $location.path('/group/'+$scope.code);
    };

  })
  .controller('HeaderCtrl', function ($scope, $location) {
    $scope.isActive = function (viewLocation) {
      return viewLocation === $location.path();
    };
  });

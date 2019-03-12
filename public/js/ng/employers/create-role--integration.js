/**
 * Created by domina on 11/14/2017.
 */

(function() {
  'use strict';
  var app = angular.module('app');
  var base_url = $('body').data('base_url');

  app.controller('CreateRoleIntegration', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile',
    function (GlobalConstant, $scope, $window, $http, $cookies, $filter, $timeout, $compile) {
      //alert("hi")
      $scope.role_create_tab_loader = 1;

      $timeout(function (){
		$scope.role_create_tab_loader = 0;
      }, 500);
    }]);
}());
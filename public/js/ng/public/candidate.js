(function () {  
    'use strict';
        var app = angular.module('app');
        var base_url = $('body').data('base_url');
        var slug_id = $('#slug-id').val();

        
        app.controller('PublicCandidateController', ['GlobalConstant','$scope','$window','$http', '$cookies', function(GlobalConstant, $scope, $window, $http, $cookies) {
            
            var token       = $cookies.get('token');
            var UserType    = $cookies.get('ut');
            var token       = $cookies.get('token');

            //Check if logged in and if employer
            if (token != null && UserType == 'employer') {
                
                $scope.LoadCandidateData = function ( uri ) {
                    if (uri != 'error') {
                        $scope.uricheck = true;

                        $scope.preview_img = true;
                        $scope.GetCandidateData = [];
                        $http.get(GlobalConstant.APIRoot  +'candidate/public/profile/'+uri )
                            .then(function(response) {
                                 
                                 $scope.GetCandidateData = response.data.data
                                   //console.log($scope.GetCandidateData)     
                            },
                            function (response) {
                                // body...
                       });

                     

                    }else{
                        $scope.uricheck = false;
                    }
                
                }
                
            }else{
                //SET 403 ERROR
            }

        }]);



}());




    
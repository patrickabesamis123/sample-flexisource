(function () {

    'use strict';
    var app = angular.module('app');

    app.controller('BlogPostDetailsController', ['$scope', '$window', '$http', '$cookies',
        ($scope, $window, $http, $cookies) => {

            var slugName = window.location.pathname.split('/').filter(el => {
                return !!el;
            }).pop();

            $scope.getDetails = () => {
                $http.get(window.location.origin + '/api/blog-post/' + slugName)
                    .then(response => {
                        if (response.status === 200) {
                            $scope.posts = response.data;
                            $scope.post_created = new Date(response.data.Created);
                        }
                    });
            }

        }
    ]);

}());

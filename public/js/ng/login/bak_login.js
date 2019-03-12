(function() {
    'use strict';
    var app = angular.module('app');
    var base_url = $('body').data('base_url');
    app.controller('LoginController', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$filter', '$location',
        function(GlobalConstant, $scope, $window, $http, $cookies, $filter, $location   ) {
            $scope.preload = true;
            $scope.validme = 1;
            var getRedirect = $cookies.get('redirectBack');

             var withHashLocation = function(location) {
                    if (window.location.hash) {
                        var hash = window.location.hash.substring(1);
                        hash = hash.replace(/^\/|\/$/g, '');
                        $window.location.href = hash;
                    } else {
                        $window.location.href = location;
                    }
                }


            //Check if user is logged in
            if (angular.isUndefined($cookies.get('token')) == false) {
                 

                if ( $location.absUrl() == base_url+'login' ) {
                	 //Check user type to determine redirect
	                $http.get(GlobalConstant.CheckUserType + $cookies.get('token')).then(function(response) {
	                    var userType = response.data.data;
	                    if (userType == 'candidate') {
	                        //Redirect to candidte dashboard
	                        $window.location.href =  GlobalConstant.CandidateDashboard ;				    		
	                    } else if (userType == 'employer') {
	                        console.log('empaaa');
	                        //Redirect to employer dashboard
	                        $window.location.href =  GlobalConstant.EmployerDashboard ;
	                    }
	                });
                } 

            } else {
                //Not Logged In
                $scope.login = function() {
                	 
                    $scope.loginDataTemp = {
                        client_id: GlobalConstant.cid,
                        client_secret: GlobalConstant.cse,
                        grant_type: GlobalConstant.grantType,
                        username: $scope.email,
                        password: $scope.pass
                    };
                    $scope.preload = false;
                    $http({
                        method: 'GET',
                        params: $scope.loginDataTemp,
                        url: GlobalConstant.apiUrl
                    }).then(function(response) {
                        // console.log(response.data);alert();
                        var token = response.data.access_token;
                        var expire = parseInt(response.data.expires_in);
                        var refresh_token = response.data.refresh_token;
                        console.log(response.data);
                        var email = $scope.email;
                        if (response.status === 200) {
                            var SetDateforLogin = new Date();
                            var LoginTime = parseInt(SetDateforLogin.getTime() / 1000);
                            var ExpireTime = parseInt(SetDateforLogin.getTime() / 1000) + expire;
                            var ExpireTimetoDate = new Date(ExpireTime * 1000);
                            //Store all data needed to cookies
                            $cookies.put('token', token, {
                                'path': '/'
                            });
                            $cookies.put('LoginTime', LoginTime, {
                                'path': '/'
                            });
                            // $cookies.put('IdleTime', ExpireTime, {'path':'/' } );
                            $cookies.put('exp', expire, {
                                'path': '/'
                            });
                            //need for refresher   
                            $cookies.put('email', email, {'path':'/' } ); 
                            //get ob_key for candidate
                            $scope.params = {
                                access_token: $cookies.get('token')
                            };
                            
                           
                            $http.get(GlobalConstant.CheckUserType + $cookies.get('token')).then(function(response) {
                                var userType = response.data.data;
                                           
                                if (userType == 'candidate') {

                                    //Store user type cookie
                                    $cookies.put('ut', userType, {
                                        'path': '/'
                                    });

                                    $.ajax({
                                        url: GlobalConstant.tokenstorage,
                                        type: 'post',
                                        data: {
                                            token_refresh: refresh_token,
                                            token_access: token,
                                            username: $scope.email
                                        },
                                        success: function(token_id) {
                                            
                                            $cookies.put('token_id', token_id, {
                                                'path': '/'
                                            });
                                            $http({
                                                method: 'GET',
                                                params: $scope.params,
                                                url: GlobalConstant.profileApi
                                            }).then(function(response) {
                                                console.log('response')
                                                console.log(response)
                                                $cookies.put('obkey', response.data.data.ob_key, {
                                                    'path': '/'
                                                });

                                                 withHashLocation(GlobalConstant.CandidateDashboard);
                                            });
                                        }
                                    }).done(function() {
                                        $scope.preload = true;
                                        console.log('cand');
                                         
                                          
                                        
                                    });
                                } else if (userType == 'employer') {
                                    //Store user type cookie
                                    $cookies.put('ut', userType, {
                                        'path': '/'
                                    });
                                    
                                    $.ajax({
                                        url: GlobalConstant.tokenstorage,
                                        type: 'post',
                                        data: {
                                            token_refresh: refresh_token,
                                            token_access: token,
                                            username: $scope.email
                                        },
                                        success: function(token_id) {
                                            $cookies.put('token_id', token_id, {
                                                'path': '/'
                                            });
                                        }
                                    }).done(function() {
                                        $scope.preload = true;
                                        withHashLocation();
                                       
                                          withHashLocation(GlobalConstant.EmployerDashboard);
                                         
                                    });
                                }
                            });
                        }
                    }, function(response) {
                        //Error Condition
                        console.log(response.status);
                        $scope.preload = true;
                        $scope.ErrorMsg = response.data.error_description;
                        //$scope.ErrorMsgs = response.data.errors;
                    });
                };
            }

            $scope.goToRegister = function () {
            	 var current_location = window.location
            	 $window.location.href =  base_url +'register#'+$location.url() ;
            }

            $scope.gohome = function(){
                window.location = base_url;
            }
        }
    ]);
}());
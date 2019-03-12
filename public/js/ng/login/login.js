(function() {
    'use strict';
    var app = angular.module('app');
    var base_url = $('body').data('base_url');


 

    app.controller('LoginController', ['GlobalConstant', 'OAuth',  'OAuthToken', '$scope', '$window', '$http', '$cookies', '$filter',   '$location',
        function(GlobalConstant, OAuth, OAuthToken, $scope, $window, $http, $cookies, $filter, $location    ) {
            $scope.preload = true;
            $scope.validme = 1;
             
             // var withHashLocation = function(location, userType) {
             //        if (window.location.hash) {
             //            var hash = window.location.hash.substring(1);
             //            hash = hash.replace(/^\/|\/$/g, '');
             //            if(hash.indexOf('thread/') != -1 || hash.indexOf('external/') != -1 || hash.indexOf('internal/') != -1){
             //                if(userType == 'candidate'){
             //                    hash = 'messages/#/' + hash;
             //                    $window.location.href = hash;
             //                }else{
             //                     $window.location.href = $location.absUrl();
             //                     $window.location.reload();
             //                } 
             //            }else{
             //                $window.location.href = hash;
             //            }
             //        } else {
             //            $window.location.href = location;
             //        }
             //    }
             var withHashLocation = function(location, userType) {
                    var getRedirect = $cookies.get('redirectBack');
                   
                    if (window.location.hash) {
                        var hash = window.location.hash.substring(1);
                        hash = hash.replace(/^\/|\/$/g, '');

                         
                         if ( angular.isDefined(getRedirect) ) {
                             
                        
                            $window.location.reload();
                            $cookies.remove('redirectBack');
                             
                             
                         }else{
                            
                              
                            if(hash.indexOf('thread/') != -1 || hash.indexOf('external/') != -1 || hash.indexOf('internal/') != -1){
                                if(userType == 'candidate'){
                                    hash = 'messages/#/' + hash;
                                    $window.location.href = hash;
                                }else{
                                     $window.location.href = $location.absUrl();
                                     $window.location.reload();
                                } 
                            }else{
                                $window.location.href = hash;
                            }
                        }
                       
                             
                         

                    } else {
                        $window.location.href = location;
                    }
                }
            //console.log( OAuth.isAuthenticated() )

            //Check if user is logged in
            if (OAuth.isAuthenticated()) {
                 

                if ( $location.absUrl() == base_url+'login' ) {

                   //console.log($location.absUrl())
                    //console.log(   OAuth );
                     
                     
                    // Check user type to determine redirect
                    $http.get(GlobalConstant.APIRoot+'user-type-check' ).then(function(response) {
                        var userType = response.data.data;
                        //console.log('logged in')
                        //console.log(userType)
                        //return false
                        if (userType == 'candidate') {
                            //Redirect to candidte dashboard
                            $window.location.href = GlobalConstant.CandidateDashboard ;                            
                        } else if (userType == 'employer') {
                            //console.log('empaaa');
                            //Redirect to employer dashboard
                            $window.location.href = GlobalConstant.EmployerDashboard ;
                        }
                    });
                } 

            }  

            //Not Logged In
            $scope.login = function() {


                //Test Auth function
                $scope.preload = false;
                $scope.data = {
                    username: $scope.email,
                    password: $scope.pass
                }
                

                var login = OAuth.getAccessToken($scope.data, {method:'GET'} ) 
                login.then(function (result) {



                   
                    $scope.preload = true;

                    $scope.access_token = result.data;
                    //console.log($scope.access_token.access_token)

                    //Check user type
                    $http.get(GlobalConstant.APIRoot+'user-type-check')
                    .then(function(response) {

                            
                            var userType = response.data.data;
                            //console.log(userType)  
                            //return false

                            OAuthToken.setToken( $scope.access_token )
                            var token_data = OAuthToken.getToken();

                            $cookies.put('token', token_data.access_token, {
                                'path': '/'
                            });
                            // $cookies.put('IdleTime', ExpireTime, {'path':'/' } );
                          
                            //need for refresher   
                            $cookies.put('email',  $scope.email, {'path':'/' } );
                          
                             
                            // return false

                            //For Old Login data
                            var expire =  parseInt (  token_data.expires_in );
                            // var expire = parseInt ( OAuthToken.getToken().expires_in )  - 3500;
                            var SetDateforLogin = new Date();
                            var LoginTime = parseInt(SetDateforLogin.getTime() / 1000);
                            var ExpireTime = parseInt(SetDateforLogin.getTime() / 1000) + expire;
                            var ExpireTimetoDate = new Date(ExpireTime * 1000);
                            //Store all data needed to cookies

                            $cookies.put('LoginTime', LoginTime, {
                                'path': '/'
                            });
                            $cookies.put('exp', expire, {
                                'path': '/'
                            });
                            
                               

                            //return false

                            if (userType == 'candidate') {

                                //Store user type cookie
                                $cookies.put('ut', userType, {
                                    'path': '/'
                                });

                                //console.log( token_data.refresh_token )
                                //console.log( token_data.access_token )
                                //Store token to database
                                $.ajax({
                                    url: GlobalConstant.tokenstorage,
                                    type: 'post',
                                    data: {
                                        token_refresh: token_data.refresh_token,
                                        token_access: token_data.access_token,
                                        username: $scope.email
                                    },
                                    success: function(token_id) {
                                        
                                        $cookies.put('token_id', token_id, {
                                            'path': '/'
                                        });
                                        
                                        $http.get( GlobalConstant.profileApi ).then(function(response) {
                                            //console.log('response')
                                            //console.log(response)
                                            $cookies.put('obkey', response.data.data.ob_key, {
                                                'path': '/'
                                            });

                                             withHashLocation(GlobalConstant.CandidateDashboard, userType);
                                        });
                                    }
                                }).done(function() {
                                    $scope.preload = true;
                                    //console.log('cand');
                                     
                                      
                                    
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
                                        token_refresh: token_data.refresh_token,
                                        token_access: token_data.access_token,
                                        username: $scope.email
                                    },
                                    success: function(token_id) {
                                        $cookies.put('token_id', token_id, {
                                            'path': '/'
                                        });
                                    }
                                }).done(function() {
                                    $scope.preload = true;
                                     
                                      withHashLocation(GlobalConstant.EmployerDashboard, userType);
                                     
                                });
                            }



                    },function (response){
                        //console.log(response.status);
                        $scope.preload = true;
                        $scope.ErrorMsg = response.data.error_description;
                    });
                    


                }, function(response) {
                    //Error Condition
                    //console.log(response.status);
                    $scope.preload = true;
                    $scope.ErrorMsg = response.data.error_description;
                    })
                return false;


            };

            $scope.goToRegister = function () {
                 var current_location = window.location
                 $window.location.href =  base_url +'register#'+$location.url() ;
            }

            $scope.gohome = function(){

                if (OAuth.isAuthenticated()) {

                    var currentLocation = String(window.location);
                    //check if in admin area of candidate or employer
                    if( currentLocation.search('/employer/') == -1 || currentLocation.search('/candidate/') == -1  ){
                        //$window.location.href = $location.absUrl();
                        //$window.location.reload();
                        $('#Loginmodal').modal('hide');
                    }else{
                        $window.location.href = base_url;
                    }  
                }else{
                    $window.location.href = base_url;
                }
            }
            $scope.gohomeforbidden = function(){
                $window.location.href = base_url;
            } 
        }
    ]);
}());
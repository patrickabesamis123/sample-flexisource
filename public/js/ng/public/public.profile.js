(function() {
    'use strict';
    var app = angular.module('app');
    var base_url = $('body').data('base_url');
    var slug_id = $('#slug-id').val();

     app.config(['$locationProvider',function($locationProvider) {
        $locationProvider.html5Mode(true);

    }]);

  
    app.controller('PublicProfileController', ['GlobalConstant', '$scope', '$window', '$http','CandidateSettingsSvcs','EmployerSvcs', '$cookies', '$location', function(GlobalConstant, $scope, $window, $http,CandidateSettingsSvcs,EmployerSvcs, $cookies, $location) {

        var token = $cookies.get('token');
        var UserType = $cookies.get('ut');
        $scope.watchlistText = 'WATCHLIST';
        $scope.sortDate = function(item) {
            var date = new Date(item.date_x);
            return date;
        };
        $scope.profile = [];
        $scope.company_name = "";
        $scope.ut = UserType;
        $scope.showLoader = true;
        $scope.requestPage = false;
        $scope.registerPage = false;
        $scope.publicRegisterPage = false;
        $scope.publicRequestPage = false;
        $scope.blackListed = false;

        $scope.thisUserUrl = "";


        $scope.initIcebreakerVid = function(vidData) {
            $scope.preview_img = false;
            if ($('#vid1').length) {
                var myPlayer = amp('vid1', {
                    "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                    "nativeControlsForTouch": false,
                    autoplay: false,
                    controls: true,
                    width: "275",
                    logo: {
                        "enabled": false
                    },
                    poster: ""
                }, function() {
                    // open camera modal
                    this.addEventListener('click', function(elm) {
                            if (!$(elm.target).hasClass('vjs-control') && !$(elm.target).hasClass('vjs-big-play-button')) {
                                // $scope.open_camera();
                                $scope.open_camera_new();
                            }
                        })
                        // add an event listener
                    this.addEventListener('ended', function() {

                    });
                });
                if (vidData) {
                    if(vidData.doc_url) {
                        myPlayer.src([{
                        src: vidData.doc_url,
                        type: "application/vnd.ms-sstr+xml"
                        }]);
                    }else{

                    $scope.preview_img = 'loading';

                    }
                } else {
                    $scope.preview_img = true;
                }
            }
        }
        $scope.watchThis = function() {
            $http.post( GlobalConstant.APIRoot + 'employer/candidate/watchlist/' + slug_id )
            .then(function(response) {
              $scope.watchlist = response.data.data.watchlist;
              if($scope.watchlist){
                   $scope.watchlistText = 'WATCHING';
              }else{
                   $scope.watchlistText = 'WATCHLIST';
              }
           });
       };
       $scope.goToLink = function(e) {
            var elem = $(e.currentTarget);
            window.location.href = elem.attr('data-url');
        };
        $scope.requestWhiteliest = function() {
            CandidateSettingsSvcs.postWhiteListRequest().then(function(res){
                if(res.data.success === true) {
                    alert('Request access sent.');
                }
            },
            function(err){
                if(err.data.code === 500) {
                    alert(err.data.message);
                    if(err.data.message == 'Company is already whitelisted'){
                        window.location.href = window.location.href;
                    }
                } else if(err.data.code === 400) {
                    alert(err.data.message);
                } else {
                    alert("Unable to send request, please try again later.");
                }
            });
        };
        $scope.checkNull = function() {
            if($scope.profile.privacy.first_name == false || $scope.profile.privacy.last_name == false || $scope.profile.privacy.location == false ||$scope.profile.privacy.contact_number == false
                || $scope.profile.privacy.email == "" || $scope.profile.privacy.sub_industry == false || $scope.profile.privacy.about_me == false || $scope.profile.privacy.profile_photo == false || $scope.profile.privacy.generic_video == false
                || $scope.profile.privacy.experience == false || $scope.profile.privacy.education == false || $scope.profile.privacy.references == false || $scope.profile.privacy.resume == false || $scope.profile.privacy.supporting_docs == false){
                    return true;
            } else {
                    return false;
            }
        };
        $scope.addMetaTags = function() {
            var pageTitle = $('title');
            
            var image;
            var name = "";
            if(!$scope.profile.first_name) {
                name += ""
            } else {
                name += $scope.profile.first_name;
            }
            if(!$scope.profile.last_name) {
                name += "";
            } else {
                name += " "+$scope.profile.last_name;
            }
            if(!$scope.profile.first_name && !$scope.profile.last_name) {
                name = "Me"
            }
            pageTitle.text(name+" | PreviewMe");

            if($scope.profile.docs.profile_image) {
                image = $scope.profile.docs.profile_image;
            }else {
                image = "https://dev.previewmedev.co/themes/bbt/images/defaultPhoto.png";
            }
            var tags = '<meta name="description" content="'+$scope.profile.industry.data.industry.display_name+': '+$scope.profile.long_description+'"/>'+
                        '<link rel="canonical" href="'+base_url+'me/'+slug_id+'" />'+
                        ' <meta property="og:locale" content="en_US" />'+
                        '<meta property="og:type" content="article" />'+
                        '<meta property="og:title" content="'+name+' | PreviewMe" />'+
                        '<meta property="og:description" content="'+$scope.profile.industry.data.industry.display_name+': '+$scope.profile.long_description+'" />'+
                        '<meta property="og:url" content="'+base_url+'me/'+slug_id+'" />'+
                        '<meta property="og:site_name" content="PreviewMe" />'+
                        '<meta property="article:publisher" content="'+name+' | PreviewMe" />'+
                        '<meta property="og:image" content="'+image+'" />'+
                        '<meta property="og:image:secure_url" content="'+base_url+'me/'+slug_id+'" />'+
                        '<meta name="twitter:card" content="summary" />'+
                        '<meta name="twitter:description" content="'+$scope.profile.industry.data.industry.display_name+': '+$scope.profile.long_description+'" />'+
                        '<meta name="twitter:title" content="'+name+' | PreviewMe" />'+
                        '<meta name="twitter:site" content="@previewme" />'+
                        '<meta name="twitter:image" content="'+$scope.profile.industry.data.industry.display_name+': '+$scope.profile.long_description+'" />'+
                        '<meta name="twitter:creator" content="@previewme" />';
            $(tags).insertAfter(pageTitle);

        };
        $scope.callGetProfile = function(tokenKey) {
            CandidateSettingsSvcs.getProfile(tokenKey).then(function(res){
                if(res.data.success === true) {
                    $scope.profile = res.data.data;
                    if($scope.profile.docs.icebreaker_video) {
                        $scope.initIcebreakerVid($scope.profile.docs.icebreaker_video);
                    };
                  if($scope.profile.privacy.type == 'public') {
                    $scope.showLoader = false;
                    if($scope.profile.privacy.seo_enabled == true) {
                        $scope.addMetaTags();
                    } else {
                        var htmlHead = $('head');
                        htmlHead.append('<meta name="robots" content="noindex">');
                        htmlHead.append('<meta name="googlebot" content="noindex">');
                    }
                    if(UserType == 'employer') {
                        if($scope.checkNull()) {
                                $scope.publicRequestPage = true;

                        }else {
                            $scope.publicRequestPage = false;
                        }
                    } else if(UserType == 'candidate') {
                        if($scope.checkNull()) {
                            CandidateSettingsSvcs.getMyProfile(tokenKey).then(function(res){
                                if(res.data.data.profile_url !== slug_id) {
                                    $scope.showLoader = false;
                                    $scope.publicRegisterPage = true;
                                } else {
                                    $scope.showLoader = false;
                                    $scope.publicRegisterPage = false;
                                }
                            });
                        }
                    } else {
                        $scope.showLoader = false;
                        if($scope.checkNull() == true) {
                            $scope.publicRegisterPage = true;
                        } else {
                            $scope.publicRegisterPage = false;
                        }
                    }
                  } else {
                    $scope.showLoader = false;
                  }
                }; 
            },
            function(err) {
                if(tokenKey) {
                    if(err) {
                        if(UserType == 'candidate') {
                            console.log('err',err.statusText)
                            if(err.data.message == "Sorry you don't have permission to view this profile") {
                                $scope.showLoader = false;
                                $scope.registerPage = true;  
                            }
                        }else {
                            if(!err.data.message) {
                                $scope.showLoader = false;
                                alert('Something went wrong while fetching your data.');
                            }
                            if(err.data.message == 'You need to request permission to access this profile') {
                                $scope.requestPage = true;
                                $scope.showLoader = false;
                            } else if(err.data.message == 'Access Denied'){
                                EmployerSvcs.getEmployerProfile().then(function(res){
                                    $scope.company_name = res.data.data.company.company_name;
                                    $scope.showLoader = false;
                                    $scope.blackListed = true;
                                });
                            }else {
                                alert('Something went wrong while fetching your data.');
                            }
                        }
                    }else {
                        $scope.showLoader = false;
                         alert('Something went wrong while fetching your data.');
                    }
                }else  {
                    // window.location = base_url + '404';
                    $scope.showLoader = false;
                    $scope.registerPage = true;
                }
            });
        };
        $scope.initWatchList = function() {
            CandidateSettingsSvcs.getWatchList().then(function(res){
                if(res){
                    $scope.watchlistText = 'WATCHING';  
                } else {
                    $scope.watchlistText = 'WATCHLIST';
                }
            });
        }
        $scope.initPublicProfile = function() {
            if(UserType == 'employer' || UserType == 'candidate') {
               $scope.callGetProfile(token);
               if(UserType == 'employer') {
                    $scope.initWatchList();
               }
            } 
            else {
                $scope.callGetProfile('');
            }
        }
        $scope.initPublicProfile();
    }]);
    app.factory('CandidateSettingsSvcs', ['GlobalConstant', '$http','$cookies', function (GlobalConstant, $http,$cookies) {
        return {
            getProfile: function (key) {
                return $http.get(GlobalConstant.CandidateRootApi+'/public/profile/'+slug_id,{})
                    .then(function(res){
                        return res;
                });
            },
            getMyProfile: function (tokenKey) {
                var header = {};
                if(tokenKey){
                  angular.extend(header, {headers: {'Authorization': 'Bearer ' + tokenKey,'Content-Type':'application/json'}})
                }
                return $http.get(GlobalConstant.profileApi,{},header)
                    .then(function(res){
                        return res;
                });
            },
            getWatchList: function() {
                return $http.get(GlobalConstant.APIRoot + 'employer/candidate/watchlist/' + slug_id,{})
                    .then(function(res) {
                    return res.data.data.watchlist;
                });
            },
            postWhiteListRequest: function() {
                var token = $cookies.get('token');
                var header = {};
                if(token){
                angular.extend(header, {headers: {'Authorization': 'Bearer ' + token,'Content-Type':'application/json'}})
                }
              return $http.post(GlobalConstant.CandidateRootApi+'/public/profile/'+slug_id+'/request',{},header)
                .then(function(res){
                    return res;
                });
             }
        }
      }]);
      app.factory('EmployerSvcs', ['GlobalConstant', '$http','$cookies', function (GlobalConstant, $http,$cookies) {
        return {
            getEmployerProfile:function() {
                return $http.get(GlobalConstant.APIRoot+'employer/profile',{})
                    .then(function(res){
                        return res;
                });
            }
        }
      }])

}());
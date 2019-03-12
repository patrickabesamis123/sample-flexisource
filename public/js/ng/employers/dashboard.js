(function() {
    'use strict';
    var app = angular.module('app');
    var base_url = $('body').data('base_url');

     $('#jobs_container').TrackpadScrollEmulator();
     $('.em-dash-content-con').TrackpadScrollEmulator();




     // $('.em-dash-content-con').
     //    mouseenter(function(evt){
     //        evt.preventDefault();
     //       $(this).find('.tse-scrollbar').hide()
     //      if(!$(this).find('.tse-scrollbar drag-handle').hasClass('visible')){
     //            $(this).find('.tse-scrollbar drag-handle').addClass('visible')
     //      }
     //    }).mouseleave(function(evt){
     //         evt.preventDefault();
     //       $(this).find('.tse-scrollbar').hide()
     //    });





    app.controller('EmployerManageJobs', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile',
        function(GlobalConstant, $scope, $window, $http, $cookies, $filter, $timeout, $compile) {

        	$scope.token = $cookies.get('token')

	            $scope.GetJobs = [];
	            // $http.get(GlobalConstant.EmployerRootApi  +'/job/active'+ '?access_token=' + $scope.token)
                  // $http.get(GlobalConstant.EmployerRootApi  +'/job/tms-data/active' ) //Uncomment for live API call
                  $http.get(window.location.origin + '/js/minified/test-data/test_emp_dashboard_active_data.json')
	                .then(function(response) {
                    $scope.GetJobs = response.data;
	                },
	                function (response) {
	                 	// body...
	           });

                $scope.GetDraftJobs = [];
                // $http.get(GlobalConstant.EmployerRootApi  +'/job/draft' ) //Uncomment for live API call
                $http.get(window.location.origin + '/js/minified/test-data/test_emp_dashboard_draft_data.json')
                    .then(function(response) {
                        ////console.log(response)
                         $scope.GetDraftJobs = response.data
                    },
                    function (response) {
                        // body...
               });

        }
    ]);

     app.controller('EmployerDashboard', ['GlobalConstant', 'ajaxService', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile',
        function(GlobalConstant, ajaxService, $scope, $window, $http, $cookies, $filter, $timeout, $compile) {

            $scope.token = $cookies.get('token');

                $scope.GetJobs = [];
                var today = new Date();

                $scope.loadingJobs = false;
                // $http.get(GlobalConstant.EmployerRootApi  +'/job/active'+ '?access_token=' + $scope.token)
                // $http.get(GlobalConstant.EmployerRootApi  +'/job/tms-data/active') //Uncomment for live API call
                $http.get(window.location.origin + '/js/minified/test-data/test_emp_dashboard_active_data.json')
                    .then(function(response) {

                         $scope.loadingJobs = true;

                        var data = response.data;
                        var data2 = [];

                        angular.forEach(data, function(v,k){
                            //console.log(v.expiry_date)
                            if (v.expiry_date) {
                              var aExpireDate = v.expiry_date.split("-");
                              var expireDate = new Date(aExpireDate[2],aExpireDate[1]-1,aExpireDate[0]);
                              if((expireDate.getTime() - today.getTime()) > 0){
                                  //data2.push(v);
                              }
                            }
                        })

                        // remove expired dates or greater than today's date
                        $scope.GetJobs = data;

                        // Add initial to be used in default image
                          var b =1;
                          for (var i=0; i<$scope.GetJobs.length; i++) {
                            for (var a=0; a<$scope.GetJobs[i].members.length; a++) {
                              if(b>=6) {
                                b=1;
                              }

                              $scope.F_initial = $scope.GetJobs[i].members[a].first_name;
                              $scope.F_initial = $scope.F_initial.substr(0, 1);

                              $scope.L_initial = $scope.GetJobs[i].members[a].last_name;
                              $scope.L_initial = $scope.L_initial.substr(0, 1);

                              $scope.GetJobs[i].members[a].initial = $scope.F_initial + $scope.L_initial;

                              // change default photo's background color

                              if(b==1) {
                                $scope.GetJobs[i].members[a].profile_color = "member-initials--sky";
                              }
                              else if(b==2) {
                                $scope.GetJobs[i].members[a].profile_color = "member-initials--pvm-purple";
                              }
                              else if(b==3) {
                                $scope.GetJobs[i].members[a].profile_color = "member-initials--pvm-green";
                              }
                              else if(b==4) {
                                $scope.GetJobs[i].members[a].profile_color = "member-initials--pvm-red";
                              }
                              else if(b==5) {
                                $scope.GetJobs[i].members[a].profile_color = "member-initials--pvm-yellow";
                              }
                              b++;
                            }
                          }

                         if($scope.GetJobs.length > 0) {
                          $scope.showJobs = true;
                          $scope.showEmpty = false;
                         } else {

                          $scope.showJobs = false;
                          $scope.showEmpty = true;
                         }


                    },
                    function (response) {
                        //console.log('error');
                        //console.log(response);
                });



                    $scope.sortRolesDate = function(item) {

                        if(item.expiry_date) {
                            var item = item.expiry_date;
                            var aItem = item.split('-');
                            var newDate = aItem[1] +'-'+aItem[0]+'-'+aItem[2];
                            return new Date(newDate);
                        }

                    };


                // Get Employer Profile


                $scope.params = {access_token: $scope.token};
                $scope.employerdata = [];

                ajaxService.getEmployerProfile().then(function(response){
                    var data = response.data.data;

                     if(!$cookies.get('azureContainer')){
                        $cookies.put('azureContainer', data.azure_container_key,{'path': '/'});
                    }
                        $scope.employerdata = data;
                })
                // $http({
                //     method: 'GET',
                //     params: $scope.params,
                //     url: GlobalConstant.APIRoot+'employer/profile'
                // }).then(function(response) {
                //     var data = response.data.data;
                //     //console.log(data);
                //     if(!$cookies.get('azureContainer')){
                //         $cookies.put('azureContainer', data.azure_container_key,{'path': '/'});
                //     }
                //     $scope.employerdata = data;

                // });

                $scope.base_url = base_url;


                $scope.GetDraftJobs = [];
                //$http.get(GlobalConstant.EmployerRootApi  +'/job/draft'+ '?access_token=' + $scope.token)
                // $http.get(GlobalConstant.EmployerRootApi  +'/job/draft') //Uncomment for live API call
                $http.get(window.location.origin + '/js/minified/test-data/test_emp_dashboard_draft_data.json')
                    .then(function(response) {
                        //console.log(response)
                         $scope.GetDraftJobs = response.data

                        //console.log('job draft')
                        //console.log($scope.GetDraftJobs)
                    },
                    function (response) {
                        // body...
               });

                $scope.GetExpiredJobs = [];
                //$http.get(GlobalConstant.EmployerRootApi  +'/job/closed'+ '?access_token=' + $scope.token)
                // $http.get(GlobalConstant.EmployerRootApi  +'/job/closed') //Uncomment for live API call
                $http.get(window.location.origin + '/js/minified/test-data/test_emp_dashboard_closed_data.json')
                    .then(function(response) {
                        //console.log(response)
                        $scope.GetExpiredJobs = response.data
                    },
                    function (response) {
                        //console.log(response)
                        // body...
               });


                $scope.GetWatchlistJobs = [];
                //$http.get(GlobalConstant.EmployerRootApi  +'/candidate/watchlist'+ '?access_token=' + $scope.token)
                // $http.get(GlobalConstant.EmployerRootApi  +'/candidate/watchlist') //Uncomment for live API call
                $http.get(window.location.origin + '/js/minified/test-data/test_emp_dashboard_watchlist_data.json')
                    .then(function(response) {

                         $scope.GetWatchlistJobs = response.data

                         if($scope.GetWatchlistJobs.length > 0){

                            angular.forEach($scope.GetWatchlistJobs, function(v,k){
                                 $http.get(GlobalConstant.APIRoot + 'employer/candidate/watchlist/' + v.profile_url  )
                                    .then(function(r) {
                                       $scope.GetWatchlistJobs[k].seen = r.data;
                                       $scope.GetWatchlistJobs[k].index = k;
                                    });

                                })
                         }

                         //console.log('$scope.GetWatchlistJobs')
                         //console.log($scope.GetWatchlistJobs)


                    },
                    function (response) {
                        // body...
               });


                $scope.deleteExpired = function(id) {

                    //var deleteURL = GlobalConstant.EmployerRootApi  +'/job/'+ id + '?access_token=' + $scope.token
                    var data = {data: {close_reason: 'draft_draft' }}
                    var deleteURL = GlobalConstant.EmployerRootApi  +'/job/'+ id
                    $http.delete( deleteURL, {data: data})
                    .then(function() {
                        $('#exp_'+id).remove();
                    });


                }

                $scope.watchThis = function(e, id) {
                var obj = $(e.target);
                var idx = obj.attr('data-index');
                     $http.post( GlobalConstant.APIRoot + 'employer/candidate/watchlist/' + id )
                     .then(function(response) {
                       $scope.GetWatchlistJobs.candidates[idx].seen = response.data.data.watchlist;
                    });
                }

        }
    ]);




}());

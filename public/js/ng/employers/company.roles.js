  (function() {
    'use strict';

    var app = angular.module('app');
    var base_url = $('body').data('base_url');


    app.controller('EmployerCompanyRoles', ['GlobalConstant', 'fileUploadService', '$scope', '$cookies', '$window', '$http', '$filter', '$timeout', '$location',
      function(GlobalConstant, fileUploadService, $scope, $cookies, $window, $http, $filter, $timeout, $location) {
        var roleURL = window.location.href;
        var roleURLdraft = roleURL.search("#/draft");
        var roleURLexp = roleURL.search("#/expired");
        var roleURLactive = roleURL.search("#/active");
        $scope.preload = true;

        $scope.token = $cookies.get('token');
        var type = window.location.hash.substr(2);
        $scope.params = {access_token: $scope.token};
        var monDate = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var today = new Date();

        $scope.activeCount = 0;
        $scope.activeLoaded = false;
        $scope.draftCount = 0;
        $scope.draftLoaded = false;
        $scope.expiredCount = 0;
        $scope.expiredLoaded = false;
        $http.get('/api/job/tally/' + 5) //Uncomment for live API call. The last sub-domain is the company_id (a variable)
        // $http.get(window.location.origin + '/js/minified/test-data/test_company_roles_count_data.json')
        .then(function (response) {
          var data = response.data;
          //console.log("h",data)

          for(var x=0; x < data.length; x++){
            if(data[x].job_status === "active"){
              $scope.activeCount = data[x].total;
            }else if(data[x].job_status === "closed"){
              $scope.expiredCount = data[x].total;
            }else if(data[x].job_status === "draft"){
              $scope.draftCount = data[x].total;
            }else{
              alert("Something went wrong on the tally.");
            }

          }
          
        });

        $scope.lazyJobActive = function (company_id) {
          $scope.preload = true;
          if($scope.activeLoaded == false) {
            $http.get('/api/job/active/' + company_id) //Uncomment for live API call.
            // $http.get(window.location.origin + '/js/minified/test-data/test_company_roles_active_data.json')
            .then(function (response) {
              var data = response.data;

              if (data.company_details.length) {
                angular.forEach(data.company_details, function (v, k) {
                  v.days_left = $scope.getDaysLeft(v.expiry_date)
                  if (v.job_description != null) {
                    if (v.job_description.length > 300) {
                      v.ellipsis = true;
                      v.truncate_description = v.job_description.substr(0, 300) + '...';
                    } else {
                      v.ellipsis = false;
                    }
                  }

                  v.expiredText = 'Expires';
                  if (v.expiry_date) {
                    var aExpiredDate = v.expiry_date.split(" ");
                    var getExpiredDate = new Date(aExpiredDate[3], monDate.indexOf(aExpiredDate[2]), aExpiredDate[1], 23, 59, 59);
                    if ((getExpiredDate.getTime() - today.getTime()) < 0) {
                      v.expiredText = 'Expired';
                    }
                  }
                });
              }

              $scope.jobApplicationActive = data;
              $scope.jobApplicationActiveJobDetails = data.company_details;
              $scope.jobApplicationActiveOtherTeams = data.other_teams;
              $scope.jobApplicationActiveOtherTeamMembers = data.other_team_mem;

              // console.log("active",$scope.jobApplicationActive.company_details)bers
              //Encode URLs
              for (var i = 0; i < $scope.jobApplicationActive.company_details.length; i++) {
                $scope.jobApplicationActive.company_details[i].date_created = new Date($scope.jobApplicationActive.company_details[i].date_created);
                $scope.jobApplicationActive.company_details[i].closing_date = new Date($scope.jobApplicationActive.company_details[i].closing_date);
                $scope.jobApplicationActive.company_details[i].expiry_date = new Date($scope.jobApplicationActive.company_details[i].expiry_date);
                $scope.jobApplicationActive.company_details[i].closed_date = new Date($scope.jobApplicationActive.company_details[i].closed_date);

                $scope.jobApplicationActive.company_details[i].company_url = encodeURIComponent($scope.jobApplicationActive.company_details[i].company_url);
                $scope.jobApplicationActive.company_details[i].role_url = encodeURIComponent($scope.jobApplicationActive.company_details[i].object_id);

                $scope.otherMemList = Object.keys($scope.jobApplicationActive.other_team_members);
                $scope.teamList = Object.keys($scope.jobApplicationActive.other_teams);
                var b = 1;
                for (var a = 0; a < $scope.otherMemList.length; a++) {
                  if (b >= 5) {
                    b = 1;
                  }
                  $scope.F_initial = $scope.jobApplicationActive.company_details[i].other_members[a].first_name;
                  $scope.jobApplicationActive.company_details[i].other_members[a].nickname = $scope.F_initial;
                  $scope.F_initial = $scope.F_initial.substr(0, 1);

                  $scope.L_initial = $scope.jobApplicationActive.company_details[i].other_members[a].last_name;
                  $scope.L_initial = $scope.L_initial.substr(0, 1);

                  $scope.jobApplicationActive.company_details[i].other_members[a].initial = $scope.F_initial + $scope.L_initial;

                  // change default photo's background color

                  if (!$scope.jobApplicationActive.company_details[i].other_members[a].profile_picture_url) {

                    if (b == 1) {
                      $scope.jobApplicationActive.company_details[i].other_members[a].profile_color = "member-initials--sky";
                    }
                    else if (b == 2) {
                      $scope.jobApplicationActive.company_details[i].other_members[a].profile_color = "member-initials--pvm-purple";
                    }
                    else if (b == 3) {
                      $scope.jobApplicationActive.company_details[i].other_members[a].profile_color = "member-initials--pvm-green";
                    }
                    else if (b == 4) {
                      $scope.jobApplicationActive.company_details[i].other_members[a].profile_color = "member-initials--pvm-red";
                    }
                    b++;
                  }
                }

                for (var a = 0; a < $scope.teamList.length; a++) {
                  //console.log($scope.jobApplicationActive.company_details[i].other_teams[a].id)

                  $scope.memList = Object.keys($scope.jobApplicationActive.company_details[i].other_teams[a].members);
                  for (var c = 0; c < $scope.memList.length; c++) {
                    if (b >= 5) {
                      b = 1;
                    }
                    $scope.F_initial = $scope.jobApplicationActive.company_details[i].other_teams[a].members[c].first_name;
                    $scope.jobApplicationActive.company_details[i].other_teams[a].members[c].nickname = $scope.F_initial;
                    $scope.F_initial = $scope.F_initial.substr(0, 1);

                    $scope.L_initial = $scope.jobApplicationActive.company_details[i].other_teams[a].members[c].last_name;
                    $scope.L_initial = $scope.L_initial.substr(0, 1);

                    $scope.jobApplicationActive.company_details[i].other_teams[a].members[c].initial = $scope.F_initial + $scope.L_initial;

                    // change default photo's background color

                    if (!$scope.jobApplicationActive.company_details[i].other_teams[a].members[c].profile_picture_url) {

                      if (b == 1) {
                        $scope.jobApplicationActive.company_details[i].other_teams[a].members[c].profile_color = "member-initials--sky";
                      }
                      else if (b == 2) {
                        $scope.jobApplicationActive.company_details[i].other_teams[a].members[c].profile_color = "member-initials--pvm-purple";
                      }
                      else if (b == 3) {
                        $scope.jobApplicationActive.company_details[i].other_teams[a].members[c].profile_color = "member-initials--pvm-green";
                      }
                      else if (b == 4) {
                        $scope.jobApplicationActive.company_details[i].other_teams[a].members[c].profile_color = "member-initials--pvm-red";
                      }
                      b++;
                    }
                  }
                }
              }

              $scope.activeCount = $scope.jobApplicationActive.company_details.length >= 10 ?
              $scope.jobApplicationActive.company_details.length : '0' + $scope.jobApplicationActive.company_details.length;
              $('#application-contents, .roles-list-container').TrackpadScrollEmulator();
              $('#active_tab').addClass('active'); // ibv

              if ($scope.jobApplicationActive.company_details.length) {
                $scope.preload = false;
                $scope.activeLoaded = true;
              }
            });
          } else {
            $scope.preload = false;
          }
        }

        $scope.lazyJobDraft = function (company_id) {
          $scope.preload = true;
          if($scope.draftLoaded == false) {
            $http.get('/api/job/draft/' + company_id) //Uncomment for live API call
            // $http.get(window.location.origin + '/js/minified/test-data/test_company_roles_draft_data.json')
            .then(function (response) {
              var data = response.data;

              if (data.company_details.length) {
                angular.forEach(data.company_details, function (v, k) {
                  v.days_left = $scope.getDaysLeft(v.expiry_date);

                  if (v.job_description != null) {
                    if (v.job_description.length > 300) {
                      v.ellipsis = true;
                      v.truncate_description = v.job_description.substr(0, 300) + '...';
                    } else {
                      v.ellipsis = false;
                    }
                  }
                });
              }

              $scope.jobApplicationDraft = data;
              $scope.jobApplicationDraftJobDetails = data.company_details;
              $scope.jobApplicationDraftOtherTeams = data.other_teams;
              $scope.jobApplicationDraftOtherTeamMembers = data.other_team_mem;

              $scope.draftCount = $scope.jobApplicationDraft.company_details.length >= 10 ?
                  $scope.jobApplicationDraft.company_details.length : '0' + $scope.jobApplicationDraft.company_details.length;

              $('#application-contents, .roles-list-container').TrackpadScrollEmulator();
              $('#draft_tab').addClass('active');
              
              if ($scope.jobApplicationDraft.company_details.length) {
                $scope.preload = false;
                $scope.draftLoaded = true;
              }
            });
          } else {
            $scope.preload = false;
          }
        }

        $scope.lazyJobExp = function (company_id) {
          var dateNow = new Date();
          $scope.preload = true;
          if($scope.expiredLoaded == false) {
            $http.get('/api/job/closed/' + company_id) //Uncomment for live API call
            // $http.get(window.location.origin + '/js/minified/test-data/test_company_roles_closed_data.json') //Uncomment for test data
            .then(function (response) {
              var data = response.data;

              if (data.company_details.length) {
                angular.forEach(data.company_details, function (v, k) {
                  v.days_left = $scope.getDaysLeft(v.expiry_date);
                  if (v.job_description != null) {
                    if (v.job_description.length > 300) {
                      v.ellipsis = true;
                      v.truncate_description = v.job_description.substr(0, 300) + '...';
                    } else {
                      v.ellipsis = false;
                    }
                  }
                  v.expiredText = 'Expires';
                  if (v.expiry_date) {
                    var aExpiredDate = v.expiry_date.split(" ");
                    var getExpiredDate = new Date(aExpiredDate[3], monDate.indexOf(aExpiredDate[2]), aExpiredDate[1], 23, 59, 59);
                    if ((getExpiredDate.getTime() - today.getTime()) < 0) {
                      v.expiredText = 'Expired';
                    }
                  }
                });
              }
              $scope.jobApplicationExpired = data;
              $scope.jobApplicationExpiredJobDetails = data.company_details;
              $scope.jobApplicationExpiredOtherTeams = data.other_teams;
              $scope.jobApplicationExpiredOtherTeamMembers = data.other_team_members;

              // console.log("expired ", $scope.jobApplicationExpired.company_details);
              $scope.expiredCount = $scope.jobApplicationExpired.company_details.length >= 10 ? $scope.jobApplicationExpired.company_details.length : '0' + $scope.jobApplicationExpired.company_details.length;


              // vERn
              for (var j = 0; j < $scope.jobApplicationExpired.company_details.length; j++) {
                $scope.jobApplicationExpiredJobDetails[j].date_created = new Date($scope.jobApplicationExpired.company_details[j].date_created);
                $scope.jobApplicationExpiredJobDetails[j].closing_date = new Date($scope.jobApplicationExpired.company_details[j].closing_date);
                $scope.jobApplicationExpiredJobDetails[j].expiry_date = new Date($scope.jobApplicationExpired.company_details[j].expiry_date);
                $scope.jobApplicationExpiredJobDetails[j].closed_date = new Date($scope.jobApplicationExpired.company_details[j].closed_date);

                $scope.jobApplicationExpired.company_details[j].company_url = encodeURIComponent($scope.jobApplicationExpired.company_details[j].company_url);
                $scope.jobApplicationExpired.company_details[j].role_url = encodeURIComponent($scope.jobApplicationExpired.company_details[j].object_id);
                var exp_date = new Date($scope.jobApplicationExpired.company_details[j].expiry_date);
                var closed_date = new Date($scope.jobApplicationExpired.company_details[j].closed_date);
                var closing_date = new Date($scope.jobApplicationExpired.company_details[j].closing_date);
                $scope.jobApplicationExpired.company_details[j].expiredNotice = exp_date >= closed_date ? 1 : 0;

                if (closed_date) {
                  $scope.jobApplicationExpired.company_details[j].closedNotice = closed_date <= dateNow ? 1 : 0;
                } else {
                  $scope.jobApplicationExpired.company_details[j].closedNotice = closing_date <= dateNow ? 1 : 0;
                }


                $scope.expiredOtherMemList = Object.keys($scope.jobApplicationExpired.other_team_members);
                $scope.expiredTeamList = Object.keys($scope.jobApplicationExpired.other_teams);
                var b = 1;
                for (var a = 0; a < $scope.expiredOtherMemList.length; a++) {
                  if (b >= 5) {
                    b = 1;
                  }
                  $scope.F_initial = $scope.jobApplicationExpired.other_team_members[a].first_name;
                  $scope.jobApplicationExpired.other_team_members[a].nickname = $scope.F_initial;
                  $scope.F_initial = $scope.F_initial.substr(0, 1);

                  $scope.L_initial = $scope.jobApplicationExpired.other_team_members[a].last_name;
                  $scope.L_initial = $scope.L_initial.substr(0, 1);

                  $scope.jobApplicationExpired.other_team_members[a].initial = $scope.F_initial + $scope.L_initial;

                  // change default photo's background color

                  if (!$scope.jobApplicationExpired.other_team_members[a].profile_picture_url) {

                    if (b == 1) {
                      $scope.jobApplicationExpired.other_team_members[a].profile_color = "member-initials--sky";
                    }
                    else if (b == 2) {
                      $scope.jobApplicationExpired.other_team_members[a].profile_color = "member-initials--pvm-purple";
                    }
                    else if (b == 3) {
                      $scope.jobApplicationExpired.other_team_members[a].profile_color = "member-initials--pvm-green";
                    }
                    else if (b == 4) {
                      $scope.jobApplicationExpired.other_team_members[a].profile_color = "member-initials--pvm-red";
                    }
                    b++;
                  }
                }

                for (var a = 0; a < $scope.expiredTeamList.length; a++) {
                  //console.log($scope.jobApplicationExpired.company_details[i].other_teams[a].id)

                  $scope.memList = Object.keys($scope.jobApplicationExpired.other_teams[a].members);
                  for (var c = 0; c < $scope.memList.length; c++) {
                    if (b >= 5) {
                      b = 1;
                    }
                    $scope.F_initial = $scope.jobApplicationExpired.other_teams[a].members[c].first_name;
                    $scope.jobApplicationExpired.other_teams[a].members[c].nickname = $scope.F_initial;
                    $scope.F_initial = $scope.F_initial.substr(0, 1);

                    $scope.L_initial = $scope.jobApplicationExpired.other_teams[a].members[c].last_name;
                    $scope.L_initial = $scope.L_initial.substr(0, 1);

                    $scope.jobApplicationExpired.other_teams[a].members[c].initial = $scope.F_initial + $scope.L_initial;

                    // change default photo's background color

                    if (!$scope.jobApplicationExpired.other_teams[a].members[c].profile_picture_url) {

                      if (b == 1) {
                        $scope.jobApplicationExpired.other_teams[a].members[c].profile_color = "member-initials--sky";
                      }
                      else if (b == 2) {
                        $scope.jobApplicationExpired.other_teams[a].members[c].profile_color = "member-initials--pvm-purple";
                      }
                      else if (b == 3) {
                        $scope.jobApplicationExpired.other_teams[a].members[c].profile_color = "member-initials--pvm-green";
                      }
                      else if (b == 4) {
                        $scope.jobApplicationExpired.other_teams[a].members[c].profile_color = "member-initials--pvm-red";
                      }
                      b++;
                    }
                  }
                }
              }

              $('#application-contents, .roles-list-container').TrackpadScrollEmulator();
              $('#expired_tab').addClass('active');
              if ($scope.jobApplicationExpired.company_details.length) {
                $scope.preload = false;
                $scope.expiredLoaded = true;
              }
            });
          } else {
            $scope.preload = false;
          }
        }

        $scope.sortExpiredDate = function(item) {
          if(item.expiry_date) {
            var item = item.expiry_date.toString();
            var aItem = item.split(' ');
            var month = monDate.indexOf(aItem[2]) + 1;
            var newDateString = month + '-' + aItem[1] + '-' + aItem[3];
            return new Date(newDateString);
          }
        };
        $scope.CloseDrop = function( id){
          if($('#close_role_'+id).hasClass('hide')) {
            $('#close_role_'+id).removeClass('hide');
          } else {
            $('#close_role_'+id).addClass('hide');
          }
        }
        $scope.deleteRole = function( reason, job_id , object_id){
          var data = { reason: reason };
          $http.put( GlobalConstant.APIRoot + 'employer/job/' +job_id+ '/close',  data)
          .then(function(response) {
            alert('Job deleted because it was '+ reason);
              angular.forEach($scope.jobApplicationActive.company_details, function(v,k){
                if(v.object_id == object_id){
                  $scope.jobApplicationActive.company_details.splice(k,1);
                  $scope.activeCount--;
                  $scope.lazyJobExp();
                }
              })
          }, function(response) {
          });
        }


        if(roleURLdraft > -1) {
          $scope.roleURLdraft = true;
          $scope.lazyJobDraft(5); //put the company_id as the argument for the function call
        } else if(roleURLexp > -1) {
          $scope.roleURLexp = true;
          $scope.lazyJobExp(5); //put the company_id as the argument for the function call
        } else if(roleURLactive > -1) {
          $scope.roleURLactive = true;
          $scope.lazyJobActive(5); //put the company_id as the argument for the function call
        } else {
          $scope.roleURLactive = true;
          $scope.lazyJobActive(5); //put the company_id as the argument for the function call
        }

        $scope.deleteJob = function(jobId) {
          var data = {data: {close_reason: 'draft_delete' }}
          $http.delete( GlobalConstant.EmployerRootApi + '/job/' + jobId, {data: data }  ).then(function(response) {
            $('.job_draft_item_' + jobId).remove();
            $scope.draftCount = $scope.jobApplicationDraft.count - 1;
          }, function(response) {
              alert('error')
          });
        }
        $scope.getDaysLeft = function(str) {
          return false;
          str = str.split( '(' ), str = str[1].split(' '), str = str[0];
          return parseInt(str);
        }
        $scope.jobContent = function(type) {
          $('#application-contents').find('.tab-pane').addClass('hide').removeClass('in');
          $('#application-contents').find('#' + type).removeClass('hide').addClass('fade active in');
        }
        }
    ]);
  }());
(function() {
    'use strict';
    var app = angular.module('app');
    var base_url = $('body').data('base_url');
  
    // Work history Multi industries scroll
    $('.industry_multi_holder').TrackpadScrollEmulator();
  
  
    //find key and value of object inside array
    function functiontofindIndexByKeyValue(arraytosearch, key, valuetosearch) {
      for (var i = 0; i < arraytosearch.length; i++) {
        if (arraytosearch[i][key] == valuetosearch) {
          return i;
        }
      }
      return null;
    }
  
    app.directive('shareCount', ['$http', 'GlobalConstant', 'IdentifierBridge','$scope', function ($http, GlobalConstant, IdentifierBridge,$scope) {
      return {
        restrict: 'EA',
        scope: {
          src : '=?bind'
        },
        replace: true,
        link: function ($scope, element, attrs) {
          element.bind('click', function () {
            var srcUrl;
            $scope.src = attrs.name;
  
            if ($scope.src == 'facebook') {
              srcUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(location.href);
            } else if ($scope.src == 'twitter') {
              srcUrl = "https://twitter.com/share?url=" + encodeURIComponent(location.href);
            } else if ($scope.src == 'linkedin') {
              srcUrl = "https://www.linkedin.com/cws/share?url=" + encodeURIComponent(location.href);
            } else if ($scope.src == 'email') {
              srcUrl = "https://DummyEmailOnly";
            }
  
            var roleId = IdentifierBridge.get();
            var data = {
              role_id: roleId,
              type: $scope.src,
              source: srcUrl
            }
            if(data){
              $http.post(GlobalConstant.EmployerRootApi + '/analytics/sourceclicks/', data).then(function (res) {
                  return console.log('Share success');
                })
            }
          });
        }
  
      };
    }]);
  
    app.service("IdentifierBridge", function() {
      var role_id;
  
      return {
        get: function () {
          return role_id;
        },
        set: function (data) {
          role_id = data;
        }
      }
    });
  
    app.factory('SaveVideoAnalytics', ['GlobalConstant', '$http', function (GlobalConstant, $http) {
      return {
        postVideoData: function (data) {
          // console.log("Saving Data: ", data);
          return $http.post(GlobalConstant.EmployerRootApi + '/analytics/insertvideo/', data)
          .then(function(res) {
            return res.data;
          });
        }
      }
    }]);
  
    app.controller('JoblistingController', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$compile', 'IdentifierBridge', 'SaveVideoAnalytics', function(GlobalConstant, $scope, $window, $http, $cookies, $compile, IdentifierBridge, SaveVideoAnalytics) {
      //Remove existing cookie on page load
      //$cookies.remove('jobObjectId', { 'path':'/'});
  
      //var jobId = $('#job-listing-id').val();
      var pathArray = window.location.pathname.split('/');
      var jobId = pathArray[3];

      jobId = $.trim(jobId.replace(/\/$/, ''));
      var token = $cookies.get('token');
      $scope.ut = $cookies.get('ut');
      var color_bg_initial_set = [];
      // random color set
      color_bg_initial_set = [
        "member-initials--sky",
        "member-initials--pvm-purple",
        "member-initials--pvm-green",
        "member-initials--pvm-red",
        "member-initials--pvm-yellow"
      ];
  
  
      $scope.ellipsesText = function(text) {
        return '<span title="' + text + '">...</span>';
      }
  
      $scope.joblistingPrintTemplate = 'themes/bbt/templates/Layout/Job_listing_print_template.html';
      $scope.hideMe = true;
      $scope.base_url = base_url;
  
  
      if (jobId) {
        $scope.params = {
            access_token: token
        };
  
        //Get Job detals
        //$http.get(GlobalConstant.JobsApi + '/' + jobId) //Uncomment for live API call
        //$http.get(window.location.origin + "/js/minified/test-data/test_job_listing_data.json")
        $http.get(window.location.origin + "/api/job/" + jobId)
          .then(function(response) {

          if (response.status == 200) {

            var data = response.data;

            //Custom image when sharing on Facebook
            //angular.element('head').append('<meta property="og:image" content="' + data.company.logo_url + '"><meta property="og:image:secure_url" content="' + data.company.logo_url + '">');
  
            // data.min_salary = 100000;
            // data.max_salary = 200000;
            if (data.min_salary) {
                data.min_salary =  (data.min_salary / 1000) + 'k';
            }
            if (data.max_salary) {
                data.max_salary = (data.max_salary / 1000) + 'k';
            }
  
            var classArray = ['padding-l-zero pull-left', 'more-listing2 pull-left', 'padding-r-zero pull-right'];
            var i = 0;
            if (angular.isDefined(data.company_extra_data.active_jobs.results.jobs)) {
                if (data.company_extra_data.active_jobs.results.jobs.length) {
                    angular.forEach(data.company_extra_data.active_jobs.results.jobs, function(v, k) {
  
                        v.myclass = classArray[i];
                        v.limit_description = (v.job_description.length < 200) ? v.job_description :
                            v.job_description.substr(0, 200) + $scope.ellipsesText(v.job_description);
                        v.job_title_limit = v.job_title.length < 20 ? v.job_title :
                            v.job_title.substr(0, 20) + $scope.ellipsesText(v.job_title);
                        v.company_name_limit = v.company.company_name.length < 33 ? v.company.company_name :
                            v.company.company_name.substr(0, 33) + $scope.ellipsesText(v.company.company_name);
  
  
                        if (i == 2) {
                            i = 0;
                        }
                        i++;
                    })
                }
            }

  
            $scope.joblisting = data;

            IdentifierBridge.set($scope.joblisting.object_id);
  
            // added Jobs comp initial name and bg color
            // for (var a = 0; a < $scope.jobSearch.results.jobs.length; a++) {
            $scope.comp_initial = $scope.joblisting.company.company_name;
            $scope.comp_initial = $scope.comp_initial.replace(/[^A-Z]/g, "");
            $scope.joblisting.company.initial = $scope.comp_initial
  
            // change default photo's background color
            var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
            $scope.joblisting.company.profile_color = color_bg_initial;
            // }
  
  
            // Joblisting Title
            $('#joblisting_title').html($scope.joblisting.job_title + ' | PreviewMe');
  
            $scope.company_website = '';
            if ($scope.joblisting.company.website_url) {
                $scope.company_website = $scope.joblisting.company.website_url.replace(/^https?:\/\//, '');
            }
  
            if(data.company.company_video){
                 $scope.showVideo = data.company.company_video.doc_url ? true : false;
            }
  
              $scope.showVideoTop = (typeof data.job_video_url != 'undefined') ? true : false;
            if ($scope.showVideoTop && data.job_video_url != '') {
                var vidDuration = 0, intWhole, intFloating, varcurrentTime;
  
  
  
                var myPlayer = amp('vid1', {
                  "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                  "nativeControlsForTouch": false,
                  autoplay: false,
                  controls: true,
                  width: "100%",
                  // height: "300",
                  logo: {
                      "enabled": false
                  },
                  poster: ""
                }, function() {
  
                  // Save as Avg. Viewing Time
                  this.addEventListener('ended', function() {
                    // console.log("(ended): ", this.currentTime());
                    varcurrentTime = this.currentTime();
                    postVideoViewTimeUpdate(varcurrentTime);
                  });
  
                  this.addEventListener('midpoint', function () {
                    // console.log("(midpoint): ", this.currentTime());
                    varcurrentTime = this.currentTime();
                    postVideoViewTimeUpdate(varcurrentTime);
  
                  });
  
                  this.addEventListener('firstquartile', function () {
                    // console.log("(firstquartile): ", this.currentTime());
                    varcurrentTime = this.currentTime();
                    postVideoViewTimeUpdate(varcurrentTime);
                  });
  
                  // save as watched/viewed counter
                  this.addEventListener('start', function () {
                    vidDuration = this.duration();
                    intWhole = parseInt(vidDuration, 10);
                    intWhole = intWhole / 60;
                    intFloating = intWhole % 1;
                    intWhole = parseInt(intWhole, 10);
                    intFloating = intFloating.toFixed(2);
                    intFloating = .6 * intFloating;
                    intFloating = Math.round(intFloating * 100) / 100;
                    vidDuration = intWhole + intFloating;
                  });
                });
  
                function postVideoViewTimeUpdate (objViewTime) {
                  var objectData = {
                    'company_id' : $scope.joblisting.company.id,
                    'role_object_id': $scope.joblisting.object_id,
                    'vid_viewtime' : objViewTime,
                    'vid_duration' : vidDuration,
                    'vid_url' : data.job_video_url
                  }
  
                  // SaveVideoAnalytics.postVideoData(objectData);
                }
  
                if (data.job_video_url) {
                    myPlayer.src([{
                        src: data.job_video_url,
                        type: "application/vnd.ms-sstr+xml"
                    }]);
  
                    // Save video counter
  
  
                }else{
                    $scope.showVideoTop = false;
                    $scope.showVideoLoding = true;
                }
  
  
  
            }else{
                 $scope.showVideoTop = false
            }
  
            if (data.company.company_video) {
              if ( data.company.company_video.doc_url != '0'  ) {
  
                  var myPlayer2 = amp('vid2', {
                      "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                      "nativeControlsForTouch": false,
                      autoplay: false,
                      controls: true,
                      width: "100%",
                      // height: "300",
                      logo: {
                          "enabled": false
                      },
  
                      poster: ""
                  }, function() {
  
                      this.addEventListener('ended', function() {
                          ////console.log('Finished!');
                      });
  
                  });
  
                  if (data.company.company_video.doc_url) {
                      myPlayer2.src([{
                          src: data.company.company_video.doc_url,
                          type: "application/vnd.ms-sstr+xml"
                      }]);
                  }else{
                      $scope.showVideoLoding2 = false;
                       $scope.showVideoTop = false
                  }
              }
            }
  
            $scope.followedText = '+ Follow us';
            if (token && $scope.ut == 'candidate') {
              $http.get(GlobalConstant.APIRoot + 'candidate/company/follow/' + $scope.joblisting.company.id  )
              .then(function(response) {
                //console.log('follow')
                //console.log(response.data.data)
                if (response.data.data.followed) {
                  $scope.followedText = '- Unfollow';
                } else {
                  $scope.followedText = '+ Follow us';
                }
              });
  
              $scope.follow = function(company_id) {
                $http.post(GlobalConstant.CandidateRootApi + '/company/follow/' + company_id)
                .then(function(response) {
                  var followers = parseInt($scope.joblisting.company_extra_data.followers);
                  if (response.data.data.followed) {
                    $scope.joblisting.company_extra_data.followers = followers + 1;
                    $scope.followedText = '- Unfollow';
                  } else {
                    $scope.joblisting.company_extra_data.followers = followers - 1;
                    $scope.followedText = '+ Follow us';
                  }
                }, function errorCallback(response) {});
              }
            } else {
              $scope.follow = function(company_id) {
                return false;
              }
            }
            //Submit application
            $scope.ApplyJob = function() {
              //Check if logged in
              // if (token != null || angular.isUndefined(token) == false ) {
              if (token && $scope.ut == 'candidate') {
                // $http.post(GlobalConstant.CandidateRootApi + '/application/' + jobId  ) //Uncomment for live API call
                $http.post( window.location.origin + "/js/minified/test-data/test_job_view_public_data.json"  )
                .then(function(response) {
                  //console.log(response.data)
                  $cookies.put('jobObjectId', jobId, {
                    'path': '/'
                  });
                  $cookies.put('applicationId', response.data.data.application_id, {
                    'path': '/'
                  });
                  $cookies.put('nextStep', response.data.data.next_step, {
                    'path': '/'
                  });
                  var arraycookie = angular.toJson(response.data.data.all_steps);
                  $cookies.put('availSteps', arraycookie, {
                    'path': '/'
                  });
                  $cookies.put('applied_company', $scope.joblisting.company.company_name, {
                    'path': '/'
                  });
                  $window.location.href = base_url + 'job/application?id=' + response.data.data.application_id;
  
                }, function(response) {
                  //console.log('err')
                  $scope.ErrorMsg = response.data.message;
                  // alert('You\'ve already applied to this job post');
                  alert('Applied');
                  $('.job-listing-question-button').attr('disabled', true);
                  $scope.noerror = true
                });
  
                //Follow Company
                $http.post(GlobalConstant.CandidateRootApi + '/company/follow/' + $scope.joblisting.company.id)
                .then(function(response) {
                  var followers = parseInt($scope.joblisting.company_extra_data.followers);
                  if (response.data.data.followed) {
                    $scope.joblisting.company_extra_data.followers = followers + 1;
                    $scope.followedText = '- Unfollow';
                  } else {
                    $scope.joblisting.company_extra_data.followers = followers - 1;
                    $scope.followedText = '+ Follow us';
                  }
                }, function errorCallback(response) {});
              } else {
                //trigger 401
                // $http.post(GlobalConstant.CandidateRootApi + '/application/' + jobId) //Uncomment for live API call
                $http.post(window.location.origin + "/js/minified/test-data/test_job_view_public_data.json")
                .then(function(response) {
                 //console.log(response.data)
                }, function(response) {});
                //console.log('show form if not logged');
              }
            }
          }
        }, function(response) {
            if (response.status == 404) {
                //alert("Invalid.");
                window.location = base_url + 404;
  
            }
        })
  
        // Button text on save to watchlist
        $scope.watchlist_text = 'SAVE TO WATCHLIST';
        if (token) {
  
          $scope.save_to_watchlist = function() {
              $http.post( GlobalConstant.CandidateJobWatchlistApi + '/' + jobId )
              .then(function(response) {
                  var data = response.data.data;
  
                  if (data.watchlist) {
  
                      $('.watchlist_save').addClass('pvm-blue')
                      $scope.watchlist_text = 'SAVED TO WATCHLIST';
                  } else {
                      $('.watchlist_save').removeClass('pvm-blue')
  
                  }
  
  
              }, function(response) {});
          }
  
          if ($scope.ut != 'employer') {
            $http.get( GlobalConstant.CandidateJobWatchlistApi )
            .then(function(response) {
                var data = response.data.data;
                angular.forEach(data.jobs, function(v, k) {
                    // ////console.log(v)
                    if (v.object_id == jobId) {
                        $('.watchlist_save').addClass('pvm-blue');
                        $scope.watchlist_text = 'SAVED TO WATCHLIST';
                    }
                })
            });
          }
  
          // $http.get( GlobalConstant.JobsApi + '/' + jobId ) //Uncomment for live API call
          $http.get( window.location.origin + "/js/minified/test-data/test_job_listing_data.json" )
          .then(function(response) {
            var data = response.data.data;
            // ////console.log('data')
            // ////console.log(data)
            if (data.candidate) {
                $scope.applied = data.candidate.application.applied;
            }
          });
  
  
          $scope.openEmail = function() {
            $('#joblistingEmailModal').modal('show');
          }
  
          $scope.joblistSendEmail = function() {
            var data = {
              "data": {
                  "sender_name": $scope.sender_name,
                  "sender_email": $scope.sender_email,
                  "receiver_name": $scope.receiver_name,
                  "receiver_email": $scope.receiver_email
              }
            }
  
            $http.post(  GlobalConstant.APIRoot + 'jobs/' + $scope.joblisting.object_id + '/share/email', data )
            .then(function(response) {
                alert('Message sent.')
                $('#joblistingEmailModal').modal('hide');
            }, function(response) {
                alert('error')
            })
          }
        }
      }
  
       $scope.printJoblisting = function() {
          var w = window.open();
          w.document.write($('#joblisting-printTemplate').html());
          w.document.close();
          w.focus();
          w.print();
          w.close();
      }
    }]);
  
    app.controller('JobApplication', ['GlobalConstant', 'fileUploadService', '$scope', '$window', '$http', '$cookies', '$location', '$timeout', function(GlobalConstant, fileUploadService, $scope, $window, $http, $cookies, $location, $timeout) {
          //Remove existing cookie on page load
          //$cookies.remove('jobObjectId', { 'path':'/'});
  
           $scope.isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
  
  
          $scope.clickHandler =  function (e){
  
              //console.log(e)
              if( e.keyCode == 13) {
                  e.preventDefault();
              }else{
                  var element = typeof e === 'object' ? e.target : document.getElementById(e);
                      var scrollHeight = element.scrollHeight ; // replace 60 by the sum of padding-top and padding-bottom
                  element.style.height =  scrollHeight + "px";
              }
          }
  
          //get query string by key
          function getUrlParameter(param, dummyPath) {
              var sPageURL = dummyPath || window.location.search.substring(1),
                  sURLVariables = sPageURL.split(/[&||?]/),
                  res;
              for (var i = 0; i < sURLVariables.length; i += 1) {
                  var paramName = sURLVariables[i],
                      sParameterName = (paramName || '').split('=');
  
                  if (sParameterName[0] === param) {
                      res = sParameterName[1];
                  }
              }
              return res;
          }
  
  
          //Check if logged in
          var token = $cookies.get('token');
  
          // if($scope.queryString.job_id){
  
          // }
          var ApplicationId = getUrlParameter('id');
          var token_id = $cookies.get('token_id');
          $scope.nextStep = $cookies.get('nextStep');
          $scope.noerror = false;
  
          if (getUrlParameter('job_id')) {
              jobObjectId = getUrlParameter('job_id');
          } else {
              var jobObjectId = $cookies.get('jobObjectId');
          }
  
          if (getUrlParameter('next_step')) {
              $scope.nextStep = getUrlParameter('next_step');
          }
  
          if (token != null || angular.isUndefined(token) == false) {
              //Check if has Job object Id
  
              if (ApplicationId != null || angular.isUndefined(ApplicationId) == false) {
  
                  $scope.noerror = false;
  
  
  
                  //Get Company Details
                  // $http.get(GlobalConstant.JobsApi + '/' + jobObjectId) //Uncomment for live API call
                  $http.get(window.location.origin + "/js/minified/test-data/test_job_listing_data.json")
                      .then(function(response) {
                          // ////console.log(response.data.data)
                          $scope.companyDetails = response.data.data;
                          //////console.log($scope.companyDetails)
                          //////console.log($scope.companyDetails.company.company_name)
  
  
                          // $cookies.put('applied_company', $scope.companyDetails.company.company_name, {
                          //               'path': '/'
                          //           });
  
  
  
                      });
  
                  // ////console.log($scope.nextStep);
                  if ($scope.nextStep != 'applied' || $scope.nextStep != 'rejected') {
                      //Generate Left side menu items
                      $scope.leftItems = []
  
                      if (angular.isDefined(getUrlParameter('id')) && angular.isDefined(getUrlParameter('job_id'))) {
                          //Get All step for the left sidebar
                          $http.get(GlobalConstant.CandidateRootApi + '/application/' + getUrlParameter('job_id') + '/' + getUrlParameter('id') )
                              .then(function(response) {
                                  $scope.all_steps = response.data.data.all_steps
                                  ////console.log(response.data.data)
  
                                  ////console.log($scope.currentStepIndex)
                                  $scope.currentStep = $scope.nextStep;
                                  //var all_steps = angular.fromJson($cookies.get('availSteps'));
                                  angular.forEach($scope.all_steps, function(value, key) {
                                      //////console.log(value)
                                      if (value == 'pre_apply_questions') {
                                          $scope.leftItems.push({
                                              name: 'START YOUR APPLICATION',
                                              slug: value
                                          });
                                      } else if (value == 'requirements_check') {
                                          $scope.leftItems.push({
                                              name: 'COMPLETE YOUR PROFILE',
                                              slug: value
                                          });
  
                                          $timeout(function(){
                                              angular.element( $('.appstep_'+(key-1) )).addClass('progtrckr-done')
                                              angular.element( $('.appstep_'+(key-1) )).removeClass('progtrckr-todo')
  
                                          }, 200)
  
  
  
                                      } else if (value == 'application_questions') {
                                          $scope.leftItems.push({
                                              name: 'APPLICATION QUESTIONS',
                                              slug: value
                                          });
                                          $timeout(function(){
                                              angular.element($('.appstep_'+(key-1))).addClass('progtrckr-done')
                                              angular.element($('.appstep_'+(key-1))).removeClass('progtrckr-todo')
                                              angular.element($('.appstep_'+(key-2))).addClass('progtrckr-done')
                                              angular.element($('.appstep_'+(key-2))).removeClass('progtrckr-todo')
                                          }, 200)
                                      }
                                  });
  
                              }, function(response) {
                                  ////console.log(response)
                                  $scope.ErrorMsg = response.data.message;
                                  $scope.noerror = true
                              });
                      } else {
                          $scope.currentStep = $scope.nextStep;
                          var all_steps = angular.fromJson($cookies.get('availSteps'));
                          angular.forEach(all_steps, function(value, key) {
                              //////console.log(value)
                              if (value == 'pre_apply_questions') {
                                  $scope.leftItems.push({
                                      name: 'START YOUR APPLICATION',
                                      slug: value
                                  });
                              } else if (value == 'requirements_check') {
                                  $scope.leftItems.push({
                                      name: 'COMPLETE YOUR PROFILE',
                                      slug: value
                                  });
                                   $timeout(function(){
                                              angular.element( $('.appstep_'+(key-1) )).addClass('progtrckr-done')
                                              angular.element( $('.appstep_'+(key-1) )).removeClass('progtrckr-todo')
  
                                          }, 200)
                              } else if (value == 'application_questions') {
                                  $scope.leftItems.push({
                                      name: 'APPLICATION QUESTIONS',
                                      slug: value
                                  });
                                   $timeout(function(){
                                      angular.element($('.appstep_'+(key-1))).addClass('progtrckr-done')
                                      angular.element($('.appstep_'+(key-1))).removeClass('progtrckr-todo')
                                      angular.element($('.appstep_'+(key-2))).addClass('progtrckr-done')
                                      angular.element($('.appstep_'+(key-2))).removeClass('progtrckr-todo')
                                  }, 200)
                              }
                          });
  
                      }
  
  
  
  
                      //Get current step details
                      $scope.getStepData = function() {
  
                          $http.get(GlobalConstant.CandidateRootApi + '/application/' + jobObjectId + '/' + ApplicationId + '/' + $scope.nextStep  )
                              .then(function(response) {
                                  $scope.questions = response.data.data;
                                  //console.log ( $scope.questions )
                              }, function(response) {
                                  ////console.log(response)
                              });
                      }
                      $scope.getStepData();
                      ////console.log($scope.leftItems)
                      $scope.showsections = function() {
  
                          var sections = {
                              pre_apply_questions: false,
                              requirements_check: false,
                              application_questions: false,
                              applied: false,
                              rejected: false
                          };
  
                          angular.forEach(sections, function(val, key) {
  
  
                              if (key == $scope.currentStep) {
                                  sections[$scope.currentStep] = true
                              }
                          })
  
                          return sections
                      };
                  }
  
  
  
                  $scope.preapply = true;
                  $scope.requirementcheck = false;
                  $scope.applicationquestions = false;
                  $scope.success = false;
                  $scope.fail = false;
  
  
                  //If step is pre apply question
                  if ($scope.nextStep == 'pre_apply_questions') {
  
                      $scope.preapply = true;
                      $scope.requirementcheck = false;
                      $scope.applicationquestions = false;
                      $scope.success = false;
                      $scope.fail = false;
  
  
                      //Submit Pre Apply Question form
                      $scope.PreApplyQuestions = [];
                      $scope.SubmitPreApplyQuestion = function() {
                          $scope.toSubmit = [];
                          angular.forEach($scope.PreApplyQuestions.data, function(val, key) {
                              var value = {
                                  question_id: parseInt(key),
                                  answer: val
                              }
                              $scope.toSubmit.push(value);
                          });
  
                          var data = {
                              data: $scope.toSubmit
                          };
                          if (jobObjectId) {
                              var redirect_obj_id = '&job_id=' + jobObjectId
                          } else {
                              var redirect_obj_id = ''
                          }
  
  
  
                          //Submit Pre apply questions
                          $http.post(
                                  GlobalConstant.CandidateRootApi + '/application/' + jobObjectId + '/' + ApplicationId + '/' + $scope.nextStep  ,
                                  data)
                              .then(function(response) {
                                  ////console.log('success')
                                  ////console.log(response);
                                  $cookies.put('nextStep', response.data.data.next_step, {
                                      'path': '/'
                                  });
  
  
                                  $window.location.href = base_url + 'job/application?id=' + ApplicationId + redirect_obj_id + '&next_step=' + response.data.data.next_step;
                                  ////console.log(redirect_obj_id)
                                  return false
                              }, function(response) {
                                  ////console.log('fail')
                                  ////console.log(response);
                              });
  
                      }
                  }
                  //if step is requirment check section
                  else if ($scope.nextStep == 'requirements_check') {
                      $scope.preapply = false;
                      $scope.requirementcheck = true;
                      $scope.applicationquestions = false;
                      $scope.success = false;
  
                      //
                      $scope.status = false;
                      //Get Candidate profile
  
                      $http.get(GlobalConstant.CandidateRootApi + '/profile'  )
                          .then(function(response) {
                              //console.log(response.data.data);
  
                              //  $scope.dataAboutMe = response.data.data.long_description;
                              $scope.references = response.data.data.references;
                              $scope.educations = response.data.data.qualifications;
                      });
  
                      $scope.getStepData();
                      //Update About
                      $scope.updateaboutsuc = false;
                      $scope.updateaboutrotate = false;
                      $scope.updateabouterr = false;
  
  
                      $scope.ResumeURL = '';
                      $scope.DisplayResumeURL = '';
  
                      $scope.file_save = function(e) {
  
                          var elem = $(e.currentTarget);
                          fileUploadService.save($scope);
  
                          if($scope.isPortfolioSupportingDoc) {
                              $scope.PortfolioName = $scope.return_data.file_name;
                              $scope.showPortfolioDoc = true;
                              return false;
                          }
  
                          $scope.ResumeURL = $scope.return_data;
                      }
  
                      $scope.$watch('ResumeURL', function(newval, oldval){
                          if (oldval != newval) {
                              $scope.DisplayResumeURL = newval;
                              var index = $scope.questions.indexOf('resume');
                              if(index != -1){
                                   $scope.questions.splice(index, 1);
                              }
  
                          }
                      });
  
                      $scope.$watch('PortfolioName', function(newval, oldval){
                          if (oldval != newval) {
                              $scope.DisplayResumeURL = newval;
                              var index = $scope.questions.indexOf('portfolio');
                               if(index != -1){
                                   $scope.questions.splice(index, 1);
                              }
  
                          }
                      });
  
                  /*    $scope.deletePhoto = function(){
                          var aboutVal = {
                              data: {
                                  docs:{
                                    profile_image:false
                                  }
                               }
                          }
  
                          $http.put ( GlobalConstant.profileApi,  aboutVal )
                              .then(function(response) {
                                  //console.log(response)
  
                               }, function(response) {
                                  //Error Condition
                                  ////console.log(response);
                                  alert('some error');
                          });
                      }*/
                      $scope.UpdateProfile = function( data ) {
  
  
                          var aboutVal = {
                              data: { }
                          }
  
                         switch (data) {
                              case 'about' :
  
                                  if ($scope.aboutfield == null || $scope.aboutfield == '' || $scope.aboutfield == undefined) {
                                      $scope.notcomplete = false;
                                      return false;
                                  }
  
  
                                  aboutVal.data.long_description = $scope.aboutfield;
                                  $scope.updateabouterr = false;
                                  $scope.updateaboutrotate = true;
                                  break;
                              case 'phone':
  
                                  if ($scope.phoneField == null || $scope.phoneField == '' || $scope.phoneField == undefined) {
                                      $scope.notcomplete = false;
                                      return false;
                                  }
  
                                  aboutVal.data.phone_number = $scope.phoneField
  
                                  $scope.updatephoneerr = false;
                                  $scope.updatephonerotate = true;
  
                                  break;
                              case 'location': // ib
                                  if ($scope.locationField == null || $scope.locationField == '' || $scope.locationField == undefined) {
                                      $scope.notcomplete = false;
                                      return false;
                                  }
  
                                  aboutVal.data.location = $scope.locationField
  
                                  $scope.updatelocerr = false;
                                  $scope.updatelocrotate = true;
                                  break;
                          }
  
  
  
  
                          $http.put ( GlobalConstant.profileApi,  aboutVal )
                              .then(function(response) {
                                  // alert('update success');
                                  //scope.status = true;
                                  //console.log(response)
                                  switch (data) {
                                      case 'about' :
                                          $scope.updateaboutrotate = false;
                                          var index = $scope.questions.indexOf('about_me');
                                          if (response.status == 204) {
  
                                              $scope.updateabouterr = false;
                                              $scope.updateaboutsuc = true;
                                          } else {
  
                                              $scope.updateabouterr = false;
                                              $scope.updateaboutsuc = true;
                                          }
  
                                          break;
                                      case 'phone':
                                          $scope.updatephonerotate = false;
                                          var index = $scope.questions.indexOf('phone_number')
  
                                          if (response.status == 204) {
  
                                              $scope.updatephoneerr = false;
                                              $scope.updatephonesuc = true;
                                          } else {
  
                                              $scope.updatephoneerr = false;
                                              $scope.updatephonesuc = true;
                                          }
  
                                          break;
                                      case 'location': //ib
                                          $scope.updatephonerotate = false;
                                          var index = $scope.questions.indexOf('location')
  
                                          $scope.updatelocerr = false;
                                          $scope.updatelocsuc = true;
                                          break;
                                  }
                                  if (index != -1 ) {
                                      $scope.questions.splice(index, 1);
                                  }
  
  
  
                                  ////console.log(response)
                                      // $scope.getStepData()
                                      //$('#Form_my_file').attr('data-ob_key', response.data.data.ob_key);
                              }, function(response) {
                                  //Error Condition
                                  ////console.log(response);
                                  alert('some error');
                              });
                      }
  
  
                      //Update Reference
                      $scope.params = {
                          access_token: token
                      };
                      $scope.AddReferenceForm = function() {
                          $scope.showReferenceForm = true;
                      };
                      $scope.CancelReferenceForm = function() {
                          $scope.showReferenceForm = false;
                      }
                      $scope.AddEducationForm = function() {
                          $scope.showEducationForm = true;
                      };
  
                      $scope.CancelEducationForm = function() {
                          $scope.showEducationForm = false;
                      }
                      $scope.AddReference = function() {
                              var formData = {};
  
                              $('#addReferenceForm').serializeArray().map(function(item) {
  
                                  // changed back to company_name field to fix bug on work history form
                                  if (item.name == 'company_name_ref') {
                                      item.name = 'company_name';
                                  }
                                  formData[item.name] = item.value;
                              });
  
                              $http.post( GlobalConstant.ReferenceApi,  { data: formData } )
                                  .then(function(response) {
                                      //success
                                      ////console.log(response);
                                      if (response.status == 201) {
                                          alert('data saved');
                                          var data = response.data.data;
  
                                          var displayVal = {
                                              employer_name: data.employer_name,
                                              id: data.id,
                                              company_name: data.company_name,
                                              description: data.description
                                          };
                                          $scope.references.push(displayVal);
                                          $scope.showReferenceForm = false;
                                          $scope.getStepData()
                                      }
                                  }, function(response) {
                                      //Error Condition
                                      alert('Error found: Please review form');
                                  });
                      }
  
                      // Delete Reference
                      $scope.deleteReference = function(id) {
                          ////console.log(id);
  
                          var deleteURL = GlobalConstant.ReferenceApi + '/' + id;
                          $http.delete( deleteURL )
                              .then(function() {
                                  $('#ref_' + id).slideToggle();
                                  $scope.getStepData();
                                  ////console.log('deleted');
                              });
                      };
  
                      // Edit Reference
                      $scope.EditReference = function($data, id) {
  
                          $http.put( GlobalConstant.ReferenceApi + '/' + id , { data: $data } )
                              .then(function(response) {
                                  //success
                                  alert('data saved');
                              }, function(response) {
                                  //Error Condition
                                  alert('Error found: Please review form');
                              });
                      }
  
                      // Add Education
                      $scope.qualification = 5;
                      $scope.qualification_provider = 1;
                      $scope.qualifications = [];
                      $http.get(GlobalConstant.StaticOptionsApi + '/qualifications').then(function(response) {
                          $scope.qualifications = response.data.data;
                          // ////console.log($scope.qualifications);
                      });
  
                      $scope.qualification_providers = [];
                      $http.get(GlobalConstant.StaticOptionsApi + '/qualification_providers' ).then(function(response) {
                          $scope.qualification_providers = response.data.data;
                          //////console.log($scope.qualification_providers);
                      });
  
  
                      $scope.initDatePicker = function(e) {
  
                          $(e.target).datetimepicker({
                              timepicker:false,
                              format:'d-m-Y'
                          });
                          $(e.target).datetimepicker("show");
                      }
  
                      $scope.openDatePicker = function() {
                          ////console.log('aa');
                          $(".my_datapicker").datepicker({
                              dateFormat: 'dd-mm-yy'
                          });
                          $(".my_datapicker").datepicker("show");
  
                      };
  
  
                      $scope.closePicker = function() {
                          $scope.picker.opened = false;
                      };
  
                      $scope.AddEducation = function() {
  
                          var formData = {};
                          var form = $('#addEductionForm');
                          // get user input from the form
  
                          form.serializeArray().map(function(item) {
  
                              formData[item.name] = item.value;
                              if (item.name == 'completed_date') {
                                  formData[item.name] = $scope.parse_view_date(item.value);
                              } else if (item.name == 'qualification' || item.name == 'qualification_provider') {
                                  if (form.find('input[name="' + item.name + '"]').attr('data-id')) {
                                      formData[item.name] = parseInt(form.find('input[name="' + item.name + '"]').attr('data-id'));
                                  }
                              }
  
                          });
  
                          if (formData['degree'] == 'Other') {
                              formData['degree'] = formData['otherDegree'];
                          }
  
                          if (formData['edi_current_study']) {
                              formData['completed_date'] = null;
                          }
  
  
  
                          // var data = {
                          //     'qualification': formData['qualification'],
                          //     'completed_date': formData['completed_date'],
                          //     'qualification_provider': formData['qualification_provider'],
                          //     'degree': formData['degree']
                          // }
  
  
  
                          $http.post( GlobalConstant.EducationApi, { data: formData } )
                              .then(function(response) {
                                  //success
                                  ////console.log(response);
                                  if (response.status == 201) {
                                      alert('data saved');
                                      var data = response.data.data;
  
                                      $scope.educations.push(data);
                                      $scope.getStepData()
  
  
                                      form.find(':input:not([type="submit"])').val("");
                                      form.find(':input:not([type="submit"])').removeClass('ng-touched');
                                      form.find(':input:not([type="submit"])').addClass('ng-untouched');
                                      form.find('#edi_current_study').prop('checked', false);
                                      $scope.showEducationForm = false;;
                                      $scope.hideOther = true;
  
                                      var index = $scope.questions.indexOf('education')
                                      $scope.questions.splice(index, 1);
  
                                  }
                              }, function(response) {
                                  //Error Condition
                                  alert('Error found: Please review form');
                              });
  
                      }
  
                      // Delete Education
                      $scope.delete_education = function(id) {
                          var deleteURL = GlobalConstant.EducationApi + '/' + id;
                          $http.delete( deleteURL )
                              .then(function() {
                                  $('#edu_' + id).slideToggle();
  
                                  $scope.getStepData();
                                  ////console.log('deleted');
  
                                  // hack to remove the check icon on education view
                                  //  $scope.educations.length = $scope.educations.length - 1;
  
                              });
                      };
  
                      $scope.parse_view_date = function(date) {
                          if (!date) {
                              return null;
                          }
                          date = date.split('-');
                          date = date[2] + '-' + date[1] + '-' + date[0];
                          return date;
                      }
  
                      // Edit Education
                      $scope.EditEducation = function(data, id) {
  
                          var formData = {
                              qualification: data.qualification.id,
                              qualification_provider: data.qualification_provider.id,
                              completed_date: $scope.parse_view_date(data.completed_date),
                          };
  
                          ////console.log(formData);
                          $http.put(  GlobalConstant.EducationApi + '/' + id , { data: formData } )
                              .then(function(response) {
                                  //success
                                  alert('data saved');
                              }, function(response) {
                                  //Error Condition
                                  alert('Error found: Please review form');
                              });
  
                      }
  
                      document.EditEducation = function(obj) {
  
                          var formElm = $(obj);
                          var work_exp_id = obj.id
                          work_exp_id = work_exp_id.split('_');
                          work_exp_id = work_exp_id[2];
                          var data = [];
  
                          formElm.serializeArray().map(function(item) {
                              data[item.name] = item.value;
  
                              if (formElm.find('input[name="' + item.name + '"]').attr('data-id')) {
                                  data[item.name] = parseInt(formElm.find('input[name="' + item.name + '"]').attr('data-id'));
                              }
                          });
  
                          if (data['degree'] == 'Other') {
                              data['degree'] = data['otherDegree'];
                          }
  
                          if (data['edi_current_study']) {
                              data['completed_date'] = null;
                          }
  
  
  
                          var data = {
                              'qualification': data['qualification'],
                              'completed_date': data['completed_date'],
                              'qualification_provider': data['qualification_provider'],
                              'degree': data['degree']
                          }
  
  
                          $http.put( GlobalConstant.EducationApi + '/' + work_exp_id,  { data: data } )
                              .then(function(response) {
                                  //success
  
  
                                  var data = response.data.data;
                                  ////console.log(data);
                                  angular.forEach($scope.educations, function(v, k) {
                                      if (v.id == work_exp_id) {
                                          v.qualification.display_name = data.qualification.display_name;
                                          v.qualification.id = data.qualification.id;
                                          v.completed_date = data.completed_date;
                                          v.qualification_provider.provider_display_name = data.qualification_provider.provider_display_name;
                                          v.qualification_provider.company_logo = data.qualification_provider.company_logo;
                                          v.qualification_provider.id = data.qualification_provider.id;
                                          v.degree = data.degree;
                                      }
                                  })
  
                                  formElm.prev().removeClass('hide')
                                  formElm.addClass('hide')
  
  
                              }, function(response) {
                                  //Error Condition
                                  alert('Error found: Please review form');
                              });
  
  
                      }
  
                      // Qualification Providers (my-profile/edit, for work history autocomplete)
                      $http.get(GlobalConstant.StaticOptionsQualificationProvidersApi).then(function(response) {
                          $scope.qualificationProviders = response.data.data;
                      });
  
  
                      $scope.getSelectedDegrees = function(item) {
                          return $scope.getDegrees.indexOf(item) !== -1;
                      }
  
                      $scope.getDegrees = [
                          'High School',
                          'Associate\'s Degree',
                          'Bachelor\'s Degree',
                          'Master\'s Degree',
                          'Master of Business Administrtion (M.B.A)',
                          'Juris Doctor (J.D)',
                          'Doctor of Medicine (M.D)',
                          'Doctor of Philosophy (Ph.D)',
                          'Engineer\'s Degree',
                          'Other'
                      ];
  
                      $scope.hideOther = true;
  
                      $scope.$watch('degree', function(newVal, oldVal) {
  
                          if (angular.isUndefined(newVal) == false) {
  
                              if (newVal !== oldVal) {
  
                                  if (newVal == 'Other') {
  
  
                                      $scope.hideOther = false;
  
                                  } else {
                                      $scope.hideOther = true;
                                      $('#addEductionForm').find('input[name="otherDegree"]').val("");
                                  }
                              }
                          }
  
                      });
  
                      $scope.$watch('qualification_edu', function(newVal, oldVal) {
  
                          $scope.autoCompleteQualification(newVal);
  
                      })
  
  
                      $scope.eduQualifications = {};
                      $scope.autoCompleteQualification = function(search) {
                          $http.get( GlobalConstant.StaticOptionsAutoCompleteQualificationsApi + search )
                              .then(function(response) {
  
                                  $scope.eduQualifications = response.data.data;
  
                                  // ////console.log($scope.eduQualifications)
                                  if ($scope.eduQualifications.length) {
                                      $('#addEductionForm .auto_complete_qualifications').removeClass('ng-hide');
                                  } else {
                                      $('#addEductionForm .auto_complete_qualifications').addClass('ng-hide')
  
                                  }
  
  
                              });
                      }
  
  
                      $scope.autoCompleteQualificationEdit = function(search, targetObj) {
                          $http.get( GlobalConstant.StaticOptionsAutoCompleteQualificationsApi + search )
                              .then(function(response) {
  
                                  $scope.eduQualifications = response.data.data;
  
                                  // ////console.log($scope.eduQualifications)
                                  if ($scope.eduQualifications.length) {
  
                                      targetObj.find('.auto_complete_qualifications').removeClass('ng-hide');
                                  } else {
                                      targetObj.find('.auto_complete_qualifications').addClass('ng-hide')
  
                                  }
  
  
                              });
                      }
  
  
  
                      document.CancelEducationForm = function(obj) {
                          var parentElm = $(obj).parents('form');
                          parentElm.prev().removeClass('hide');
                          parentElm.addClass('hide');
                      }
  
  
                      document.qualificationWatch = function(obj) {
                          var targetObj = $(obj).parents('.qualification_holder');
                          var search = $(obj).val();
  
                          $scope.autoCompleteQualificationEdit(search, targetObj);
  
                      }
  
                      document.degreesrWatch = function(obj) {
                          var obj = $(obj);
                          var degree = obj.val();
                          if (degree == 'Other') {
                              obj.next().removeClass('ng-hide')
                          } else {
                              obj.next().addClass('ng-hide')
                              obj.next().find('input').val("")
                          }
  
  
                      }
  
  
                      // for provider Education
                      $(document).on("click", ".addSelectedProvider", function(event) {
                          var obj = $(this);
                          var id = obj.attr('data-id');
  
                          obj.parents('.qualification_provider_holder').find('input[type="text"]').val(obj.text());
                          obj.parents('.qualification_provider_holder').find('input[type="text"]').attr('data-id', id);
                          obj.parent().addClass('ng-hide')
                      });
                      // for Education
                      $(document).on("click", ".addAqualification", function(event) {
                          var obj = $(this);
                          var id = obj.attr('data-id');
  
                          obj.parents('.qualification_holder').find('input[type="text"]').val(obj.text());
                          obj.parents('.qualification_holder').find('input[type="text"]').attr('data-id', id);
                          obj.parent().addClass('ng-hide')
                      });
  
                      // for provider Education
                      $(document).on("keyup", ".filterQualification", function(event) {
                          var obj = $(this);
                          var value = obj.val();
                          value = value.toLowerCase();
  
                          var objContainer = obj.parents('.qualification_provider_holder');
                          var targetAutoComplete = objContainer.find('.auto_complete_education_edu');
                          if (targetAutoComplete.hasClass('ng-hide')) {
                              targetAutoComplete.removeClass('ng-hide')
                          }
  
                          targetAutoComplete.find('li').each(function(k, v) {
                              var li = $(v);
                              var text = li.text();
                              text = text.toLowerCase();
                              // ////console.log(text)
                              if (text.indexOf(value) == -1) {
                                  li.hide();
                              } else {
                                  li.show();
                              }
                              // ////console.log(text.indexOf(value))
  
                          })
                          if (!targetAutoComplete.find('li:visible').length) {
  
                              if (!targetAutoComplete.hasClass('ng-hide')) {
                                  targetAutoComplete.addClass('ng-hide')
  
                              }
  
                          }
  
  
                      });
  
                      $(document).on("keyup", ".field_of_study", function(event) {
                          var obj = $(this);
                          obj.attr('data-id', ''); // remove data-id;
  
                      });
  
  
                      $('#pmvFileModalNew').on('hidden.bs.modal', function() {
  
                          // turn this to false to avoid conflict
                          if($scope.isPortfolioSupportingDoc){
                              $scope.isPortfolioSupportingDoc = false;
                          }
                      })
  
  
  
  
                      //Upload File Portfolio
                      $scope.modal_percent_value = 0;
                       $scope.showPortfolioDoc = false;
  
                      $scope.uploadPortfolio = function() {
  
                          $scope.isPortfolioSupportingDoc = true;
  
                          fileUploadService.openModal($scope, '#pmvFileModalNew', 'portfolio');
                      }
  
                      $("#file_upload").change(function() {
                          // $scope.file_upload_modal(false,'Form_resume_upload_modal');
                          var elemId = $(this).attr('id');
                          var event = false;
                          var docFileType = 'portfolio';
                          var fileSizeLimit = 2;
  
  
                          fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit);
  
                      });
  
                      // $scope.file_save = function(e) {
                      //     var elem = $(e.currentTarget);
                      //     fileUploadService.save($scope);
                      //     ////console.log($scope.return_data)
  
                      //     $scope.PorfolioName = $scope.return_data.file_name;
                      //     $scope.getStepData()
                      // }
  
                      $scope.file_change = function() {
  
                              fileUploadService.fileChange($scope);
                          }
                          //Upload File Portfolio
  
                      //ON change of requirement check
  
                      $scope.showPhone = true;
                      $scope.showAbout = true;
                      $scope.showRef = true;
                      $scope.showEd = true;
                      $scope.showVid = true;
                      $scope.showportfolio = true;
                      $scope.showResume = true;
                      $scope.showProfileImg = true;
                      $scope.showLocation = true;
  
  
                      //watch data to regenerate array val
                      $scope.$watchCollection('[aboutfield, references, educations, work_experience]', function(newValue, oldValue) {
                          ////console.log(newValue)
                          if (newValue != oldValue) {
                              $scope.getStepData()
  
                          }
                      }, true);
  
                      console.log('questions: ', $scope.questions);
  
                      $scope.$watch('questions', function(newValue, oldValue) {
                          ////console.log(newValue.length + '/' + oldValue.length);
                          ////console.log($scope.questions);
                          if (newValue.length != oldValue.length) {
  
                              $scope.getStepData()
                              angular.forEach(newValue, function(value, key) {
                                  console.log("value: ", value);
  
                                  if (value == 'references') {
                                      $scope.showRef = false;
                                  } else if (value == 'education') {
                                      $scope.showEd = false;
                                  } else if (value == 'icebreaker_video') {
                                      $scope.showVid = false;
                                  } else if (value == 'about_me') {
                                      $scope.showAbout = false;
                                  } else if (value == 'portfolio') {
                                      $scope.showportfolio = false;
                                  } else if (value == 'work_experience') {
                                      $scope.showExp = false;
                                  } else if (value == 'resume') {
                                      $scope.showResume = false;
                                  } else if (value == 'phone_number') {
                                      $scope.showPhone = false;
                                  } else if (value == 'profile_image') {
                                      $scope.showProfileImg = false;
                                  } else if (value == 'location') { //ib
                                      $scope.showLocation = false;
                                  }
                              });
  
                          }
                      });
  
  
  
                      // Sort Date on view (work history and eduction)
                      $scope.sortDate = function(item) {
                          var date = new Date(item.date_x);
                          return date;
                      };
  
                      /*Add Work Histroy*/
                      $scope.work_history = []
                      $scope.showExp = true
                      $http.get(GlobalConstant.StaticOptionWorkTypeApi).then(function(response) {
                          $scope.work_types_wh = response.data.data;
                      });
  
                      $scope.AddWorkHistoryForm = function() {
                          $scope.showWorkHistoryForm = true;
                      };
  
                      $scope.CancelWorkHistory = function() {
                          $scope.showWorkHistoryForm = false;
                      }
                      document.CancelWorkHistory = function(obj) {
                          var parentElm = $(obj).parents('form');
                          parentElm.prev().removeClass('hide');
                          parentElm.addClass('hide');
                      }
  
                      document.openWorkHistoryEdit = function(obj) {
  
                          var workHistoryId = $(obj).attr('data-id');
                          var parentElm = $(obj).parents('.workhistory_item');
                          parentElm.find('form').removeClass('hide');
                          var work_exp_holder = $(obj).parents('.work_exp_holder');
                          work_exp_holder.addClass('hide');
                          var formElm = $('#form_whe_' + workHistoryId);
                          var industry_id = $('#form_whe_' + workHistoryId).find('select[name="industry"]').val();
                          var accountabilityStr = "";
  
                          var accountabilityStr = "";
  
                          // ////console.log('$scope.work_history')
                          // ////console.log($scope.work_history)
                          formElm.find('.provider_container').html("");
                          angular.forEach($scope.work_history, function(v, k) {
                              if (workHistoryId == v.id) {
  
                                  // accountabilities
                                  if (v.key_accountabilities.length) {
  
                                      angular.forEach(v.key_accountabilities, function(av, ak) {
  
                                          if (ak == 0) {
  
  
  
                                              accountabilityStr = '<div class="provider_container_con">\
                                              <div class="col-md-5" class="">\
                                                  <input type="text" value="' + av + '" name="key_accountabilities[]" placeholder="Key Responsibilities" class="filterQualification" rows="3">\
                                              </div>\
                                               <div class="col-md-7 row">\
                                                  <a class="add addNewProvider col-md-1 pvm-green"><span>+</span></a>\
                                              </div>\
                                              <div class="clearfix"></div>';
  
                                          } else {
  
                                              accountabilityStr = '<div class="provider_container_con">\
                                                              <div class="col-md-5" class="">\
                                                  <input type="text" value="' + av + '" name="key_accountabilities[]" placeholder="Key Responsibilities" class="filterQualification" rows="3">\
                                              </div>\
                                               <div class="col-md-7 row">\
                                                  <a class="add addNewProvider col-md-1 pvm-green"><span>+</span></a>\
                                                  <a class="add removeNewProvider col-md-1"><span>-</span></a>\
                                              </div>\
                                              <div class="clearfix"></div>';
  
                                          }
  
                                          formElm.find('.provider_container').append(accountabilityStr);
                                      })
  
                                  } else {
  
                                      accountabilityStr = '<div class="provider_container_con">\
                                              <div class="col-md-5" class="">\
                                                  <input type="text" value="" name="key_accountabilities[]" placeholder="Key Responsibilities" class="filterQualification" rows="3">\
                                              </div>\
                                               <div class="col-md-7 row">\
                                                  <a class="add addNewProvider col-md-1 pvm-green"><span>+</span></a>\
                                              </div>\
                                              <div class="clearfix"></div>';
  
                                      formElm.find('.provider_container').html(accountabilityStr);
                                  }
  
  
                                  // date
                                  if (!v.end_date) {
  
                                      formElm.find('input[name="end_date_whe"]').val("");
                                      formElm.find('#wh_current_work').prop('checked', true);
  
                                  }
  
  
  
  
                              }
                          });
  
  
                      }
  
                      $scope.numbersOnly = function(evt) {
                          evt = (evt) ? evt : window.event;
                          var charCode = (evt.which) ? evt.which : evt.keyCode;
                          if (isNaN(String.fromCharCode(charCode))) {
                              evt.preventDefault();
                          }
                      }
  
                      //Delete Work History item
                      $scope.delete = function(id) {
  
                          var deleteURL = GlobalConstant.WorkHistoryApi + '/' + id;
                          $http.delete( deleteURL )
                              .then(function() {
                                  var index =  functiontofindIndexByKeyValue($scope.work_history, 'id', id)
  
                                  if (index != -1) {
                                          $('#wh' + id).slideToggle('slow', function(){
                                          $scope.work_history.splice(index,1);
                                      });
                                  }
  
                              });
                      }
  
                      //Watch Work history list changing
                      $scope.$watchCollection('work_history', function(n, o){
  
                          if (n.length != o.length) {
                              if (n.length == 0 ){
                                  $scope.NoWorkExp =  true;
  
                              }else{
                                $scope.NoWorkExp = false
                              };
  
                          }
  
                      });
  
                      document.openEducationEdit = function(obj) {
  
                          var educationId = $(obj).attr('data-id');
                          var parentElm = $(obj).parents('.education_item');
                          parentElm.find('form').removeClass('hide');
                          var educations_holder = parentElm.find('.educations_holder');
                          educations_holder.addClass('hide');
                          var formElm = $('#edu_form_' + educationId);
  
                          // angular.forEach($scope.work_history, function(v,k){
                          var degreeElm = formElm.find('select[name="degree"]');
                          // ////console.log(degreeElm);
                          angular.forEach($scope.educations, function(v, k) {
                              if (educationId == v.id) {
  
  
                                  if (v.degree == null) {
                                      degreeElm.find('option:first').attr('selected', true);
  
                                  } else if ($scope.getSelectedDegrees(v.degree)) {
  
                                      angular.forEach(degreeElm.find('option'), function(dv, kv) {
                                          dv = $(dv);
                                          if (dv.val() == v.degree) {
                                              dv.attr('selected', true)
                                          }
                                      });
                                  } else {
                                      degreeElm.find('option:last').attr('selected', true);
                                      degreeElm.next().removeClass('ng-hide')
                                          // dv.find('option:last').attr('selected',true);
                                  }
  
                                  if (!v.completed_date) {
  
                                      formElm.find('input[name="completed_date"]').val("");
                                      formElm.find('#edi_current_study').prop('checked', true);
  
                                  }
  
                                  // ////console.log($scope.getSelectedDegrees(v.degree))
                              }
                          })
  
                      }
  
                      document.deleteProfileDoc = function(o) {
                          var o = $(o),
                              id = "";
                          var type = o.attr('data-type');
  
                          if (type == 'video') {
                              id = $scope.docs.icebreaker_video.doc_id;
                          } else if (type == 'resume') {
                              id = $scope.docs.resume.doc_id;
                          } else if (type == 'portfolio') {
                              id = $scope.docs.portfolio.doc_id;
                          }
  
  
                          var result = confirm("Want to delete your " + type + '?');
                          if (result && id) {
  
                              var deleteURL = GlobalConstant.APIRoot + 'candidate/doc/' + id;
                              $http.delete( deleteURL )
                                  .then(function(response) {
                                      ////console.log(response)
                                      if (type == 'video') {
                                          delete $scope.docs.icebreaker_video;
                                      } else if (type == 'resume') {
                                          delete $scope.docs.resume;
                                      } else if (type == 'portfolio') {
                                          delete $scope.docs.portfolio;
                                      }
  
                                  }, function() {
                                      alert('error')
                                  });
                          }
                      }
  
  
                      $scope.accountabilitiesLimit = 3;
  
                      $(document).on("click", ".addNewProvider", function(event) {
  
                          var accountabiliteis_length = $(this).parents('.provider_container').find('.provider_container_con').length;
                          if (accountabiliteis_length == 3) {
                              alert('Max of ' + $scope.accountabilitiesLimit + ' only.')
                              return false;
                          }
  
                          var strElement = '<div class="provider_container_con">\
                                              <div class="col-md-5" class="">\
                                  <input type="text" name="key_accountabilities[]" placeholder="Key Responsibility" class="filterQualification" rows="3">\
                              </div>\
                               <div class="col-md-7 row">\
                                  <a class="add addNewProvider col-md-1 pvm-green"><span>+</span></a>\
                                  <a class="add removeNewProvider col-md-1"><span>-</span></a>\
                              </div>\
                              <div class="clearfix"></div></div>';
  
  
                          $(this).parents('.provider_container').append(strElement)
  
  
                      });
  
                      $(document).on("click", ".removeNewProvider", function(event) {
  
                          $(this).parents('.provider_container_con').remove()
                      });
  
                      $scope.parseIndustriesData = function(industries, subindustries) {
                          var data = [];
                          angular.forEach($scope.all_industries, function(v, k) {
                              // ////console.log(v.id)
                              // ////console.log(industries)
                              if (industries.indexOf(v.id) != -1) {
                                  data.push(v.id);
                                  angular.forEach(v.sub, function(v1, k1) {
                                      if (subindustries.indexOf(v1.id) != -1) {
                                          data.push(v1.id)
                                      }
                                  })
                              }
                          });
  
                          return data;
                      }
  
  
                      $scope.newToWorkForce = function(v){
  
                              var formData = {
                                  "data": {
                                      new_to_workforce: v
                                  }
                              };
  
                          $http.put( GlobalConstant.profileApi, formData)
                              .then(function(response) {
  
                                  // alert('update success')
  
                                  var new_to_workforce = response.config.data.data.new_to_workforce
                                  $scope.showWorkHistoryForm = false;
  
                                  var index = $scope.questions.indexOf('work_experience');
                                  if (index != -1 && new_to_workforce == true) {
                                      $scope.questions.splice(index, 1);
                                  }else if(new_to_workforce == false){
                                      $scope.questions.push('work_experience')
                                  }
  
  
                              }, function(response) {
                                  //Error Condition
                                  // ////console.log(response);
                                  alert('some error');
                              });
  
                      };
  
  
                      $scope.endDateDisable = false;
                      $scope.currentlyWorking = function(){
                          //console.log($scope.currentlyWorkingField)
  
                           if ( $scope.currentlyWorkingField ) {
                              $scope.endDateDisable = true;
                              $scope.end_date = '';
                           }else{
                              $scope.endDateDisable = false;
                           }
  
                      }
  
                      document.AddWorkHistory = function(form) {
                          var form = $(form);
  
                          var formData = {};
                          var industries = [];
                          var subindustries = [];
                          // get user input from the form
                          $('#addworkhistoryform').serializeArray().map(function(item) {
  
                              // ////console.log(item)
  
                              if (item.name == 'salary_range') {
                                  item.name = null;
                                  item.value = null;
  
                              } else if (item.name == 'start_date_wka' || item.name == 'end_date_wka') {
  
                                  formData[item.name] = $scope.parse_view_date(item.value);
  
                              } else if (item.name == 'industries') {
                                  industries.push(parseInt(item.value));
                              } else if (item.name == 'subindustries') {
                                  subindustries.push(parseInt(item.value));
                              } else {
                                  formData[item.name] = item.value;
                              }
                          });
  
                          if (formData.wh_current_work) {
                              formData.end_date_wka = null;
                          }
  
  
  
                          var qualification_provider = form.find('#provider_container').find('input[name="key_accountabilities[]"]')
                          var qualification_provider_array = [];
  
  
                          qualification_provider.each(function(k, v) {
                              var obj = $(v);
                              var val = obj.val();
                              val = val.toLowerCase();
                              if (obj.val()) {
                                  qualification_provider_array.push(obj.val())
                              }
                          })
  
                          var data = {
                              "data": {
                                  "job_title": formData.job_title_wka,
                                  "industry": $scope.parseIndustriesData(industries, subindustries),
                                  // "industry" : industries.concat(subindustries),
                                  "company_name": formData.company_name_wka,
                                  "work_type": formData.work_type,
                                  "start_date": formData.start_date_wka,
                                  "end_date": formData.end_date_wka,
                                  "salary": formData.salary,
                                  "description": formData.job_description,
                                  "key_accountabilities": qualification_provider_array
                              }
                          }
  
  
  
                          // add work history
                          $http.post( GlobalConstant.WorkHistoryApi,   data )
                              .then(function(response) {
                                  //success
                                  if (response.status == 201) {
                                      alert('data saved');
  
                                      // reset form
                                      form.find(':input:not([type="submit"])').val("");
                                      form.find(':input:not([type="submit"])').removeClass('ng-touched');
                                      form.find(':input:not([type="submit"])').addClass('ng-untouched');
                                      form.find(':input[type="checkbox"]').prop('checked', false);
                                      $scope.hidesubindustry = true;
                                      angular.forEach(form.find('#provider_container').find('.provider_container_con'), function(v, k) {
                                          if (k > 0) {
                                              $(v).remove();
                                          }
                                      });
                                      form.find('#wh_current_work').prop('checked', false);
  
                                      $scope.work_history.push(response.data.data);
  
                                      $scope.showWorkHistoryForm = false;
                                      var index = $scope.questions.indexOf('work_experience')
                                      if (index != -1 ) {
                                          $scope.questions.splice(index, 1);
                                      }
                                      ////console.log($scope.questions)
  
                                  }
                              }, function(response) {
                                  //Error Condition
                                  alert('Error found: Please review form');
                              });
                          //var FormData = {company_name: 'test', end_date:'10-02-2016', max_salary: 11, min_salary: 22, start_date:"04-03-2016"}
  
                          //;
                      }
  
  
                      $scope.showIndustry = function(test) {
                          var selected = [];
                          //////console.log( test );
                          if (test) {
                              selected = $filter('filter')($scope.statuses, {
                                  value: test
                              });
                          }
                          // return selected.length ? selected[0].text : 'Not set';
                      }
  
                      $scope.showWorkType = function(test) {
                          var selected = [];
                          //////console.log( test );
                          if (test) {
                              selected = $filter('filter')($scope.work_types_wh, {
                                  value: test
                              });
                          }
                          // /return selected.length ? selected[0].text : 'Not set';
                      }
  
  
  
  
                      document.EditWorkHistory = function(obj) {
  
                          var formElm = $(obj);
                          var work_exp_id = obj.id
                          work_exp_id = work_exp_id.split('_');
                          work_exp_id = work_exp_id[2];
                          var data = [],
                              industries = [],
                              subindustries = [];
  
  
  
                          formElm.serializeArray().map(function(item) {
  
                              if (item.name == 'industries') {
                                  industries.push(parseInt(item.value));
                              } else if (item.name == 'subindustries') {
                                  subindustries.push(parseInt(item.value));
                              } else {
                                  data[item.name] = item.value;
                              }
  
                          });
  
  
  
                          var accountabilities = formElm.find('input[name="key_accountabilities[]"]')
                          var accountabilities_array = [];
  
                          accountabilities.each(function(k, v) {
                              var obj = $(v);
                              var val = obj.val();
                              val = val.toLowerCase();
                              if (obj.val()) {
                                  accountabilities_array.push(obj.val())
                              }
                          })
  
  
                          if (data.wh_current_work) {
                              data.end_date_whe = null;
                          }
  
  
                          var formData = {
                              company_name: data.company_name_whe,
                              work_type: data.work_type,
                              industry: $scope.parseIndustriesData(industries, subindustries),
                              // industry : industries.concat(subindustries),
                              start_date: $scope.parse_view_date(data.start_date_whe),
                              end_date: $scope.parse_view_date(data.end_date_whe),
                              salary: data.salary,
                              key_accountabilities: accountabilities_array,
                              description: data.job_description,
                              job_title: data.job_title_whe
  
                          };
  
  
  
  
                          $http.put( GlobalConstant.WorkHistoryApi + '/' + work_exp_id ,  { data: formData } )
                              .then(function(response) {
                                  //success
                                  // ////console.log(response.data.data);
  
                                  var result = response.data.data;
                                  // ////console.log(result.key_accountabilities);
                                  ////console.log('result')
                                  ////console.log(result)
  
                                  var content = formElm.prev();
  
  
                                  angular.forEach($scope.work_history, function(v, k) {
                                      if (work_exp_id == v.id) {
                                          $scope.work_history[k].company_name = result.company_name;
                                          $scope.work_history[k].job_title = result.job_title;
                                          $scope.work_history[k].salary = result.salary;
                                          $scope.work_history[k].description = result.description;
                                          $scope.work_history[k].key_accountabilities = result.key_accountabilities;
                                          $scope.work_history[k].start_date = result.start_date;
                                          $scope.work_history[k].end_date = result.end_date;
                                          $scope.work_history[k].display_date = result.display_date;
  
                                          // work type
                                          angular.forEach($scope.work_types_wh, function(val, key) {
                                              if (result.work_type == val.id) {
                                                  $scope.work_history[k].work_type = {
                                                      id: result.work_type,
                                                      display_name: val.display_name
                                                  }
                                              }
                                          })
  
                                          $scope.work_history[k].industries_display = result.industries_display;
  
  
                                      }
                                  });
  
                                  // show content
                                  content.removeClass('hide');
                                  // hide form
                                  formElm.addClass('hide');
  
  
  
  
                                  // alert('data saved');
                              }, function(response) {
                                  //Error Condition
                                  alert('Error found: Please review form');
                              });
  
  
                      }
  
                      // All industries (Profile edit page)
                      $http.get( GlobalConstant.APIRoot + 'static/options/industries/all')
                      .then(function(response) {
                          var data = response.data.data;
                          $scope.all_industries = data;
                          // ////console.log($scope.all_industries)
                      });
  
                      document.hoverIndustry = function(obj) {
                          var checkbox = $(obj).find('input[name="industries"]')[0];
                          document.industry_selected(checkbox)
                      }
  
  
                      document.industry_selected = function(obj) {
                          var obj = $(obj);
                          obj.parents('ul').find('.all_industry').removeClass('pvm-light-gray-background');
                          obj.parent().addClass('pvm-light-gray-background');
                          var sub_industry = obj.parent().find('.sub_industry_multi_holder').clone();
  
                          obj.parents('.industry_multi_main').next().find('.sub_industry_holder').html(sub_industry);
                          obj.parents('.industry_multi_main').next().find('.sub_industry_holder').find('.sub_industry_multi_holder').removeClass('hide');
                          $('.sub_industry_multi_holder').TrackpadScrollEmulator();
  
                      }
  
                      $scope.onHoverSubIndustries = true;
  
                      document.showSubIndustries = function(obj) {
                          $scope.onHoverSubIndustries = true;
                          if (obj) {
                              $(obj).parent().find('.subindustry_multi_main').removeClass('hide')
                          }
                      }
  
                      document.hideSubIndustries = function(obj) {
                          $scope.onHoverSubIndustries = false;
                          setTimeout(function() {
                              if ($scope.onHoverSubIndustries == false) {
                                  $(obj).find('.subindustry_multi_main').addClass('hide');
                              }
                          }, 1500);
                      }
  
                      document.sub_industry_selected = function(obj) {
                          var obj = $(obj);
                          var sub_industry = obj.parents('ul').clone();
                          var industry_id = obj.parents('.sub_industry_multi_holder').attr('data-id');
  
                          // force checked industry
                          obj.parents('.subindustry_multi_main').prev().find('#industry_' + industry_id + ' > input').prop('checked', true)
                              // force checked/unchecked original subindustry
                          obj.parents('.subindustry_multi_main').prev().find('.sub_' + industry_id).html(sub_industry);
  
                      }
  
                      document.sub_check_all = function(o) {
                          var obj = $(o);
                          obj.parents('ul').next().find('input').prop('checked', o.checked);
                          document.sub_industry_selected(obj.parents('ul').next().find('input:first')[0]);
                      }
  
                      document.subLabel = function(o) {
                          $(o).prev().click();
                      }
  
                      //End Work History
  
  
  
                      if ($('.section_container .tse-scroll-content').length) {
  
                          $(".tse-scroll-content").scroll(function() {
                              var getHash = window.location.hash.substring(1)
                              var obj = $(this);
  
                              if (obj.scrollTop() === 0) {
  
                                  if ($scope.more_present) {
                                      getHash = getHash.split('/')
                                      getHash.shift();
  
                                      var offset = messageScrollCounter * 20;
  
                                      $scope.getMessageThreads(getHash[1], offset)
  
  
                                  }
  
                                  messageScrollCounter++;
  
                              }
                          });
  
                      }
  
  
                      if (jobObjectId) {
                          var redirect_obj_id = '&job_id=' + jobObjectId
                      } else {
                          var redirect_obj_id = ''
                      }
  
                      if ($scope.nextStep) {
                          var redirect_nxt_stp = '&next_step=' + $scope.nextStep
                      } else {
                          var redirect_nxt_stp = '';
                      }
  
                      $scope.notcomplete = true;
                      $scope.questions = [];
                      $scope.SubmitRequirementCheck = function() {
                        if ($scope.questions.length > 0) {
                          if ($scope.profile_image || $scope.showResume || $scope.showportfolio || $scope.showVid) {
                            location.reload();
                            $scope.notcomplete = true;
                          } else {
                            $scope.notcomplete = false;
                          }
  
                        } else {
                            var submitdata = {
                              data: $scope.questions
                            }
                            $http.post(GlobalConstant.CandidateRootApi + '/application/' + jobObjectId + '/' + ApplicationId + '/' + $scope.nextStep , submitdata)
                            .then(function(response) {
                              //console.log(response.data.data)
                              $scope.questions = response.data.data;
                              $cookies.put('nextStep', response.data.data.next_step, {
                                  'path': '/'
                              });
                              $window.location.href = base_url + 'job/application?id=' + ApplicationId + redirect_obj_id + '&next_step=' + response.data.data.next_step;
                            });
                        }
                          //console.log($scope.questions.length)
                      };
  
                  } else if ($scope.nextStep == 'application_questions') {
                      $scope.preapply = false;
                      $scope.requirementcheck = false;
                      $scope.applicationquestions = true;
                      $scope.success = false;
                      $scope.fail = false;
                      $scope.notcomplete = true;
  
                      $scope.appQuestion = [];
                      $scope.appQuestion.answer = {}
                          //Upload File Portfolio
  
                      $scope.modal_percent_value = 0;
                      $scope.UploadQuestion = -1;
                      $scope.uploadDoument = function(fieldId) {
                          $scope.UploadQuestion = fieldId;
                          fileUploadService.openModal($scope, '#pmvFileModalNew', 'resume');
  
  
                      }
  
                      $scope.$watch('UploadQuestion', function(n, o) {
  
                          if (n != o) {
                              $scope.selectedFieldId = n
                          }
                      })
  
                      $("#file_upload").change(function() {
                          // $scope.file_upload_modal(false,'Form_resume_upload_modal');
                          var elemId = $(this).attr('id');
                          var event = false;
                          var docFileType = 'portfolio';
                          var fileSizeLimit = 2;
  
  
                          fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit);
  
                      });
  
  
  
                      // step 3
                      $scope.file_save = function(e) {
  
                          var elem = $(e.currentTarget);
                          $scope.is_candidate_question = true;
                          fileUploadService.save($scope);
  
                          $scope.DocumentName = $scope.return_data.url;
  
                          function getName(s) {
                              return s.replace(/^.*[\\\/]/, '');
                          }
  
  
                          var url = $scope.DocumentName;
                          var filename = getName(url);
                          var filetype = filename.split('.')
                          angular.forEach(filetype, function(v, k) {
                              $scope.testitem = v;
                          })
  
                          var fileupload = {
                              "doc_url": $scope.return_data.url,
                              "doc_file_type": $scope.testitem,
                              "doc_filename": getName(url)
                          }
  
                          // show file link of view (job/application?id Step 3)
                          $('#file_data_'+$scope.UploadQuestion).removeClass('hide');
                          $('#file_data_'+$scope.UploadQuestion).find('a').attr('href',url);
  
                          //$scope.appQuestion.answer[$scope.selectedFieldId].url = 'aaa'
                          $scope.appQuestion.answer[$scope.selectedFieldId] = angular.fromJson(fileupload)
  
  
                      }
  
                      $scope.file_change = function() {
                          fileUploadService.fileChange($scope);
                      }
                          //Upload File Portfolio
  
  
                      $scope.SubmitApplicationQuestion = function() {
                          $scope.appQuestionSubmitted = [];
  
                          //console.log($scope.appQuestion.answer)
  
                          angular.forEach($scope.appQuestion.answer, function(val, key) {
                              // var data = {question_id: key, answer: val }
                              // $scope.appQuestionSubmitted.push()
  
                              if (typeof(val) == "object") {
                                  ////console.log('object')
                                  ////console.log(val)
                                      //
                                  var savemulti = []
                                  angular.forEach(val.multi, function(va, ke) {
                                      savemulti.push(va);
                                  });
                                  //////console.log(savemulti)
                                  if (val.multi) {
                                      var data = {
                                          question_id: parseInt(key),
                                          answer: savemulti
                                      }
                                  }
  
                                  if (!val.multi) {
                                      var data = {
                                          question_id: parseInt(key),
                                          answer: val
                                      }
                                  }
                              } else {
                                  ////console.log('not object')
                                  var data = {
                                      question_id: parseInt(key),
                                      answer: val
                                  }
                              }
  
                              $scope.appQuestionSubmitted.push(data)
  
                          });
  
                          var data = {
                              data: $scope.appQuestionSubmitted
                          };
  
  
                          if (jobObjectId) {
                              var redirect_obj_id = '&job_id=' + jobObjectId
                          } else {
                              var redirect_obj_id = ''
                          }
  
  
  
  
                          $http.post(GlobalConstant.CandidateRootApi + '/application/' + jobObjectId + '/' + ApplicationId + '/' + $scope.nextStep , data)
                              .then(function(response) {
                                  ////console.log(response.data.data)
                                  $scope.questions = response.data.data;
                                  console.log('$scope.questions response: ', $scope.questions);
  
                                  $cookies.put('nextStep', response.data.data.next_step, {
                                      'path': '/'
                                  });
  
                                  ////console.log('dito.')
                                  ////console.log($scope.questions)
  
                                  if ($scope.questions.extra_data) {
  
                                      var extra_data = JSON.stringify($scope.questions.extra_data);
                                      $.ajax({
                                          url: GlobalConstant.FileUploadUrl + "/update_question_data",
                                          data: {
                                              data: extra_data
                                          },
                                          type: 'post'
                                      }).done(function() {
  
                                          $window.location.href = base_url + 'job/application?id=' + ApplicationId + redirect_obj_id;
                                      })
  
                                  } else {
                                      $window.location.href = base_url + 'job/application?id=' + ApplicationId + redirect_obj_id;
                                  }
  
  
                              });
  
                          // delete last id from fileuploadjobs table
                          if ($scope.last_id) {
                              delete $scope.last_id;
                          }
  
  
                      }
  
  
                  } else if ($scope.nextStep == 'applied') {
                      //CLEAR SOME COOKIES
                      /*scope.showsections = {
                          preapply: false,
                          requirementcheck: false,
                          applicationquestions: false,
                          success: true,
                          fail: false
                      };*/
  
                      $http.get(GlobalConstant.CandidateJobWatchlistApi + '/' + jobObjectId )
                          .then(function(response) {
                              $scope.watchlistStat = response.data.data.watchlist;
                              ////console.log(response.data.data)
  
                          });
                      $scope.preload = true
                          //Watchlist
                      $scope.watchList = function(e) {
                          $scope.preload = false;
                          ////console.log(e)
                          var obj = $(e.currentTarget);
                          $http.post(GlobalConstant.CandidateJobWatchlistApi + '/' + jobObjectId ).then(function(response) {
                              $scope.preload = true
                              $scope.watchlistStat = response.data.data.watchlist
  
  
  
  
                          }, function errorCallback(response) {});
                      }
  
                  } else if ($scope.nextStep == 'rejected') {
                      //CLEAR SOME COOKIES
                      ////console.log($scope.nextStep)
  
                      $scope.follow_company = $cookies.get('applied_company');
  
  
  
                      $http.get(GlobalConstant.JobsApi + '/' + $cookies.get('jobObjectId'))
                          .then(function(response) {
  
                              $scope.follow_company_link = base_url + 'company/' + response.data.data.company.company_url
  
  
                          });
  
                      /*$scope.showsections = {
                          preapply: false,
                          requirementcheck: false,
                          applicationquestions: false,
                          success: false,
                          fail: true
                      };*/
  
                  }
  
  
  
              } else {
                  $scope.noerror = true;
                  $scope.ErrorMsg = "You haven't selected a job yet!"
                  ////console.log('Display error on application page');
              }
  
  
  
  
          } else {
              //Redirect back to login
              window.location.href = base_url + 'login';
          }
  
  
  
  
          //VIdeo Modal
          // Save to Azure
          $scope.save_file = function(e) {
  
              var elem = $(e.currentTarget);
  
              var filename = elem.attr('data-filename');
              var folder = elem.attr('data-folder');
  
              $.ajax({
                  url: GlobalConstant.accountPage + "/upload_to_cloud",
                  method: 'post',
                  data: {
                      filename: filename,
                      folder: folder,
                      obkey: $cookies.get('obkey')
                  },
                  dataType: 'json',
                  success: function(data) {
  
                      if (data.response == 200) {
                          $('.profile_img').attr('src', data.url)
                          alert('Data has been saved.');
                          elem.attr('data-filename', '');
                          elem.attr('data-folder', '');
  
                          if (elem.attr('id') == 'resume_save' && $('#Form_my_file').text() == 'RESUME') {
                              // $('#Form_my_file').text('RESUME/CHANGE');
                          }
  
                      }
                  }
  
              });
  
          }
  
          $scope.delete_old_file = function(file, folder) {
  
              $.ajax({
                  url: GlobalConstant.accountPage + "/delete_recorded_video",
                  method: 'post',
                  data: {
                      filename: file,
                      file_folder: folder
                  },
                  success: function(data) {
                      // reset target attributes
                      $('#preview').attr('data-old_file', "");
                      $('#preview').attr('data-file_folder', "");
                      $('#preview_img_new').attr('data-old_file', "");
                      $('#preview_img_new').attr('data-file_folder', "");
                      $('#resume_save').attr('data-folder', '');
                      $('#resume_save').attr('data-filename', '');
                      $('#image_save').attr('data-folder', '');
                      $('#image_save').attr('data-filename', '');
                      $('#portfolio_save').attr('data-folder', '');
                      $('#portfolio_save').attr('data-filename', '');
                  }
  
              });
  
  
          }
  
  
          $scope.video_upload_modal = function(argument, evt) {
  
              var fileField = document.getElementById("Form_video_upload_modal");
              // alert(argument);
              // target file field for mobile
              $scope.modal_percent_value = 0;
  
  
              if ($scope.mobile_agent && argument != 'file_upload') {
                  fileField = document.getElementById("mobile_camera_capture");
              } else if (evt) {
                  fileField = evt.dataTransfer;
              }
  
              var preview = document.getElementById("preview");
  
              var record = document.getElementById('record');
              var stop = document.getElementById('stop');
              var save = document.getElementById('save');
              save.disabled = false;
  
              if (!$('#save').hasClass('ng-hide')) {
                  $('#save').addClass('ng-hide');
              }
  
              if (!$('#stop').hasClass('ng-hide')) {
                  $('#stop').addClass('ng-hide');
  
              }
              if (!$('#record').hasClass('ng-hide')) {
                  $('#record').addClass('ng-hide');
              }
  
              // delete old upload video
              if ($('#preview').attr('data-old_file')) {
                  var filename = $('#preview').attr('data-old_file');
                  var folder = $('#preview').attr('data-file_folder');
                  $scope.delete_old_file(filename, folder);
                  // $('#preview').attr('data-old_file', "");
                  // $('#preview').attr('data-file_folder', "");
              }
  
  
              var fileToUpload = fileField.files[0];
              var ob_key = $('#Form_video_upload_modal').data('ob_key');
              var d = new Date();
              var n = d.getTime();
              var filename = n + '_' + fileToUpload.name;
              var upload_folder = 'Video';
  
              if ($scope.mobile_agent) {
                  filename = 'camera_' + filename;
                  upload_folder = 'Camera';
                  // $('#mobile_camera_capture').attr('data-old_file', filename);
              } else {
                  // $('#Form_video_upload_modal').attr('data-old_file', filename);
              }
  
              // ////console.log(filename); return false;
              var allowed_files = ['mp4', 'wma', 'mpg', 'mpeg', 'wmv', 'avi', 'mov'];
  
              var last_dot = filename.lastIndexOf('.');
              var ext = filename.substr(last_dot + 1).toLowerCase();
  
              if (allowed_files.indexOf(ext) == -1) {
                  alert("Invalid Video file must be 'mp4','wma','mpg','mpeg','wav','avi' extension");
                  return false;
              }
  
              var oneMb = 1048576;
              var videoSizeLimit = 150;
              if(Math.ceil(fileToUpload.size / oneMb) > videoSizeLimit){
                  alert('Max video limit must be '+videoSizeLimit+'mb in size.');
                   return false;
              }
  
  
              var chunksize = 1000000 // 1MB
              var chunks = Math.ceil(chunksize / fileToUpload.size);
              chunks = chunks > 1 ? 1 : chunks;
  
  
              preview.src = '';
              preview.poster = '';
  
  
              if ($('#modal_percent').hasClass('hidden')) {
                  $('#modal_percent').removeClass('hidden');
              }
  
              var uploadChunk = function(fileToUpload, chunk) {
                  var xhr = new XMLHttpRequest();
                  var uploadStatus = xhr.upload;
  
                  uploadStatus.addEventListener("progress", function(ev) {
                      if (ev.lengthComputable) {
                          var percent = Math.ceil((ev.loaded / ev.total) * 100);
                          $scope.modal_percent_value = percent;
  
                      }
                  }, false);
  
  
                  xhr.addEventListener('readystatechange', function(e) {
  
                      if (this.readyState === 4) {
  
                          if ($('#save').hasClass('ng-hide')) {
                              $('#save').removeClass('ng-hide');
                          }
  
                          if (!$('#modal_percent').hasClass('hidden')) {
                              $('#modal_percent').addClass('hidden');
                          }
  
  
                          var rewrite_filename = filename.split(' ');
                          rewrite_filename = rewrite_filename.join('_');
  
  
                          preview.src = 'assets/Uploads/' + upload_folder + '/' + rewrite_filename;
                          // preview.poster = '';
                          preview.play();
                          preview.muted = false;
                          // $scope.progressValue2 = 0;
                          // $('#video_progress_modal').addClass('ng-hide');
                          $('#save').attr('data-save_type', 'video');
                          save.disabled = false;
                          record.disabled = true;
  
                          $('#preview').attr('data-old_file', rewrite_filename);
                          $('#preview').attr('data-file_folder', upload_folder);
  
                      }
                  });
  
                  var start = chunksize * chunk;
                  var end = start + (chunksize - 1)
                  if (end >= fileToUpload.size) {
                      end = fileToUpload.size - 1;
                  }
                  var params = '?file_folder=' + upload_folder;
                  xhr.open("POST", GlobalConstant.accountPage + "/video_upload_submit" + params, true);
                  xhr.setRequestHeader("Cache-Control", "no-cache");
                  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                  // xhr.setRequestHeader("Content-Type", "multipart/form-data");
                  // xhr.setRequestHeader("content-type","multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2));
                  xhr.setRequestHeader("X-File-Name", filename);
                  xhr.setRequestHeader("X-File-Size", fileToUpload.size);
                  xhr.setRequestHeader("X-File-Type", fileToUpload.type);
                  xhr.setRequestHeader("Content-Range", start + "-" + end + "/" + fileToUpload.size);
                  xhr.send(fileToUpload);
  
              }
  
              for (var c = 0; c < chunks; c++) {
                  uploadChunk(fileToUpload, c);
              }
  
          }
  
          $scope.video_upload = function(evt) {
              //console.log('a');
  
                      var fileField = document.getElementById("Form_video_upload");
                      var fileToUpload = fileField.files[0];
                      var ob_key = $cookies.get('obkey');
                      if (evt) {
                          fileToUpload = evt.dataTransfer.files[0];
                      }
  
                      var d = new Date();
                      var n = d.getTime();
                      var filename = n + '_' + fileToUpload.name;
                      var allowed_files = ['mp4', 'wma', 'mpg', 'mpeg', 'wmv', 'avi', 'mov'];
  
                      var last_dot = filename.lastIndexOf('.');
                      var ext = filename.substr(last_dot + 1).toLowerCase();
                      if (allowed_files.indexOf(ext) == -1) {
                          alert("Invalid Video file must be 'mp4','wma','mpg','mpeg','wav','avi' extension");
  
                          return false;
                      }
  
                      var chunksize = 1000000 // 1MB
                      var chunks = Math.ceil(chunksize / fileToUpload.size);
                      chunks = chunks > 1 ? 1 : chunks;
  
                      if ($('#video_progress').hasClass('ng-hide')) {
                          $('#video_progress').removeClass('ng-hide');
                      }
  
                      var uploadChunk = function(fileToUpload, chunk) {
                          var xhr = new XMLHttpRequest();
                          var uploadStatus = xhr.upload;
  
                          uploadStatus.addEventListener("progress", function(ev) {
                              if (ev.lengthComputable) {
  
                                  var percent = Math.ceil((ev.loaded / ev.total) * 100);
  
                                  $scope.progressValue = percent;
  
                              }
                          }, false);
  
                          uploadStatus.addEventListener("error", function(ev) {
                              $("#error").html(ev)
                          }, false);
                          uploadStatus.addEventListener("load", function(ev) {
                              $("#error").html("uploading file to server, please wait...")
                          }, false);
  
                          xhr.addEventListener('readystatechange', function(e) {
  
                              if (this.readyState === 4) {
                                  $.ajax({
                                      url: GlobalConstant.accountPage + '/save_uploaded_file',
                                      type: 'post',
                                      data: {
                                          filename: filename,
                                          doc_type: 'icebreaker_video',
                                          ob_key: ob_key,
                                          token_id: token_id
                                      },
                                      success: function(data) {
  
                                          if (data) {
                                              $scope.progressValue = 0;
                                              $('#video_progress').addClass('ng-hide');
                                              $('#video_placeholder').attr('src', 'themes/bbt/images/placeholder_encoding.png');
                                          } else {
                                              alert('Internal error.');
                                          }
                                          fileField.value = "";
  
                                      }
  
                                  });
                              }
                          });
  
                          var start = chunksize * chunk;
                          var end = start + (chunksize - 1)
                          if (end >= fileToUpload.size) {
                              end = fileToUpload.size - 1;
                          }
                          var params = '?file_folder=video';
                          xhr.open("POST", GlobalConstant.accountPage + "/video_upload_submit" + params, true);
                          xhr.setRequestHeader("Cache-Control", "no-cache");
                          xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                          // xhr.setRequestHeader("Content-Type", "multipart/form-data");
                          // xhr.setRequestHeader("content-type","multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2));
                          xhr.setRequestHeader("X-File-Name", filename);
                          xhr.setRequestHeader("X-File-Size", fileToUpload.size);
                          xhr.setRequestHeader("X-File-Type", fileToUpload.type);
                          xhr.setRequestHeader("Content-Range", start + "-" + end + "/" + fileToUpload.size);
                          xhr.send(fileToUpload);
  
                      }
  
                      for (var c = 0; c < chunks; c++) {
                          uploadChunk(fileToUpload, c);
                      }
  
          }
  
  
          document.dropVideoModalNew = function(ev) {
              ev.preventDefault();
              $scope.ondragoverout_image = false;
              $scope.ondragover_image = true;
              $scope.new_video_upload_modal('', ev);
          }
  
          document.allowDrop = function(ev) {
              ev.preventDefault();
              $scope.ondragoverout_image = true;
              $scope.ondragover_image = false;
          }
  
          document.leaveIt = function(ev) {
              $scope.ondragoverout_image = false;
              $scope.ondragover_image = true;
          }
  
          document.dropFileModalNew = function(ev) {
              ev.preventDefault();
              var elemId = $(this).attr('id');
              var event = ev;
              var docFileType = $('#pmvFileModalNew').attr('data-docFileType');
              var fileSizeLimit = 3;
              fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit);
          }
  
          $('#image_upload_modal_new').change(function() {
                  $scope.new_image_upload_modal();
          })
  
  
          // Video Modal buttons/sections/percent
  
          $('#video_upload_modal_new').change(function() {
              $scope.new_video_upload_modal('video_upload_modal_new');
          })
  
  
          fileUploadService.initParams($scope);
  
  
          $scope.buttonsHideShow = function(a, b, c, d, e) {
              $scope.record_btn = a;
              $scope.record_again_btn = b;
              $scope.stop_btn = c;
              $scope.save_btn = d;
              $scope.change_btn = e;
          }
  
          $scope.sectionsHideShow = function(a, b) {
              $scope.showSection1 = a;
              $scope.showSection2 = b;
          }
  
        function checkBrowsers() {
          var nVer = navigator.appVersion;
          var nAgt = navigator.userAgent;
          $scope.browserName  = navigator.appName;
          var fullVersion  = ''+parseFloat(navigator.appVersion);
          var majorVersion = parseInt(navigator.appVersion,10);
          var nameOffset,verOffset,ix;
  
          // In Opera, the true version is after "Opera" or after "Version"
          if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
            $scope.browserName = "Opera";
            fullVersion = nAgt.substring(verOffset+6);
            if ((verOffset=nAgt.indexOf("Version"))!=-1)
              fullVersion = nAgt.substring(verOffset+8);
          }
          // In MSIE, the true version is after "MSIE" in userAgent
          else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
            $scope.browserName = "IE";
            fullVersion = nAgt.substring(verOffset+5);
          }
          // In Chrome, the true version is after "Chrome"
          else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
            $scope.browserName = "Chrome";
            fullVersion = nAgt.substring(verOffset+7);
          }
          // In Safari, the true version is after "Safari" or after "Version"
          else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
            $scope.browserName = "Safari";
            fullVersion = nAgt.substring(verOffset+7);
            if ((verOffset=nAgt.indexOf("Version"))!=-1)
              fullVersion = nAgt.substring(verOffset+8);
          }
          // In Firefox, the true version is after "Firefox"
          else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
            $scope.browserName = "Firefox";
            fullVersion = nAgt.substring(verOffset+8);
          }
          // In most other browsers, "name/version" is at the end of userAgent
          else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) <
              (verOffset=nAgt.lastIndexOf('/')) )
          {
            $scope.browserName = nAgt.substring(nameOffset,verOffset);
            fullVersion = nAgt.substring(verOffset+1);
            if (browserName.toLowerCase()==browserName.toUpperCase()) {
              $scope.browserName = navigator.appName;
            }
          }
          // trim the fullVersion string at semicolon/space if present
          if ((ix=fullVersion.indexOf(";"))!=-1)
            fullVersion=fullVersion.substring(0,ix);
          if ((ix=fullVersion.indexOf(" "))!=-1)
            fullVersion=fullVersion.substring(0,ix);
  
          majorVersion = parseInt(''+fullVersion,10);
          if (isNaN(majorVersion)) {
            fullVersion  = ''+parseFloat(navigator.appVersion);
            majorVersion = parseInt(navigator.appVersion,10);
          }
  
          $('body').addClass($scope.browserName + ' ' + $scope.browserName + '-' + majorVersion);
        }
  
          $scope.startVideo = function() {
            checkBrowsers();
                  if($scope.isSafari || $scope.browserName == "Safari") {
                      // alert('Oh oh looks like your\'re using Safari! Use Chrome or Firefox to record a video using your webcam.');
                      alert('Oh oh this feature is not yet supported by your browser. Drag and drop a video file instead, or use Chrome, Firefox or Microsoft Edge to record a video using your webcam.');
                  } else{
                       fileUploadService.startVideo($scope);
                  }
          }
  
          $scope.recordVideo = function() {
              fileUploadService.recordVideo($scope);
          }
  
          $scope.stopVideo = function() {
              fileUploadService.stopVideo($scope);
          }
  
   // var index = $scope.questions.indexOf('icebreaker_video')
   //                    $scope.questions.splice(index, 1);
  
          $scope.videomgs = false;
          $scope.saveVideo = function() {
  
  
              if ($scope.doc_type == 'icebreaker_video') {
                  /*var data = {
                  //     "data": {
                  //         // "doc_url": "https://previewmedev.streaming.mediaservices.windows.net/c0d90bfc-1f1c-484c-be14-45852669128c/camera_120740530.ism/manifest",
                  //         "doc_url": "",
                  //         "doc_file_type": "video",
                  //         "doc_type": "icebreaker_video",
                  //         "doc_filename": "someth gile name"
                  //     }
                  // }
  
                  // $http.post( GlobalConstant.CandidateRootApi + '/doc',  data )
                  // .then(function(response) {
                  //     fileUploadService.saveVideo($scope);
                  //     alert('Video Saved')
                  //     var index = $scope.questions.indexOf('icebreaker_video')
                  //     $scope.questions.splice(index, 1);
                  //     $scope.videomgs = true;
                  // }, function(response) {
                  //     alert('error')
  
                  // })
                  $('#video_placeholder').attr('src', 'themes/bbt/images/video_preload.gif');*/
                  $('#video_placeholder').attr('src', 'themes/bbt/images/ajax-loader-video.gif').css({'width':'106px', 'text-align':'center', 'margin':'20px 40px' });
                  fileUploadService.saveVideo($scope, 'candidate_profile_edit');
              } else {
  
  
                  if ($scope.nextStep == 'requirements_check') {
                      ////console.log('requirements_check')
                      var index = $scope.questions.indexOf('icebreaker_video')
                      $scope.questions.splice(index, 1);
                      ////console.log($scope.questions)
                  // }else if($scope.nextStep == 'application_questions') {
                  }
  
                  // if element if exist, replaced default image to video loading
                  if($scope.question_id){
                       $('#video_placeholder_'+$scope.question_id).attr('src', 'themes/bbt/images/ajax-loader-video.gif').css({'width':'106px', 'text-align':'center', 'margin':'20px 40px' });
                       $('.videomgs'+$scope.question_id  ).show();
                  }
  
                  var origin = 'application';
                  var data = {'application_id': getUrlParameter('id'), 'question_id': $scope.question_id};
                  fileUploadService.saveVideo($scope, origin, data);
  
              }
  
          }
  
          $scope.recordVideoAgain = function() {
              $scope.buttonsHideShow(false, true, true, true, true);
              //$scope.recordVideo();
          }
  
          $scope.openVideoModal = function(question_id, doc_type) {
              $('#pmvCameraModalNew').modal('show');
              $scope.doc_type = doc_type;
              $scope.question_id = question_id;
  
          }
  
  
  
          $scope.changeVideo = function() {
  
              fileUploadService.changeVideo($scope);
  
  
          }
  
          // Submit recorded video/audio
          var PostBlob = function(audioBlob, videoBlob, fileName) {
  
              var formData = new FormData();
              formData.append('filename', fileName);
              formData.append('audio-blob', audioBlob);
              formData.append('video-blob', videoBlob);
  
  
              var params = "?ob_key=" + $cookies.get('obkey') +
                  "&doc_type=icebreaker_video" +
                  "&token_id=" + token_id +
                  "&file_folder=camera";
  
              xhrVideo(
                  GlobalConstant.accountPage + "/camera_upload_submit" + params,
                  formData,
                  fileName
              );
          }
  
  
          // Ajax request for recorded video/audio
          var xhrVideo = function(url, formData, filename, callback) {
              var request = new XMLHttpRequest();
              var uploadStatus = request.upload;
  
              uploadStatus.addEventListener("progress", function(ev) {
                  if (ev.lengthComputable) {
                      $scope.modal_percent_value = Math.ceil((ev.loaded / ev.total) * 100);
                  }
              }, false);
  
              request.onreadystatechange = function() {
  
                  if (request.readyState == 4 && request.status == 200) {
  
  
                      // hide percent progress
                      //      if(!$('#modal_percent').hasClass('hidden')){
                      //  $('#modal_percent').addClass('hidden');
                      // }
  
                      $scope.modal_percent = true;
  
                      if ($('#pmvCameraModal').data('bs.modal')) {
                          $('#save').attr('data-recorded', filename);
                          $('#preview').attr('data-old_file', filename);
                          $('#preview').attr('data-file_folder', 'camera');
  
                      } else if ($('#pmvCameraModalNew').data('bs.modal')) {
                          $('#save_btn').attr('data-recorded', filename);
                          $('#preview_new').attr('data-old_file', filename);
                          $('#preview_new').attr('data-file_folder', 'camera');
  
                      }
  
                      if (request.responseText == 500) {
                          alert('Error: Video not upload, please try again');
                          return false;
                      }
  
  
                      postBlobCallBack(filename);
  
  
                  }
              };
  
              request.open('POST', url);
              request.send(formData);
          }
  
          var postBlobCallBack = function(filename) {
  
              var ob_key = $cookies.get('obkey');
              var doc_type = 'icebreaker_video';
              // var filename = $('#record').attr('data-recorded');
  
              $.ajax({
                  url: GlobalConstant.accountPage + "/save_uploaded_file",
                  'type': 'post',
                  data: {
                      filename: filename,
                      ob_key: ob_key,
                      doc_type: doc_type,
                      token_id: token_id
                  },
                  success: function(data) {
  
                      alert('Video has been saved.')
  
                      if ($('#pmvCameraModal').data('bs.modal')) {
                          $('#save').attr('data-save_type', '')
                          $('#save').attr('data-recorded', '')
                          $('#pmvCameraModal').modal('hide');
  
                      } else if ($('#pmvCameraModalNew').data('bs.modal')) {
                          $('#save_btn').attr('data-save_type', '')
                          $('#save_btn').attr('data-recorded', '')
                          $('#pmvCameraModalNew').modal('hide');
  
                      }
  
                  }
              })
  
          }
  
          //Check Modal if there is a successful upload
          $('#pmvCameraModalNew').on('hidden.bs.modal', function () {
              var  AzureresponsoHandler = JSON.parse  ( localStorage.getItem('VideoUploadResponseData') );
  
              $('.successUpload').hide();
  
              if ($scope.doc_type == 'question' ) {
                  if (angular.isDefined(AzureresponsoHandler) && AzureresponsoHandler != null ) {
  
                      var questionId = AzureresponsoHandler.data.question_id
  
                      $('input[name=test_'+questionId+']').val(1);
                      $scope.appQuestion.answer[questionId] = 1;
  
                      $('#video_placeholder_'+$scope.question_id).attr('src', 'themes/bbt/images/ajax-loader-video.gif').css({'width':'106px', 'text-align':'center', 'margin':'20px 40px' });
                      $('.videomgs'+questionId).show()
  
                      localStorage.removeItem('VideoUploadResponseData') ;
  
                  }
              }else if ($scope.doc_type == 'icebreaker_video') {
  
                  if (angular.isDefined(AzureresponsoHandler) && AzureresponsoHandler != null ) {
  
                      $('#video_placeholder').attr('src', 'themes/bbt/images/ajax-loader-video.gif').css({'width':'106px' });
  
                      var index = $scope.questions.indexOf('icebreaker_video')
                      $scope.questions.splice(index, 1);
                      $scope.videomgs = true;
  
                      localStorage.removeItem('VideoUploadResponseData') ;
                  }
  
              }
  
          })
  
  
          //New azure media service upload
          $scope.new_video_upload_modal = function(file_elm, evt) {
  
              if ($scope.doc_type == 'question' ) {
                  var origin = 'application';
                  var data = {'application_id': getUrlParameter('id'), 'question_id': $scope.question_id};
              }else if( $scope.doc_type == 'icebreaker_video' ){
                  var origin = 'candidate_profile_edit'
                  var data = null;
              }
  
              fileUploadService.video_upload($scope, file_elm, evt, origin, data);
  
  
          }
  
  
            $scope.open_camera_new = function() {
  
                      // Check webcam and mic is set on desktop
  
                       if ($scope.isSafari) {
                           $('#pmvCameraModalNew').modal('show');
                      }else{
  
                           if (!(DetectRTC.hasMicrophone && DetectRTC.hasWebcam) && !$scope.mobile_agent) {
  
                              $('.pvm-video-container-error').html("");
  
  
                              if (DetectRTC.hasMicrophone == false) {
                                  $('.pvm-video-container-error').append('<p class="text-danger">Microphone not set</p>');
  
                              }
                              if (DetectRTC.hasWebcam == false) {
                                  $('.pvm-video-container-error').append('<p class="text-danger">Camera not set</p>');
                              }
  
  
                              $('#pmvErrorMsg').modal('show');
  
                          } else {
  
  
                          $('#pmvCameraModalNew').modal('show');
  
  
                          }
  
                      }
  
                  }
  
          /*CANDIDATE VIDEO UPLOAD END*/
          $scope.crop_data = {
                  w: 240,
                  h: 240,
                  x: 80,
                  y: 0
              };
  
  
  
          $scope.startVideoImage = function() {
            checkBrowsers();
              if($scope.isSafari || $scope.browserName == "Safari") {
                  // alert('Oh oh looks like your\'re using Safari! Use Chrome or Firefox to capture image using your webcam.');
                  alert('Oh oh this feature is not yet supported by your browser. Drag and drop an image instead, or use Chrome, Firefox or Microsoft Edge to capture an image using your webcam.');
              }else{
                   fileUploadService.startVideoImage($scope);
              }
  
          }
  
          $scope.take_photo = function() {
              //console.log('photo');
              fileUploadService.take_photo($scope);
          }
  
          $scope.take_photo_again = function() {
              window.stream = '';
              $scope.startVideoImage();
          }
  
  
          $scope.save_photo = function() {
              fileUploadService.save_photo($scope);
          }
  
          $scope.mobile_image_upload = function() {
              fileUploadService.mobile_image_upload($scope);
          }
  
  
          $scope.mobile_video_upload = function() {
              fileUploadService.mobile_video_upload($scope);
          }
  
          $scope.mobile_resume_upload = function() {
              fileUploadService.mobile_resume_upload($scope);
          }
  
          $scope.mobile_portfolio_upload = function() {
              fileUploadService.mobile_portfolio_upload($scope);
          }
          document.dropImageModalNew = function(ev) {
                  ev.preventDefault();
                  $scope.new_image_upload_modal(ev);
              }
          // Image upload
          $scope.new_image_upload_modal = function(evt) {
  
              fileUploadService.new_image_upload_modal($scope, evt);
          }
  
  
  
  
  
          /******* Camera Recording *****/
          // Unit variables
          var record = document.getElementById('record');
          var stop = document.getElementById('stop');
          var audio = document.querySelector('audio');
          var preview = document.getElementById('preview');
          var preview_new = document.getElementById('preview_new');
          var container = document.getElementById('container');
          var save = document.getElementById('save');
          var isFirefox = !!navigator.mozGetUserMedia;
          var recordAudio, recordVideo, fileName;
  
          // if elements is presents
          if (record && stop && save) {
  
              // open modal
              $scope.open_camera = function() {
  
                  // Check webcam and mic is set on desktop
                  if (!(DetectRTC.hasMicrophone && DetectRTC.hasWebcam) && !$scope.mobile_agent) {
  
                      $('.pvm-video-container-error').html("");
  
  
                      if (DetectRTC.hasMicrophone == false) {
                          $('.pvm-video-container-error').append('<p class="text-danger">Microphone not set</p>');
  
                      }
                      if (DetectRTC.hasWebcam == false) {
                          $('.pvm-video-container-error').append('<p class="text-danger">Camera not set</p>');
                      }
  
                      if (isSafari) {
                          $('.pvm-video-container-error').html('<p class="text-danger">Your browser not supported.</p>');
                      }
  
                      $('#pmvErrorMsg').modal('show');
  
                  } else {
                      // hide percentage
                      if (!$('#modal_percent').hasClass('hidden')) {
                          $('#modal_percent').addClass('hidden');
                      }
  
                      $('#pmvCameraModal').modal('show');
                      // reset buttons and preview original state
                      if (!$('.video_buttons').hasClass('ng-hide')) {
                          $('.video_buttons').addClass('ng-hide');
                      }
                      $('#pmvCameraModal').find('.video_buttons').each(function(k, o) {
                          var o = $(o);
                          if (!o.hasClass('ng-hide')) {
                              o.addClass('ng-hide');
                          }
                      })
                      $('#preview').attr('src', '');
                      $('#preview').attr('data-old_file', '');
                      $('#preview').attr('data-file_folder', '');
                      $('#preview').attr('poster', 'themes/bbt/images/camera_poster.jpg');
  
  
                  }
              }
  
  
  
  
              // Record Camera
              record.onclick = function() {
  
                  record.disabled = true;
                  save.disabled = true;
  
                  // delete old file if exists
                  if ($('#record').attr('data-recorded')) {
                      var filename = $('#record').attr('data-recorded');
                      $scope.delete_old_file(filename, 'camera');
                  }
  
                  // hide percent progress
                  if (!$('#modal_percent').hasClass('hidden')) {
                      $('#modal_percent').addClass('hidden');
                  }
  
                  var onstream = function() {
                      preview.src = window.URL.createObjectURL(stream);
                      preview.play();
                      preview.muted = false;
  
                      recordAudio = RecordRTC(stream, {
                          // bufferSize: 16384,
                          onAudioProcessStarted: function() {
                              // if (!isFirefox) {
                              recordVideo.startRecording();
                              //   }
                          }
                      });
  
                      recordVideo = RecordRTC(stream, {
                          type: 'video'
                      });
  
                      recordAudio.startRecording();
                      stop.disabled = false;
                  }
  
                  !window.stream && navigator.getUserMedia({
                      audio: true,
                      video: true
                  }, function(stream) {
                      window.stream = stream;
                      onstream();
                  }, function(error) {
                      alert(JSON.stringify(error, null, '\t'));
                  });
  
  
                  window.stream && onstream();
  
  
              };
  
              // Stop Recording and save recorded video
              stop.onclick = function() {
  
                  $('#save').attr('data-save_type', 'camera');
  
                  record.disabled = false;
                  stop.disabled = true;
                  save.disabled = false;
                  preview.src = '';
                  // preview.poster = 'themes/bbt/images/ajax-loader-video.gif';
                  fileName = Math.round(Math.random() * 99999999) + 99999999;
                  fileName = 'camera_' + fileName + '.mp4';
                  $('#record').attr('data-recorded', fileName);
  
                  // reset percent to 0
                  $scope.modal_percent_value = 0;
  
                  // show percent progress
                  //      if($('#modal_percent').hasClass('hidden')){
                  //  $('#modal_percent').removeClass('hidden');
                  // }
                  // remove poster
                  $('#preview').attr('poster', '');
  
                  // if (!isFirefox) {
                  recordAudio.stopRecording(function(audioUrl) {
                      preview.src = audioUrl;
                      recordVideo.stopRecording(function(videoUrl) {
                          // preview.src = videoUrl;
                          // PostBlob(recordAudio.getBlob(), recordVideo.getBlob(), fileName);
  
                          stream.stop();
                          window.stream = '';
                      });
  
                  });
  
  
                  // }
              };
  
              save.onclick = function() {
  
                  var save_btn = $(this);
                  var preview = document.getElementById('preview');
                  var ob_key = $cookies.get('obkey');
  
  
                  // Save Camera Video
                  if (save_btn.attr('data-save_type') == 'camera') {
  
                      // show percent
                      if ($('#modal_percent').hasClass('hidden')) {
                          $('#modal_percent').removeClass('hidden')
                      }
  
                      var filename = $('#record').attr('data-recorded');
                      var doc_type = 'icebreaker_video';
  
  
  
                      if (!filename) {
                          return false;
                      }
  
                      PostBlob(recordAudio.getBlob(), recordVideo.getBlob(), filename);
  
  
  
                      // Save Uploaded Video
                  } else if (save_btn.attr('data-save_type') == 'video') {
  
                      var fileField = document.getElementById("Form_video_upload_modal");
                      var filename = $('#preview').attr('src');
                      var fileLastIndex = filename.lastIndexOf('/') + 1;
                      filename = filename.substr(fileLastIndex);
  
                      if (!filename) {
                          return false;
                      }
  
                      $.ajax({
                          url: GlobalConstant.accountPage + '/save_uploaded_file',
                          type: 'post',
                          data: {
                              filename: filename,
                              doc_type: 'icebreaker_video',
                              ob_key: ob_key,
                              token_id: token_id
                          },
                          success: function(data) {
  
                              if (data) {
                                  $scope.progressValueModel = 0;
                                  // $('#video_placeholder').attr('src', 'themes/bbt/images/placeholder_encoding.png');
                                  $('#pmvCameraModal').modal('hide');
                              } else {
                                  alert('Internal error.');
                              }
                              fileField.value = "";
  
                          }
  
                      });
                  }
  
                  $('#preview').attr('src', '');
  
  
              }
  
              $('#record_camera').click(function() {
  
                  var filename = $('#preview').attr('data-old_file');
                  var folder = $('#preview').attr('data-file_folder');
  
                  $scope.delete_old_file(filename, folder);
  
                  if ($('#preview').attr('src')) {
                      $('#preview').attr('src', '');
                      window.stream = '';
                  }
  
                  $('.video_buttons').removeClass('ng-hide');
                  save.disabled = true;
                  record.disabled = false;
                  stop.disabled = true;
  
                  !window.stream && navigator.getUserMedia({
                      audio: true,
                      video: true
                  }, function(stream) {
                      window.stream = stream;
  
                      preview.src = window.URL.createObjectURL(stream);
                      preview.play();
  
  
                  }, function(error) {
                      alert(JSON.stringify(error, null, '\t'));
                  });
  
              });
  
              /* MODAL EVENT LISTENERS FOR OPEN AND CLOSE */
  
              // Modal close event
              $('#pmvCameraModal, #pmvCameraModalNew, #pmvImageModalNew, #pmvFileModalNew').on('hidden.bs.modal', function() {
                  // stop/unseen video stream
  
                  if (window.stream) {
                      stream.stop();
                      stream.getVideoTracks()[0].stop();
                      window.stream = "";
                  }
                  // reset buttons/sections/percent
                  fileUploadService.initParams($scope);
  
                  // reset preview video
                  $('#preview_new').attr('src', '');
                  $('#preview_img_new').attr('src', '');
  
                  //Jcrop fix alignment
                  if (!$('#preview_img_new_holder').find('.jcrop-holder').length) {
                      $('#preview_img_new_holder').removeClass('jcrop_adjust_margin');
                  }
                  //Jcrop fix alignment
                  if (!$('#preview_img_new_holderRE').find('.jcrop-holder').length) {
                      $('#preview_img_new_holderRE').removeClass('jcrop_adjust_margin');
                  }
  
                  // $scope.sectionsHideShow(false,true);
  
  
                  // ($('#preview_img_new').Jcrop()).destroy();
                  // ////console.log($scope.jcropImage.destroy())
  
  
              })
  
              // resume modal on close event, delete uploaded old file
              $('#pmvResumeModal').on('hidden.bs.modal', function() {
                  var resume_save_btn = $('#resume_save');
                  if (resume_save_btn.attr('data-filename') && resume_save_btn.attr('data-folder')) {
                      $scope.delete_old_file(resume_save_btn.attr('data-filename'), resume_save_btn.attr('data-folder'));
                  }
              })
  
              $('#pmvResumeModal').on('show.bs.modal', function() {
                  var buttons = $('#pmvResumeModal').find('.resume_buttons');
                  if (!buttons.hasClass('ng-hide')) {
                      buttons.addClass('ng-hide');
                  }
              })
  
              $('#pmvImageModal').on('hidden.bs.modal', function() {
                  var resume_save_btn = $('#image_save');
                  if (resume_save_btn.attr('data-filename') && resume_save_btn.attr('data-folder')) {
                      $scope.delete_old_file(resume_save_btn.attr('data-filename'), resume_save_btn.attr('data-folder'));
                  }
              })
  
  
              $('#pmvImageModal').on('show.bs.modal', function() {
                  var buttons = $('#pmvImageModal').find('.resume_buttons');
                  if (!buttons.hasClass('ng-hide')) {
                      buttons.addClass('ng-hide');
                  }
              })
  
  
              $('#pmvPortfolioModal').on('hidden.bs.modal', function() {
                  var portfolio_save_btn = $('#portfolio_save');
                  if (portfolio_save_btn.attr('data-filename') && portfolio_save_btn.attr('data-folder')) {
                      $scope.delete_old_file(portfolio_save_btn.attr('data-filename'), portfolio_save_btn.attr('data-folder'));
                  }
              })
  
              $('#pmvPortfolioModal').on('show.bs.modal', function() {
                  var buttons = $('#pmvPortfolioModal').find('.resume_buttons');
                  if (!buttons.hasClass('ng-hide')) {
                      buttons.addClass('ng-hide');
                  }
              });
  
              // open popup modal for resume ()
              $scope.open_file_modal = function(e) {
                  var elem = $(e.currentTarget);
                  var docFileType = elem.attr('data-docFileType');
                  fileUploadService.openModal($scope, '#pmvFileModalNew', docFileType);
              }
              $("#file_upload").change(function() {
                  var elemId = $(this).attr('id');
                  var event = false;
                  var docFileType = $('#pmvFileModalNew').attr('data-docFileType');
                  var fileSizeLimit = 3;
                  fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit, true);
              });
               $scope.file_change = function() {
                  fileUploadService.fileChange($scope);
              }
  
  
  
  
          } // end stop, record, play element
  
  
  
      }]);
  
  
  
  
  }());
  
  $(document).ready(function() {
  
      $('[data-toggle="tooltip"]').tooltip();
      // PAJ
      var url_string = window.location.href;
      var url = new URL(url_string);
      var c = url.searchParams.get("tpl");
  
      if(c == 1) {
        $(".modal-me").modal("show");
      }
      // PAJ
  
      $('.mydatepicker').datetimepicker({
           timepicker:false,
           format:'d-m-Y'
      })
  
  
      //     $(window).scroll(function() {
      //         //job-listing-about-employer-con
      //         var targetTop = $('#job-listing-top-con').offset().top;
      //         var targetBottom = $('#job-listing-about-employer-con').offset().top;
      //         var objTop = $(this).scrollTop();
      // // ////console.log(objTop + ' <--')
      // // ////console.log(targetTop)
      // // ////console.log(targetBottom)
  
      //         if (objTop == 0) {
      //             $('#job_listed_con').css({'position': 'absolute'});
      //         } else if (objTop > targetTop && (targetBottom - objTop) >= 584) {
  
      //             $('#job_listed_con').css({
      //                 'position': 'fixed',
      //                 'top': '0px'
      //             });
      //         } else if ((targetBottom - objTop) < 584) {
  
      //             $('#job_listed_con').css({
      //                 'position': 'absolute',
      //                 'top': targetBottom - ((targetTop * 2) + 180) + 'px'
  
      //             });
  
      //         } else {
      //             $('#job_listed_con').css({
      //                 'position': 'absolute'
  
      //             });
      //         }
  
      //     })
  
  })
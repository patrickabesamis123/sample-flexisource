(function() {
    //'use strict';
    var app = angular.module('app');
    var jcropImage = "";
    var base_url = $('body').data('base_url');
    $('#thread_list').TrackpadScrollEmulator();
    $('#thread_list_message_candidate').TrackpadScrollEmulator();

    app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
      $locationProvider.html5Mode(false);
    }]);

    function functiontofindIndexByKeyValue(arraytosearch, key, valuetosearch) {
      for (var i = 0; i < arraytosearch.length; i++) {
        if (arraytosearch[i][key] == valuetosearch) {
          return i;
        }
      }
      return null;
    }

    app.controller('CandidateController', ['GlobalConstant', 'fileUploadService', 'CandidateSrvcs', '$scope', '$cookies', '$window', '$http', '$filter', '$timeout', '$interval', '$location', 'OAuth',  'OAuthToken', '$rootScope',
      function(GlobalConstant, fileUploadService, CandidateSrvcs, $scope, $cookies, $window, $http, $filter, $timeout, $interval, $location, OAuth, OAuthToken, $rootScope) {
          // changed jquery datepicker default date format
        $scope.showNameInfo = false;
        $scope.added = {
          qualification: '',
          qualification_provider: '',
          completed_date: ''
        };

        $scope.initDatePicker = function(e) {
          $(e.target).datetimepicker({
             timepicker:false,
             format:'d-m-Y'
          });
          $(e.target).datetimepicker("show");
        }
        var token = $cookies.get('api_token');
        var token_id = $cookies.get('token_id');
        //var token = "M2IzMjlkNDVmMjA1ZjAzZWNjYTgxNTU2YWVjZTQzZDUxNDNhZTBkMTY0ZTRhODFlYjQ1YzQ1Njc2OWUyZTcxZg";
        //var token_id = "7592";
        $http.get( window.location.origin + "/api/user-auth-data/", {
           headers: { 'Authorization': 'Bearer ' + token }
         }).then(function(res) {
           $scope.candidateId = res.data.data[0].id;
         }, function(response) {
          //temporary
          if(response.status == 401) {
            window.location.href = window.location.origin + '/login';//Unauthorized
          }
        });
        var messageScrollCounter = 1;
        var getHash = window.location.hash.substring(1);
        var color_bg_initial_set = [
          "member-initials--sky",
          "member-initials--pvm-purple",
          "member-initials--pvm-green",
          "member-initials--pvm-red",
          "member-initials--pvm-yellow"
        ];
        //console.log($cookies.get('token'));

        $scope.ondragoverout_image = false;
        $scope.ondragover_image = true;
        $scope.jcropImage = "";
        $scope.crop_data = {w: 240, h: 240, x: 80, y: 0};
        $scope.params = {access_token: token};

        // Sort Date on view (work history and eduction)
        $scope.sortDate = function(item) {
          var date = new Date(item.date_x);
          return date;
        };

        if (token != null) {
          $scope.test = token;
          // Candidate Get Flash Message
          $scope.candidateFlashMessage = '';
          //$http.get( GlobalConstant.CandidateFlashApi )
          $http.get( window.location.origin + "/js/minified/test-data/test_flash_message.json" )
          .then(function(response) {
            if (response.status == 200 && response.data.data.message) {
              if (response.data.data.message) {
                $scope.candidateFlashMessage = response.data.data.message;
              }
            }
          });

          // Embed ob_key on Video and Resume upload form
          $('#Form_my_file').attr('data-ob_key', $cookies.get('obkey'));
          $('#Form_video_upload').attr('data-ob_key', $cookies.get('obkey'));
          $('#preview').attr('data-ob_key', $cookies.get('obkey'));


          $scope.preload = true;
          $scope.contentloader = false;
          $scope.mobile_agent = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
          var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
          $scope.isMSEdge = (/edge/i.test(navigator.userAgent.toLowerCase()));
          $scope.isSafari = isSafari;
          $scope.mobile_agent_name = false;
          if ($scope.mobile_agent) {
            if ((/iphone|ipad|ipod/i.test(navigator.userAgent.toLowerCase()))) {
              $scope.mobile_agent_name = 'ios';
            } else {
              $scope.mobile_agent_name = 'android';
            }
          }


          $scope.getDaysLeft = function(str) {
            str = str.split('('), str = str[1].split(' '), str = str[0];
            return parseInt(str);
          }

          var monDate = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
          var today = new Date();

          // Cadidate my-job-applications page
          if ($('body').hasClass('my-job-applications')) {

            //onload highlight 'active' tab
            $('#applied_tab').addClass('active');

            $scope.sortAppliedDate = function(item) {
              if(item.application.applied_date) {
                var item = item.application.applied_date;
                var aItem = item.split(' ');
                var month = monDate.indexOf(aItem[2]) + 1;
                var newDateString = month + '-' + aItem[1] + '-' + aItem[3];
                return new Date(newDateString);
              }
            };

            var type = window.location.hash.substr(2);
            var aType = type.split('/');

            $scope.activeCount= 0
            //$http.get( GlobalConstant.CandidateJobApplicationApi + '/active' )
            //$http.get( window.location.origin + "/js/minified/test-data/test_candidate_application_active.json" )
            $http.get( window.location.origin + "/api/candidate/application/"+ $scope.candidateId +"/active")
            .then(function(response) {
         
              var data = response.data;

              if (data.count) {
                angular.forEach(data.jobs, function(v, k) {

                  v.job.days_left = $scope.getDaysLeft(v.job.expiry_date);

                  v.job.expiredText = 'Expires';
                  v.job.isRedColor = false;
                  if(v.job.expiry_date){
                    var aExpiredDate = v.job.expiry_date.split(" ");
                    var getExpiredDate = new Date(aExpiredDate[3],monDate.indexOf(aExpiredDate[2]),aExpiredDate[1],23,59,59);
                    if((getExpiredDate.getTime() - today.getTime()) < 0){
                      v.job.expiredText = 'Expired';
                    }
                  }
                  if(v.job.days_left < 6 || v.job.expiredText == 'Expired'){
                    v.job.isRedColor = 'pvm-red';
                  }

                })
              }
              // data.jobs = data.jobs.slice(0,1);
              // data.jobs[0].job.job_description = "As the Intellectual Property manager you will operate in a team environment providing professional expert Intellectual Property advice. Specifically you will provide support and advise on PreviewMe's platform delivery, expansion and product acquisition. Working alongside the Head of Development and Head of Acquisitions you will be exposed to complex transactions requiring above all an understanding of foreign legal frameworks and their implications on PreviewMe.As the Intellectual Property manager you will operate in a team environment providing professional expert Intellectual Property advice. Specifically you will provide support and advise on PreviewMe's platform delivery, expansion and product acquisition. Working alongside the Head of Development and Head of Acquisitions you will be exposed to complex transactions requiring above all an understanding of foreign legal frameworks and their implications on PreviewMe.As the Intellectual Property manager you will operate in a team environment providing professional expert Intellectual Property advice. Specifically you will provide support and advise on PreviewMe's platform delivery, expansion and product acquisition. Working alongside the Head of Development and Head of Acquisitions you will be exposed to complex transactions requiring above all an understanding of foreign legal frameworks and their implications on PreviewMe.";
              //console.log("---");
             // console.log(data);

              $scope.jobApplicationActive = data;
              $scope.activeCount = $scope.jobApplicationActive.count >= 10 ?
              $scope.jobApplicationActive.count : '0' + $scope.jobApplicationActive.count;

              // Add comapny initials as default picture
              for (var activeJobInits = 0; activeJobInits < $scope.jobApplicationActive.jobs.length; activeJobInits++) {
                $scope.comp_initial = $scope.jobApplicationActive.jobs[activeJobInits].job.job.company.company_name;
                $scope.comp_initial = $scope.comp_initial.replace(/[^A-Z]/g, "");
                $scope.jobApplicationActive.jobs[activeJobInits].job.company.initial = $scope.comp_initial

                // change default photo's background color
                var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
                $scope.jobApplicationActive.jobs[activeJobInits].job.company.profile_color = color_bg_initial;
              }

              $('#application-contents').TrackpadScrollEmulator();

              if (type == 'applied') {
                $scope.jobContent(type);
                $('#' + type + '_tab').addClass('active')
              }
              //console.log('active')
              //console.log(data)
            });

            $scope.draftCount = 0
            //$http.get( GlobalConstant.CandidateJobApplicationApi + '/draft' )
            //$http.get( window.location.origin + "/js/minified/test-data/test_candidate_application_draft.json" )
            $http.get( window.location.origin + "/api/candidate/application/"+ $scope.candidateId +"/draft")
            .then(function(response) {
              var data = response.data;
              if (data.count) {
                angular.forEach(data.jobs, function(v, k) {
                  v.job.days_left = $scope.getDaysLeft(v.job.expiry_date);
                  v.job.expiredText = 'Expires';

                  if(v.job.expiry_date){
                    var aExpiredDate = v.job.expiry_date.split(" ");
                    var getExpiredDate = new Date(aExpiredDate[3],monDate.indexOf(aExpiredDate[2]),aExpiredDate[1],23,59,59);
                    if((getExpiredDate.getTime() - today.getTime()) < 0){
                      v.job.expiredText = 'Expired';
                    }
                  }

                  if(v.job.days_left < 6 || v.job.expiredText == 'Expired'){
                    v.job.isRedColor = 'pvm-red';
                  }
                })
              }

              $scope.jobApplicationDraft = data;
              $scope.draftCount = $scope.jobApplicationDraft.count >= 10 ?
              $scope.jobApplicationDraft.count : '0' + $scope.jobApplicationDraft.count;

              // Add comapny initials as default picture
              for (var activeJobInits = 0; activeJobInits < $scope.jobApplicationDraft.jobs.length; activeJobInits++) {
                $scope.comp_initial = $scope.jobApplicationDraft.jobs[activeJobInits].job.company.company_name;
                $scope.comp_initial = $scope.comp_initial.replace(/[^A-Z]/g, "");
                $scope.jobApplicationDraft.jobs[activeJobInits].job.company.initial = $scope.comp_initial

                // change default photo's background color
                var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
                $scope.jobApplicationDraft.jobs[activeJobInits].job.company.profile_color = color_bg_initial;
              }

              //console.log("jobApplicationDraft: ", $scope.jobApplicationDraft);

              if (type == 'draft') {
                $scope.jobContent(type);
                $('#' + type + '_tab').addClass('active')
              }
            });

            $scope.expiredCount = 0;

            
            //$http.get( GlobalConstant.CandidateJobApplicationApi + '/closed' )
            //$http.get( window.location.origin + "/js/minified/test-data/test_candidate_application_closed.json" )
            $http.get( window.location.origin + "/api/candidate/application/"+ $scope.candidateId +"/closed")
            .then(function(response) {
              var data = response.data;
              //console.log('expired')
              //console.log(data)

              if (data.count) {
                angular.forEach(data.jobs, function(v, k) {
                  v.job.days_left = $scope.getDaysLeft(v.job.expiry_date);
                  v.job.expiredText = 'Expires';
                  v.job.isRedColor = false;
                  if(v.job.expiry_date){
                    var aExpiredDate = v.job.expiry_date.split(" ");
                    var getExpiredDate = new Date(aExpiredDate[3],monDate.indexOf(aExpiredDate[2]),aExpiredDate[1],23,59,59);
                    if((getExpiredDate.getTime() - today.getTime()) < 0){
                      v.job.expiredText = 'Expired';
                    }
                  }

                  if(v.job.days_left < 6 || v.job.expiredText == 'Expired'){
                    v.job.isRedColor = 'pvm-red';
                  }
                })
              }

              $scope.jobApplicationExpired = data;
              $scope.expiredCount = $scope.jobApplicationExpired.count >= 10 ?
              $scope.jobApplicationExpired.count : '0' + $scope.jobApplicationExpired.count;

              // Add comapny initials as default picture
              for (var activeJobInits = 0; activeJobInits < $scope.jobApplicationExpired.jobs.length; activeJobInits++) {
                $scope.comp_initial = $scope.jobApplicationExpired.jobs[activeJobInits].job.company.company_name;
                $scope.comp_initial = $scope.comp_initial.replace(/[^A-Z]/g, "");
                $scope.jobApplicationExpired.jobs[activeJobInits].job.company.initial = $scope.comp_initial

                // change default photo's background color
                var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
                $scope.jobApplicationExpired.jobs[activeJobInits].job.company.profile_color = color_bg_initial;
              }



              if (type == 'expired') {
                $scope.jobContent(type);
                $('#' + type + '_tab').addClass('active')
              }
            });

            /*
            $scope.deleteJob = function(jobId, applicationId) {
              $http.post(GlobalConstant.APIRoot + 'candidate/application/' + jobId + '/' + applicationId + '/delete' )
              .then(function(response) {
                // //console.log(response);
                $('.job_draft_item_' + jobId).remove();
              }, function(response) {
                alert('error')
              })
            }
            */

            $scope.showQuestionsContent = function(type) {
              if(type == 'pre-approval' || type == false){
                $scope.questionHideShow = true
                $scope.preapprovalActive = 'active';
                $scope.standardActive = '';
              }else{
                $scope.preapprovalActive = '';
                $scope.standardActive = 'active';
                $scope.questionHideShow = false;
              }
            }

            // Multiple choice question
            $scope.preApprovalAnswers = ['yes', 'developing', 'no'];
            var original_height = 740;
            var additional_height = 400;
            var original_height_child = 662;
            var original_tse_scroll_content_height = 661;

            $scope.makeRandomId = function()
            {
              var text = "";
              var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

              for( var i=0; i < 10; i++ ) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
              }
              return text;
            }

            // $scope.jobContent = function(type, object_id = false, content_type = false, is_red_color) {
            // safari dosen't accept default values on parameter
            $scope.jobContent = function(type, object_id, content_type , is_red_color) {

              if(object_id) {
                // Date on Detail Job Application content if red or normal color
                $scope.isRedColor = is_red_color ? is_red_color : '';

                $scope.object_id = object_id;
                $('#job-application-holder').height(original_height + additional_height);
                $('#application-contents').height(original_height_child + additional_height)
                $('#application-details-sec1, #application-details-sec2').css('height','');

                //$http.get( GlobalConstant.CandidateRootApi + '/job-application-detail/'+ object_id )
                //$http.get( window.location.origin + "/js/minified/test-data/test_candidate_job_detail.json" )
                $http.get( window.location.origin + "/api/candidate/job-application-details/"+ $scope.candidateId +"/" + object_id)
                .then(function(response){

                  angular.forEach(response.data, function(v, k) {
                    $scope[k] = v;
                  });

                  $scope.application.applied_date_obj = new Date($scope.application.applied_date['date']);
                  $scope.job.expiry_date_obj =  new Date($scope.job.expiry_date);
                  $scope.expiredText = 'Expires';

                  if($scope.job.expiry_date){
                    var aExpiredDate = $scope.job.expiry_date.split(" ");
                    var getExpiredDate = new Date(aExpiredDate[3],monDate.indexOf(aExpiredDate[2]),aExpiredDate[1],23,59,59);
                    if((getExpiredDate.getTime() - today.getTime()) < 0){
                      $scope.expiredText = 'Expired';
                    }
                  }
                  angular.forEach($scope.application.application_questions, function(v,k){
                    if(v.answer_type == 'video'){
                      v.video_id = $scope.makeRandomId();
                      if (v.answer) {
                        if(v.answer.doc_url == 'pending_doc_url' || v.answer.doc_url == '') {
                          // v.poster = true;
                          v.video_notavail = true;
                        }else{
                          v.video_notavail = false;
                          var videoDomeReady = function() {
                            var scrollInterval = setInterval(function() {
                              if($('#'+ v.video_id).length){
                                var myPlayer = amp(v.video_id, {
                                "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                                "nativeControlsForTouch": false,
                                autoplay: false,
                                controls: true,
                                width: "100%",
                                logo: {
                                  "enabled": false
                                },
                                poster: false
                                }, function() {});

                                myPlayer.src([{
                                  src: v.answer.doc_url,
                                  type: "application/vnd.ms-sstr+xml"
                                }]);
                                clearInterval(scrollInterval);
                              }
                            }, 1000);
                          }
                          videoDomeReady();
                        }
                      }

                    }
                  })

                  $scope.section1Border = 'border-r';
                  var counter = 1;
                  var getHeightContainterFunc = function() {
                    var getHeightContainter = setInterval(function() {
                      //console.log($('#application-details-sec1').height())
                      if(counter > 1){
                        counter = 1;

                        if($('#application-details-sec1').height() > $('#application-details-sec2').height()) {
                          if($('#application-details-sec1').height() < 1000){
                            $('#application-details-sec1').height(1000)
                          }
                          $scope.section1Border = 'border-r';
                          $scope.section2Border = '';
                        } else{
                          if($('#application-details-sec2').height() < 1000){
                            $('#application-details-sec2').height(1000)
                          }
                          $scope.section2Border = 'border-l';
                          $scope.section1Border = '';
                        }

                        $('#application-contents').TrackpadScrollEmulator({'recalculate':true});
                        clearInterval(getHeightContainter);
                      }
                      counter++;
                    }, 200);
                  }

                  getHeightContainterFunc();
                  $('#application-contents .tse-scroll-content').height(1000)
                  $('#application-contents').TrackpadScrollEmulator({'recalculate':true});
                });

                $scope.current_tab_link = type;
                if(type == 'applied') {
                  // show section
                  type = 'applied-application';
                  // label on applicaiton job
                  $scope.current_tab = 'Active';
                }else if (type == 'expired') {
                  $scope.current_tab = 'Expired';
                }

                $scope.showQuestionsContent(content_type);

              }else{

                $('#job-application-holder').height(original_height);
                $('#application-contents').height(original_height_child);
                $('#application-contents .tse-scroll-content').height(original_tse_scroll_content_height);

              }
              $('#application-contents').find('.tab-pane').addClass('hide').removeClass('in');
              $('#application-contents').find('#' + type).removeClass('hide').addClass('fade active in');
            }

            // View applied/expired application
            if(aType[1]){
              $scope.jobContent(aType[0], aType[1], aType[2]);
              $('#' + aType[0] + '_tab').addClass('active');
            }

          } // END : my-job-applications page

          // Cadidate Settings page
          if ($('body').hasClass('settings')) {
            //Relogin function
            $scope.validatelogin = function(){
              $scope.preload = false;
              $scope.data = {username: $scope.emailfield, password: $scope.pass}
              //return false
              //if ($cookies.get('email') == $scope.emailfield) {

              var login = OAuth.getAccessToken($scope.data, {method:'GET'} )
              login.then(function (result) {
                $scope.validated = true
                $scope.preload = true;
                $scope.access_token = result.data;
                //Check user type
                $http.get(GlobalConstant.CheckUserType1 )
                .then(function(response) {
                  var userType = response.data.data;
                  OAuthToken.setToken( $scope.access_token )
                  var token_data = OAuthToken.getToken();
                  //For Old Login data
                  var expire =  parseInt (  token_data.expires_in );
                  // var expire = parseInt ( OAuthToken.getToken().expires_in )  - 3500;
                  var SetDateforLogin = new Date();
                  var LoginTime = parseInt(SetDateforLogin.getTime() / 1000);
                  var ExpireTime = parseInt(SetDateforLogin.getTime() / 1000) + expire;
                  var ExpireTimetoDate = new Date(ExpireTime * 1000);
                  //Store all data needed to cookies
                  $cookies.put('token', token_data.access_token, {'path': '/'});
                  $cookies.put('LoginTime', LoginTime, {'path': '/'});
                  // $cookies.put('IdleTime', ExpireTime, {'path':'/' } );
                  $cookies.put('exp', expire, {'path': '/'});
                  //need for refresher
                  $cookies.put('email',  $scope.emailfield, {'path':'/' } );

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
                        $cookies.put('token_id', token_id, {'path': '/'});
                        $http.get( GlobalConstant.profileApi )
                        .then(function(response) {
                          //console.log('response')
                          //console.log(response)
                          $cookies.put('obkey', response.data.data.ob_key, {'path': '/'});
                        });
                      }
                    }).done(function() {
                      $scope.preload = true;
                      //console.log('cand');
                    });
                  }
                });

                //Trigger form function
                switch ($scope.referrer) {
                  case 'changePassword':
                    $scope.changePassword( );
                    break;
                  case 'changeProfileUrl':
                    $scope.changeProfileUrl( );
                    break;
                  case 'changeEmail':
                    $scope.changeEmail()
                  default:
                }
                return true
              }, function(response) {
                //Error Condition
                //console.log(response.status);
                $scope.preload = true;
                alert('You are trying to edit an account that is not yours. You will now be logged out.')
                $.ajax({
                  url: GlobalConstant.logoutPage,
                  type: 'get',
                  'success' : function(data) {
                    if(data == 200){
                      $window.location.href =  base_url;
                    }
                  }
                });
                //$scope.ErrorMsg = response.data.error_description;
              })

              /* }else{
                alert('You are trying to edit someone else\'s profile, you will now be logged out!' );
                $.ajax({
                  url  : GlobalConstant.logoutPage,
                  type : 'get',
                  'success' : function(data) {
                    if(data == 200){
                        $window.location.href =  base_url;
                    }
                  }
                });

              }*/
            }

            //Open modal and validate fields
            $scope.OpenSecurityModal = function ( referrer ){
              $scope.preload = true;
              $scope.referrer = referrer
              switch ($scope.referrer) {
                case 'changePassword':
                  $('#changePassordForm').serializeArray().map(function(item) {
                    items[item.name] = item.value;
                  });

                  if(items.password != items.confirm_password){
                    $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                    $('#changePassordForm').prev().addClass('pvm-red').html('New Password and Confirm Password do not match!').fadeIn();
                    return false;
                  }else{
                    angular.element($('#Securitymodal')).modal('show')
                  }
                  break;
                case 'changeEmail':
                  $('#changeEmailForm').serializeArray().map(function(item) {
                      items[item.name] = item.value;
                  });
                  if(items.email != items.email_confirm){
                    $('#changeEmailForm').prev().removeClass('pvm-red pvm-green');
                    $('#changeEmailForm').prev().addClass('pvm-red').html('New Email and Confirm Email do not match!').fadeIn();
                    return false
                  }else{
                    angular.element($('#Securitymodal')).modal('show')
                  }
                default:
                  angular.element($('#Securitymodal')).modal('show')
              }
            }

            var items = {}
            $scope.changeEmail = function() {
              $('#changeEmailForm').serializeArray().map(function(item) {
                items[item.name] = item.value;
              });
              if (items.email == items.email_confirm) {
                $http.post( GlobalConstant.APIRoot + 'change-email', items )
                .then(function(response) {
                  angular.element($('#dismissSecurity')).trigger('click')
                  $('#changeEmailForm').prev().removeClass('pvm-red pvm-green');
                  $('#changeEmailForm').prev().addClass('pvm-green').html('Email updated.').fadeIn();
                  $('#changeEmailForm').find('input').not(':submit').val("");
                  $scope.email = items.email;
                  $cookies.put('email',  $scope.email, {'path':'/' } );
                }, function(response) {
                  if (response.data.errors.email) {
                    $('#changeEmailForm').prev().addClass('pvm-red').html(response.data.errors.email).fadeIn();
                  } else {
                    alert('error')
                  }
                })
              } else {
                $('#changeEmailForm').prev().removeClass('pvm-red pvm-green');
                $('#changeEmailForm').prev().addClass('pvm-red').html('Email and Confirm Email do not match!').fadeIn();
              }
            }

            var items = {}
            $scope.changePassword = function() {
              $('#changePassordForm').serializeArray().map(function(item) {
                items[item.name] = item.value;
              });

              if (items.password == items.confirm_password) {
                var data = {
                  "current_password": items.current_password,
                  "plainPassword": {
                    "first": items.password,
                    "second": items.confirm_password
                  }
                }

                $http.post( GlobalConstant.APIRoot + 'change-password', data  )
                .then(function(response) {
                  angular.element($('#dismissSecurity')).trigger('click')
                  $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                  $('#changePassordForm').prev().addClass('pvm-green').html('Password updated.').fadeIn();
                  $('#changePassordForm').find('input').not(':submit').val("");
                }, function(response) {
                  angular.element($('#dismissSecurity')).trigger('click')
                  $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                  if (response.data.errors.current_password) {
                    $('#changePassordForm').prev().addClass('pvm-red').html(response.data.errors.current_password).fadeIn();
                  }else if(response.data.errors.first == 'Invalid password'){
                    $('#changePassordForm').prev().addClass('pvm-red').html('Password must be between 8 to 10 characters long and must contain at least one digit').fadeIn();
                  } else {
                    alert('error')
                  }
                })
              } else {
                $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                $('#changePassordForm').prev().addClass('pvm-red').html('Password and Confirm Password do not match!').fadeIn();
              }
            }

            $scope.changeProfileUrl = function() {
              var profile_url = $.trim($('#profile_url').val());

              $http.put( GlobalConstant.APIRoot + 'candidate/change-profile-url',  {profile_url: profile_url} )
              .then(function(response) {
                angular.element($('#dismissSecurity')).trigger('click')
                // $('#msg_url').removeClass('pvm-red pvm-green');
                // $('#msg_url').addClass('pvm-green').html('Profile updated.').fadeIn();
                $('#msg_url').hide();
                 $scope.profile_url =  $('#profile_url').val();
                $('#profile_url').val("");
                var full_profile_url = base_url + 'me/' + profile_url;
              }, function(response) {
                angular.element($('#dismissSecurity')).trigger('click')
                $('#msg_url').removeClass('pvm-red pvm-green');
                $('#msg_url').addClass('pvm-red').html('Profile url is already taken. Try another one!').fadeIn();
              })
            }

            document.cancelSettings = function(obj) {
              $(obj).parents('form').find('input').not(':submit').val("")
              $(obj).parents('form').prev('#msg').html("").css('display', 'none');
            }

            $scope.disable_account = function() {
              $http.post( GlobalConstant.APIRoot + 'disable' ).then(function(response) {
                alert('Account is disabled.')
                $.ajax({
                  url  : GlobalConstant.logoutPage,
                  type : 'get',
                  'success' : function(data) {
                    if(data == 200){
                      $window.location.href =  base_url;
                    }
                  }
                });
              }, function(){
                alert('internal error');
              });
            }
          } // END : Cadidate Settings page

          // Analytics page
          if ($('body').hasClass('analytics')) {

            $scope.getTab = function() {
              var getTab = window.location.hash.substring(1);
              return getTab.split('/')[1];
            }

            $scope.getPercent = function(val, data) {
              var total = 0;
              angular.forEach(data, function(v, k) {
                total += v;
              })
              return (val * 100) / total;
            }

            var addPercentLabel = function(e, data) {
              var index = $(this).data().order;
              $('.pieTip').text(data[index].title + ": " + Math.round(data[index].value) + '%').fadeIn(200);
            }

            $scope.manageAnalyticsShow = function(type) {
              $('.candidate-analytics-tab').removeClass('active');
              $('#' + type + '_tab').addClass('active');
              // show selected tab content
              $('#analytics-contents-wrapper').find('.tab-pane').addClass('hide').removeClass('in');
              $('#analytics-contents-wrapper').find('#' + type).removeClass('hide').addClass('fade active in');
            }

            // For select options on top
            $http.get( GlobalConstant.CandidateJobApplicationApi + '/applied' )
            .then(function(response) {
              var data = response.data.data;
              $scope.appliedData = data;
              //console.log(data)\
              $scope.jobObject = $scope.appliedData.jobs[0];
              $scope.jobApplicationContent($scope.getTab());
              $scope.preApprovalContent($scope.getTab());
            });

            // Select options data
            $http.get( GlobalConstant.CandidateRootApi + '/job-application/analytics-ready')
            .then(function(response){
              $scope.selectOptions = response.data.data;
            })

            $scope.$watch('jobObject', function(newVal, oldVal) {
              if (newVal && oldVal) {
                //console.log(newVal.job.object_id)
                //console.log(oldVal.job.object_id)
                if (typeof newVal != 'undefined' && newVal.job.object_id !== oldVal.job.object_id) {
                  $scope.jobObject = newVal;
                  $scope.jobApplicationContent($scope.getTab());
                  $scope.preApprovalContent($scope.getTab());
                }
              }
            });

            $scope.jobApplicationContent = function(type) {
              if (!type) {
                type = 'job-applications';
              }else{
                if (type != 'job-applications')
                return false;
              }

              $scope.analytic_title = 'My Job Applications';

              // var job_id = 'J475JJC7Y1F1';

              $http.get( GlobalConstant.CandidateRootApi + '/job/analytics/' + $scope.jobObject.job.object_id )
              .then(function(response) {
                var data = response.data.data;
                // //console.log(data)

                if (!data) {
                  $scope.showJobApplication = false;
                }else{
                  if(!data.job){
                    $scope.showJobApplication = false;
                    $scope.manageAnalyticsShow(type);
                    return false;
                  }

                  $scope.showJobApplication = true;
                  $scope.industries_data = [];
                  var i = 0;
                  var colors = ['#55bbe6', '#7ec7e8', '#a9d7ed', '#d2e9f4', '#edf3f5'];
                  $scope.data = data;

                  angular.forEach($scope.data.job.industries.sections, function(v, k) {
                    if (i > 4) {
                      i = 0;
                    }
                    $scope.getPercent(v, $scope.data.job.industries.sections);
                    $scope.industries_data
                    .push({
                      title: k,
                      value: $scope.getPercent(v, $scope.data.job.industries.sections),
                      color: colors[i]
                    });
                    i++;
                  })
                  /* Success Rage Graph */
                  // round success and failed percentage
                  $scope.success_percentage = Math.round(data.job.success_rate.success_percentage);
                  $scope.failed_percentage = Math.round(data.job.success_rate.failed_percentage);

                  // invade data on graph element to be use on tooltip hover
                  if ($scope.failed_percentage >= $scope.success_percentage) {
                    $('.inner-circle').attr('data-percent', $scope.failed_percentage + '%')
                    .attr('data-value', $scope.data.job.success_rate.failed_number);

                    $('.inner-circle2').attr('data-percent', $scope.success_percentage + '%')
                    .attr('data-value', $scope.data.job.success_rate.success_number);
                  }

                  if ($scope.failed_percentage < $scope.success_percentage) {
                    $('.inner-circle').attr('data-percent', $scope.success_percentage + '%')
                    .attr('data-value', $scope.data.job.success_rate.success_number);

                    $('.inner-circle2').attr('data-percent', $scope.failed_percentage + '%')
                    .attr('data-value', $scope.data.job.success_rate.failed_number);
                  }

                  /* Industries pie chart */
                  $('.pieTip').remove();
                  $("#pieChart").html("").drawPieChart($scope.industries_data, {
                      onPieMouseenter: addPercentLabel
                  });
                  /* Regions */
                  $('#regions').TrackpadScrollEmulator();
                }

                // highlight selected tab
                $scope.manageAnalyticsShow(type);

                var i = 0;
                var promise = $interval(function(){
                  $interval.cancel(promise);
                  var a = parseInt($('.industries_box').height());
                  var b = parseInt($('.success_rate_box').height());

                  if($( window ).width() >= 1024) {
                    if( a > 0 && b > 0) {
                      if(a >= b){
                        $('.success_rate_box').height(a);
                      }else{
                        $('.industries_box').height(b);
                      }
                    }
                  }else{
                    $('.success_rate_box').css('height','auto')
                    $('.industries_box').css('height','auto')
                  }


                  if(i == 1){ $interval.cancel(promise); }
                  i++;
                },1000);

                // ipad fixed toggle portrait/landscape
                $( window ).resize(function() {
                  var a = parseInt($('.industries_box').height());
                  var b = parseInt($('.success_rate_box').height());

                  if($( window ).width() >= 1024) {
                    if( a > 0 && b > 0) {
                      if(a >= b){
                        $('.success_rate_box').height(a);
                      }else{
                        $('.industries_box').height(b);
                      }
                    }
                  }else{
                    $('.success_rate_box').css('height','auto')
                    $('.industries_box').css('height','auto')
                  }
                });
              });
            }

            $scope.preApprovalContent = function(type) {
              if (!type || type != 'pre-approval') {
                return false;
              }
              $scope.analytic_title = 'My Pre-Approval Questions';

              // var job_id = 'J475JJC7Y1F1';
              $http.get( GlobalConstant.CandidateRootApi + '/job/analytics/' + $scope.jobObject.job.object_id )
              .then(function(response) {

                var data = response.data.data;
                //console.log(data)
                if (!data) {
                  $scope.showPreApproval = false;
                  $scope.manageAnalyticsShow(type);
                }else{
                  if(!data.pre_approval_questions || data.pre_approval_questions.length == 0){
                    $scope.showPreApproval = false;
                    $scope.manageAnalyticsShow(type);
                    return false;
                  }
                  $scope.showPreApproval = true;
                  $scope.data = data;
                  angular.forEach(data.pre_approval_questions, function(v,k){
                    var i = 0;
                    angular.forEach(v.stats, function(v2,k2){
                      v2.index = i;
                      i++;
                    })
                  })
                  $scope.preApproval = data.pre_approval_questions;
                  $scope.manageAnalyticsShow(type);
                }
              });
            }

            // job application tab
            $('.inner-circle').bind({
              mouseover: function() {
                $('.successRateTip').show();
              },
              mouseleave: function() {
                $('.successRateTip').hide();
              }
            })

            $('.inner-circle, .inner-circle2').mousemove(function(e) {
              var textLabel = $(this).attr('data-percent') + ' (';
              textLabel += $(this).attr('data-value') + ')';
              if ($(e.target).hasClass('inner-circle2')) {
                var textLabel = $('.inner-circle2').attr('data-percent') + ' (';
                textLabel += $('.inner-circle2').attr('data-value') + ')';
              }

              $('.successRateTip').css({
                left: (e.pageX - 35) + 'px',
                top: (e.pageY - 35) + 'px'
              }).text(textLabel);
            })

            $('body').append('<div class="successRateTip" style="display: none;"></div>');
          } // END : Analytics page

          // dashboard page count
          var animateCount = function(elem, count) {
            elem.text(count)
            var NumElem = elem;
            var getValue = NumElem.text();
            var parseVal = parseFloat(getValue.replace(',', '').replace(' ', ''))
            var StartVal = 0;

            $({
              someValue: StartVal
            }).animate({
              someValue: parseVal
            }, {
              duration: 1500,
              easing: 'swing', // can be anything
              step: function() { // called on every step
                // Update the element's text with rounded-up value:
                var n = Math.round(this.someValue);

                NumElem.text(commaSeparateNumber((n < 10) ? ("0" + n) : n));
                return false;
              }
            });
          }

          // // Get Candidate Job Watch List (Dashboard page)
          // $http.get( GlobalConstant.CandidateJobWatchlistApi )
          // .then(function(response) {
          //   var data = response.data.data;
          //   $scope.watchlist = data;
          //   var jobText = ($scope.watchlist.count == 0 || $scope.watchlist.count > 1) ? 'Jobs' : 'Job';
          //   $('.dash__ana-count--watch').parents('.dash__ana-summary').find('.dash__ana-desc span').text(jobText);
          //   animateCount($('.dash__ana-count--watch'), $scope.watchlist.count);
          //   $('#watchlist_scroll').TrackpadScrollEmulator();
          // });
          // // Get Candidate Job Active  (Dashboard page)
          // $http.get( GlobalConstant.CandidateJobActionApi )
          // .then(function(response) {
          //   var data = response.data.data;
          //   $scope.jobsActive = data;
          //   /*var x;
          //   for (x = 0; x < 5; x++) {
          //     console.log($scope.jobsActive.jobs[x].current_step);
          //   }*/
          // //     Will park this for sprint 1
          //   for (var i=0; i<$scope.jobsActive.jobs.length; i++) {
          //     if($scope.jobsActive.jobs[i].current_step != "Long List" && $scope.jobsActive.jobs[i].current_step != "Short List" && $scope.jobsActive.jobs[i].current_step != "Interview" && $scope.jobsActive.jobs[i].current_step != "Hired" && $scope.jobsActive.jobs[i].current_step != "Not Interested") {
          //       $scope.jobsActive.jobs[i].current_step = "Application Pending"
          //     }
          //   }
            
          //   var jobText = ($scope.jobsActive.count == 0 || $scope.jobsActive.count > 1) ? 'JOBS' : 'JOB';
          //   $('.dash_inc').eq(0).parents('.animateSection').find('.jobs-holder').text(jobText);
          //   animateCount($('.dash_inc').eq(0), $scope.jobsActive.count);

          //   $('#applied_jobs_scroll').TrackpadScrollEmulator();
          // });

          // $http.get( GlobalConstant.CandidateJobSuggestedApi )
          // .then(function(response) {
          //   var data = response.data.data;
          //   $scope.jobsSuggested = data;
          //   var jobText = ($scope.jobsSuggested.num_found == 0 || $scope.jobsSuggested.num_found > 1) ? 'JOBS' : 'JOB';
          //   $('.dash_inc').eq(2).parents('.animateSection').find('.jobs-holder').text(jobText);
          //   animateCount($('.dash_inc').eq(2), $scope.jobsSuggested.num_found);
          //   if ($scope.jobsSuggested.num_found) {
          //       $('#suggested_jobs_scroll').TrackpadScrollEmulator();
          //   }

          // });



          /** Messages Page **/

          if ($('body.messages').length) {


              $http.get( GlobalConstant.MessagesThreadApi )
              .then(function(response) {
                  var data = response.data.data;
                  $scope.threads = data;
                  $scope.messagesThreads = data;

              });


              $scope.getMessageThreads = function(thread_id, offset) {


                  if (offset) {
                      $scope.params.offset = offset;
                  } else {
                      delete $scope.params.offset;
                  }

                  $http.get(   GlobalConstant.MessagesThreadApi + '/' + thread_id + '/message', {async: false} )
                  .then(function(response) {
                      var data = response.data.data;
                      // ////console.log('thread');
                      // ////console.log(data);
                      if (offset) {

                          var liHeight = $(".tse-scroll-content li:first").height() + 25;
                          var incrementLiHieght = 0;

                          angular.forEach(data.messages, function(v, k) {
                              $scope.childThreads.messages.push(v);
                              incrementLiHieght += liHeight;
                          });

                          forceScrollBottom(incrementLiHieght);
                      } else {
                          $scope.childThreads = data;
                      }

                      $scope.more_present = data.scrolling.more_present;

                  })
                  .finally(function(){
                      if(!offset){
                          forceScrollBottom();
                      }

                  })

              }


              $scope.playSound = function (soundObj) {
                var sound = document.getElementById(soundObj);
                  sound.play();
              }


              if (getHash) {
                  getHash = getHash.split('/')
                  getHash.shift();
                  if (getHash[0] == 'thread') {
                      if (getHash[1]) {
                          $scope.getMessageThreads(getHash[1]);

                      }
                  }
              }

              $scope.listThread = function(threadId) {
                  messageScrollCounter = 1;
                  $scope.getMessageThreads(threadId, 0);
              }

              var forceScrollBottom = function(bottomPosition) {

                  var i = 0
                  var scrollInterval = setInterval(function() {

                      bottomPosition = (typeof bottomPosition != 'undefined') ? bottomPosition : $(".tse-scroll-content")[0].scrollHeight;
                      $(".tse-scroll-content").scrollTop(bottomPosition);
                      i++;

                      if (i > 5) {
                          clearInterval(scrollInterval);
                      }
                  }, 100);
              }


              var timeoutMessage = "";
              $scope.$watch(function() {
                  return location.hash
              }, function(urlHash) {
                  // alert(urlHash)
                  var hash = urlHash.split('/');

                  if (timeoutMessage) {

                      $timeout.cancel(timeoutMessage);
                  }

                  if (hash[2]) {

                      var newThreadCandidate = function() {

                          ////console.log(hash[2])
                          $http.get( GlobalConstant.APIRoot + 'messaging/thread/' + hash[2] + '/message/new' )
                          .then(function(response) {
                              var data = response.data.data;
                              ////console.log(data);
                              ////console.log(data.messages.length);

                              if (data.messages.length) {
                                  $scope.playSound('message_beep');
                                  $scope.getMessageThreads(hash[2]);
                              }
                          })

                          timeoutMessage = $timeout(newThreadCandidate, 2000);
                      }

                      timeoutMessage = $timeout(newThreadCandidate, 2000);

                  }

              });


          }
          // end messages page

          // All industries (Profile edit page)
          //$http.get(  GlobalConstant.APIRoot + 'static/options/industries/all' )
          $http.get(window.location.origin + '/api/industries/list-parent')
          .then(function(response) {
              var data = response.data;
              $scope.all_industries = data;
          });

          document.hoverIndustry = function(obj) {
              var checkbox = $(obj).find('input[name="industries"]')[0];
              document.industry_selected(checkbox)
          }

          $scope.onHoverSubIndustries = true;

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


                  // Message Page add message
                  var countEnterPress = 0;
                  $scope.addMessage = function(e) {

                    var add_message = $.trim($('#add_message').val());
                    var getHash = window.location.hash.substring(1)
                    getHash = getHash.split('/')
                    getHash.shift();
                    $scope.thread_id = getHash[1];

                    if (  e.type == 'submit') {
                      countEnterPress = 1;

                      if ($scope.thread_id) {
                        $scope.addMsgParams = {
                            "data": {
                                "message": add_message
                            }
                        };
                        $http.post( GlobalConstant.MessagesThreadApi + '/' + $scope.thread_id + '/message' ,  $scope.addMsgParams, {async: false} )
                        .then(function(response) {
                            if (response.status == 201) {
                              countEnterPress = 0;
                              $scope.childThreads.messages.unshift(response.data.data);
                              angular.element($('#add_message')).val("").removeClass('ng-valid')

                            }
                        })
                        .finally(function() {
                            forceScrollBottom();
                        });
                      }

                      e.preventDefault();
                    }
                  }
                  /******************** End Messages Page **/



                  $scope.unseen = function(e) {
                      var obj = $(e.target);
                      var object_id = obj.attr('data-object_id')
                      var countElem = $('.dash_inc').eq(1);
                      var count = parseInt(countElem.text());

                      $http.post(  GlobalConstant.CandidateJobWatchlistApi + '/' + object_id  )
                      .then(function(response) {

                          if (response.data.data.watchlist) {

                              if (obj.hasClass('custom-icon-eye')) {
                                  obj.removeClass('custom-icon-eye')
                                  obj.addClass('custom-icon-eye-blue')
                                  count++;
                              }

                          } else {

                              if (obj.hasClass('custom-icon-eye-blue')) {
                                  obj.removeClass('custom-icon-eye-blue')
                                  obj.addClass('custom-icon-eye');
                                  count--;
                              }

                          }
                          count = count < 10 ? '0' + count : count;
                          countElem.text(count);

                      });

                  }

                  $scope.work_history =[];

                  // Get Candidate Profile
                  //$http.get( GlobalConstant.profileApi )
                  //$http.get( window.location.origin + "/js/minified/test-data/test_my_profile_data.json" )
                  //$http.get( window.location.origin + "/api/candidate/myprofile/2132" )
                  

                  $http.get( window.location.origin + "/api/candidate/profile/details", {
                    headers: { 'Authorization': 'Bearer ' + token }
                  })
                    .then(function(response) {

                      var data = response.data;
                      // console.log('profile ', data);
                      ////console.log(data)
                      //Variables
                      // Add initial to be used in default image
                      $scope.F_initial = data.first_name;
                      $scope.temp_firstname = data.first_name;;
                      $scope.F_initial = $scope.F_initial.substr(0, 1);

                      $scope.L_initial = data.last_name;
                      $scope.temp_lastname = data.last_name;
                      $scope.L_initial = $scope.L_initial.substr(0, 1);

                      $scope.initial = $scope.F_initial + $scope.L_initial;

                      if($(".randomInitialColor").hasClass("member-initials--sky")) {
                        $scope.profile_color = "member-initials--sky";
                      }
                      else if($(".randomInitialColor").hasClass("member-initials--pvm-purple")) {
                        $scope.profile_color = "member-initials--pvm-purple";
                      }
                      else if($(".randomInitialColor").hasClass("member-initials--pvm-green")) {
                        $scope.profile_color = "member-initials--pvm-green";
                      }
                      else if($(".randomInitialColor").hasClass("member-initials--pvm-red")) {
                        $scope.profile_color = "member-initials--pvm-red";
                      }
                      else if($(".randomInitialColor").hasClass("member-initials--pvm-yellow")) {
                        $scope.profile_color = "member-initials--pvm-yellow";
                      }

                      angular.forEach(data, function(v, k) {
                          $scope[k] = v;
                      })

                      // set obkey if not set
                      if (!$cookies.get('obkey')) {

                          $cookies.put('obkey', data.ob_key, {
                              'path': '/'
                          });
                      }

                      $scope.profile_image = $scope.docs.profile_image;
                      // show preview if true
                      $scope.preview_img = true;

                      angular.forEach(data.qualifications, function(v, k) {

                          var c_date = v.completed_date;
                          if (c_date) {
                              c_date = c_date.split('-');
                              data.qualifications[k].date_x = c_date[1] + '-' + c_date[0] + '-' + c_date[2];
                          } else {
                              data.qualifications[k].date_x = null;
                          }
                      })

                      $scope.educations = data.qualifications;

                      // PLFE-159 fix on disabling completion date field
                      angular.forEach($scope.educations, function(value) {
                        if (!value.completed_date) {
                          value.current_study_edit = true;
                        } else {
                          value.current_study_edit = false;
                        }
                      });

                      if (data.docs.portfolio) {
                          $scope.portfolio = data.docs.portfolio;
                      }

                      if (data.docs.resume) {
                          $scope.resume = data.docs.resume.doc_url;
                      }

                      if (data.docs.icebreaker_video) {
                        $scope.icebreaker_video = $scope.docs.icebreaker_video;

                        // $scope.resume = $scope.docs.resume.doc_url;

                        // show manifest url video if false and hide preview img
                        if ( data.docs.icebreaker_video.doc_id != '' && data.docs.icebreaker_video.doc_url == '') {
                            $scope.preview_img = 'loading';

                        } else {


                          var docurl = data.docs.icebreaker_video.doc_url;
                          var docId = data.docs.icebreaker_video.doc_id;
                          if (docurl) {
                            var docurlcount = docurl.split('/');

                            if ( docurlcount.length == 1 ) {
                              $scope.preview_img = 'error';
                              $scope.errorVideo = data.docs.icebreaker_video.doc_url

                            }else{

                              $scope.preview_img = false;

                              if ($('#vid1').length) {
                                var vidDuration, intWhole, intFloating;

                                var myPlayer = amp('vid1', {
                                    "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                                    "nativeControlsForTouch": false,
                                    autoplay: true,
                                    controls: true,
                                    width: "275",
                                    logo: {
                                        "enabled": false
                                    },
                                    poster: ""
                                }, function() {
                                    // open camera modal

                                    if ($scope.mobile_agent == false) {
                                      this.addEventListener('click', function(elm) {
                                        if (!$(elm.target).hasClass('vjs-control') && !$(elm.target).hasClass('vjs-big-play-button')) {
                                          // $scope.open_camera();
                                          $scope.open_camera_new();
                                        }
                                      });
                                    }

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
                                    SetCandidateAnalyticsVid(vidDuration);

                                  });
                                });

                                function SetCandidateAnalyticsVid (obj) {
                                  var data = {
                                    "vid_viewtime" : 0,
                                    "vid_duration" : obj,
                                    "vid_url" : $scope.icebreaker_video.doc_url
                                  }
                                  CandidateSrvcs.setCandidateVid(data);
                                }

                                if ($scope.icebreaker_video) {

                                    if($scope.icebreaker_video.doc_url) {
                                         myPlayer.src([{
                                            src: $scope.icebreaker_video.doc_url,
                                            type: "application/vnd.ms-sstr+xml"
                                        }]);
                                    }

                                } else {
                                    $scope.preview_img = true;

                                }

                              }
                            }
                          } else if (docId) {
                            console.log("uploading profile video");
                            $scope.preview_img = 'loading';
                          }
                        }
                      }

                      if (data.industry.length > 0) {

                          $scope.industry = {
                              id: data.industry.data.industry.id,
                              industry_display_name: data.industry.data.industry.display_name,
                              sub_industry: data.industry.data.sub
                          };
                      }
                    

                      if (data.nationality) {
                          $scope.nationality = {
                              display_name: data.nationality.displayName,
                              id: data.nationality.id
                          };
                      }

                      // if (data.preferred_location !== null) {
                      //     $scope.preferred_location_region = {
                      //         id: data.preferred_location.data.region.id,
                      //         display_name: data.preferred_location.data.region.display_name
                      //     };

                      //     $scope.preferred_location_city = {
                      //         id: data.preferred_location.data.city.id,
                      //         display_name: data.preferred_location.data.city.display_name
                      //     };


                      //     $scope.preferred_location_suburb = {
                      //         id: data.preferred_location.data.suburb.id,
                      //         display_name: data.preferred_location.data.suburb.display_name,
                      //     };
                      // }

                      /**CANDIDATE PROFILE**/
                      if (data.work_type !== null) {
                          $scope.work_type = {
                              display_name: data.work_type.display_name,
                              id: data.work_type.id
                          };
                      }

                      $scope.willing_to_relocate = (data.willing_to_relocate == true) ? 'Yes' : 'No';

                      angular.forEach(data.work_history, function(v, k) {

                          var s_date = data.work_history[k].start_date;
                          if (s_date != null) {
                            s_date = s_date.split('-');
                            data.work_history[k].date_x = s_date[1] + '-' + s_date[0] + '-' + s_date[2];
                          }

                      })

                      if( data.work_history.length != 0){
                          $scope.work_history = data.work_history;
                      }
                      $scope.preload = false;
                      $scope.contentloader = true;


                      $scope.newToWorkForceField = data.new_to_workforce

                      $scope.newToWorkForce = function(v){
                          var formData = {
                              "data": {
                                  new_to_workforce: v
                              }
                          };

                          UpdateUser(formData);
                          $scope.showSuccessWorkforce = true;
                      };


                      //Watch Work history list changing
                      $scope.$watchCollection('work_history', function(n, o){

                          if (n.length != o.length) {
                              if (n.length == 0 ){
                                  $scope.NoWorkExp =  true;
                                  $scope.newToWorkForceField = data.new_to_workforce
                              }else{
                                $scope.NoWorkExp = false
                              };

                          }

                      });

                      //Delete Work History item

                      //Date Picker Fix
                      $scope.picker = {
                          opened: false
                      };

                      $scope.pickerEnd = {
                          opened: false
                      };

                      $scope.openPicker = function() {
                          $timeout(function() {
                              $scope.picker.opened = true;
                          });
                      };

                      $scope.openPickerEditWH = function() {

                          $scope.picker.opened = true;
                          // ////console.log($scope.picker.opened);
                      };

                      $scope.initDatePicker = function(e) {

                           $(e.target).datetimepicker({
                               timepicker:false,
                               format:'Y-m-d'
                          });
                           $(e.target).datetimepicker("show");
                      }

                      $scope.openDatePicker = function() {
 
                          $(".my_datapicker").datepicker({
                              dateFormat: 'dd-mm-yy'
                          });

                          $(".my_datapicker").datepicker("show");

                      };


                      $scope.closePicker = function() {
                          $scope.picker.opened = false;
                      };

                      /***** GET DROPDOWN VALUE FOR INLINE FIELD******/

                      //Get Nationalities
                      $scope.nationalities = []
                      $scope.loadNationalities = function() {
                          $http.get(GlobalConstant.StaticOptionNationalitiesApi).then(function(response) {
                              $scope.nationalities = response.data.data;
                          });
                      }

                      $scope.$watch('nationality.id', function(newVal, oldVal) {

                          if (angular.isUndefined(newVal) == false) {

                              if (newVal.id !== oldVal) {
                                  var selected = $filter('filter')($scope.nationalities, {
                                      id: newVal
                                  });
                                  if (angular.isUndefined(selected[0]) == false) {
                                      $scope.nationality.display_name = selected[0].display_name;
                                  }

                              }
                          }

                      });
                      $scope.hidesubindustry = true;
                      $scope.$watch('Industry_wh', function(newVal, oldVal) {


                          if (angular.isUndefined(newVal) == false) {

                              var id = newVal.id;
                              // alert(id)

                              $scope.hidesubindustry = true;
                              $http.get(GlobalConstant.StaticOptionSubIndustryApi + '/' + id).then(function(response) {
                                  // ////console.log(response)
                                  $scope.subIndustry = response.data.data;
                                  $scope.hidesubindustry = false;


                              });
                          }
                      });


                      $scope.loadSubIndustriesWHE = function(industry_id, subdustry_id, elem) {

                          elem.html("");

                          $http.get(GlobalConstant.StaticOptionSubIndustryApi + '/' + industry_id)

                          .then(function(response) {
                              // ////console.log(response)
                              if (response.data.data) {

                                  var str = '<select name="subindustry_edit"><option value="">Select Sub Industry</opiton>';

                                  angular.forEach(response.data.data, function(v, k) {
                                      // ////console.log(v)
                                      if (v.id == subdustry_id) {
                                          str += '<option selected value="' + v.id + '">' + v.display_name + '</opiton>';
                                      } else {
                                          str += '<option value="' + v.id + '">' + v.display_name + '</opiton>';
                                      }


                                  })
                                  str += '</select>';
                                  elem.append(str);

                              }


                          });
                          elem.append('</select>');
                      }

                      document.workHistoryIndustryWatch = function(obj) {
                          var obj = $(obj);
                          var industry_id = obj.val();
                          var targetElm = obj.parent().next().find('.subindustries_select');

                          $scope.loadSubIndustriesWHE(industry_id, false, targetElm);
                      }

                      //Get Industry
                      $scope.industries = []
                      $scope.loadIndustries = function() {
                          //$http.get(GlobalConstant.StaticOptionIndustryApi).then(function(response) {
                            $http.get(window.location.origin + '/api/industries/list-parent').then(function(response){
                              $scope.industries = response.data.data;
                          });
                      }

                      $scope.$watch('industry.id', function(newVal, oldVal) {
                          if (typeof newVal != 'undefined' && newVal.id !== oldVal) {
                              var selected = $filter('filter')($scope.industries, {
                                  id: newVal
                              });

                              if (angular.isUndefined(selected[0]) == false) {

                                  $scope.industry.industry_display_name = selected[0].display_name;
                                  $scope.industry.sub_industry.id = newVal;
                                  $scope.loadSubIndustries();
                              }

                          }

                      });

                      $scope.subIndustries = []
                      $scope.loadSubIndustries = function() {


                          $http.get(GlobalConstant.StaticOptionSubIndustryApi + '/' + $scope.industry.id)
                              .then(function(response) {
                                  $scope.subIndustries = response.data.data;
                              });
                      }

                      $scope.$watch('industry.sub_industry.id', function(newVal, oldVal) {

                          if (typeof newVal != 'undefined' && newVal !== oldVal) {
                              var selected = $filter('filter')($scope.subIndustries, {
                                  id: newVal
                              });

                              if (angular.isUndefined(selected[0]) == false) {


                                  $scope.industry.sub_industry.display_name = selected[0].display_name;

                              }

                          }

                      })

                      //Get Work types
                      $scope.work_types = []
                      $scope.loadWorkType = function() {
                          $http.get(GlobalConstant.StaticOptionWorkTypeApi).then(function(response) {
                              $scope.work_types = response.data.data;
                          });
                      }

                      $scope.$watch('work_type.id', function(newVal, oldVal) {

                          if (angular.isUndefined(newVal) == false) {

                              if (newVal.id !== oldVal) {

                                  var selected = $filter('filter')($scope.work_types, {
                                      id: newVal
                                  });
                                  if (angular.isUndefined(selected[0]) == false) {
                                      $scope.work_type.display_name = selected[0].display_name;
                                  }
                              }
                          }

                      });

                      $scope.WorkType_wh = {};
                      $scope.WorkType_wh.display_name = false
                      $scope.WorkType_wh.id = false;

                      $scope.$watch('WorkType_wh.id', function(newVal, oldVal) {

                          if (angular.isUndefined(newVal) == false) {

                              if (newVal !== oldVal) {

                                  var selected = $filter('filter')($scope.work_types_wh, {
                                      id: newVal
                                  });

                                  if (angular.isUndefined(selected[0]) == false) {
                                      $scope.WorkType_wh.display_name = selected[0].display_name;
                                      $scope.WorkType_wh.id = selected[0].id;
                                  }
                              }
                          }

                      });

                      //Willing to relocate top section / profile edit
                      if(data.willing_to_relocate){
                           $scope.relocateClass = 'checkbox-checked2';
                      }else{
                           $scope.relocateClass = 'checkbox-uncheck';
                      }

                      $scope.willingToRelocate = function() {

                          data.willing_to_relocate = data.willing_to_relocate ? false : true;

                          var formData = {
                            "data": {
                                willing_to_relocate: data.willing_to_relocate
                            }
                          };
                          
                          UpdateCandidateOnly(formData);

                          if(data.willing_to_relocate){
                              $scope.relocateClass = 'checkbox-checked2';
                          }else{
                              $scope.relocateClass = 'checkbox-uncheck';
                          }


                      }

                      //Willing to relocate
                      $scope.willing_to_relocate_option = [{
                          value: 1,
                          text: 'Yes'
                      }, {
                          value: 0,
                          text: 'No'
                      }];
                      $scope.showRelocate = function() {
                          var selected = $filter('filter')($scope.willing_to_relocate_option, {
                              value: $scope.willing_to_relocate
                          });
                          if ($scope.willing_to_relocate && selected.length) {
                              $scope.willing_to_relocate = selected[0].text;
                          };
                      };


                      //Preferred location
                      $scope.suburbs = [];
                      $scope.loadSuburbs = function(getCityId) {
                          var id = getCityId;
                          if (!id) return false;
                          $http.get(GlobalConstant.StaticOptionLocationsApi + '/suburbs/' + id).then(function(response) {
                              $scope.suburbs = response.data.data;
                          });
                      }


                      $scope.cities = [];
                      $scope.loadCities = function(getRegionId) {
                          var id = getRegionId;
                          if (!id) return false;
                          $http.get(GlobalConstant.StaticOptionLocationsApi + '/cities/' + id).then(function(response) {
                              $scope.cities = response.data.data;

                              $('select[name=city]').change(function() {
                                  var str = $(this).val();
                                  var nstr = parseInt(str.replace('number:', ''));

                                  $scope.loadSuburbs(nstr);
                              });

                          });
                      }

                      $scope.regions = [];
                      $scope.loadRegions = function() {
                          $http.get(GlobalConstant.StaticOptionLocationsApi + '/regions').then(function(response) {
                              $scope.regions = response.data.data;

                              //get dropdown values on load
                              if ($scope.preferred_location_region.id !== null || $scope.preferred_location_city.id !== null) {
                                  $scope.loadCities($scope.preferred_location_region.id);
                                  $scope.loadSuburbs($scope.preferred_location_city.id);
                              }


                              //Change dropdown value on change
                              $('select[name=region]').change(function() {

                                  var str = $(this).val();
                                  var nstr = parseInt(str.replace('number:', ''));

                                  $scope.loadCities(nstr);
                                  $scope.loadSuburbs(nstr);
                              });
                          });
                      }

                      $scope.$watch('region.id', function(newVal, oldVal) {
                          if (newVal !== oldVal) {
                              var selected = $filter('filter')($scope.regions, {
                                  id: newVal
                              });
                              if (angular.isUndefined(selected[0]) == false) {
                                  $scope.region.display_name = selected[0].display_name + ',';
                                  $scope.region.id = selected[0].id;
                              }
                          }
                      });



                      $scope.$watch('city.id', function(newVal, oldVal) {
                          if (newVal !== oldVal) {
                              var selected = $filter('filter')($scope.cities, {
                                  id: newVal
                              });
                              if (angular.isUndefined(selected[0]) == false) {
                                  $scope.city.display_name = selected[0].display_name + ',';
                                  $scope.city.id = selected[0].id;
                              }
                          }
                      });


                      $scope.$watch('suburb.id', function(newVal, oldVal) {
                          if (newVal !== oldVal) {
                              var selected = $filter('filter')($scope.suburbs, {
                                  id: newVal
                              });
                              $scope.suburb.display_name = selected[0].display_name;
                              $scope.suburb.id = selected[0].id;
                          }
                      });

                      $scope.$watch('preferred_location_region.id', function(newVal, oldVal) {
                          if (newVal !== oldVal) {
                              var selected = $filter('filter')($scope.regions, {
                                  id: newVal
                              });
                              if (angular.isUndefined(selected[0]) == false) {
                                  $scope.preferred_location_region.display_name = selected[0].display_name;
                                  $scope.preferred_location_region.id = selected[0].id;
                              }
                          }
                      });

                      $scope.$watch('preferred_location_city.id', function(newVal, oldVal) {
                          if (newVal !== oldVal) {
                              var selected = $filter('filter')($scope.cities, {
                                  id: newVal
                              });
                              if (angular.isUndefined(selected[0]) == false) {
                                  // put comma on region display
                                  var str = $scope.preferred_location_region.display_name;
                                  str = str.replace(/^[,\s]+|[,\s]+$/g, '');
                                  // $scope.preferred_location_region.display_name = str + ', ';

                                  $scope.preferred_location_city.display_name = selected[0].display_name;
                                  $scope.preferred_location_city.id = selected[0].id;
                              }
                          }
                      });

                      $scope.$watch('preferred_location_suburb.id', function(newVal, oldVal) {
                          if (newVal !== oldVal) {
                              var selected = $filter('filter')($scope.suburbs, {
                                  id: newVal
                              });
                              if (angular.isUndefined(selected[0]) == false) {

                                  var str = $scope.preferred_location_city.display_name;
                                  str = str.replace(/^[,\s]+|[,\s]+$/g, '');
                                  // $scope.preferred_location_city.display_name = str + ', ';

                                  $scope.preferred_location_suburb.display_name = selected[0].display_name;
                                  $scope.preferred_location_suburb.id = selected[0].id;
                              }
                          }
                      });

                      $scope.checkRegion = function(data) {
                          if (data === '' || data === 'null') {
                              return "Region cannot be empty";
                          }
                      };


                       /**Location Start**/
                      $scope.location = {}
                      $scope.countries = [];
                      $scope.alldata = []
                      $scope.LoadCountries = function(){
                        //$http.get(GlobalConstant.StaticOptionsApi+'/api/countries')
                        // $http.get(window.location.origin + '/js/minified/test-data/test_countries_data.json')
                        $http.get( window.location.origin + "/api/country/list" )
                        .then(function(response){
                            $scope.countries = response.data;

                            $('select[name=country]').change(function() {
                                var country = angular.element(  $(this) ).val()
                                var nstr = parseInt(country.replace('number:', ''));

                                angular.element(  $('input[name=areaid]') ).val(null)
                                angular.element(  $('input[name=area]') ).val(null)

                                $scope.preferred_location.data.display_name = null;
                                $scope.preferred_location.data.id = null;


                                $scope.preferred_location.data.country.id = nstr
                               // $scope.LoadAreas( parseInt(nstr) ) ;
                            });

                        });
                      }

                      $scope.$watch('preferred_location.data.country.id', function(newval, oldval){
                          ////console.log('change me')

                          if (newval !== oldval) {
                              ////console.log(1)
                              var selected = $filter('filter')($scope.countries, {
                                  id: newval
                              });

                              if ($scope.alldata.length != 0) {
                                  $scope.alldata = []
                              }

                              ////console.log(selected)
                              if (selected.length != 0) {
                                  ////console.log(1.1)
                                  $scope.preferred_location.data.country.display_name = selected[0].display_name;
                                  $scope.preferred_location.data.country.id = selected[0].id;
                                  $scope.preferred_location.data.display_name = ''
                                  $scope.preferred_location.data.id = ''

                                  // $scope.alldata = []
                                  // $scope.alldata.push({display_name: $scope.preferred_location.data.id, area_id: $scope.preferred_location.data.display_name  })

                                  ////console.log($scope.preferred_location.data)
                              }
                              else{
                                  ////console.log(1.2)
                                  if ($scope.preferred_location.data.display_name == '' && $scope.preferred_location.data.id == '') {
                                      angular.element(  $('input[name=areaid]') ).val(null)
                                      angular.element(  $('input[name=area]') ).val(null)

                                      $scope.preferred_location.data.display_name = ''
                                      $scope.preferred_location.data.id = ''
                                  }

                              }
                          }else{
                              ////console.log(2)
                          }

                      }, true)

                      $scope.$watch('preferred_location.data.id', function(newval, oldval) {
                        if (newval !== oldval) {
                          if ($scope.alldata.length != 0) {
                            $scope.alldata = []
                          }
                          if (newval != null) {
                              ////console.log('a')
                              var selected = $filter('filter')($scope.areas, {
                                  id: newval
                              }, true);
                          } else {
                             ////console.log('b')
                            $scope.preferred_location.data.display_name = ''
                            $scope.preferred_location.data.id = ''
                            ////console.log($scope.preferred_location.data )
                          }
                        }
                      });

                      angular.element($('body')).click(function(){
                        if (angular.element($('#autoDataLocation')).is(':visible')) {
                          angular.element(  $('#autoDataLocation') ).hide()
                        }
                      });

                      $scope.GetAreas = function(data, country_id){

                        angular.element(  $('#autoDataLocation') ).show()
                        angular.element(  $('input[name=areaid]') ).val('aa')
                        $scope.preferred_location.data.id = 'aa';
                        if ($scope.alldata.length != 0) {
                          $scope.alldata =[]
                        }

                        //$http.get(GlobalConstant.APIRoot+'static/autocomplete/location?q='+data+'&country_id='+country_id )
                        $http.get( window.location.origin + "/api/location/auto-complete/" + data + "/" +country_id )
                        .then(function(response){

                          $scope.areas = response.data

                        });
                      }


                      $scope.getAutoCompleteData = function(data){

                          //$scope.preferred_location.data.display_name = data.display_name;
                          //$scope.preferred_location.data.id = data.id;

                          angular.element(  $('input[name=areaid]') ).val( data.id )
                          angular.element(  $('input[name=area]') ).val( data.display_name )

                          $scope.alldata = []
                          $scope.alldata.push({display_name: data.display_name, area_id: data.id  })

                          angular.element(  $('#autoDataLocation') ).hide()
                      }

                      /**Location End**/

                      //FORM FIELD: Preferred Location data gathering + saving
                      $scope.updateLocation = function(data) {

                         /* if ($scope.preferred_location_city.id == null && $scope.preferred_location_suburb.id == null) {
                              var preferred_location = $scope.preferred_location_region.id;
                          } else if ($scope.preferred_location_suburb.id == null) {
                              var preferred_location = $scope.preferred_location_city.id;
                          } else {
                              var preferred_location = $scope.preferred_location_suburb.id;
                          }*/

                          if ($scope.alldata[0]) {
                              ////console.log(0)
                              $scope.preferred_location.data.display_name = $scope.alldata[0].display_name;
                              $scope.preferred_location.data.id =  $scope.alldata[0].area_id;

                              ////console.log($scope.preferred_location.data)
                              ////console.log($scope.alldata[0])
                              if (  $scope.preferred_location.data.id != ''  ) {
                                  var preferred_location = $scope.preferred_location.data.id
                              }else{
                                  ////console.log($scope.alldata[0])
                                  var preferred_location = {country_id: $scope.preferred_location.data.country.id, location:  $scope.preferred_location.data.display_name }
                              }
                          }else{
                              ////console.log(1)
                              ////console.log($scope.preferred_location.data)
                               if (  data.area != null ) {
                                  var preferred_location = {country_id: data.country, location: data.area }
                              }else{
                                  var preferred_location = data.country
                              }
                          }

                          ////console.log(preferred_location)
                          //return false;
                          var formData = {
                              "data": {
                                  preferred_location: preferred_location
                              }
                          };

                          // if (!$scope.preferred_location_city.id) {
                          //     $scope.preferred_location_city.display_name = null;
                          // }

                          // if (!$scope.preferred_location_suburb.id) {
                          //     $scope.preferred_location_suburb.display_name = null;
                          // }


                          UpdateUser(formData);
                      }

                      //FORM FIELD: Username Data gathering + saving
                      $scope.space_validator = false;
                      $scope.updateUserName = function() {
                        var firstname_valid = $scope.first_name ? $scope.first_name : '';
                        var lastname_valid = $scope.last_name ? $scope.last_name : '';

                        var formData = {
                          "data": {
                              first_name: $scope.first_name,
                              last_name: $scope.last_name,
                              nickname: $scope.nickname
                          }
                        };

                        if (firstname_valid.length != 0 && lastname_valid.length != 0) {
                          UpdateUser(formData);
                          $scope.showuserForm();
                        } else {
                          $scope.space_validator = true;
                          $scope.first_name = $scope.temp_firstname;
                          $scope.last_name = $scope.temp_lasstname
                        }
                      }

                      $scope.resetUsername = function (d) {
                        $scope.first_name = $scope.temp_firstname;
                        $scope.last_name = $scope.temp_lastname;
                        // console.log('reset ', $scope.last_name, $scope.first_name);
                        $scope.showuserForm();
                      };

                      $scope.showuserForm = function(){
                        if ($scope.showNameInfo) {
                          $scope.showNameInfo = false;
                        } else {
                          $scope.showNameInfo = true;
                        }
                      }

                      //FORM FIELD: Salary data gathering + saving
                      $scope.updateSalaryRange = function() {

                          var formData = {
                              "data": {
                                  min_salary: $scope.min_salary,
                                  max_salary: $scope.max_salary
                              }
                          };

                          UpdateUser(formData);
                      }

                      $scope.disableAlert = function(){
                          $scope.ProfileUpdated = false;
                      }
                      $scope.ProfileUpdated = false;

                      var UpdateUser = function(formData) {
                        //$http.put( GlobalConstant.profileApi, formData)
                        //$http.put( window.location.origin + "/api/candidate/myprofile", formData )
                        $http.put( window.location.origin + "/api/candidate/profile/update-name/" + $scope.candidateId, formData, {
                           headers: { 'Authorization': 'Bearer ' + token }})
                          .then(function(response) {
                              ////console.log(response)
                              // alert('update success')
                              //$('#Form_my_file').attr('data-ob_key', response.data.data.ob_key);
                              $scope.ProfileUpdated = true;
                          }, function(response) {
                              //Error Condition
                              // ////console.log(response);
                             // alert('some error');
                          });
                      }

                      var UpdateCandidateOnly = function(formData) {
                        
                        $http.put( window.location.origin + "/api/candidate/profile/update-candidate-only/" + $scope.candidateId, formData, {
                           headers: { 'Authorization': 'Bearer ' + token }})
                          .then(function(response) {

                              $scope.ProfileUpdated = true;
                          }, function(response) {
   
                          });
                      }

                      $scope.updateCandidate = function(formData) {
                        var getDataKey = this.$editable.name;
                        var getDataVal = this.$data;
                        var formData = '{"data": {"' + getDataKey + '" : "' + getDataVal + '"}}';
                        formData = JSON.parse(formData);

                        $http.put( window.location.origin + "/api/candidate/profile/update-candidate/" + $scope.candidateId, formData, {
                           headers: { 'Authorization': 'Bearer ' + token }})
                          .then(function(response) {
                            // success
                              $scope.ProfileUpdated = true;
                          }, function(response) {
                            // error
                          });
                      }

                      $scope.updateCandidateOnly = function(formData) {

                        var getDataKey = this.$editable.name;
                        var getDataVal = this.$data;
                        var formData = '{"data": {"' + getDataKey + '" : "' + getDataVal + '"}}';
                        formData = JSON.parse(formData);

                        $http.put( window.location.origin + "/api/candidate/profile/update-candidate-only/" + $scope.candidateId, formData, {
                           headers: { 'Authorization': 'Bearer ' + token }})
                          .then(function(response) {
                            // success
                              $scope.ProfileUpdated = true;
                          }, function(response) {
                            // error
                          });
                      }

                      $scope.updateUser = function() {

                          switch (this.$editable.name) {
                              case 'nationality.id':
                                  var getDataKey = 'nationality';
                                  break;
                              case 'industry.id':
                                  var getDataKey = 'industry';
                                  $scope.industry.sub_industry.display_name = 'Add Sub Industry';
                                  break;
                              case 'industry.sub_industry.id':
                                  var getDataKey = 'industry';
                                  break;
                              case 'work_type.id':
                                  var getDataKey = 'work_type';
                                  break;
                              default:
                                  var getDataKey = this.$editable.name;
                          }


                          //Check if date field
                          if (getDataKey === 'dob') {
                              var dobnew = new Date('"' + this.$data + '"');
                              var getDataVal = $filter('date')(dobnew, "dd-MM-yyyy");

                          } else {
                              var getDataVal = this.$data;
                          }

                          var formData = '{"data": {"' + getDataKey + '" : "' + getDataVal + '"}}';
                          formData = JSON.parse(formData);

                          UpdateUser(formData);

                          //Workhistory
                          $scope.addUser = function() {
                              $scope.inserted = {
                                  id: $scope.users.length + 1,
                                  name: '',
                                  status: null,
                                  group: null
                              };
                              $scope.users.push($scope.inserted);
                          };

                      };

                      // update for about field on my account page
                      $scope.updateUserAbout = function($data) {
                        var formData = {
                            data: $data
                        };

                        $http.put( window.location.origin + "/api/candidate/profile/update-candidate-only/" + $scope.candidateId, formData, {
                           headers: { 'Authorization': 'Bearer ' + token }} )
                          .then(function(response) {
                            // success
                              $scope.ProfileUpdated = true;
                          }, function(response) {
                            // error
                          });

                      };

                      /**CANDIDATE PROFILE END**/

                      /*CANDIDATE WORK HISTORY*/

                      //$http.get(GlobalConstant.StaticOptionWorkTypeApi).then(function(response) {
                      $http.get( window.location.origin + "/api/work-types/list" ).then(function(response) {
                        $scope.work_types_wh = response.data;
                      });

                      // Qualification Providers (my-profile/edit, for work history autocomplete)
                      //$http.get(GlobalConstant.StaticOptionsQualificationProvidersApi).then(function(response) {
                      $http.get( window.location.origin + "/api/qualification-provider/list" ).then(function(response) {
                        $scope.qualificationProviders = response.data;
                      });

                      //$http.get(GlobalConstant.StaticOptionIndustryApi).then(function(response) {
                      $http.get( window.location.origin + "/api/industries/list-parent" ).then(function(response) {
                        $scope.industry_wh = response.data;
                        $scope.industry_whe = response.data;
                      });

                      //$http.get(GlobalConstant.StaticOptionIndustryApi).then(function(response) {
                      //    $scope.industry_whe = response.data.data;
                      //});

                      $scope.numbersOnly = function(evt) {
                          evt = (evt) ? evt : window.event;
                          var charCode = (evt.which) ? evt.which : evt.keyCode;
                          if (isNaN(String.fromCharCode(charCode))) {
                              evt.preventDefault();
                          }
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
                              if (type == 'video') {
                                  var deleteURL = GlobalConstant.APIRoot + 'candidate/videodoc/icebreaker_video';
                              }else {
                                  var deleteURL = GlobalConstant.APIRoot + 'candidate/doc/' + id;
                              }
                              $http.delete( deleteURL)
                                  .then(function(response) {
                                      ////console.log(response)
                                      if (type == 'video') {
                                          delete $scope.docs.icebreaker_video;
                                          $scope.preview_img = true;
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

                      $scope.showSubIndustries = function(industry) {
                        $scope.sub_industries = [];
                        
                        $http.get(window.location.origin + '/api/industries/list-parent-and-sub').then(function(response){

                          angular.forEach(response, function(val, key) {
                            angular.forEach(val, function(sub_val, sub_key) {
                              if(industry == sub_val.id) {
                                $scope.sub_industries = sub_val.sub;
                              }
                            });
                          });
                        });
                        $scope.showSubClassification = true;
                      };

                      /* EDUCATION */

                      $scope.qualification = 5;
                      $scope.qualification_provider = 1;
                      $scope.qualifications = [];
                      $http.get(window.location.origin + "/api/qualification/list").then(function(response) {
                          $scope.qualifications = response.data.data;
                      });

                      $scope.qualification_providers = [];
                      //$http.get(GlobalConstant.StaticOptionsApi + '/qualification_providers').then(function(response) {
                      $http.get( window.location.origin + "/api/qualification-provider/list" ).then(function(response) {
                          $scope.qualification_providers = response.data.data;
                      });

                      $scope.CancelReferenceForm = function() {
                          $scope.showReferenceForm = false;
                      }

                      $scope.AddReferenceForm = function() {
                          $scope.showReferenceForm = true;
                          $('#addReferenceForm input:text').val("");
                          $('#addReferenceForm textarea').val("");
                      };

                      // Create Reference
                      $scope.AddReference = function() {

                        var formData = {};

                        $('#addReferenceForm').serializeArray().map(function(item) {
                            formData[item.name] = item.value;
                        });

                        //http.post( GlobalConstant.ReferenceApi ,  { data: formData} )
                        $http.post( window.location.origin + "/api/candidate/reference/create", { data: formData}, {
                           headers: { 'Authorization': 'Bearer ' + token }} )
                          .then(function(response) {
                            //success
                            if (response.status == 201) {
                                var data = response.data;
                                var displayVal = {
                                  id: data.id,
                                  employer_name: data.employer_name,
                                  companyName: data.company_name,
                                  description: data.description,
                                  contact_phone: data.contact_phone,
                                  contactEmail: data.contact_email,
                                };
                                $scope.references.push(displayVal);
                                $scope.showReferenceForm = false;
                            }
                          }, function(response) {
                            //Error Condition
                            alert('Error found: Please review form');
                          });
                      }

                      // Delete Reference
                      $scope.deleteReference = function(id) {
                        //var deleteURL = GlobalConstant.ReferenceApi + '/' + id;
                        var deleteURL = window.location.origin + "/api/candidate/reference/delete/" + id;
                        $http.delete( deleteURL )
                          .then(function() {
                            $('#ref_' + id).slideToggle();
                          });
                      };

                      // Edit Reference
                      $scope.EditReference = function($data, id) {
                        //$http.put( GlobalConstant.ReferenceApi + '/' + id , {data: $data } )
                        $http.put( window.location.origin + "/api/candidate/reference/update/" + id, { data: $data} )
                          .then(function(response) {
                              //success
                          }, function(response) {
                              //Error Condition
                              alert('Error found: Please review form');
                          });
                      }

                      // $scope.hideQualifications = true;

                      /*Add Work Histroy*/

                      $scope.delAcct = function(history, index) {
                        var cutAcct = $scope.work_history.indexOf(history);
                        $scope.work_history[cutAcct].key_accountabilities.splice(index, 1);
                      }

                      $scope.AddMoreResponsiblity = function (index) {
                        $scope.work_history[index].key_accountabilities.push('');
                      }

                      $scope.CancelWorkHistoryForm = function(history) {
                        $scope.showWorkHistoryForm = false;
                        if(!('id' in history)) {
                          var index = $scope.work_history.indexOf(history);
                          $scope.work_history.splice(index, 1);
                        } else {
                          history.isWHID = -1;
                        }
                      }


                      $scope.openWorkHistoryEdit = function(wh) {
                        $scope.showWorkHistoryForm = true;
                        angular.forEach($scope.work_history, function(val, key) {
                          val.isWHID = -1;
                        });

                        wh.isWHID = wh.id;
                        wh.industrySelect = wh.industries[0];
                        angular.forEach($scope.all_industries, function(val, key) {
                          if(wh.industrySelect == val.id) {
                            $scope.sub_industries = val.sub;
                          }
                        });
                        wh.sub_industrySelect = wh.industries[1];
                        if(wh.end_date === null) {
                          wh.currently_work_here = true;
                        }
                        console.log("scopoe educs:", wh);
                      }

                      $scope.AddWorkHistoryForm = function() {
                        $scope.showWorkHistoryForm = true;
                        var newWorkHistory = {
                          company_name: "",
                          currently_work_here: false,
                          description: "",
                          end_date: "",
                          industry: [],
                          job_title: "",
                          key_accountabilities: [""],
                          salary: "",
                          start_date: "",
                          isWHID: 0,
                          work_type: ""
                        }

                        $scope.work_history.push(newWorkHistory);
                        console.log("just added work:", $scope.work_history)

                        $scope.showWorkHistoryForm = true;
                      };

                      $scope.AddWorkHistory = function(wh) {

                        //console.log(wh);
                        wh.industry = [];
                        if('industrySelect' in wh || wh.industrySelect) {
                          wh.industry.push(wh.industrySelect);
                        }
                        if('sub_industrySelect' in wh || wh.sub_industrySelect) {
                          wh.industry.push(wh.sub_industrySelect);
                        }
                        if(!(Number.isInteger(wh.work_type))) {
                          wh.work_type = wh.work_type.id;
                        }
                        //console.log("---");
                        //console.log(wh);
                        if(wh.id > 0) { 
                          //Update work history
                          //$http.put(GlobalConstant.WorkHistoryApi + '/' + wh.id,  {data:wh})
                          $http.put( window.location.origin + "/api/candidate/work-history/update/" + wh.id, {data:wh}, {
                           headers: { 'Authorization': 'Bearer ' + token }} )
                          .then(function(response) {
                            $scope.showWorkHistoryForm = false;
                          });
                        } else {
                          //Create work history
                          //$http.post(GlobalConstant.WorkHistoryApi , {data: wh} )
                          $http.post( window.location.origin + "/api/candidate/work-history/create", {data:wh}, {
                           headers: { 'Authorization': 'Bearer ' + token }} )
                          .then(function(response) {
                            if (response.status == 201) {

                              var responseData = {
                                id: response.data.id,
                                company_name: response.data.company_name,
                                description: response.data.description,
                                display_date: response.data.display_date,
                                end_date: response.data.end_date,                                
                                job_title: response.data.job_title,
                                key_accountabilities: [""],
                                start_date: response.data.start_date,
                                work_type: {
                                  displayName: response.data.work_type,
                                },
                              }   

                              var index = $scope.work_history.indexOf(wh);
                             
                              $scope.work_history[index] = responseData;
                              $scope.showWorkHistoryForm = false;
                            }

                          }, function(response) {
                              alert('Error found: Please review form');
                          });
                        }

                      }

                      $scope.deleteWork = function(history) {
                        //var deleteURL = GlobalConstant.WorkHistoryApi + '/' + history.id;
                        var deleteURL = window.location.origin + "/api/candidate/work-history/delete/" + history.id;
                        $http.delete(deleteURL, {
                           headers: { 'Authorization': 'Bearer ' + token }})
                        .then(function() {
                          var index = $scope.work_history.indexOf(history);
                          $scope.work_history.splice(index, 1);
                        });
                      }

                      $scope.getDegrees = [
                        {name: 'High School', value: 'High School'},
                        {name:'Associate\'s Degree', value: 'Associate\'s Degree'},
                        {name:'Bachelor\'s Degree', value:'Bachelor\'s Degree'},
                        {name:'Master\'s Degree', value:'Master\'s Degree'},
                        {name:'Master of Business Administrtion (M.B.A)', value:'Master of Business Administrtion (M.B.A)'},
                        {name:'Juris Doctor (J.D)', value:'Juris Doctor (J.D)'},
                        {name:'Doctor of Medicine (M.D)', value:'Doctor of Medicine (M.D)'},
                        {name:'Doctor of Philosophy (Ph.D)', value:'Doctor of Philosophy (Ph.D)'},
                        {name:'Engineer\'s Degree', value:'Engineer\'s Degree'},
                        {name:'Other', value:'Other'}
                      ];

                      $scope.eduQualifications = {};

                      $scope.CancelEducationForm = function(ed) {
                        $scope.showEducationForm = false;
                        if(!('id' in ed)) {
                          var index = $scope.educations.indexOf(ed);
                          $scope.educations.splice(index, 1);
                        } else {
                          ed.isEdID = -1;
                        }
                      }

                      $scope.openEducationEdit = function(ed) {
                        $scope.showEducationForm = true;
                        ed.isEdID = ed.id;
                        console.log("scopoe educs:", ed);
                      }

                      $scope.autoCompleteQualificationEdit = function(ed) {              
                        //$http.get( GlobalConstant.StaticOptionsAutoCompleteQualificationsApi + ed.qualification.display_name )
                        $http.get( window.location.origin + "/api/qualification/auto-complete/" + ed.qualification.display_name + "/10")
                        .then(function(response) {
                          $scope.eduQualifications = response.data;
                          //console.log($scope.educations)
                          if ($scope.eduQualifications.length) {
                            var qindex = $scope.educations.indexOf(ed);
                            console.log(qindex)
                            if(qindex > -1) {
                              $scope.educations[qindex].activeID = true;
                              $scope.educations[qindex].autocomplete = "qualification";
                            } else {
                              $scope.educations[qindex].activeID = false;
                            }
                          } else {
                            $scope.educations[qindex].activeID = false;
                          }
                        });
                      }

                      $scope.autoCompleteQualificationProEdit = function(ed) {
                      //if (ed.qualification.length > 1) {
                        var qindex = $scope.educations.indexOf(ed);
                        if(qindex > -1) {
                          $scope.educations[qindex].activeID = true;
                          $scope.educations[qindex].autocomplete = "provider";
                        } else {
                          $scope.educations[qindex].activeID = false;
                        }
                      }

                      $scope.selectFOS =function(data, ed) {
                        var index = $scope.educations.indexOf(ed);
                        if(index > -1) {
                          $scope.educations[index].qualification.display_name = data.display_name;
                          $scope.educations[index].qualification.id = data.id;
                          $scope.educations[index].activeID = false;
                        }

                        console.log("what happen", $scope.educations)
                      };

                      $scope.selectProvider =function(data, ed) {
                        var index = $scope.educations.indexOf(ed);
                        if(index > -1) {
                          $scope.educations[index].qualification_provider.provider_display_name = data.provider_display_name;
                          $scope.educations[index].qualification_provider.id = data.id;
                          $scope.educations[index].activeID = false;
                        }

                        console.log("what happen", $scope.educations)
                      };

                      $scope.hideOther = true;


                      $scope.AddEducationForm = function() {
                        $scope.showEducationForm = true;
                        var newEducation = {
                          completed_date: null,
                          degree: "",
                          edi_current_study: false,
                          qualification: {
                            display_name: "",
                            id: ""
                          },
                          qualification_provider: {
                            provider_display_name: "",
                            id: ""
                          },
                          isEdID: 0,
                          activeID: false
                        }

                        $scope.educations.push(newEducation);
                        console.log("just added Educ:", $scope.educations)

                        $scope.showEducationForm = true;
                      };

                      // Add Education
                      $scope.AddEducation = function(ed) {
                        var genQualification = "", genQualificationPro = "", edSubmit;
                        //console.log("post", ed);

                        // PLF-36 ---
                        //$http.get(GlobalConstant.StaticOptionsApi + '/qualification_providers').then(function(response) {
                        $http.get( window.location.origin + "/api/qualification-provider/list" ).then(function(response) {

                          var isInProviderList = [];

                          angular.forEach(response.data.data, function(val, key) {
                            isInProviderList.push(val.provider_display_name);
                          });

                          if(!(Number.isInteger(ed.qualification_provider.provider_display_name))) {
                            var isThereInPL = isInProviderList.indexOf(ed.qualification_provider.provider_display_name);
                            if(isThereInPL > -1) {
                              genQualificationPro = ed.qualification_provider.id;
                            } else {
                              genQualificationPro = ed.qualification_provider.provider_display_name;
                            }
                          }

                          if(ed.edi_current_study) {
                            ed.completed_date = null;
                          }

                          //$http.get(GlobalConstant.StaticOptionsApi + '/qualifications').then(function(response) {
                          $http.get( window.location.origin + "/api/qualification/list" ).then(function(response) {
                          var isInQualiList = [];

                            angular.forEach(response.data.data, function(val, key) {
                              isInQualiList.push(val.display_name);
                            });

                            if(!(Number.isInteger(ed.qualification.display_name))) {
                              var isThereInQL = isInQualiList.indexOf(ed.qualification.display_name);
                              if(isThereInQL > -1) {
                                genQualification = ed.qualification.id;
                              } else {
                                genQualification = ed.qualification.display_name;
                              }
                            }

                            if(ed.degree == "") {
                              alert("Please select your degree.")
                            } else {

                              data = {
                                degree: ed.degree,
                                completed_date: ed.completed_date,
                                qualification: genQualification,
                                qualification_provider: genQualificationPro
                              }

                              if(ed.id > 0) {
                                // update education
                                //$http.put( GlobalConstant.EducationApi + '/' + ed.id,  {data:edSubmit})
                                $http.put( window.location.origin + "/api/candidate/qualification/update/" + ed.id, {data}, {
                                  headers: { 'Authorization': 'Bearer ' + token }
                                })
                                .then(function(response) {
                                  $scope.showEducationForm = false;
                                });
                              } else {
                                // create new education
                                //$http.post( GlobalConstant.EducationApi, {data: edSubmit})
                                $http.post( window.location.origin + "/api/candidate/qualification/create", {data}, {
                                  headers: { 'Authorization': 'Bearer ' + token }
                                })
                                  .then(function(response) {
                                  var index = $scope.educations.indexOf(ed);
                                  $scope.educations[index] = response.data;
                                  $scope.showEducationForm = false;
                                });
                              }

                            }
                          });
                        });
                        // --- PLF-36
                      }

                      // Delete Education
                      $scope.delete_education = function(ed) {
                        //var deleteURL = GlobalConstant.EducationApi + '/' + ed.id;
                        deleteURL = window.location.origin + "/api/candidate/qualification/delete/"+ ed.id;
                        $http.delete(deleteURL)
                        .then(function() {
                          var index = $scope.educations.indexOf(ed);
                          $scope.educations.splice(index, 1);
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

                    }, function(response) {
                          //Error Condition
                          $scope.error = response.data.error_description;
                          //$scope.ErrorMsgs = response.data.errors;
                          if(response.status == 401) {
                            window.location.href = window.location.origin + '/login';//Unauthorized
                          }
                    });

                  /*CANDIDATE WORK HISTORY END*/


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

                  $scope.file_save = function(e) {
                      var elem = $(e.currentTarget);
                      fileUploadService.save($scope);

                      //update docs
                      //UpdateUser()

                  }


                  $("#Form_portfolio_upload_modal").change(function() {
                      $scope.file_upload_modal(false, 'Form_portfolio_upload_modal');
                  });

                  $("#Form_image_upload_modal").change(function() {
                      $scope.image_upload_modal();
                  });

                  $("#Form_video_upload_modal").change(function() {
                      $scope.video_upload_modal('file_upload');
                  });

                  // open popup modal for video or webcam
                  $("#Form_video_upload").click(function() {
                      $scope.open_camera_new();
                  });

                  $('#mobile_camera_capture').change(function() {
                      $scope.video_upload_modal();
                  })

                  $('#video_upload_modal_new').change(function() {
                      $scope.new_video_upload_modal('video_upload_modal_new');
                  })

                  $('#image_upload_modal_new').change(function() {
                          $scope.new_image_upload_modal();
                  })
                      //camera_capture_image
                  $('#mobile_image_upload').change(function() {
                          $scope.mobile_image_upload();
                          // $scope.save_photo();
                      })
                      // camera_capture_video
                  $('#mobile_video_upload').change(function() {
                      $scope.mobile_video_upload();
                  })
                  $('#mobile_resume_upload').change(function() {
                       $scope.docType = 'resume';
                       $scope.fileElemId = 'mobile_resume_upload';
                       $scope.progress_bar = 'data_progress';
                      $scope.mobile_resume_upload($scope);
                  })

                  $('#mobile_portfolio_upload').change(function() {
                      $scope.docType = 'portfolio';
                       $scope.fileElemId = 'mobile_portfolio_upload';
                       $scope.progress_bar = 'data_progress_portfolio';
                      $scope.mobile_resume_upload($scope);
                  })


                  document.dropVideo = function(ev) {
                      ev.preventDefault();
                      $scope.video_upload(ev);
                  }

                  document.dropVideoModal = function(ev) {
                      ev.preventDefault();
                      $scope.video_upload_modal('', ev);
                  }

                  document.dropVideoModalNew = function(ev) {
                      ev.preventDefault();
                      $scope.ondragoverout_image = false;
                      $scope.ondragover_image = true;
                      $scope.new_video_upload_modal('', ev);
                  }

                  document.dropFileModalNew = function(ev) {
                      ev.preventDefault();
                      var elemId = 'file_upload';
                      var event = ev;
                      var docFileType = $('#pmvFileModalNew').attr('data-docFileType');
                      var fileSizeLimit = 3;
                      fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit, true);
                  }

                  document.dropImageModalNew = function(ev) {
                      ev.preventDefault();
                      $scope.new_image_upload_modal(ev);
                  }

                  document.dropImageModal = function(ev) {
                      ev.preventDefault();
                      $scope.image_upload_modal(ev);
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


                  // Video Upload - candidate
                  $scope.video_upload = function(evt) {


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

                  // RESUME Upload
                  $scope.upload = function(evt) {
                      var fileField = document.getElementById("Form_my_file");
                      var file_data = fileField.files[0];
                      if (evt) {
                          file_data = evt.dataTransfer.files[0];
                      }
                      var allowed_files = ['doc', 'docx', 'pdf'];
                      var filename = file_data.name;
                      var last_dot = filename.lastIndexOf('.');
                      var file_folder = 'resume';
                      var ext = filename.substr(last_dot + 1).toLowerCase();
                      if (allowed_files.indexOf(ext) == -1) {
                          alert('Invalid file must be .doc, docx. .pdf extension');
                          return false;
                      }
                      var ob_key = $('#Form_my_file').data('ob_key');
                      var form_data = new FormData();
                      form_data.append('file', file_data);
                      $scope.progressResumeValue = 0;

                      if ($('#data_progress').hasClass('ng-hide')) {
                          $('#data_progress').removeClass('ng-hide');
                      }

                      var params = '?ob_key=' + ob_key + '&file_folder=' + file_folder;
                      $.ajax({
                          url: GlobalConstant.accountPage + '/upload_submit' + params,
                          dataType: 'text',
                          cache: false,
                          contentType: false,
                          processData: false,
                          data: form_data,
                          type: 'post',
                          success: function(res) {

                              if (res == 1) {
                                  // alert('Uploading Success');
                                  if (!$('#data_progress').hasClass('ng-hide')) {
                                      $scope.progressResumeValue = 0;
                                      $('#data_progress').addClass('ng-hide');
                                      fileField.value = '';
                                  }

                              }
                          },
                          beforeSend: function() {
                              $('#file_upload_msg').html('uploading to server please wait...');
                          },
                          xhr: function() {
                              var xhr = new window.XMLHttpRequest();
                              xhr.upload.addEventListener("progress", function(evt) {
                                  if (evt.lengthComputable) {
                                      var percentComplete = Math.ceil((evt.loaded / evt.total) * 100);

                                      $scope.progressResumeValue = percentComplete;

                                  }
                              }, false);

                              // xhr.addEventListener("progress", function(evt) {
                              //     if (evt.lengthComputable) {
                              //         var percentComplete = evt.loaded / evt.total;
                              //         //Do something with download progress
                              //          ////console.log('here');
                              //          ////console.log(percentComplete);
                              //     }
                              // }, false);

                              return xhr;
                          },


                      });
                  }

                  // RESUME Upload
                  $scope.file_upload_modal = function(evt, elem_id) {
                      var fileField = document.getElementById(elem_id);
                      var file_folder = fileField.getAttribute("data-folder");

                      var save_btn = document.getElementById(file_folder + '_save');
                      save_btn.disabled = true;
                      var file_data = fileField.files[0];
                      if (evt) {
                          file_data = evt.dataTransfer.files[0];
                      }

                      // Delete old file if user change file
                      if ($('#' + file_folder + '_save').attr('data-filename')) {
                          var filename = $('#' + file_folder + '_save').attr('data-filename');
                          var folder = $('#' + file_folder + '_save').attr('data-folder');
                          $scope.delete_old_file(filename, folder);
                      }

                      var allowed_files = ['doc', 'docx', 'pdf'];
                      var filename = file_data.name;
                      var last_dot = filename.lastIndexOf('.');
                      var ext = filename.substr(last_dot + 1).toLowerCase();

                      if (allowed_files.indexOf(ext) == -1) {
                          alert('Invalid file must be .doc, docx. .pdf extension');
                          return false;
                      }
                      var ob_key = $cookies.get('obkey');
                      var form_data = new FormData();
                      form_data.append('file', file_data);

                      var params = '?ob_key=' + ob_key + '&file_folder=' + file_folder;

                      $scope.modal_file_percent_value = 0;

                      $.ajax({
                          url: GlobalConstant.accountPage + '/upload_submit' + params,
                          dataType: 'text',
                          cache: false,
                          contentType: false,
                          processData: false,
                          data: form_data,
                          type: 'post',
                          success: function(res) {
                              res = JSON.parse(res);

                              if (res.response == 200) {
                                  // alert('Uploading Success');
                                  save_btn.disabled = false;

                                  if (!$('#modal_percent_file').hasClass('hidden')) {
                                      $('#modal_percent_file').addClass('hidden')
                                  }
                                  fileField.value = '';
                                  //alert('File has been saved.');
                                  $('#' + file_folder + '_save').attr('data-filename', res.filename);
                                  $('#' + file_folder + '_save').attr('data-folder', file_folder);
                                  if ($('.resume_buttons').hasClass('ng-hide')) {
                                      $('.resume_buttons').removeClass('ng-hide');
                                  }

                              }
                          },
                          beforeSend: function() {

                              if ($('#modal_percent_file').hasClass('hidden')) {
                                  $('#modal_percent_file').removeClass('hidden')
                              }

                          },
                          xhr: function() {
                              var xhr = new window.XMLHttpRequest();
                              xhr.upload.addEventListener("progress", function(evt) {
                                  if (evt.lengthComputable) {
                                      $scope.modal_file_percent_value = Math.ceil((evt.loaded / evt.total) * 100);
                                  }
                              }, false);

                              return xhr;
                          },


                      });
                  }

                  // Image upload
                  $scope.new_image_upload_modal = function(evt) {

                      fileUploadService.new_image_upload_modal($scope, evt);
                  }


                  // Image upload
                  $scope.image_upload_modal = function(evt) {

                      var fileField = document.getElementById("Form_image_upload_modal");

                      var save_btn = document.getElementById('resume_save');
                      save_btn.disabled = true;
                      var file_data = fileField.files[0];
                      // drag drop
                      if (evt) {
                          file_data = evt.dataTransfer.files[0];
                      }

                      // delete old file if exists
                      if ($('#image_save').attr('data-filename')) {
                          var filename = $('#image_save').attr('data-filename');
                          var folder = $('#image_save').attr('data-folder');
                          $scope.delete_old_file(filename, folder);
                      }


                      var allowed_files = ['png', 'jpg', 'gif'];
                      var filename = file_data.name;
                      var last_dot = filename.lastIndexOf('.');
                      var file_folder = 'image';
                      var ext = filename.substr(last_dot + 1).toLowerCase();
                      if (allowed_files.indexOf(ext) == -1) {
                          alert('Invalid file must be .png, jpg. .gif extension');
                          return false;
                      }
                      var ob_key = $cookies.get('obkey');
                      var form_data = new FormData();
                      form_data.append('file', file_data);
                      var params = '?ob_key=' + ob_key + '&file_folder=' + file_folder;
                      $scope.modal_file_percent_value = 0;

                      $.ajax({
                          url: GlobalConstant.accountPage + '/upload_submit' + params,
                          dataType: 'text',
                          cache: false,
                          contentType: false,
                          processData: false,
                          data: form_data,
                          type: 'post',
                          success: function(res) {
                              res = JSON.parse(res);

                              if (res.response == 200) {
                                  // alert('Uploading Success');
                                  save_btn.disabled = false;

                                  if (!$('#modal_percent_image').hasClass('hidden')) {
                                      $('#modal_percent_image').addClass('hidden')
                                  }
                                  fileField.value = '';
                                  //alert('File has been saved.');
                                  $('#image_save').attr('data-filename', res.filename);
                                  $('#image_save').attr('data-folder', file_folder);
                                  if ($('.resume_buttons').hasClass('ng-hide')) {
                                      $('.resume_buttons').removeClass('ng-hide');
                                  }

                              }
                          },
                          beforeSend: function() {
                              $scope.modal_file_percent_value = 0;

                              if ($('#modal_percent_image').hasClass('hidden')) {
                                  $('#modal_percent_image').removeClass('hidden')
                              }

                          },
                          xhr: function() {
                              var xhr = new window.XMLHttpRequest();
                              xhr.upload.addEventListener("progress", function(evt) {
                                  if (evt.lengthComputable) {
                                      $scope.modal_file_percent_value = Math.ceil((evt.loaded / evt.total) * 100);
                                  }
                              }, false);

                              return xhr;
                          },


                      });
                  }

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
                      }

                      // ////console.log(filename); return false;
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


                  // Video Modal buttons/sections/percent


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
                          // alert('Oh oh looks like your\'re using Safari! Use Chrome or Firefox to record a video using your webcam.')
                          alert('Oh oh this feature is not yet supported by your browser. Drag and drop a video file instead, or use Chrome, Firefox or Microsoft Edge to record a video using your webcam');
                      }else{
                           fileUploadService.startVideo($scope);
                      }

                  }

                  $scope.recordVideo = function() {
                      fileUploadService.recordVideo($scope);
                  }

                  $scope.stopVideo = function() {
                      fileUploadService.stopVideo($scope);
                  }


                  $scope.makeVideoLoadingMode = function() {

                      $scope.preview_img = 'loading';
                      var data = {
                          "data": {
                              // "doc_url": "https://previewmedev.streaming.mediaservices.windows.net/e93c89e2-5cd7-4f33-afed-fd0199ba64b6/camera_112254282.ism/manifest",
                              "doc_url": "",
                              "doc_file_type": "video",
                              "doc_filename": "dummy file",
                              "doc_type": 'icebreaker_video',
                              "extra_data" : []
                          }
                      }

                      $http.post( GlobalConstant.APIRoot+'candidate/doc',  data )
                      .then(function(response) {
                      }, function(response) {
                          alert('error')
                      });

                  }

                  $scope.saveVideo = function() {
                      fileUploadService.saveVideo($scope, 'candidate_profile_edit');

                     // $scope.makeVideoLoadingMode();
                  }

                  $scope.recordVideoAgain = function() {
                      $scope.buttonsHideShow(false, true, true, true, true);
                      //$scope.buttonsHideShow(true, true, false, true, true)
                      //$scope.recordVideo();
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
                      var response =   localStorage.getItem('VideoUploadResponseData') ;

                      if (angular.isDefined(response) && response != null ) {
                          $scope.preview_img = 'loading';
                          localStorage.removeItem('VideoUploadResponseData') ;
                      }

                      //console.log( response )
                      $('.successUpload').hide();
                  })


                  $scope.new_video_upload_modal = function(file_elm, evt) {

                      fileUploadService.video_upload($scope, file_elm, evt, 'candidate_profile_edit');
                  }


                  $scope.open_camera_new = function() {


                      $('#pmvCameraModalNew').modal('show');

                      $('#pmvCameraModalNew').on('shown.bs.modal', function () {
                        //Check if webcam is set up

                          if (!(DetectRTC.hasMicrophone && DetectRTC.hasWebcam) && !$scope.mobile_agent) {
                              $('#pmvCameraModalNew .errorUpload').show();
                              $('#pmvCameraModalNew .modal-button-right-con').html('<p class="text-danger">Recording unavailable. see error below</p>')
                              if (DetectRTC.hasMicrophone == false) {
                                  $('#pmvCameraModalNew .errorUpload span').html('<p class="text-danger">Microphone not set</p>');
                              }
                              if (DetectRTC.hasWebcam == false) {
                                  $('#pmvCameraModalNew .errorUpload span').html('<p class="text-danger">Camera not set</p>');

                              }

                              if (isSafari) {
                                  $('#pmvCameraModalNew .errorUpload span').html('<p class="text-danger">Your browser not supported.</p>');
                              }


                          }
                      })

                  }

                  /*CANDIDATE VIDEO UPLOAD END*/

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
                      $scope.makeVideoLoadingMode();
                  }

                  $scope.mobile_resume_upload = function() {
                      fileUploadService.mobile_resume_upload($scope);
                  }

                  $scope.mobile_portfolio_upload = function() {
                      fileUploadService.mobile_portfolio_upload($scope);
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
                              //alert(JSON.stringify(error, null, '\t'));
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
                      })


                  } // end stop, record, play element
              }

          }
      ]);

      app.controller('CandidateProfileController', ['GlobalConstant', '$scope', '$cookies', '$http', '$filter', '$timeout', function(GlobalConstant, $scope, $cookies, $http, $filter, $timeout) {

          //var token = $cookies.get('token');
          //var token_id = $cookies.get('token_id');
          //alert("candidate.js, fixed token, line: " + 4193);
          //var token = "M2IzMjlkNDVmMjA1ZjAzZWNjYTgxNTU2YWVjZTQzZDUxNDNhZTBkMTY0ZTRhODFlYjQ1YzQ1Njc2OWUyZTcxZg";
          var token_id = $cookies.get('token_id');
          var token = $cookies.get('api_token');
          $scope.preload = true;

          $http.get( window.location.origin + "/api/user-auth-data/", {
             headers: { 'Authorization': 'Bearer ' + token }
           }).then(function(res) {
             $scope.candidateId = res.data.data[0].id;
           }, function(response) {
            //temporary
            if(response.status == 401) {
              window.location.href = window.location.origin + '/login';//Unauthorized
            }
          });
          // set obkey if not set
          if (!$cookies.get('obkey')) {
            
            //http.get( GlobalConstant.profileApi )
            $http.get( window.location.origin + "/js/minified/test-data/test_my_profile_data.json" )
                .then(function(response) {
                    $cookies.put('obkey', response.data.data.ob_key, {
                        'path': '/'
                    });
                });
          }
            if (token != null) {

              $scope.preview_img = true;
              $scope.params = {
                  access_token: token
              };

              var numberWithCommas = function(x) {
                  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              }

              // Candidate Get Flash Message
              //$http.get( GlobalConstant.CandidateFlashApi )
              $http.get( window.location.origin + "/js/minified/test-data/test_flash_message.json" )
              .then(function(response) {
                if (response.status == 200 && response.data.data.message) {
                  if (response.data.data.message) {
                    $scope.candidateFlashMessage = response.data.data.message;
                  }
                }
              });

              //$http.get(GlobalConstant.profileApi)
              //$http.get( window.location.origin + "/js/minified/test-data/test_my_profile_data.json" )
              //$http.get( window.location.origin + "/api/candidate/myprofile/2132" )
              //$scope.candidateId = "";
              
              $http.get( window.location.origin + "/api/candidate/profile/details", {
                headers: { 'Authorization': 'Bearer ' + token }
              }).then(function(response) {
                var data = response.data;

                $scope.preload = false;

                angular.forEach(data, function(v, k) {
                    $scope[k] = v;
                })

                $scope.profile_image = $scope.docs.profile_image;
                $scope.icebreaker_video = "";

                if (data.docs.portfolio) {
                    $scope.portfolio = data.docs.portfolio;
                }
                if (data.docs.resume) {
                    $scope.resume = data.docs.resume;
                }

                // if (data.docs.icebreaker_video) {

                //           $scope.icebreaker_video = $scope.docs.icebreaker_video;

                //           if ( data.docs.icebreaker_video.doc_id != '' && data.docs.icebreaker_video.doc_url == '') {
                //                   $scope.preview_img = 'loading';

                //           }else{

                //               var docurl = data.docs.icebreaker_video.doc_url;
                //               if (docurl) {
                //                 var docurlcount = docurl.split('/');
                //               }

                //               if ( docurlcount.length == 1 ) {
                //                   $scope.preview_img = 'error';
                //                   $scope.errorVideo = data.docs.icebreaker_video.doc_url

                //               }else{

                //                   // show manifest url video if false and hide preview img
                //                   $scope.preview_img = false;

                //                   if ($('#vid1').length) {
                //                       var myPlayer = amp('vid1', {
                //                           "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                //                           "nativeControlsForTouch": false,
                //                           autoplay: false,
                //                           controls: true,
                //                           width: "275",
                //                           logo: {
                //                               "enabled": false
                //                           },

                //                           poster: ""
                //                       }, function() {
                //                           // open camera modal
                //                           this.addEventListener('click', function(elm) {

                //                                   if (!$(elm.target).hasClass('vjs-control') && !$(elm.target).hasClass('vjs-big-play-button')) {
                //                                       // $scope.open_camera();
                //                                       $scope.open_camera_new();
                //                                   }
                //                               })
                //                               // add an event listener
                //                           this.addEventListener('ended', function() {
                //                               ////console.log('Finished!');
                //                           });
                //                       });


                //                       if ($scope.icebreaker_video) {

                //                           if($scope.icebreaker_video.doc_url) {
                //                                myPlayer.src([{
                //                                   src: $scope.icebreaker_video.doc_url,
                //                                   type: "application/vnd.ms-sstr+xml"
                //                               }]);
                //                           }else{

                //                               $scope.preview_img = 'loading';

                //                           }

                //                       } else {
                //                           $scope.preview_img = true;

                //                       }
                //                   }
                //               }
                //           }
                // }


                if (data.industry !== null) {
                    $scope.industry = {
                      id: data.industry.data.industry.id,
                      industry_display_name: data.industry.data.industry.display_name,
                      sub_industry: data.industry.data.sub
                    };
                }

                if (data.nationality !== null) {
                  $scope.nationality = data.nationality;
                }

                if (data.preferred_location !== null) {
                  $scope.preferred_location_region = {
                      id: data.preferred_location.data.country.id,
                      display_name: data.preferred_location.data.country.display_name
                  };

                  $scope.preferred_location_city = {
                      id: data.preferred_location.data.id,
                      display_name: data.preferred_location.data.display_name
                  };
                }

                var calcDate = function(date1, date2) {
                    var diff = Math.floor(date1.getTime() - date2.getTime());
                    var day = 1000 * 60 * 60 * 24;
                    var days = Math.floor(diff / day);
                    var months = Math.ceil(days / 31);
                    var years = Math.floor(months / 12);

                    // var message = date2.toDateString();
                    var message = "";
                    var s_year = (years > 1) ? 'years' : 'year';
                    var calc_months = months - (years * 12);
                    var s_month = (calc_months > 1) ? 'months' : 'month';
                    message += "( " + years + " " + s_year + ", ";
                    message += calc_months + " " + s_month + ")";

                    return message;
                }

                // Sort Date on view (work history and eduction)
                $scope.sortDate = function(item) {
                    // //console.log(item.date_x)
                    var date = new Date(item.date_x);
                    return date;
                }

                if (data.work_history !== null) {
                    $.each(data.work_history, function(k, v) {
                        // //console.log(v)
                        var s_date = data.work_history[k].start_date;
                        s_date = s_date.split('-');

                        data.work_history[k].date_x = s_date[1] + '-' + s_date[0] + '-' + s_date[2];
                        var e_date = data.work_history[k].end_date;
                        if (e_date) {
                            e_date = e_date.split('-');
                        } else {

                            var today = new Date();
                            var d = today.getDate();
                            var m = today.getMonth() + 1;
                            var y = today.getFullYear();

                            e_date = d + '-' + m + '-' + y;
                            e_date = e_date.split('-');
                        }

                        var cal_start_date = new Date(s_date[2], (parseInt(s_date[1]) - 1), parseInt(s_date[0]));
                        var cal_end_date = new Date(e_date[2], (parseInt(e_date[1]) - 1), parseInt(e_date[0]));
                        data.work_history[k].calcDate = calcDate(cal_end_date, cal_start_date);

                    });
                    $scope.work_history = data.work_history;
                }

                if (data.qualifications !== null) {
                    angular.forEach(data.qualifications, function(v, k) {
                      if (v.completed_date) {
                        var d = v.completed_date;
                        d = d.split('-');
                        data.qualifications[k].date_x = d[1] + '-' + d[0] + '-' + d[2];
                      } else {
                        data.qualifications[k].date_x = null;
                      }
                    });

                    $scope.qualifications = data.qualifications;
                }
                if (data.references !== null) {
                  $scope.references = data.references;
                }

              }, function(response) {
                //temporary
                if(response.status == 401) {
                  window.location.href = window.location.origin + '/login';//Unauthorized
                }
              }); // End Profile API

          } // token condition end

    }]);
    // controller end

    // Analytics Candidate video service
    app.factory('CandidateSrvcs', ['GlobalConstant', '$http', function(GlobalConstant, $http) {
      return {
        setCandidateVid: function (data) {
          console.log(data);
          $http.post(GlobalConstant.CandidateRootApi + '/analytics/insertvideo', data).then(function (res) {
            return res
          });
        }
      }
    }]);

  }());

  $(document).ready(function() {
          $('.mydraft').on('click',function(){
              //console.log('a')
              $('#draft_tab').trigger('click');
              $('.job-applications-tab').removeClass('active')
              $('#draft_tab').addClass('active')
          });
  })
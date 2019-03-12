(function() {
  'use strict';
  var app = angular.module('app');
  var base_url = $('body').data('base_url');
  app.requires.push('rzModule');

  app.directive('autoResize', autoResize);
  autoResize.$inject = ['$timeout'];

  function autoResize($timeout) {
    var directive = {
      restrict: 'A',
      link: function autoResizeLink(scope, element, attributes, controller) {

        element.css({ 'height': 'auto', 'overflow-y': 'hidden' });
        $timeout(function () {
            element.css('height', element[0].scrollHeight + 'px');
        }, 100);

        element.on('input', function () {
          element.css({ 'height': 'auto', 'overflow-y': 'hidden' });
          element.css('height', element[0].scrollHeight + 'px');
        });
      }
    };
    return directive;
  }

  app.directive('addResponsibility', function(){
    return {
      link: function (scope, iElement, iAttrs) {
        iElement.on('click', function(e){
          e.stopPropagation();
          e.preventDefault();
          var addResp_div = angular.element(iElement).parent().parent().parent().parent();
          var templateStr;

          templateStr = '<div class="tellus_addedresp-item">';
          templateStr = templateStr + '<p><input type="text" placeholder="Key accountability" name="key_accountabilities[]" class="accountability_selector tellus__general-textbox" ng-model="key_accountabilities_'+ scope.addResp_ctr +'"" rows="3"></p>';
          templateStr = templateStr + '<p remove-resp><i class="fa fa-minus"></i></p>'
          templateStr = templateStr + '</div>';
          if (scope.addResp_ctr < 2) {
            addResp_div.append(templateStr);
          }

          scope.addResp_ctr += 1;

        });
      }
    }
  });

  app.directive('fdInput', [function () {
    return {
      controller: 'StandardQuestionCtrl',
      link: function (scope, element, attrs, controller) {
        element.on('change', function  (evt) {
            scope.files = evt.target.files;
        });
      }
    }
  }]);

  app.directive('removeResp', function(){
    return {
      link: function (scope, iElement, iAttrs) {
        iElement.on('click', function(e){
          e.stopPropagation();
          e.preventDefault();

        });
      }
    }
  });

  app.controller('RoleAppMainCtrl', ['$scope', '$window', '$cookies', '$compile', '$interval', '$timeout', 'RoleAppSrvcs', 'RoleAppGetUrl', 'fileUploadService', '$http',
    function($scope, $window, $cookies, $compile, $interval, $timeout, RoleAppSrvcs, RoleAppGetUrl, fileUploadService, $http){

    $scope.fileType = "";
    $scope.role_app_tab_loader = 1;
    $scope.promptCandidate = false;
    $scope.notdeclared = false;

    $scope.$watch('role_app_tab_loader', function(newVal, oldVal){ // trivial code
      // // console.log('WATCH LOADER: ', newVal);
    });
    $scope.requirements_check = '';
    // $scope.$watch('requirements_check', function(newVal, oldVal){ // trivial code
    //   // console.log('WATCH REQUIREMENTS: ', newVal);
    // });
    $scope.pa_validator_ids = []; // pre app questions validator
    $scope.sq_validator_ids = []; // standard questions validator
    // $scope.$watch('sq_validator_ids', function(newVal, oldVal){ // trivial code
    //   // console.log('WATCH SQ VALIDATOR: ', newVal);
    // });
    $scope.submit_standardq = [];
    // $scope.$watch('submit_standardq', function(newVal, oldVal){ // trivial code
    //   // console.log('WATCH SQ POSTING: ', newVal);
    // });

    $scope.docs_video_watcher = ""; // main watcher for uploading video. set to empty when new video has been uploaded

    $scope.return_data_daym = "";
    $scope.preapply_form_valid = false;
    $scope.standard_form_valid = false;
    $scope.compDecl = false;
    $scope.showVid = true;

    $scope.isPassed = false;
    $scope.isFailed = false;

    $scope.submitVisible = false;

    /*loader variables*/
    $scope.loadGen = false;
    $scope.loadAddRef = false;
    $scope.loadAddESP = false;
    $scope.loadAddWH = false;
    $scope.loadEditRef = false;
    $scope.loadEditESP = false;
    $scope.loadEditWH = false;
    $scope.loadDelRef = false;
    $scope.loadDelESP = false;
    $scope.loadDelWH = false;
    $scope.loadDelRefId = 0;
    $scope.loadDelESPId = 0;
    $scope.loadDelWHId = 0;

    $scope.reqcheck_form_valid = false;
    // Company and Candidate declaration vars (Collection)
    $scope.candidate_dec = "";
    $scope.company_dec = "";
    $scope.video_required = [];

    // $scope.role_objId = RoleAppGetUrl.getUrlParameter('job_id', '');
    // $scope.application_objId = RoleAppGetUrl.getUrlParameter('id', '');
    $scope.active_tab = 0;

    //$scope.role_objId = "JV5EHZ1ZX";
    //$scope.application_objId = "lsYgyZRMLR5lSYaFqGgnVrSt";

    var urlPathArray = window.location.pathname.split('/');
    $scope.job_objId = urlPathArray[3];

    var token = $cookies.get('api_token');
    $http.get( window.location.origin + "/api/user-auth-data/", {
      headers: { 'Authorization': 'Bearer ' + token }
    }).then(function(res) {
      alert(res);
      $scope.pm_user_id = res;
    });

    $scope.tabs = {
      showPre: 0,
      showReq: 0,
      showVideo: 0,
      showStan: 0,
      showDec: 0
    };
    $scope.ondragoverout_image = false;
    $scope.ondragover_image = true;
    $scope.jcropImage = "";
    $scope.crop_data = {w: 240, h: 240, x: 80, y: 0};
    $scope.submit_preapp = [];

    $scope.stepstab = {
      showPre: 0,
      showReq: 0,
      showVideo:0,
      showStan: 0,
      showDec: 0
    };
    $scope.errors = {
      showPre: 0,
      showReq: 0,
      showVideo:0,
      showStan: 0,
      showDec: 0
    };
    $scope.notexist = {
      standard: 0,
      preapp:0
    };

    $scope.readyForApply = false;
    $scope.getVidReq = "";

    // Video upload BEGIN
    $scope.showSection1 = false;
    $scope.showSection2 = true;
    $scope.modal_percent = true;

    $scope.record_btn = false;
    $scope.record_again_btn = true;
    $scope.stop_btn = true;
    $scope.save_btn = false;
    $scope.change_btn = false;
    $scope.modal_percent = true;

    $scope.docFileType = "";
    $scope.Origin = "";
    $scope.sq_id = 0; // standard quesiton id
    $scope.abc = ["A", "B", "C","D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    // $scope.myIndus;
    // $scope.mySubIndus;
    $scope.editEH;

    $scope.updateSubIndus = function(id, index) {
      //$scope.resProfile.work_history[index].industries[1] = id;
      // console.log(id, index)
    }

    $scope.updateIndus = function(id, index) {
      //$scope.resProfile.work_history[index].industries[0] = id;
      // console.log(id, index)
    }

    $scope.sectionsHideShow = function(a, b) {
      $scope.showSection1 = a;
      $scope.showSection2 = b;
    };

    // video record button controls BEGIN
    // func triggered from button at #pmvCameraModalNew modal
    $scope.saveVideo = function() {
      var data = "";

      if ($scope.Origin == 'standard_question_answer') {
        data = {
          question_id: $scope.sq_id,
          application_id: $scope.application_objId
        }
      }
      // // console.log("save recorded: ", $scope.Origin)
      fileUploadService.saveVideo($scope, $scope.Origin, data);
    };

    $scope.recordVideo = function() {
      fileUploadService.recordVideo($scope);
    };

    $scope.stopVideo = function() {
      fileUploadService.stopVideo($scope);
    };

    $scope.recordVideoAgain = function() {
      $scope.buttonsHideShow(false, true, true, true, true);
    };
    // video record button controls END

    // Modal close event
    $('#pmvCameraModal, #pmvCameraModalNew, #pmvImageModalNew, #pmvFileModalNew').on('hidden.bs.modal', function() {
      // stop/unseen video stream
      console.log("CLOSING CURRENT MODAL");

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
    });

    $scope.ready_steps = function () {
      // console.log("init stepstab: ", $scope.stepstab);
      // console.log("init active_tab: ", $scope.active_tab);
      // console.log("tabs: ", $scope.tabs);
      // console.log("current step: ", $scope.next_step);
      $scope.activeCtr = 0;
      angular.forEach($scope.tabs, function(val, key){ // parse each of the steps if they are required or not, val == 1 if required/included
        // // console.log("current step key: ", key, val);

        if (key == "showPre") {
          if (val != 0) {
            $scope.activeCtr += 1;
            $scope.stepstab.showPre = $scope.activeCtr;
            // // console.log("SHOW PRE");
          }
        }
        if (key == "showReq") {
          if (val != 0) {
            $scope.activeCtr += 1;
            $scope.stepstab.showReq = $scope.activeCtr;
            // // console.log("SHOW REQ");
          }
        }
        if (key == "showStan") {
          if (val != 0) {
            $scope.activeCtr += 1;
            $scope.stepstab.showStan = $scope.activeCtr;
          }
        }
        if (key == "showVideo") {
          if (val != 0) {
            $scope.activeCtr += 1;
            $scope.stepstab.showVideo = $scope.activeCtr;
          }
        }
        if (key == "showDec") {
          if (val != 0) {
            $scope.activeCtr += 1;
            $scope.stepstab.showDec = $scope.activeCtr;
            // // console.log("SHOW DEC!!!!");
          }
        }
      });

      if ($scope.next_step == "pre_apply_questions") {
        // console.log("set to PRE-APPLY QUESTIONS tab");
        $scope.active_tab = $scope.stepstab.showPre; // jump view to pre apply
      }

      // if ($scope.next_step == "requirements_check" && $scope.stepstab.showReq != 0) {
      if ($scope.next_step == "requirements_check") {
        // console.log("set to REQUIREMENTS CHECK tab");
        $scope.active_tab = $scope.stepstab.showReq; // jump view to requirements/profile
        $scope.tabs.showReq = 1;
        // $scope.tabs.showVideo = 1;
      }

      if ($scope.next_step == "application_questions") {
        // console.log("set to STANDARD QUESTIONS tab");
        $scope.active_tab = $scope.stepstab.showStan; // jump view to standard q
      }

    };
    $scope.submitLast = function() {
      $scope.ready_steps();
      if($scope.activeCtr == $scope.active_tab) {
        $scope.readyForApply = true;
      }else {
        $scope.readyForApply = false;
      }
    }
    $scope.revalidateShowVideo = function() {
      if($scope.showVideo == 0) {
          if($scope.isVideoRequired == 'yes') {
            $scope.tabs.showVideo = 1;
            $scope.ready_steps();
          }else {
            $scope.tabs.showVideo = 0;
          }
      }
    }
    $scope.$watch('isVideoRequired', function (newVal, oldVal) {
      if(this.last == 'yes' && $scope.tabs.showVideo == 0) {
        $scope.tabs.showVideo = 1;
      }else {
        $scope.tabs.showVideo = 0;
        $scope.activeCtr -= 1;
      }
      $scope.submitLast();
    })
    $scope.Init_Application = function() {

      RoleAppSrvcs.getSteps($scope.job_objId).then(function (res){ // get all the steps and indicate the current step

        $scope.steps = res.data.all_steps;
        $scope.next_step = res.data.next_step;

        //redirect to my job application if already applied
        if(res.data.next_step == "applied") {
          window.location.href = ""+window.location.origin+"/my-job-applications";      
        }

        if($scope.next_step != 'rejected') {
          angular.forEach($scope.steps, function(val, key){
            if(val == "application_questions"){
              $scope.tabs.showStan = 1;
              $scope.ready_steps();
              // $scope.tabs.showDec = 0;
            }

            if(val == "requirements_check"){
              $scope.tabs.showReq = 1;

              // RoleAppSrvcs.getCompanyProfile(job_objId).then(function (res){
                // $scope.isVideoRequired = res.data.application_requirements.icebreaker_video;
                if($scope.isVideoRequired == 'yes') {
                  $scope.tabs.showVideo = 1;
                }else {
                  $scope.tabs.showVideo = 0;
                }
              // });
              $scope.ready_steps();
            }
            if(val == "pre_apply_questions"){
              $scope.tabs.showPre = 1;
              $scope.ready_steps();
            }
          // // console.log("tabs: ", $scope.tabs);
          });
        } else if ($scope.next_step == 'rejected') {
          $scope.isFailed = true;
        }
      });
    };
    $scope.Init_Application();
    $scope.showSection2 = 1;
    $scope.checkRequirementsUpdate = function(){

      //replace this
      var application_objId = "lsYgyZRMLR5lSYaFqGgnVrSt";
      var job_objId = "JV5EHZ1ZX";
      var jobId = "1363";
      var candidateId = "1422";

      //RoleAppSrvcs.getRequirementsCheck($scope.job_objId, $scope.application_objId).then(function(res){
      RoleAppSrvcs.getRequirementsCheck(jobId, candidateId).then(function(res){
        $scope.validateRequirements = res.data;
      });
    };
    $scope.submitData = function() {
      $scope.isPassed = true;
      $scope.submitVisible = true;
      var data = {data: []};

      RoleAppSrvcs.getWatch($scope.role_objId).then(function(res) {
        $scope.watchlistStat = res;
      });
      $scope.watchList = function(e) {
        RoleAppSrvcs.postWatch($scope.role_objId).then(function(res) {
          $scope.preload = true
          $scope.watchlistStat = response.data.data.watchlist
        }, function errorCallback(response) {});
      };
    }

    $scope.checkNext = function(type) {
      $scope.dispose_amp = 0;
      $scope.dispose_sq_amp = 0;
      
      //console.log("CHECK NEXTs ", type);
      //console.log("$scope.active_tab: ", $scope.active_tab);
      //console.log("$scope.stepstab: ", $scope.stepstab);
      //console.log("req check start",$scope.requirements_check)

      $scope.role_objId = RoleAppGetUrl.getUrlParameter('job_id', '');
      if (!$scope.role_objId) {
        $scope.role_objId = $cookies.get('jobObjectId');
      }

      $scope.revalidateShowVideo();
      // $scope.checkRequirementsUpdate();

      var data, formValid = 0;

      if ($scope.active_tab < $scope.activeCtr + 1) {
        if ($scope.active_tab == $scope.stepstab.showPre){ // submit Pre Apply
          // console.log('submit PA: ', $scope.submit_preapp);
          data = {data: $scope.submit_preapp};

          $scope.preapply_form_valid=true;
          // if ($scope.preapply_form_valid) { // pre apply submission
            // console.log(1234, $scope.pa_validator_ids.length, $scope.pa_validator_ids);
          if ($scope.pa_validator_ids.length == 0) {

            RoleAppSrvcs.postPreApply($scope.job_objId, data).then(function(res) {

              $scope.next_step = res.next_step;

              $cookies.put('nextStep', res.next_step, {
                'path': '/'
              });

              if (res.next_step == 'rejected') { // pre application validation
                $scope.isFailed = true;
              } else {
                // console.log("pre apply validated");
                // formValid = 1; // move to next stage
                $scope.active_tab += 1;
              }
            });
          } else {
            alert("Oops! You are leaving a question unanswered. Kindly make sure you answered all the questions.");
            if ($scope.notexist.preapp == 1){
              formValid = 1;
            }
          }
        } else if ($scope.active_tab == $scope.stepstab.showReq){ // submit Profile

          //console.log("++++");
          //console.log($scope.requirements_check);

          //var video_required = $scope.requirements_check.indexOf("icebreaker_video");

          //if (video_required != -1) {
          if(angular.isDefined($scope.requirements_check.video_required)) {
            $scope.video_required = $scope.requirements_check.splice(video_required, 1);
          }

          //if (!$scope.requirements_check || $scope.requirements_check == '') { // empty = valid,  length = 1 = video is not cleared
            //var data = {data: [$scope.requirements_check]};
            var data = {data: []};

            var role_objId = "JV5EHZ1ZX";
            var application_objId = "lsYgyZRMLR5lSYaFqGgnVrSt";

            RoleAppSrvcs.postRequirementsCheck(role_objId, application_objId, data).then(function(res) {
              $scope.next_step = res.data.next_step;
              // console.log("NEXT STEP: ", $scope.next_step);
              // console.log('resres',res);
              $cookies.put('nextStep', res.data.next_step, {
                  'path': '/'
              });
            });
            formValid = 1; //go next tab
            $scope.submitVisible = true;
          // } else {
          //   $scope.submitVisible = false;
          //   // do something later
          //   var html_alert = ""
          //   html_alert += "The following requirement(s) is still missing: ";
          //   angular.forEach($scope.requirements_check, function(val, key) {
          //     html_alert += " - " + key;
          //   });
          //   alert(html_alert);
          //   return false;
          // }

        } else if ($scope.active_tab == $scope.stepstab.showVideo) { // validate requirement
          $scope.checkRequirementsUpdate();
          if($scope.validateRequirements) {
            $timeout(function() {
              if($scope.validateRequirements.indexOf("icebreaker_video") == -1) {
                var data = {data: []};


                RoleAppSrvcs.postRequirementsCheck(role_objId, application_objId, data).then(function(res) {
                  $scope.next_step = res.data.next_step;
                  $cookies.put('nextStep', res.data.next_step, {
                      'path': '/'
                  });
                });
                formValid = 1; //proceed next tab
              }else {
                alert("No profile video has been found and is required by the employer. Please upload one.");
                return false;
              }
            }, 1000);
          }else {
            var data = {data: []};


            RoleAppSrvcs.postRequirementsCheck(role_objId, application_objId, data).then(function(res) {
              $scope.next_step = res.data.next_step;
              $cookies.put('nextStep', res.data.next_step, {
                  'path': '/'
              });
            });
            formValid = 1; //proceed next tab
          }
        } else if ($scope.active_tab == $scope.stepstab.showStan){ // standard question submission
          
          //console.log("SQ VALIDATION IDS: ", $scope.sq_validator_ids);
          data = {data: $scope.submit_standardq};
          //console.log("SQ data for POST ", data);

          if ($scope.sq_validator_ids.length == 1) { // if empty = standard questions are all answered
            if (!$scope.candidate_dec) { // if true, submit SQs and set candidate as applied

              var role_objId = "JV5EHZ1ZX";
              var application_objId = "lsYgyZRMLR5lSYaFqGgnVrSt";

              RoleAppSrvcs.postStandardQ(role_objId, application_objId, data).then(function(res){
                $cookies.put('nextStep', res.next_step, {
                  'path': '/'
                });
              });

            } else {
              // console.log("CANDIDATE DECLARATION FOUND!");
            }
            formValid = 1;
          } else {
            alert("All questions requires answers. Kindly provide essential information on each questions.");
            type = '';
          }
        } else if ($scope.active_tab == $scope.stepstab.showDec){ // last and optional stage of application process
          // console.log("APPLYING! ", $scope.submit_standardq);
          data = {data: $scope.submit_standardq};

          RoleAppSrvcs.postStandardQ($scope.role_objId, $scope.application_objId, data).then(function(res){
            // console.log("okay standard q! ", res);
            $cookies.put('nextStep', res.next_step, {
              'path': '/'
            });
          });
        } else {
          formValid = 1;
        }

        if($scope.active_tab+1 == $scope.stepstab.showStan) {
          // $scope.Init_standard();
        }
        // if (type == 'submit' && ($scope.requirements_check || $scope.requirements_check != '')) { // submit application btn
        if (type == 'submit') { // submit application btn
          // $scope.checkRequirementsUpdate();
          // if($scope.validateRequirements) {
          //   if($scope.validateRequirements.indexOf("icebreaker_video") == -1) {
          //     $scope.submitData();
          //   }else {
          //     alert("The following requirement(s) is still missing: icebreaker_video");
          //     return false;
          //   }
          // }else {
          // }
            $scope.submitData();

        } else { // next next button
          if (formValid == 1) {
            $scope.active_tab += 1;
            // console.log("going to next tab: ", $scope.active_tab);
          } else {
            // console.log("something's wong");
          }
        }
      }

      // console.log("req check end",$scope.requirements_check);
      // console.log("$scope.stepstab: ", $scope.stepstab);
    };

    $scope.$watchGroup(['active_tab', 'activeCtr'], function(newVal, oldVal){
      // console.log("READY TO APPLY: ", $scope.readyForApply, newVal, $scope.activeCtr);
      if (newVal[0] == newVal[1]) {
        $scope.readyForApply = true;
      } else {
        $scope.readyForApply = false;
      }
    });

    $scope.checkPrev = function () {
      if ($scope.active_tab > 0) {
        $scope.active_tab -= 1;

        // // console.log("Previous: ", $scope.active_tab, $scope.stepstab.showVideo);

        // if (parseInt($scope.active_tab) != parseInt($scope.stepstab.showVideo)) { // equal or greater that video step number
        //   $scope.dispose_amp = 1;
        // }
        // if (parseInt($scope.active_tab) == parseInt($scope.stepstab.showStan) - 1) { // equal or greater that SQ step number
        //   $scope.dispose_sq_amp = 1;
        // }
      }
    }; // tae

    var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    $scope.isMSEdge = (/edge/i.test(navigator.userAgent.toLowerCase()));
    $scope.isSafari = isSafari;

    $scope.buttonsHideShow = function(a, b, c, d, e) {
      $scope.record_btn = a;
      $scope.record_again_btn = b;
      $scope.stop_btn = c;
      $scope.save_btn = d;
      $scope.change_btn = e;
    };

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
    };

    $scope.startVideo = function() {
      // // console.log("WEBCAM from ROLE MAIN");
      checkBrowsers();
      if($scope.isSafari || $scope.browserName == "Safari") {
          // alert('Oh oh looks like your\'re using Safari! Use Chrome or Firefox to record a video using your webcam.')
          alert('Oh oh this feature is not yet supported by your browser. Drag and drop a video file instead, or use Chrome, Firefox or Microsoft Edge to record a video using your webcam');
        }else{
          fileUploadService.startVideo($scope);
          $scope.modal_percent = true;
        }

    };

    $scope.new_video_upload_modal = function(file_elm, evt) {
      var data = "";

      if ($scope.Origin == 'standard_question_answer') { // special case, only if standard questions
        data = {
          question_id: $scope.sq_id,
          application_id: $scope.application_objId
        }
      }

      fileUploadService.video_upload($scope, file_elm, evt, $scope.Origin, data);

    };

    $('#image_upload_modal_new').change(function() {
      $scope.new_image_upload_modal();
    });

    $('#video_upload_modal_new').change(function() {
      // // console.log("ORIGIN: ", $scope.Origin);
      $scope.new_video_upload_modal('video_upload_modal_new');
    })

    $scope.new_image_upload_modal = function(evt) {
      fileUploadService.new_image_upload_modal($scope, evt);
    };

    $scope.startVideoImage = function() {
      checkBrowsers();
      if($scope.isSafari || $scope.browserName == "Safari") {
        alert('Oh oh this feature is not yet supported by your browser. Drag and drop an image instead, or use Chrome, Firefox or Microsoft Edge to capture an image using your webcam.');
      }else{
        fileUploadService.startVideoImage($scope);
        $scope.modal_percent = true;
      }
    };

    $scope.take_photo = function() {
      fileUploadService.take_photo($scope);
    };

    $scope.take_photo_again = function() {
      window.stream = '';
      $scope.startVideoImage();
    };

    $scope.save_photo = function() {
      // console.log("save poto tae");
        fileUploadService.save_photo($scope);
    };

    $scope.mobile_video_upload = function() {
      fileUploadService.mobile_video_upload($scope);
    };

    $scope.Init_company = function () {
      var job_objId = RoleAppGetUrl.getUrlParameter('job_id', '');

      if (!job_objId) {
        job_objId = $cookies.get('jobObjectId');
      }
      
      //replace this
      //job_objId = "JZJ3PTNMW";
     // job_objId = "J1129HNJ6CFZJ";         

      job_objId = "JV5EHZ1ZX";



      RoleAppSrvcs.getCompanyProfile(job_objId).then(function (res){
        $scope.company = res.data;
        $scope.isVideoRequired = res.data.application_requirements.icebreaker_video;
        if($scope.isVideoRequired != 'yes') {
          $scope.submitVisible = true;
        }
      });
    };

    $scope.Init_company();

    $scope.ActiveNav = function(data) { // jumps to different tabs
      $scope.active_tab = data;
    };

    // upload document BEGIN
    // triggered from modal #pmvFileModalNew
    $scope.file_save = function(e) {
      fileUploadService.save($scope, '', '', $scope.Origin);
    };

    $scope.file_change = function() {
      // // console.log("PAYL CHANGE");
      fileUploadService.fileChange($scope);
    };
    // upload document END

    // universal call file saving from modal #pmvFileModalNew CandidateModal.ss
    $("#file_upload").change(function() {
      var elemId = $(this).attr('id');
      var event = false;
      var docFileType = $scope.docFileType;
      var fileSizeLimit = 2;
      // console.log("file_upload Changed: ", $scope.Origin, docFileType);
      fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit, true, $scope.Origin);
    });

    // candidate profile upload file
    $scope.uploadFile = function(type, type2) {
      // // console.log("UPLOADFILE DOCTYPE COMON: ", type2);
      $scope.docFileType = type;
      $scope.Origin = 'candidate_profile_edit_app';

      // this statement will soon be commented out, after BE enhancements are applied for uploading
      // cover letters and transcripts. Also, $scope.fileType is being checked up by requirements validation/check for now.
      if (type2 == 'cover_letter' || type2 == 'transcript') {
        // // console.log("TYPE 2!!!!");
        $scope.fileType = type2;
      } else {
        // // console.log("TYPE 1");
        $scope.fileType = type;
      }

      // // console.log("FILE TYPE: ", $scope.fileType);
      fileUploadService.openModal($scope, '#pmvFileModalNew', $scope.fileType);
    };

    // $scope.$watch('return_data', function(newVal, oldVal){ // SQ File upload return file
    //   // // console.log('SUPPORT RETURN DATASS: ', newVal);
    //   if (newVal) {
    //     $scope.return_data_daym = newVal;
    //     // // console.log("YES DOC ", $scope.return_data_daym);
    //   }
    //   // else {
    //   //   $scope.return_data_daym = $scope.supportdocs; // commented out, no longer needs to be use
    //   //   // // console.log("BACK UP YES DOC ", $scope.return_data_daym);
    //   // }
    // });


    // =========================================================
    $scope.$watch('docs_video_watcher', function (newVal, oldVal) {
      // // console.log("ICE BRRRREAKER: ", newVal, oldVal);
    });
    // =========================================================
  }]);

  app.controller('QuickQuestionCtrl', ['$scope', '$window', '$cookies', '$compile', 'RoleAppSrvcs', 'RoleAppGetUrl', function($scope, $window, $cookies, $compile, RoleAppSrvcs, RoleAppGetUrl){
    // console.log('QQ activated');
    $scope.levels = [
      'yes',
      'developing',
      'no'
    ];
    $scope.gpaWhat = null;
    $scope.post_preapply = [];
    $scope.role_objId = RoleAppGetUrl.getUrlParameter('job_id', '');
    if (!$scope.role_objId) {
      $scope.role_objId = $cookies.get('jobObjectId');
    }

    $scope.application_objId = RoleAppGetUrl.getUrlParameter('id', '');
    $scope.api_status = 200;

    $scope.slider_preapp = [];

    //replace this
    var jobObjectId = "J1129HNJ6CFZJ";
    var applicationObjId = "xJDGgcbF5rHu0vHbV6euIyC6";

var applicationObjId = "lsYgyZRMLR5lSYaFqGgnVrSt";
var jobObjectId = "JV5EHZ1ZX";



    $scope.Init_questions = function () {
      $scope.$parent.$parent.role_app_tab_loader = 1; // loader
      //RoleAppSrvcs.getPreApply($scope.role_objId, $scope.application_objId)
      RoleAppSrvcs.getPreApply(jobObjectId)
      .then(function (res){
        // console.log("pre app res: ", res);
        $scope.pre_apply = res;
        if ($scope.pre_apply.length > 0 || $scope.pre_apply) {
          $scope.$parent.$parent.role_app_tab_loader = 0; // loader
        }
        // // console.log("$scope.pre_apply: ", $scope.pre_apply);

        // parse each pre application question
        angular.forEach($scope.pre_apply, function(val, key) {
          $scope.pre_apply[key].mychoices = [];
          //// console.log(4,$scope.pre_apply[key].choices)
          for(var cho = 0; cho < $scope.pre_apply[key].choices.length; cho++) {
            if($scope.pre_apply[key].choices[cho] == 11) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "A+"});
            } else if($scope.pre_apply[key].choices[cho] == 10) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "A"});
            } else if($scope.pre_apply[key].choices[cho] == 9) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "A-"});
            } else if($scope.pre_apply[key].choices[cho] == 8) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "B+"});
            } else if($scope.pre_apply[key].choices[cho] == 7) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "B"});
            } else if($scope.pre_apply[key].choices[cho] == 6) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "B-"});
            } else if($scope.pre_apply[key].choices[cho] == 5) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "C+"});
            } else if($scope.pre_apply[key].choices[cho] == 4) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "C"});
            } else if($scope.pre_apply[key].choices[cho] == 3) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "C-"});
            } else if($scope.pre_apply[key].choices[cho] == 2) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "D"});
            } else if($scope.pre_apply[key].choices[cho] == 1) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "E"});
            } else if($scope.pre_apply[key].choices[cho] == 0) {
              $scope.pre_apply[key].mychoices.push({value : $scope.pre_apply[key].choices[cho], label : "F"});
            }
          }
          // // console.log(567, $scope.pre_apply)
          var ke = "pre_apply[" + key + "].answer";

          $scope.$watchCollection(ke, function (newVal, oldVal) {
            //// console.log(key)
            // console.log(oldVal, newVal);
            if(newVal) {
              if(newVal.indexOf('yes') > -1) {
                $scope.pre_apply[key].levelYes = true;
              } else {
                $scope.levelYes = false;
                $scope.pre_apply[key].levelYes = false;
              }

              if (newVal.indexOf('developing') > -1) {
                $scope.levelDev = true;
                $scope.pre_apply[key].levelDev = true;
              } else {
                $scope.levelDev = false;
                $scope.pre_apply[key].levelDev = false;
              }

              if (newVal.indexOf('no') > -1) {
                $scope.levelNo = true;
                $scope.pre_apply[key].levelNo = true;
              } else {
                $scope.levelNo = false;
                $scope.pre_apply[key].levelNo = false;
              }
            }
          });

          $scope.pa_validator_ids.push(val.id);
          $scope.post_preapply.push({
            question_id: val.id,
            answer: []
          });

          // add 'slider' key | parent questions as well
          if (val.type == 'custom_pre_apply_2') { // separate bespoke questions (slider)
            val.slider = {
              min: 0,
              max: 10,
              options: {
                floor: 0,
                ceil: 10,
                id: val.id,
                onEnd: function(sliderId, modelValue, highValue, pointerType) {
                  $scope.slider_func(sliderId, modelValue, highValue, pointerType);
                }
              }
            };
          }

          // child/sub questions here
          if (val.sub_questions) {
            angular.forEach(val.sub_questions, function(sub1_val, sub1_key){
              if (sub1_val.type == 'custom_pre_apply_2_sub') { // separate bespoke sub questions
                sub1_val.slider = {
                  min: 0,
                  max: 10,
                  options: {
                    floor: 0,
                    ceil: 10,
                    id: sub1_val.id,
                    onEnd: function(sliderId, modelValue, highValue, pointerType) {
                      $scope.slider_func(sliderId, modelValue, highValue, pointerType);
                    }
                  }
                };
              } else { // normal sub questions here
                /*$scope.post_preapply.push({
                  question_id: sub1_val.id,
                  answer: ""
                });*/
              }
            });
          }
          val.answer = "";
        });

        // console.log('ALL PRE APP Qs: ', $scope.pre_apply);
      });
    };

    $scope.$watch('active_tab', function(newVal, oldVal){
      if (newVal == $scope.stepstab.showPre && $scope.stepstab.showPre != 0) { // STEP CHECKER
        // console.log("INIT QQ");
        $scope.Init_questions();
      }
    })

    $scope.submit_preapply = function (id, ans, q) {
      //$scope.gpaWhat = null;
      //console.log(q)
      // console.log("tae: ", $scope.post_preapply, $scope.pa_validator_ids, ans);
      if(q.type == 'gpa') {
        $scope.gpaWhat = ans;
      }
        //console.log(1,$scope.gpaWhat);
      var keep = true;
      var failCtr = 0;
      var forCtr = $scope.post_preapply.length;
      var data;


      if (q) {// slider does not pass any 3rd arguments
        if(q.type == 'gpa' || q.type == 'custom_pre_apply_1') { // rca 244
          if(ans >= q.ideal_answer[0]) {
            $scope.promptCandidate = true;
          } else {
            $scope.promptCandidate = false;
          }
        }
      }

      $scope.$parent.$parent.preapply_form_valid = $scope.PreApplyForm.$valid;
      if (ans) {
        // console.log("meh sagot: ", $scope.post_preapply, id, $scope.pa_validator_ids);
        angular.forEach($scope.post_preapply, function(val, key) {
          if (val.question_id == id) {
            val.answer = [ans];

            var splicethis = $scope.pa_validator_ids.indexOf(id);
            if (splicethis != -1) {
              $scope.pa_validator_ids.splice(splicethis,1);
            }
          }
        });


        $scope.$parent.$parent.submit_preapp = $scope.post_preapply;
        // console.log('submit PA: ', $scope.submit_preapp, $scope.pa_validator_ids);
      }
    };

    // slider functions BEGIN
    $scope.refreshSlider = function () {
      $timeout(function () {
          $scope.$broadcast('rzSliderForceRender');
      });
    };

    $scope.slider_func = function (sliderId, modelValue, highValue, pointerType) {
      // console.log('slider_func', sliderId, modelValue);
      $scope.submit_preapply(sliderId, modelValue);
    };
    // slider functions END
  }]);

  app.filter('getFilteredEducationProviders', function() {
    return function(dict, val) {
      var returnArray = [];
      var searchTextSplit = val.toLowerCase().split(' ');

      for(var x = 0; x < dict.length; x++){
        var count = 0;
        for(var y = 0; y < searchTextSplit.length; y++){
          if(dict[x].provider_display_name.toLowerCase().indexOf(searchTextSplit[y]) !== -1){
            count++;
          }
        }
        if(count == searchTextSplit.length){
          returnArray.push({
            id: dict[x].id,
            provider_display_name: dict[x].provider_display_name
          });
        }
      }
      return returnArray;
    }
  });

  app.controller('TellUsCtrl', ['$scope', '$window', '$cookies', '$compile', '$filter', 'RoleAppSrvcs', 'RoleAppGetUrl', 'fileUploadService', 'InitialPlaceholder', 'CandidateUploadSvcs', 'GlobalConstant', 'ajaxService',
    function($scope, $window, $cookies, $compile, $filter, RoleAppSrvcs, RoleAppGetUrl, fileUploadService, InitialPlaceholder, CandidateUploadSvcs, GlobalConstant, ajaxService){
    // console.log('Tell Us activated ', $scope.active_tab, $scope.stepstab.showReq);
    $scope.maxLimitReachedCreate = 0;
    var color_bg_initial_set = [
      "member-initials--sky",
      "member-initials--pvm-purple",
      "member-initials--pvm-green",
      "member-initials--pvm-red"
      // "member-initials--pvm-yellow"
    ];

    // $('#test_aplod').change(function (){
    //   console.log("test aplowd: ", $scope.files[0]);
    //   var img_con = document.querySelector('#test_aplod_img');
    //   var image_uploaded = document.querySelector('input[type=file]').files[0];
    //   var reader = new FileReader();

    //   console.log('uploaded image: ', img_con, image_uploaded);

    //   reader.onloadend = function () {
    //     img_con.src = reader.result;


    //     var form = new FormData();
    //     form.append("document", image_uploaded);
    //     form.append("job_application_object_id", "");

    //     var settings = {
    //       "url": GlobalConstant.CandidateRootApi + "/upload/profile_image",
    //       "type": "POST",
    //       "headers": {
    //         "Content-Type": undefined,
    //         "Authorization": "Bearer " + $cookies.get("token")
    //       },
    //       "processData": false,
    //       "contentType": false,
    //       "data": form
    //     }

    //     $.ajax(settings).done(function (response) {
    //       console.log(response);
    //     });
    //   }

    //   if (image_uploaded) {
    //     reader.readAsDataURL(image_uploaded);
    //   } else {
    //     img_con.src = "";
    //   }


    // });

    $scope.aplod = function (element) {
      var img_con = document.querySelector('#test_aplod_img');
      var image_uploaded = element.files[0];
      var reader = new FileReader();

      // console.log('uploaded image: ', img_con, image_uploaded);

      reader.onloadend = function () {
        img_con.src = reader.result;
        ajaxService.postImageUpload(image_uploaded).then(function(res){

        });
      }

      if (image_uploaded) {
        reader.readAsDataURL(image_uploaded);
      } else {
        img_con.src = "";
      }
    }

    $scope.profile_img_exist = 0;
    $scope.phone_number_exist = 0;

    $scope.selected_edu_providers = '';
    //req check
    $scope.showPhone = true;
    $scope.showAbout = true;
    $scope.showRef = true;
    $scope.showEd = true;

    $scope.showportfolio = true;
    $scope.showResume = true;
    $scope.showProfileImg = true;
    $scope.showLocation = true;
    $scope.showCoverLetter = true;
    $scope.showLanguage = true;
    $scope.showExp = true;
    $scope.showRef = false;
    $scope.showTranscript = true;

    $scope.showGeneralInfo = false;
    $scope.showUploads = false;
    $scope.showUploadDocs = false;
    // ==============================
    $scope.RequirementsCheckForm = false;
    $scope.candidate_docs = "";
    $scope.postreference = {
      description: '',
      employer_name: '',
      company_name: '',
      contact_email: '',
      contact_phone: ''
    };
    $scope.updateThisWorkhistory = true;
    $scope.updateThisWorkhistory_id = 0;

     // =====================================================================
    $scope.$watch('profile_image', function(newVal,oldVal) {
      // // console.log("PROFLE PUTO APLOD WATCH FROM TELLUS CTRL: ", newVal);
      if (newVal) {
        // // console.log("photo uploaded");
        $scope.resProfile.docs.profile_image = newVal;

        var photo_index = $scope.$parent.$parent.requirements_check.indexOf('profile_image'); // validate photo
        if (photo_index != -1) {
          $scope.$parent.$parent.requirements_check.splice(photo_index, 1);
        }
        // // console.log("profile photo validated ", $scope.$parent.$parent.requirements_check);
      } else {
        // // console.log("not");
      }
    });
    // =====================================================================


    $scope.AddMoreResponsiblity = function (index) {
      // console.log("account 1: ", index, $scope.resProfile.work_history[index].key_accountabilities);
      $scope.maxLimitReachedCreate = $scope.resProfile.work_history[index].key_accountabilities.length;
      // console.log("account 1 LENGTH before: ", $scope.maxLimitReachedCreate);

      if ($scope.maxLimitReachedCreate < 10) {
        $scope.resProfile.work_history[index].key_accountabilities.push([]);
      } else {
        // console.log("Max limit reached");
        // $scope.AddMoreResponsiblity_create_notice = "Max limit reached";
      }
      // console.log("account 1 LENGTH after: ", $scope.resProfile.work_history[index].key_accountabilities.length);
    };

    $scope.AddMoreResponsiblity2 = function (index) {
      // console.log("account 2: ", index);
      $scope.workHistory.key_accountabilities.push('');
    }

    $scope.delAcct = function(index, acct) {
      $scope.maxLimitReachedCreate = 0;
      // console.log("acct index ", index, acct);

      // // console.log("tae: ", index, $scope.resProfile.work_history[0].key_accountabilities.length);
      var cutAcct = $scope.resProfile.work_history[index].key_accountabilities.indexOf(acct);
      $scope.resProfile.work_history[index].key_accountabilities.splice(cutAcct, 1);
    }

    $scope.delAcct2 = function(acct) {
      var cutAcct = $scope.workHistory.key_accountabilities.indexOf(acct);
      $scope.workHistory.key_accountabilities.splice(cutAcct, 1);
    }

    $scope.role_objId = RoleAppGetUrl.getUrlParameter('job_id', '');
    if (!$scope.role_objId) {
      $scope.role_objId = $cookies.get('jobObjectId');
    }

    $scope.application_objId = RoleAppGetUrl.getUrlParameter('id', '');
    $scope.chvron = 0;
    $scope.addESP = 0;
    $scope.addResp_ctr = 0;
    $scope.personal_details = [];
    $scope.selectedQuals = {};
    $scope.educationHistory_submit = {};
    $scope.educationHistory = {
      completed_date:"",
      degree:"",
      edi_current_study:false,
      otherDegree:"",
      qualification:"",
      qualification_povider:""
    };
    $scope.workHistory_submit = {};
    $scope.workHistory = {
      job_title:"",
      industry:[],
      company_name:"",
      work_type:"",
      start_date:"",
      end_date:"",
      salary:"",
      description:"",
      key_accountabilities:[]
    };
    $scope.qualification_provider_array = [];
    $scope.industries_selected = [];
    $scope.industries_selected_edit = [];


     // ===================================================================== enhancement of above code
    $scope.$watch("return_uploaded_app_profile", function(newVal, oldVal) {
      if (newVal) {
        // console.log("profile doc upload success: ", newVal);
        if (newVal.doctype == 'resume') {
          // console.log("Doc Type is resume ", newVal.doctype);
          var requirement_satisfied = $scope.$parent.$parent.requirements_check.indexOf("resume");
          if (requirement_satisfied != -1) {
            $scope.$parent.$parent.requirements_check.splice(requirement_satisfied, 1);
          }

          $scope.candidate_docs.resume = {
            // doc_filename: newVal.file_name.substr(newVal.file_name.indexOf("_") + 1),
            doc_filename: newVal.file_name,
            doc_url: newVal.url
          }
        } else if (newVal.doctype == 'portfolio') {
          // console.log("Doc Type is portfolio ", newVal.doctype);
          var requirement_satisfied = $scope.$parent.$parent.requirements_check.indexOf("portfolio");
          if (requirement_satisfied != -1) {
            $scope.$parent.$parent.requirements_check.splice(requirement_satisfied, 1);
          }

          $scope.candidate_docs.portfolio = {
            // doc_filename: newVal.file_name.substr(newVal.file_name.indexOf("_") + 1),
            doc_filename: newVal.file_name,
            doc_url: newVal.url
          }
        } else if (newVal.doctype == 'cover_letter') {
          // console.log("Doc Type is cover_letter ", newVal);
          var requirement_satisfied = $scope.$parent.$parent.requirements_check.indexOf("cover_letter");
          if (requirement_satisfied != -1) {
            $scope.$parent.$parent.requirements_check.splice(requirement_satisfied, 1);
          }

          $scope.candidate_docs.cover_letter = {
            // doc_filename: newVal.file_name.substr(newVal.file_name.indexOf("_") + 1),
            doc_filename: newVal.file_name,
            doc_url: newVal.url
          }
        } else if (newVal.doctype == 'transcript') {
          // console.log("Doc Type is transcript ", newVal.doctype);
          var requirement_satisfied = $scope.$parent.$parent.requirements_check.indexOf("transcript");
          if (requirement_satisfied != -1) {
            $scope.$parent.$parent.requirements_check.splice(requirement_satisfied, 1);
          }

          $scope.candidate_docs.transcript = {
            // doc_filename: newVal.file_name.substr(newVal.file_name.indexOf("_") + 1),
            doc_filename: newVal.file_name,
            doc_url: newVal.url
          }
        }
        // console.log("CANDIDATE DOOOOCZ: ", $scope.candidate_docs);
      }
    });
    // =====================================================================

    // Initialize profile data content
    $scope.$watch('active_tab', function(newVal, oldVal){
      if (newVal == $scope.stepstab.showReq && $scope.stepstab.showReq != 0) { // STEP CHECK
        // // console.log("INIT PROFILE ", $scope.active_tab, $scope.stepstab.showReq);
        $scope.$parent.$parent.role_app_tab_loader = 1; // loader
        RoleAppSrvcs.getCandidateProfile().then(function(res){
          $scope.resProfile = res;

          // console.log("asdnajkldnak jsdnak jsd ", res);

          if ($scope.resProfile.docs.profile_image) {
            $scope.profile_img_exist = 1;
          } // RCA-253

          // console.log("tae ", $scope.resProfile.phone_number);
          if ($scope.resProfile.phone_number) {
            $scope.phone_number_exist = 1;
          } // RCA-253

          if ($scope.resProfile.length > 0 || $scope.resProfile) {
            $scope.$parent.$parent.role_app_tab_loader = 0; // loader
          }

          angular.forEach($scope.resProfile.qualifications, function(val, key) {
            if($scope.resProfile.qualifications[key].completed_date != null) {
              $scope.resProfile.qualifications[key].completed_date = new Date($scope.resProfile.qualifications[key].completed_date);
            }
          });

          $scope.qualifications = $scope.resProfile.qualifications;
          $scope.candidate_docs = $scope.resProfile.docs;

          // application based documents GET PQB-23
          CandidateUploadSvcs.getCandidateApplicationDocs($scope.application_objId).then(function(res) {

            $scope.candidate_docs.cover_letter = res.docs.cover_letter;
            // console.log('res.docs.cover_letter',res);



            if (res.docs.resume.doc_url) {
              // console.log("meron laman ang resume");
              $scope.candidate_docs.resume = res.docs.resume;
              // console.log("eto na bagong laman: ", $scope.candidate_docs);
            }

            if (res.docs.transcript.doc_url) {
              // console.log("meron laman ang resume");
              $scope.candidate_docs.transcript = res.docs.transcript;
              // console.log("eto na bagong laman: ", $scope.candidate_docs);
            }

            if (res.docs.portfolio.doc_url) {
              // console.log("meron laman ang resume");
              $scope.candidate_docs.portfolio = res.docs.portfolio;
              // console.log("eto na bagong laman: ", $scope.candidate_docs);
            }


          });

          $scope.references = $scope.resProfile.references;

          angular.forEach($scope.references, function(val, key) {
            val.description = val.description.replace(/\r?\n|\r/g, "<br>");
          });

          $scope.newToWorkForceField = $scope.resProfile.new_to_workforce;
          // // console.log('candidate_docs: ', $scope.resProfile);

          angular.forEach($scope.qualifications, function(val, key) {
            if (!val.qualification_provider.company_logo) {
              val.qualification_provider.initial = InitialPlaceholder.setSingleNameInitial(val.qualification_provider.provider_display_name);
              val.qualification_provider.color = InitialPlaceholder.setBackgroundColor();

            }
          });

          if ($scope.resProfile.work_history && $scope.resProfile.work_history.length > 0) {
            // // console.log("LEN: ", $scope.resProfile.work_history.length);
            //$scope.chvron = $scope.resProfile.work_history[0].id; remove since chevron is removed
          } else {
            $scope.chvron = 0;
          }

          // RCA-246 BEGIN ===========================================================
          var Fname_initial = $scope.resProfile.first_name.substr(0, 1);
          var Lname_initial = $scope.resProfile.last_name.substr(0, 1);
          $scope.profile_img_initial = Fname_initial + Lname_initial;

          // // change default photo's background color
          var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
          $scope.profile_img_color = color_bg_initial;
          // RCA-246 END ===========================================================
        
          //replace this
          var application_objId = "lsYgyZRMLR5lSYaFqGgnVrSt";
          var job_objId = "JV5EHZ1ZX";
          var jobId = "1363";
          var candidateId = "1422";

          //RoleAppSrvcs.getRequirementsCheck($scope.role_objId, $scope.application_objId).then(function(res){
          RoleAppSrvcs.getRequirementsCheck(jobId, candidateId).then(function(res){
            //console.log("GET REQUIREMENTS CHECK BEFORE: ", $scope.$parent.$parent.requirements_check);
            //$scope.$parent.$parent.requirements_check = res.data;
            $scope.$parent.$parent.requirements_check = res;
            // console.log('chcu',res);
            //console.log("GET REQUIREMENTS CHECK BEFORE: ", $scope.requirements_check);
            //RCA-253 BEGIN 
            
            //var check_profimage = $scope.requirements_check.indexOf('profile_image');
            var check_profimage = $scope.requirements_check.profile_image;

            //var check_phone = $scope.requirements_check.indexOf('phone_number');
            var check_phone = $scope.requirements_check.phone_number;

            // console.log("check_phone: ", check_phone, $scope.phone_number_exist );
            // console.log("profile_img_exist: ", $scope.profile_img_exist, check_profimage);
            // if (check_profimage == -1 && $scope.profile_img_exist == 0) {
            //   $scope.requirements_check.push('profile_image');
            // }
            // if (check_phone == -1 && $scope.phone_number_exist == 0) {
            //   $scope.requirements_check.push('phone_number');
            // }
            // console.log('img before? ', $scope.requirements_check, check_profimage);
            if (check_profimage != undefined) {
              $scope.requirements_check.splice(check_profimage, 1);
            }
            //RCA-253 END

            // console.log('img required? ', $scope.requirements_check);

            if ($scope.requirements_check) {
              // console.log("REQ LEESTs: ", $scope.requirements_check);
              angular.forEach($scope.requirements_check, function(value, key) {
                if (value == 'references') {
                    $scope.showRef = false;
                    $scope.showGeneralInfo = true;
                } else if (value == 'education') {
                    $scope.showEd = false;
                    $scope.showGeneralInfo = true;
                } else if (value == 'icebreaker_video') {
                    $scope.$parent.$parent.showVid = false;
                    // // console.log("JUST WTF? ", $scope.showVid);
                    $scope.showUploads = true;
                } else if (value == 'about_me') {
                    $scope.showAbout = false;
                    $scope.showGeneralInfo = true;
                } else if (value == 'portfolio') {
                    $scope.showportfolio = false;
                    $scope.showUploads = true;
                    $scope.showUploadDocs = true;
                } else if (value == 'work_experience') {
                    $scope.showExp = false;
                    $scope.showGeneralInfo = true;
                } else if (value == 'resume') {
                    $scope.showResume = false;
                    $scope.showUploads = true;
                    $scope.showUploadDocs = true;
                } else if (value == 'phone_number') {
                    $scope.showPhone = false;
                    $scope.showGeneralInfo = true;
                } else if (value == 'profile_image') {
                    $scope.showProfileImg = false;
                    $scope.showUploads = true;
                } else if (value == 'location') { //ib
                    $scope.showLocation = false;
                    $scope.showGeneralInfo = true;
                } else if (value == 'cover_letter') { //ib
                    $scope.showCoverLetter = false;
                    $scope.showUploads = true;
                    $scope.showUploadDocs = true;
                } else if (value == 'language') { //ib
                    // $scope.showLanguage = false;
                    var remove_language = $scope.$parent.$parent.requirements_check.indexOf("language");
                    $scope.$parent.$parent.requirements_check.splice(remove_language, 1);
                } else if (value == 'transcript') { //ib
                    $scope.showTranscript = false;
                    $scope.showUploads = true;
                    $scope.showUploadDocs = true;
                }
              });
            }
          });
        });

        $scope.$watch('candidate_docs', function(val, key) {
          // var resume_exist = val.resume.doc_url ? true : false;
          // if (resume_exist == true) {
          // console.log("taena naman: ", val);
          // if (val.resume) {
          //   val.resume.file_name = val.resume.doc_url.substr(val.resume.doc_url.indexOf("_") + 1);
          // }

          // var portfolio_exist = angular.equals({}, val.portfolio);
          // // if (!portfolio_exist && val.portfolio) {
          // if (val.portfolio && val.portfolio.doc_url) {
          //   val.portfolio.file_name = val.portfolio.doc_url.substr(val.portfolio.doc_url.indexOf("_") + 1);
          // }
            // // console.log('candidate_docz: ', val);
        });

        RoleAppSrvcs.getEducationProvider_list().then(function(res){
          $scope.qualificationProviders = res;
        });

      }
    });

    // Education Content BEGIN
    $scope.qualificationWatch = function() {
      var targetObj = angular.element(document).find('.qualification_holder');
      $scope.autoCompleteQualificationEdit($scope.educationHistory.qualification, targetObj);
    };

    $scope.filterQualification = function(value) {

      var targetObj = angular.element(document).find('.provider_holder');
      $scope.autoCompleteQualificationProvider(targetObj, value);
    };

    $scope.ExpandESP = function (a) {
      // // console.log("CHEVRON: ", $scope.chvron, a);
      if ($scope.chvron == a) {
        $scope.chvron = 0;
      } else {
        $scope.chvron = a;
      }
    }

    $scope.getSelectedDegrees = function(item) {
      return $scope.getDegrees.indexOf(item) !== -1;
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

    $scope.autoCompleteQualificationEdit = function(search, targetObj) {
      RoleAppSrvcs.getEducationProvider(search).then(function(res){
        $scope.eduQualifications = res;
        if ($scope.eduQualifications.length) {
          targetObj.find('.auto_complete_qualifications').removeClass('ng-hide');
        } else {
          targetObj.find('.auto_complete_qualifications').addClass('ng-hide')
        }
      });
    };

    $scope.autoCompleteQualificationProvider = function(targetObj, val) {
      var found = $filter('getFilteredEducationProviders')($scope.qualificationProviders, val);
      $scope.selected_edu_providers = found;

      if ($scope.selected_edu_providers.length) {
        targetObj.find('.auto_complete_education_edu').removeClass('ng-hide');
      } else {
        targetObj.find('.auto_complete_education_edu').addClass('ng-hide')
      }
    };

    $scope.selectFOS =function(data, id) {
      //var id = angular.element(document).find('.addAqualification').attr('data-id');
      var targetObj = angular.element(document).find('.qualification_holder');
      var targetObj2 = angular.element(document).find('.auto_complete_qualifications');

      //targetObj.find('input[type="text"]').val(data);
      $scope.educationHistory.qualification = data;
      targetObj.find('input[type="text"]').attr('data-id', id);
      $scope.educationHistory_submit.degree = $scope.educationHistory.degree;
      $scope.educationHistory_submit.qualification = parseInt(id);
      //console.log(data, $scope.educationHistory_submit)
      targetObj2.addClass('ng-hide');
      // console.log(data,$scope.educationHistory_submit)
    };

    $scope.selectedProvider =function(data, id) {
      // console.log(79,data)
      //var id = angular.element(document).find('.addSelectedProvider').attr('data-id');
      $scope.educationHistory.qualification_povider = data;
      var targetObj = angular.element(document).find('.provider_holder');
      var targetObj2 = angular.element(document).find('.auto_complete_education_edu');

      //targetObj.find('input[type="text"]').val(data);
      targetObj.find('input[type="text"]').attr('data-id', id);
      $scope.educationHistory_submit.qualification_provider = parseInt(id);
      targetObj2.addClass('ng-hide');
    };

    $scope.$watchGroup(['educationHistory.degree', 'educationHistory.completed_date', 'educationHistory.edi_current_study'], function(newVal, oldVal){
      if(newVal[0] != oldVal[0]) {
        $scope.educationHistory_submit.degree = newVal[0].value;
      }
      if(newVal[1] != oldVal[1]) {
        $scope.educationHistory_submit.completed_date = newVal[1];
      }
      if(newVal[2] != oldVal[2]) {
        $scope.educationHistory_submit.edi_current_study = newVal[2];
      }
    });

    $scope.initDatePicker = function(e) {
      $(e.target).datetimepicker({
         timepicker:false,
         format:'Y-m-d'
      });
      $(e.target).datetimepicker("show");
    }

    $scope.toggleAddESP = function() {
      if (!$scope.addESP) {
        $scope.addESP = 1;
      } else {
        $scope.addESP = 0;
      }
    };

    $scope.cancelRef = function() {
      $scope.editRef = 0;
    }

    $scope.CancelEditWH = function (id) {
      if ($scope.updateThisWorkhistory_id == id) {
        $scope.updateThisWorkhistory_id = 0;
        $scope.updateThisWorkhistory = true;
        $scope.chvron = 0;
      }
    }

    $scope.toggleAddWH = function() {
      // PLF-18
      $scope.$watch('workHistory.currently_work_here', function(newVal, oldVal) {
        if(newVal) {
          $scope.workHistory.end_date = ""
        }
      });
      // PLF-18

      if (!$scope.addWH) {
        $scope.addWH = 1;
      } else {
        $scope.addWH = 0;
      }
    };

    $scope.EditThisWH = function (id) {
      if ($scope.updateThisWorkhistory_id == 0) {
        $scope.updateThisWorkhistory_id = id;
        $scope.updateThisWorkhistory = false;
        $scope.chvron = id;
      }

      // set industries on editing
      angular.forEach($scope.resProfile.work_history, function(val, key) {
        if (val.id == id) {
          $scope.myIndus = val.industries[0];
          $scope.mySubIndustry = val.industries[1];
        }
      });
    }

    $scope.changeSubIndustriesEdit = function () {
      $scope.industries_selected_edit = [];
      var updateIndustryId = this.myIndus.id;

      angular.forEach($scope.all_industries, function(val, key){
        if (val.id == updateIndustryId) {
          $scope.mySubIndus = val.sub;
        }
      });

      $scope.industries_selected_edit.push(updateIndustryId);
    };

    $scope.selectSubIndustryEdit = function() {
      // console.log("sub indus sselected: ", this.mySubIndustry);
      var subUpdateIndustryId = this.mySubIndustry.id;
      $scope.industries_selected_edit.push(subUpdateIndustryId);
    };

    $scope.changeSubIndustriesAdd = function () {
      $scope.industries_selected = [];
      var AddIndustryId = this.addIndustry.id;

      angular.forEach($scope.all_industries, function(val, key){
        if (val.id == AddIndustryId) {
          $scope.AddSubIndus = val.sub;
        }
      });

      $scope.industries_selected.push(AddIndustryId);
    };

    $scope.selectSubIndustryAdd = function() {
      // console.log("sub indus sselected: ", this.addSubIndustry);
      var subUpdateIndustryId = this.addSubIndustry.id;
      $scope.industries_selected.push(subUpdateIndustryId);
    };


    $scope.saveNewWork = function() {
      $scope.loadAddWH = true;
      var data;
      // // console.log(!("description" in $scope.workHistory));
      if(!("description" in $scope.workHistory)) {
        $scope.workHistory.description = "";
      }

      $scope.workHistory.industry = $scope.industries_selected;

      data = {data: $scope.workHistory};

      setTimeout(function() {
        RoleAppSrvcs.postWorkHistory(data).then(function(res) {
          $scope.resProfile.work_history.push(res);
          // // console.log("WH SAVED: ", $scope.resProfile.work_history);
          //$scope.workHistory = {};
          $scope.workHistory = {
            "work_type": "",
            "company_name": "",
            "job_title": "",
            "key_accountabilities": [],
            "description": "",
            "industry":[],
            "start_date": "",
            "end_date":"",
            "salary":""
          }
          $scope.toggleAddWH();

          var wh_index = $scope.$parent.$parent.requirements_check.indexOf("work_experience");
          if(wh_index != -1){
            $scope.$parent.$parent.requirements_check.splice(wh_index, 1);
            // // console.log("Work History Validate: ", $scope.$parent.$parent.requirements_check);
          }
          $scope.loadAddWH = false;
        });
      }, 300);
    };

    $scope.UpdateThisWH = function (obj, id) {

      //$scope.educationHistory.qualification_provider_name = esp.qualification_povider;
      // console.log(33, obj)
      if(obj.start_date != null) {
        if(new Date(obj.start_date) == 'Invalid Date') {
          var dSDate = obj.start_date;
          // console.log(obj.start_date)
          var das = dSDate.substring(0, dSDate.indexOf('-'));
          dSDate = dSDate.substring((dSDate.indexOf('-'))+1, dSDate.length)
          var mos = dSDate.substring(0, dSDate.indexOf('-'));
          dSDate = dSDate.substring((dSDate.indexOf('-'))+1, dSDate.length)
          var yrs = dSDate;

          obj.start_date = mos + '-' + das + '-' + yrs;

          // console.log('das',da)
          // console.log('mos',mo)
          // console.log('date',obj.start_date)
        }

        var format_date = new Date(obj.start_date);
        var format_date_month = format_date.getMonth() + 1;
        var formatted_date = format_date.getDate() + '-' + format_date_month + '-' + format_date.getFullYear();
        obj.start_date = formatted_date;
      } else {
        //obj.start_date = obj.start_date;
        //$scope.educationHistory.edi_current_study = true;
      }

      if(obj.end_date != null) {
        if(new Date(obj.end_date) == 'Invalid Date') {
          var dEndDate = obj.end_date;
          var da = dEndDate.substring(0, dEndDate.indexOf('-'));
          dEndDate = dEndDate.substring((dEndDate.indexOf('-'))+1, dEndDate.length)
          var mo = dEndDate.substring(0, dEndDate.indexOf('-'));
          dEndDate = dEndDate.substring((dEndDate.indexOf('-'))+1, dEndDate.length)
          var yr = dEndDate;

          obj.end_date = mo + '-' + da + '-' + yr;

          // console.log('da',da)
          // console.log('mo',mo)
          // console.log('date',obj.end_date)
        }

        var format_date = new Date(obj.end_date);
        var format_date_month = format_date.getMonth() + 1;
        var formatted_date = format_date.getDate() + '-' + format_date_month + '-' + format_date.getFullYear();
        obj.end_date = formatted_date;
      } else {
        //obj.start_date = obj.start_date;
        //$scope.educationHistory.edi_current_study = true;
      }

      if($scope.industries_selected_edit.length <= 0) {
        var thisIndus = obj.industries;
      } else {
        var thisIndus = $scope.industries_selected_edit;
      }

      for(var x = 0; x < obj.key_accountabilities.length; x++) {
        if(obj.key_accountabilities[x] == null || obj.key_accountabilities[x] == "") {
          obj.key_accountabilities.splice(x, 1);
        }
      }
      //// console.log(obj,89);

      var data = {
       "data":{
          "display_date": obj.display_date,
          "id": obj.id,
          "work_type": obj.work_type.id,
          "company_name": obj.company_name,
          "job_title": obj.job_title,
          "key_accountabilities": obj.key_accountabilities,
          "description": obj.description,
          "industry":thisIndus,
          "start_date": obj.start_date,
          "end_date":obj.end_date,
          "salary":obj.salary
       }
      }
      // console.log(222,data)

      $scope.loadEditWH = true;
      setTimeout(function() {
        RoleAppSrvcs.putUpdateWorkHistory(data, id).then(function (res){

          angular.forEach($scope.resProfile.work_history, function(val, key){
            if (val.id == res.id) {
              // val = res;
              // console.log("selfie muna bago update: ", val);
              $scope.resProfile.work_history[key] = res;
              // console.log("updated na: ", $scope.resProfile.work_history[key]);
            }
          });

          $scope.updateThisWorkhistory = true;
          $scope.updateThisWorkhistory_id = 0;

          $scope.loadEditWH = false;
          $scope.chvron = 0;
        });
      }, 300);
    };

    $scope.DeleteThisWH = function (index, id) {
      $scope.loadDelWH = true;
      $scope.loadDelWHId = id;
      // // console.log("DELETE: ", index, id);
      RoleAppSrvcs.deleteWorkHistory(id).then(function (res) {
        $scope.resProfile.work_history.splice(index, 1);
        $scope.loadDelWH = false;
        $scope.loadDelWHId = 0;
        // // console.log("DELETED: ", $scope.resProfile);
      });
    };


    $scope.cancelESP = function() {
      $scope.editEH = 0;
    }

    $scope.editESP = function(esp) {
      $scope.educationHistory_submit.degree = $scope.educationHistory.degree;
      $scope.educationHistory_submit.edi_current_study = $scope.educationHistory.edi_current_study;
      $scope.educationHistory_submit.qualification_provider = $scope.educationHistory.qualification_povider;
      //console.log("submitting EH edit: ", $scope.educationHistory);


      /*if(!("qualification_povider" in $scope.educationHistory_submit)) {
        $scope.educationHistory_submit.qualification_provider = $scope.educationHistory.qualification_poviderID;
      }*/
      if(!("qualification" in $scope.educationHistory_submit)) {
        $scope.educationHistory_submit.qualification = $scope.educationHistory.qualificationID;
      }

      if($scope.educationHistory_submit.edi_current_study) {
        $scope.educationHistory_submit.completed_date = null;
      }

      // PL-11 ---
      RoleAppSrvcs.getEducationProvider_list().then(function(res){
        var isInProviderList = [];

        angular.forEach(res, function(val, key) {
          isInProviderList.push(val.provider_display_name);
        });

        var isThereInPL = isInProviderList.indexOf($scope.educationHistory_submit.qualification_provider);
        if(isThereInPL > -1) {
          $scope.educationHistory_submit.qualification_provider = $scope.educationHistory.qualification_poviderID;
        } else {
          $scope.educationHistory_submit.qualification_provider = $scope.educationHistory.qualification_povider;
        }
      });
      // --- PL-11

      // PL-13 ---
      var isInQualiList = [];

      angular.forEach($scope.eduQualifications, function(val, key) {
        isInQualiList.push(val.qualification);
      });

      var isThereInQL = isInQualiList.indexOf($scope.educationHistory_submit.qualification);
      if(isThereInQL <= -1) {
        $scope.educationHistory_submit.qualification = $scope.educationHistory.qualification;
      } else {
        $scope.educationHistory_submit.qualification = $scope.educationHistory.qualificationID;
      }
      // --- PL-13

      //console.log($scope.educationHistory_submit,786);
      var data = {data : $scope.educationHistory_submit};
      // console.log("EDIT SAVE EH: ", $scope.editEH, data);

      $scope.loadEditESP = true;
      setTimeout(function() {
        RoleAppSrvcs.putEducationHistory(data, esp).then(function(res) {
          // console.log("NEW ADDED ESP: ", res);
          // console.log("CURRENT ESP: ", $scope.resProfile.qualifications);
          $scope.educationHistory = {};

          angular.forEach($scope.resProfile.qualifications, function(val, key) {
            if (val.id == $scope.editEH) {
              $scope.resProfile.qualifications[key] = res;
            }
          });

          $scope.loadEditESP = false;
          $scope.editEH = 0;
          $scope.educationHistory = {
            completed_date:"",
            degree:"",
            edi_current_study:false,
            otherDegree:"",
            qualification:"",
            qualification_povider:""
          };
        });
      }, 300);
    }

    $scope.saveNewESP = function () {

      // PL-11 ---
      RoleAppSrvcs.getEducationProvider_list().then(function(res){
        var isInProviderList = [];

        angular.forEach(res, function(val, key) {
          isInProviderList.push(val.provider_display_name);
        });
        //console.log(3543,$scope.educationHistory_submit);

        if(!(Number.isInteger($scope.educationHistory_submit.qualification_provider))) {
          var isThereInPL = isInProviderList.indexOf($scope.educationHistory_submit.qualification_provider);
          //console.log(23,$scope.educationHistory_submit.qualification_provider)
          //console.log(24,isInProviderList)
          if(isThereInPL > -1) {
            $scope.educationHistory_submit.qualification_provider = $scope.educationHistory.qualification_povider;
          } else {
            $scope.educationHistory_submit.qualification_provider = $scope.educationHistory.qualification_poviderID;
          }
        } else {                                                           
          $scope.educationHistory_submit.qualification_provider = $scope.educationHistory.qualification_poviderID;
        }

        if($scope.educationHistory_submit.edi_current_study) {
          $scope.educationHistory_submit.completed_date = null;
        }
      // --- PL-11

        RoleAppSrvcs.getEducationProvider($scope.educationHistory.qualification).then(function(result) {
        var isInQualiList = [];
        // PL-13 ---

        //console.log(34,result);
        //console.log(35,$scope.educationHistory_submit);
          angular.forEach(result, function(val, key) {
            isInQualiList.push(val.display_name);
          });

          if(!(Number.isInteger($scope.educationHistory_submit.qualification))) {
            var isThereInQL = isInQualiList.indexOf($scope.educationHistory_submit.qualification);
            if(isThereInQL <= -1) {
              $scope.educationHistory_submit.qualification = $scope.educationHistory.qualification;
            } else {
              $scope.educationHistory_submit.qualification = $scope.educationHistory.qualificationID;
            }
          } else {
            //$scope.educationHistory_submit.qualification = $scope.educationHistory.qualificationID;
          }
        // --- PL-13

          //console.log($scope.educationHistory_submit,786);
          if(!("degree" in $scope.educationHistory_submit)) {
            alert("Please select your degree.")
          } else {
            var data = {data : $scope.educationHistory_submit};
            $scope.loadAddESP = true;
            // // console.log("SAVING NEW ESP: ", data);
            setTimeout(function() {
              RoleAppSrvcs.postNewEducationHistory(data).then(function(res){
                $scope.qualifications.push(res);
                $scope.addESP = 0;
                $scope.educationHistory = {};
                $scope.educationHistory_submit = {};

                var edu_index = $scope.$parent.$parent.requirements_check.indexOf("education");
                if(edu_index != -1){
                  $scope.$parent.$parent.requirements_check.splice(edu_index, 1);
                }
                $scope.loadAddESP = false;
              });
            },300);
          }
        });
      });
    };

    $scope.EditThisEH = function (esp) {
      var format_date = new Date(esp.completed_date);
      var format_date_month = format_date.getMonth() + 1;
      var formatted_date = format_date.getDate() + '-' + format_date_month + '-' + format_date.getFullYear();
      $scope.editEH = esp.id;
      $scope.educationHistory.degree = esp.degree;
      $scope.educationHistory.qualification = esp.qualification.display_name;
      $scope.educationHistory.qualificationID = esp.qualification.id;
      $scope.educationHistory.qualification_povider = esp.qualification_provider.provider_display_name;
      //$scope.educationHistory.qualification_provider_name = esp.qualification_povider;
      $scope.educationHistory.qualification_poviderID = esp.qualification_provider.id;
      if(esp.completed_date != null) {
        $scope.educationHistory.completed_date = formatted_date;
      } else {
        $scope.educationHistory.completed_date = $scope.educationHistory.completed_date;
        $scope.educationHistory.edi_current_study = true;
      }
    }

    $scope.DeleteThisEH = function (index, id) {
      $scope.loadDelESP = true;
      $scope.loadDelESPId = id;
      // console.log("DELETE: ", index, id);
      RoleAppSrvcs.delEducationHistory(id).then(function (res) {
        $scope.resProfile.qualifications.splice(index, 1);
        $scope.loadDelESP = false;
        $scope.loadDelESPId = 0;
        // console.log("DELETED: ", $scope.resProfile);
      });
    };
    // Education Content END

    // Work History BEGIN
    RoleAppSrvcs.getWorkType().then(function(res){
      $scope.work_types_wh = res;
    });

    RoleAppSrvcs.getAllIndustries().then(function(res){
      $scope.all_industries = res;
      // console.log('all industries: ', $scope.all_industries);
    });

    document.hoverIndustry = function(obj) {
      var checkbox = $(obj).find('input[name="industries"]')[0];
      document.industry_selected(checkbox);
    };

    document.industry_selected = function(obj) {
      var obj = $(obj);
      obj.parents('ul').find('.all_industry').removeClass('pvm-light-gray-background');
      obj.parent().addClass('pvm-light-gray-background');
      var sub_industry = obj.parent().find('.sub_industry_multi_holder').clone();

      obj.parents('.industry_multi_main').next().find('.sub_industry_holder').html(sub_industry);
      obj.parents('.industry_multi_main').next().find('.sub_industry_holder').find('.sub_industry_multi_holder').removeClass('hide');
      $('.sub_industry_multi_holder').TrackpadScrollEmulator();
    };

    document.sub_industry_selected = function(obj) {
      var obj = $(obj);
      var sub_industry = obj.parents('ul').clone();
      var industry_id = obj.parents('.sub_industry_multi_holder').attr('data-id');
      var sub_ind_val = $(obj).context.value;

      // force checked industry
      obj.parents('.subindustry_multi_main').prev().find('#industry_' + industry_id + ' > input').prop('checked', true)
          // force checked/unchecked original subindustry
      obj.parents('.subindustry_multi_main').prev().find('.sub_' + industry_id).html(sub_industry);

      // $scope.industries_selected.push(sub_ind_val);
      // IB removed old classification selection
      // $scope.industries_selected_edit = [];
      // $scope.industries_selected_edit.push(industry_id);
      // $scope.industries_selected_edit.push(sub_ind_val);
      // console.log($scope.industries_selected_edit,333)
    };

    $scope.onHoverSubIndustries = true;
    document.showSubIndustries = function(obj) {
      $scope.onHoverSubIndustries = true;
      if (obj) {
        $(obj).parent().find('.subindustry_multi_main').removeClass('hide')
      }
    };

    document.hideSubIndustries = function(obj) {
      $scope.onHoverSubIndustries = false;
      setTimeout(function() {
        if ($scope.onHoverSubIndustries == false) {
          $(obj).find('.subindustry_multi_main').addClass('hide');
        }
      }, 1500);
    };
    // Work History END

    $scope.saveGenInfo = function (data) {
      $scope.loadGen = true;
      var postdata = { data: {
        "first_name":$scope.resProfile.first_name,
        "last_name":$scope.resProfile.last_name,
        "phone_number":$scope.resProfile.phone_number,
        "long_description":$scope.resProfile.long_description,
        "location":$scope.resProfile.preferred_location.data.country.display_name
      }};

      if ($scope.$parent.$parent.requirements_check.indexOf("phone_number") > -1) {
        if ($scope.resProfile.phone_number.length > 0) {
          var indexer = $scope.$parent.$parent.requirements_check.indexOf("phone_number");
          if(indexer != -1){
            $scope.$parent.$parent.requirements_check.splice(indexer, 1);
          }
        } else if ($scope.resProfile.phone_number.length == 0) {
          var indexer = $scope.$parent.$parent.requirements_check.indexOf("phone_number");
          if(indexer == -1){
            $scope.$parent.$parent.requirements_check.push("phone_number");
          }
        }
      }

      if ($scope.$parent.$parent.requirements_check.indexOf("about_me") > -1) {
        if ($scope.resProfile.first_name.length > 0 && $scope.resProfile.last_name.length > 0 && $scope.resProfile.long_description.length > 0 ) { // about_me
          var indexer = $scope.$parent.$parent.requirements_check.indexOf("about_me");
          // // console.log("FAWK: ", indexer);
          if(indexer != -1){
            $scope.$parent.$parent.requirements_check.splice(indexer, 1);
          }
          // // console.log("ABOUT_ME IS OK");
        } else if ($scope.resProfile.first_name.length == 0 && $scope.resProfile.last_name.length == 0 && $scope.resProfile.long_description.length == 0 ) {
          var indexer = $scope.$parent.$parent.requirements_check.indexOf("about_me");
          if(indexer == -1){
            $scope.$parent.$parent.requirements_check.push("about_me");
          }
          // // console.log("ABOUT_ME IS REQUIRED");
        }
      }

      if ($scope.$parent.$parent.requirements_check.indexOf("location") > -1) {
        if ($scope.resProfile.preferred_location.data.country.display_name.length > 0) { //location
          var indexer = $scope.$parent.$parent.requirements_check.indexOf("location");
          if(indexer != -1){
            $scope.$parent.$parent.requirements_check.splice(indexer, 1);
          }
        } else if ($scope.resProfile.preferred_location.data.country.display_name.length == 0) {
          var indexer = $scope.$parent.$parent.requirements_check.indexOf("location");
          if(indexer == -1){
            $scope.$parent.$parent.requirements_check.push("location");
          }
        }
      }

      // // console.log('SAVEGENINFO: ', $scope.$parent.$parent.requirements_check);
      //console.log(postdata);
      RoleAppSrvcs.postCandidateInfo(postdata).then(function(){
        // console.log("Info saved!",postdata);
        $scope.loadGen = false;
      });

    };

    $scope.AddReference = function() {
      $scope.loadAddRef =true;

      setTimeout(function() {
        RoleAppSrvcs.postReference($scope.postreference).then(function(res) {
          if (res.id) {
            var displayVal = {
              employer_name: res.employer_name,
              id: res.id,
              company_name: res.company_name,
              contact_email: res.contact_email,
              contact_phone: res.contact_phone,
              description: res.description
            };
            $scope.references.push(displayVal);
            $scope.showRef = false;
            // $scope.getStepData()

            $scope.postreference = {
              description: '',
              employer_name: '',
              company_name: '',
              contact_email: '',
              contact_phone: ''
            };

            var requirement_satisfied = $scope.$parent.$parent.requirements_check.indexOf("references");
            $scope.$parent.$parent.requirements_check.splice(requirement_satisfied, 1);
            $scope.loadAddRef =false;
          }
        });
      }, 300);
    }

    $scope.editThisRef = function(index) {
      $scope.editRef = $scope.references[index].id;
      $scope.references[index].description = $scope.references[index].description.replace(new RegExp("<br>", 'g'), "\n");

    }

    $scope.deleteThisRef = function(index, id) {
      $scope.loadDelRef = true;
      $scope.loadDelRefId = id;

      RoleAppSrvcs.delReference(id).then(function(res) {
        $scope.references.splice(index, 1);
        $scope.resProfile.references.splice(index, 1);
        // console.log("DELETED: ", $scope.resProfile);
        $scope.loadDelRef = false;
        $scope.loadDelRefId = 0;
      });

    }

    $scope.editReference = function(ref) {
      $scope.loadEditRef =true;

      setTimeout(function() {
        RoleAppSrvcs.editReference(ref.id, ref).then(function(res) {
          $scope.references.push(ref);
          $scope.editRef = 0;
          $scope.loadEditRef = false;
        });
      }, 300);
    }

    $scope.newToWorkForce = function(v){
      // // console.log("NEW TO WORK FORCE: ", v);
      var formData = {
          "data": {
              new_to_workforce: v
          }
      };

      RoleAppSrvcs.putNewToWorkForce(formData).then(function(res) {
        // // console.log("WORK PORSE: ", res);
        var new_to_workforce = res.config.data.data.new_to_workforce;
        $scope.addWH = 0; // hide form;
        // $scope.showWorkHistoryForm = false;

        var index = $scope.$parent.$parent.requirements_check.indexOf('work_experience');
        if (index != -1 && new_to_workforce == true) {
            $scope.$parent.$parent.requirements_check.splice(index, 1);
        } else if (index == -1 && new_to_workforce == false){
            $scope.$parent.$parent.requirements_check.push('work_experience')
        }

        // // console.log("WORK PORS REQ STATE: ", $scope.$parent.$parent.requirements_check);
      }, function(res) {
        alert('some error');
      });

    };

  }]);

  app.controller('MakeVideoCtrl', ['$scope', '$window', '$cookies', '$compile', '$interval', '$timeout', 'RoleAppSrvcs', 'fileUploadService',
    function($scope, $window, $cookies, $compile, $interval, $timeout, RoleAppSrvcs, fileUploadService){
    // console.log('MK activated');
    var myPlayer = "";

    $scope.$on('$destroy', function(){
      if(!!myPlayer) {
        myPlayer.dispose();
      }
    });

    var guid = $cookies.get('icebreakerguid');
    $scope.showDeleteVideo = 0;
    $scope.$parent.$parent.showVid = false;
    $scope.showVideoTop = false;
    $scope.showVideoLoding = false;
    $scope.VideoStatus = "nothing";
    // upload watcher scopes BEGIN =====
    $scope.encoding_progress = 0;
    $scope.encoding_job_status = "";
    $scope.video_status = "";

    $scope.deleteVideo = function() {
      var id = $scope.docs_url.docs.icebreaker_video.doc_id;

      var result = confirm("Deleting this video will affect all of your job/role that you have already applied on. Are you sure?");
      if (result && id) {
        // console.log("video delete");
        RoleAppSrvcs.deleteVideo().then(function(response) {
          delete $scope.docs_url.docs.icebreaker_video;
          $scope.VideoStatus = "nothing";
        }, function() {
            alert('error')
        });
      }
    }

    $scope.renderVideo = function (url, id) {
      // console.log("irerender nalang: ", id, url);
      $timeout(function() {
        myPlayer = amp(id, {
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
          // events here
        });

        myPlayer.src([{
          src: url,
          type: "application/vnd.ms-sstr+xml"
        }]);
      }, 2000);

      $scope.showDeleteVideo = 1;
    };

    function watchVideoProgress (guid) {
      RoleAppSrvcs.getVideoProgress(guid).then(function(res){
        // // console.log("Vid progress: ", res);
        $scope.video_status = res.video_status;

        if (res.video_status != 'discarded') {
          return false;
        } else if (res.video_status != 'processing_completed') {
          $scope.encoding_progress = res.encoding_progress ? res.encoding_progress : 0;
          $scope.encoding_job_status = res.encoding_job_status ? res.encoding_job_status : 'Ready for encoding';
          watchVideoProgress(guid);
        } else {
          $scope.VideoStatus = "";
          $scope.renderVideo(res.streaming_url, 'profile_video');
        }
      });
    }

    // =========================================================
    $scope.$watch('guid_response_profile', function (newVal, oldVal) {
      if (newVal) {
        console.log("nag uplod: ", newVal);
        $scope.VideoStatus = "uploading";
        $scope.showDeleteVideo = 0;

        // watchVideoProgress(newVal);
      }
    });
    // =========================================================
    $scope.Init_ProfileVideo = function () {
      $scope.$parent.$parent.role_app_tab_loader = 1; // loader
      RoleAppSrvcs.getCandidateProfile().then(function(res){ // call API candidate profile video
        $scope.docs_url = res;

        if ($scope.docs_url.length > 0 || $scope.docs_url) {
          $scope.$parent.$parent.role_app_tab_loader = 0; // loader
        }

        if ($scope.docs_url.docs.icebreaker_video) {
          // console.log("YOU GOT A VIDEO! ", $scope.docs_url.docs.icebreaker_video);
          if ($scope.docs_url.docs.icebreaker_video.doc_url) {
            // console.log("YOU GOT A VIDEO 2!");

            $scope.VideoStatus = "";
            $scope.renderVideo($scope.docs_url.docs.icebreaker_video.doc_url, 'profile_video');
          } else if (($scope.docs_url.docs.icebreaker_video.doc_url == 0 || $scope.docs_url.docs.icebreaker_video.doc_url == '') && $scope.docs_url.docs.icebreaker_video.doc_id) {
            // // console.log("Video 2: ", $scope.docs_url.docs.icebreaker_video);
            if (guid) { // check if uploading
              $scope.VideoStatus = "uploading";
              $scope.showVideoTop = false;
              $scope.showVideoLoding = false;
              // watchVideoProgress(guid);
            } else {
              $scope.VideoStatus = "uploading";
              $scope.showVideoTop = false;
              $scope.showVideoLoding = false;
            }
          }
        } else if (!$scope.docs_url.docs.icebreaker_video) {
          // // console.log("NOTHING")
          $scope.VideoStatus = "nothing";
          $scope.showVideoTop = false;
          $scope.showVideoLoding = false;

        }  else {
          // // console.log("UPLOAD VIDEO!");
          $scope.showVideoTop = false;
          // $scope.showVideoLoding = true;
        }
      });
    }

    // check if video has been succesfully uploaded, then validate applicants' requirement
    $scope.$watch('app_video_uploaded_success', function(newVal, oldVal) {
      // // console.log("WATCH app_video_uploaded_successsssssssssssssssssssssssssss ", newVal);
      if (newVal == 1) {
        // // console.log('video successfully uploaded');
        var video_satisfied = $scope.$parent.$parent.requirements_check.indexOf("icebreaker_video");
        if (video_satisfied != -1) {
          $scope.$parent.$parent.requirements_check.splice(video_satisfied, 1);
        }
      }
    });

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
    };

    $scope.startVideo = function() {
      $('#pmvCameraModalNew').modal('show');
      $scope.$parent.$parent.sectionsHideShow(1, 0); // show modal record video
      checkBrowsers();
      $scope.$parent.$parent.Origin = 'candidate_profile_edit';
      // $scope.$parent.$parent.Origin = 'candidate_profile_edit_app'; // uncomment later, this is an enhanced origin name

      if($scope.isSafari || $scope.browserName == "Safari") {
        alert('Oh oh this feature is not yet supported by your browser. Drag and drop a video file instead, or use Chrome, Firefox or Microsoft Edge to record a video using your webcam.');
      } else {
        fileUploadService.startVideo($scope);
        $scope.modal_percent = true;
      }
    };

    $scope.openVideoModal = function() {
      $scope.$parent.$parent.Origin = "candidate_profile_edit";
      $('#pmvCameraModalNew').modal('show');
    };

    $scope.$watch('active_tab', function(newVal, oldVal){
      if (newVal == $scope.stepstab.showVideo && $scope.stepstab.showVideo != 0) {
        $scope.Init_ProfileVideo();
      }
    });

  }]);

  app.controller('StandardQuestionCtrl', ['$scope', '$window', '$cookies', '$compile', '$timeout', 'RoleAppSrvcs', 'RoleAppGetUrl', 'fileUploadService',
    function($scope, $window, $cookies, $compile, $timeout, RoleAppSrvcs, RoleAppGetUrl, fileUploadService){
    // console.log('SQ activated');
    $scope.questions_videos = [];
    $scope.sq_guid_can = [];
    $scope.player_arr = [];

    $scope.$on('$destroy', function () {
      angular.forEach($scope.questions_videos, function(val, key) {
        var mahplayah = val.myPlayer;
        if (!!mahplayah) {
          mahplayah.dispose();
        }
      });

      angular.forEach($scope.player_arr, function(val, key) {
        var myplayah = val.myPlayer;
        myplayah.dispose();
      });
    });

    // render video to UI
    $scope.renderVideo = function (url, id) {
      var videoCon_id = "sq_video_" + id;
      var tae = document.getElementById(videoCon_id);
      var tae2 = document.getElementById('vid_outercon_' + id);

      $timeout(function() { // wait for UI/template to render
        var myPlayer = amp(videoCon_id, {
          // "techOrder": ["azureHtml5JS", "flashSS", "html5", "silverlightSS"],
          "nativeControlsForTouch": false,
          autoplay: false,
          controls: true,
          width: "100%",
          logo: {
            "enabled": false
          },
          poster: ""
        }, function() {
          // events here
          // console.log("video ready");
        });

        $scope.player_arr.push({
          id: id,
          myPlayer: myPlayer
        });

        angular.forEach($scope.player_arr, function(val, key){
          if (val.id == id) {
            val.myPlayer.src([{
              src: url,
              type: "application/vnd.ms-sstr+xml"
            }]);
          }
        });

        myPlayer = null;

        // console.log("play arr: ", $scope.player_arr);
      }, 500);
    };

    // already been uploaded but still in encoding process
    function multiVideoStatusInitiate() {
      angular.forEach($scope.pre_standard, function (val, key){
        var cookie_guid = $cookies.getObject('cansq');
        // console.log("get cookies val: ", cookie_guid);
        var question_video_guid = '';
        var absolute_cookie_id = 0;
        val.answer_video = {};

        if (cookie_guid) {
          // console.log("KOWKIE GUID: ", JSON.parse(cookie_guid));
          for (var a = 0; a < JSON.parse(cookie_guid).length; a++) {
            // console.log("QID: ", JSON.parse(cookie_guid)[a].qid, val.id);

            if (JSON.parse(cookie_guid)[a].qid == val.id) {
              val.answer_video.encoding_progress = 0;
              val.answer_video.encoding_job_status = '';
              val.answer_video.VideoStatus = "uploading";
              val.answer_video.doc_guid = JSON.parse(cookie_guid)[a].qguid;
              val.answer =  JSON.parse(cookie_guid)[a].qguid;

              absolute_cookie_id = JSON.parse(cookie_guid)[a].qid;
              // question_video_guid = val.answer_video.doc_guid;
              watchVideoProgress(val.answer_video, val.id);
            }
          }

          angular.forEach($scope.post_standard, function(kval, kkey){
            if (kval.question_id == absolute_cookie_id) {
              kval.answer = '1';
              kval.type = 'video';
              // console.log("cookie post standard: ", kval);

              var splice_question = $scope.$parent.$parent.sq_validator_ids.indexOf(kval.question_id);
              // // console.log("SPLICE VIDEO UPLOAD SQ ID: ", splice_question);
              if (splice_question > -1) {
                $scope.$parent.$parent.sq_validator_ids.splice(splice_question, 1);
                // $scope.submit_standard(kval.question_id, "1");
              }
            }
          });
        }

        // if (val.answer_video.doc_url) {
        //   console.log("parsing already uploaded videos ", val.id);
        //   val.answer_video.VideoStatus = "";
        //   $scope.renderVideo(val.answer_video.doc_url, val.id);
        // }
        // else {
        //   console.log("parsing newly uploaded videos ", val.id);
        //   if (cookie_guid) {
        //     // console.log("KOWKIE GUID: ", JSON.parse(cookie_guid));
        //     for (var a = 0; a < JSON.parse(cookie_guid).length; a++) {
        //       // console.log("QID: ", JSON.parse(cookie_guid)[a].qid, val.id);

        //       if (JSON.parse(cookie_guid)[a].qid == val.id) {
        //         val.answer_video.encoding_progress = 0;
        //         val.answer_video.encoding_job_status = '';
        //         val.answer_video.VideoStatus = "uploading";
        //         val.answer_video.doc_guid = JSON.parse(cookie_guid)[a].qguid;

        //         watchVideoProgress(val.answer_video, val.id);
        //       }
        //     }
        //   }
        // }
      });

      // console.log("done parsing all questions");
    }

    // central func, watcher
    function watchVideoProgress (video_document, question_id) {
      var guid = video_document.doc_guid;

      // get video encoding status
      RoleAppSrvcs.getVideoProgress(guid).then(function(res){
        // console.log("Vid progress: ", res, question_id);

        if (res.video_status == 'discarded') {
          return false;
        } else if (res.video_status != 'processing_completed') { // stack limiter, if still encoding. recursive when status is not cmopleted
          video_document.encoding_progress = res.encoding_progress ? res.encoding_progress : 0;
          video_document.encoding_job_status = res.encoding_job_status ? res.encoding_job_status : 'Preparing..';
          watchVideoProgress(video_document, question_id);
        } else { // if encoding is done and url available, render the video to DOM
          video_document.VideoStatus = res.video_status;
          $scope.renderVideo(res.streaming_url, question_id);
          // $scope.submit_standard(question_id, "1");

          // var splice_question = $scope.$parent.$parent.sq_validator_ids.indexOf(newVal.question_id);

          // if (splice_question > -1) {
          //   $scope.$parent.$parent.sq_validator_ids.splice(splice_question, 1);
          // }
        }
      });
    }

    var sqmplayer = "";
    $scope.post_standard = [];
    $scope.role_objId = RoleAppGetUrl.getUrlParameter('job_id', '');
    if (!$scope.role_objId) {
      $scope.role_objId = $cookies.get('jobObjectId');
    }

    $scope.$watch("guid_response_sq_can", function(newVal, oldVal){ // video upload tracker
      //console.log("GUID RESPONSE SQ candidate: ", newVal);
      if (newVal) { // validate question id
        angular.forEach($scope.pre_standard, function(val, key){
          // console.log(val.id + ' == ' + newVal.question_id);
          if (val.id == newVal.question_id) {
            val.answer_video = newVal.video_document;
            var cookie_uploaded = $cookies.getObject('cansq');
            // $scope.sq_guid_can = cookie_uploaded;
            // console.log("Stored Cookie: ", cookie_uploaded); // PITSTOP

            $cookies.remove('cansq');
            $scope.sq_guid_can.push({
              'qid': newVal.question_id,
              'qguid': newVal.video_document.doc_guid
            });
            // console.log("cookie shit ", $scope.sq_guid_can);
            $cookies.putObject('cansq', JSON.stringify($scope.sq_guid_can));

            val.answer_video.encoding_progress = 0;
            val.answer_video.encoding_job_status = '';
            val.answer_video.VideoStatus = "uploading";
            val.answer_video.doc_guid = newVal.video_document.doc_guid;
            // watchVideoProgress(val.answer_video, newVal.question_id)
            // console.log("pre standard scope: ", val);
            $scope.submit_standard(newVal.question_id, newVal.answer_id);
          }
        });

        // // console.log("TAE4 : ", $scope.$parent.$parent.sq_validator_ids);

      }
    });

    $scope.slider_temp = [];
    $scope.slider_collection = [];
    $scope.application_objId = RoleAppGetUrl.getUrlParameter('id', '');


    $scope.uploadSQFile = function(id, type) { // upload document
      // // console.log("uploadSQFile DOCTYPE: ", type);
      $scope.$parent.$parent.Origin = "standard_question_answer";

      $scope.$parent.$parent.docFileType = type;
      $scope.$parent.$parent.sq_id = id;
      fileUploadService.openModal($scope, '#pmvFileModalNew', type);
    };

    $scope.openVideoModalSQ = function(data, type) {
      // // console.log("OPEN MOWDAL");
      $scope.$parent.$parent.Origin = "standard_question_answer";
      $scope.$parent.$parent.sq_id = data;
      $('#pmvCameraModalNew').modal('show');
    };


    $scope.clear_answertypes = function (event, scope, obj) {
      // console.log("choosing ", scope);
      // console.log("choosing obj ", obj);

      if (obj.answer != "") {
        if (confirm('An answer has been detected for current answer-type. Are you sure you want to change the answer-type?')) {
          obj.answer = "";
          obj.temp_choice = scope.qans;
        } else {
          $timeout(function() {
            scope.choice = obj.temp_choice;
            obj.choice = scope.choice;
          }, 100);
        }
      } else {
        obj.temp_choice = scope.qans;
        obj.choice = scope.qans;
      }
    };



    $scope.submit_standard = function (id, answer, extra) { // general types SQ submission, 'extra' is for video upload only
      var data;
      var keep = true;
      var failCtr = 0;
      var forCtr = $scope.post_standard.length;

      // this form validation would probably no longer needed?
      // as the SQ validation relies on sq_validator_ids scope
      if ($scope.StandardQuestionForm.$valid) {
        $scope.$parent.$parent.standard_form_valid = true;
      }

      // console.log("before sq ans ", $scope.post_standard);

      if (answer) {
        angular.forEach($scope.post_standard, function(val, key) {
          // // console.log(val,332)
          if (val.question_id == id){
            val.answer = answer;

            var spliced_id = $scope.$parent.$parent.sq_validator_ids.indexOf(id);
            // console.log("splice sq id: ", spliced_id, id);
            // this matters mostly at first input field interaction, on SQ form
            if (spliced_id != -1) {
              // remove question id from object, only means that the question has been answered.
              $scope.$parent.$parent.sq_validator_ids.splice(spliced_id, 1);
            }
          } else {
            // UI SQ validator
            failCtr += 1;
          }

          // idk wtf this is, probably will enhance this one
          if (forCtr == failCtr) {
            keep = false;
          }
        });

        // pre_standard scope manifested on the UI
        angular.forEach($scope.pre_standard, function(val, key) {
          if (val.id == id) { // uploaded file manifest to UI
            if (extra) { // extra = document uploaded as an object
              val.answer = extra;
            } else {
              val.answer = answer;
            }
          }

          //rca 274 start
          angular.forEach($scope.post_standard, function(val2, key2) {
            // // console.log(val, val.answer_type.length)
            if(val2.question_id == val.id) {
              if(val.answer_type.length > 1) {
               val2.type = val.choice
              } else {
                val2.type = val.answer_type[0]
              }
            }
          });
          //rca 274 end

          var ansIndex = $scope.post_standard.indexOf(id);
        });
        // keep = true, means that all question has been answered
        if (keep) {
          // posting to parent scope at RoleMainCtrl for submission
          $scope.$parent.$parent.submit_standardq = $scope.post_standard;
          // $scope.$parent.$parent.submit_standardq.push($scope.post_standard);
          // console.log('child SCOPE: ', $scope.post_standard);
          // console.log('MOTHER SCOPE: ', $scope.$parent.$parent.submit_standardq);
        }
      }
    };

    $scope.Init_standard = function () {
      // console.log("INIT SQ");
      var role_objId = "JV5EHZ1ZX";
      $scope.$parent.$parent.role_app_tab_loader = 1; // loader
      // console.log('id',$scope.application_objId)
      //RoleAppSrvcs.getStandardQ($scope.role_objId, $scope.application_objId).then(function (res){
      RoleAppSrvcs.getStandardQ(role_objId).then(function (res){

        $scope.pre_standard = '';
        $scope.post_standard = [];
        $scope.$parent.$parent.sq_validator_ids = [];
        var arrComp_declaration = [], arrCan_declaration = [];
        $scope.pre_standard = res;
        // console.log('questions', $scope.pre_standard);
        // console.log('SQS: ', $scope.pre_standard);

        if ($scope.pre_standard.length > 0 || $scope.pre_standard) {
          $scope.$parent.$parent.role_app_tab_loader = 0; // loader
        }

        angular.forEach($scope.pre_standard, function(val, key) { // parse each question
          var vid_id_index = key;
          var vid_id = 'vid_' + vid_id_index.toString();
          // // console.log("VIDEO STANDARD QUESTION: ", val.video_document, val.video_document.length);

          // if sq video question
          if (val.video_document.doc_url) {
            // video rendering
            if (val.video_document.doc_url != 0 || val.video_document.doc_url != '') {
              $timeout(function() {
                sqmplayer = amp(vid_id, {
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
                }, function () {
                  // events here
                });
                // $scope.showVideoTop = true;
                // $scope.showVideoLoding = false;

                $scope.questions_videos.push({
                  id: vid_id,
                  myPlayer: sqmplayer
                });

                angular.forEach($scope.questions_videos, function(subVal, subKkey){
                  if (subVal.id == vid_id) {
                    subVal.myPlayer.src([{
                      src: val.video_document.doc_url,
                      type: "application/vnd.ms-sstr+xml"
                    }]);
                  }
                });

                // sqmplayer.src([{
                //   src: val.video_document.doc_url,
                //   type: "application/vnd.ms-sstr+xml"
                // }]);
              }, 3000);
            }
          }

          // if SQ is not declaration
          // if (!val.question_type) {
          //   $scope.$parent.$parent.sq_validator_ids.push(val.id);
          // }

          // if SQ is declaration
          if (val.question_type) {
            // // console.log("YOU SHOULDNT BE HERE ", val.question_type);
            if (val.question_type == 'comp_declaration') {
              arrComp_declaration.push(val);
              $scope.$parent.$parent.company_dec = arrComp_declaration[0];
              val.answer = "Yes";
              // console.log("COMP DECLAATION: ", $scope.$parent.$parent.company_dec);
            }

            if (val.question_type == 'can_declaration') {
              arrCan_declaration.push(val);
              $scope.$parent.$parent.candidate_dec = arrCan_declaration[0];
              // console.log("CAN DECLAATION: ", $scope.$parent.$parent.candidate_dec);
              $scope.$parent.$parent.tabs.showDec = 1;
              $scope.$parent.$parent.ready_steps(); // refresh steps list due to this delayed step
            }
          }

          if (val.question_type == 'comp_declaration' || val.question_type == 'can_declaration') {
            $scope.post_standard.push({
              question_id: val.id,
              answer: "Yes",
              type: ""
            });

            $scope.$parent.$parent.submit_standardq.push({ // catch, if no SQ has been created but declarations are.
              question_id: val.id,
              answer: "Yes",
              type: ""
            });
          } else {
            $scope.$parent.$parent.sq_validator_ids.push(val.id);
            //console.log("head");

            $scope.post_standard.push({
              question_id: val.id,
              answer: "",
              type: ""
            });

            $scope.$parent.$parent.submit_standardq.push({ // catch, if no SQ has been created but declarations are.
              question_id: val.id,
              answer: "",
              type: ""
            });

          }

          for (var a = 0; a < val.answer_type.length; a++) { // parent questions here
            if (val.answer_type[a] == 'boolean') {
              val.radio_boolean = 0;
            } else if (val.answer_type[a] == 'slider') { // separate bespoke questions
              $scope.slider_temp.push({
                question_id: val.id,
                question: val.question,
                answer: 0,
                type: "parent",
                slider: {}
              });
            }
          }

          if (val.sub_questions) { //sub questions here
            angular.forEach(val.sub_questions, function(sub1_val, sub1_key){
              for (var a = 0; a < sub1_val.type.length; a++) {
                if (sub1_val.type[a] == 'boolean') {
                  sub1_val.radio_boolean = 0;
                }
                if (sub1_val.type == 'slider') { // separate bespoke sub questions
                  $scope.slider_temp.push({
                    question_id: sub1_val.id,
                    question: sub1_val.question,
                    answer: 0,
                    type: "child",
                    slider: {}
                  });
                } else {
                  if (!val.question_type || val.question_type == '') {
                    $scope.post_standard.push({
                      question_id: sub1_val.id,
                      answer: "",
                      type: ""
                    });
                  }
                }
              }
            });
          }
          val.answer = "";

          val.temp_choice = "";
          // console.log("init standard: ", $scope.pre_standard);
          // console.log("init POST STANDARD: ", $scope.post_standard);
          // console.log("slider temp: ", $scope.slider_temp);
        });

        // parse each question (with sliders as did from above) and push in the slider for each question.
        angular.forEach($scope.slider_temp, function(sVal, sKey){
          sVal.slider = {
            min: sKey,
            max: 10,
            options: {
              floor: 0,
              ceil: 10,
              id: sVal.question_id,
              onEnd: function(sliderId, modelValue, highValue, pointerType) {
                $scope.slider_func(sliderId, modelValue, highValue, pointerType);
              }
            }
          };
        });

        // multiVideoStatusInitiate();
      },function(error){
        // console.log('Something is wrong',error);
      });
    };

    $scope.$watch('active_tab', function(newVal, oldVal){
      if (newVal == $scope.stepstab.showStan && $scope.stepstab.showStan != 0) {
        // console.log("call Init_standard ", newVal, $scope.stepstab.showStan);
        $scope.Init_standard();
      }
    });

    $scope.change_ans_type = function (type, id) {
      $scope.ans_type = {
        type: "",
        id: ""
      }

      $scope.ans_type.type = type;
      $scope.ans_type.id = id
    };

    // $scope.$parent.$parent.$watch('return_data_daym', function(newVal, oldVal){ // document upload respons
    $scope.$parent.$parent.$watch('return_uploaded_app_sq', function(newVal, oldVal){ // document upload respons
      // console.log("WATCHING RETURN DATA DAYM ", newVal);
      angular.forEach($scope.pre_standard, function(val, key){ // find ID
        if (val.id == $scope.$parent.$parent.sq_id) {
          val.answer = {
            file_name: newVal.file_name.substr(newVal.file_name.indexOf("_") + 1),
            doc_url: newVal.url
          };

          // // console.log("SUPPORT SQ RETURN DATA TAE: ", val.doc_url, val);
          $scope.submit_standard(val.id, newVal.id, val.answer);
        } else {
          // console.log("FILE UPLOAD ID FAILED: ", val.id, $scope.$parent.$parent.sq_id);
        }
      });
    });

    $scope.$watch("return_uploaded_app_sq", function (newVal, oldVal){
      if (newVal) {
        // console.log("upload SQ answer file success: ", newVal);
      }
    });

    $scope.$watch('post_standard', function(newVal, oldVal){ // for test only
      // // console.log('WATCHING POST_STANDARD: ', newVal);
    });

    // slider functions BEGIN
    $scope.refreshSlider = function () {
      $timeout(function () {
          $scope.$broadcast('rzSliderForceRender');
      });
    };

    $scope.slider_func = function (sliderId, modelValue, highValue, pointerType) {
      $scope.submit_standard(sliderId, modelValue);
    };
    // slider functions END

  }]);

  app.controller('DeclarationCtrl', ['$scope', '$window', '$cookies', '$compile', '$timeout', 'RoleAppSrvcs', function($scope, $window, $cookies, $compile, $timeout, RoleAppSrvcs){
    $scope.declare = false;

    $scope.$watch('$parent.$parent.candidate_dec', function(newVal, oldVal){
      $scope.declaration = newVal;
    });

    $scope.$watch('declare', function(newVal, oldVal){
      if (newVal == true) {
        $scope.$parent.$parent.notdeclared = false;
        $scope.compDecl = false;
      } else {
        if ($scope.declaration == "") {
          $scope.$parent.$parent.notdeclared = false;
        } else {
          $scope.$parent.$parent.notdeclared = true;
        }
        $scope.compDecl = true;
      }
    });
  }]);

  app.service('RoleAppGetUrl', function(){
    return  {
      getUrlParameter: function (data, path) {
        var sPageURL = path || window.location.search.substring(1),
        sURLVariables = sPageURL.split(/[&||?]/),
        res;

        for (var i = 0; i < sURLVariables.length; i += 1) {
          var paramName = sURLVariables[i],
              sParameterName = (paramName || '').split('=');

          if (sParameterName[0] === data) {
              res = sParameterName[1];
          }
        }
        return res;
      }
    }
  });

  app.service('InitialPlaceholder', function() {
    // random color set
    var color_bg_initial_set = [
      "member-initials--sky",
      "member-initials--pvm-purple",
      "member-initials--pvm-green",
      "member-initials--pvm-red",
      "member-initials--pvm-yellow"
    ];

    return {
      setSingleNameInitial: function (data) {
        // // console.log("setInitial: ", data);
        var initial = data.substr(0, 1);
        initial = initial.toUpperCase();

        return initial;
      },
      setBackgroundColor: function() {
        // change default photo's background color
        var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
        return color_bg_initial;
      }
    }
  });

  app.factory('CandidateUploadSvcs', ['GlobalConstant', '$http', function(GlobalConstant, $http){
    return {
      getCandidateApplicationDocs : function(data) {
        return $http.get(GlobalConstant.CandidateRootApi + '/' + data)
        .then(function(response) {
          // console.log("getCandidateApplicationDocs: ", response.data.data);
          return  response.data.data;
        });
      }
    }
  }]);

  app.factory('RoleAppSrvcs', ['GlobalConstant','$cookies', '$http', function (GlobalConstant, $cookies, $http) {
    return {
      getCompanyProfile : function (job_objId) {
      alert(1);
        //return $http.get( window.location.origin + "/js/minified/test-data/test_candidate_jobs_api_data.json" )
        return $http.get( window.location.origin + "/api/job/details/" + job_objId )
        .then(function(response) {
          return  response;
        });
      },
      getRequirementsCheck : function (jobId, candidateId) {
      alert(3);
        return $http.get( window.location.origin + "/api/candidate/requirements-check/"+ jobId + "/" + candidateId )
        .then(function(response) {
          return  response.data;
        });
      },
      postRequirementsCheck : function (job_objId, application_objId, data) {
      alert(4);
        //return $http.post(GlobalConstant.CandidateRootApi + '/application/' + objId + '/' + applicationId + '/requirements_check', data)
        return $http.post( window.location.origin + "/api/candidate/requirements-check/"+ job_objId +"/" + application_objId, data )
        .then(function(response) {
          return  response.data;
        });
      },
      getSteps : function (job_objId) {
      alert(5);
        //return $http.get( window.location.origin + "/js/minified/test-data/test_candidate_role_application_steps.json" )
        return $http.get( window.location.origin + "/api/candidate/job-application-steps/"+ job_objId )        
        .then(function(response) {
          return  response;
        });
      },
      getPreApply: function (jobObjId) {
      alert(6);
        //return $http.get( window.location.origin + "/js/minified/test-data/test_pre_apply_questions.json" )
        return $http.get( window.location.origin + "/api/candidate/pre-apply-questions/" + jobObjId )
        .then(function(response) {
          return response.data;
        }, function (error) {
          // console.log('pre app error: ', error.data);
        });
      },
      postPreApply: function (job_objId, data) {
        alert(7);
        return $http.post( window.location.origin + "/api/candidate/pre-apply-questions/"+ job_objId, data )
        .then(function(response) {
          return response.data;
        });
      },
      //getStandardQ : function (job_objId, applicationId) {
      getStandardQ : function (job_objId) {
        alert(8);
        // return $http.get('../themes/bbt/js/sample/ar_standard_question.json')
        //return $http.get(GlobalConstant.CandidateRootApi + '/application/' + objId + '/' + applicationId + '/application_questions')
        
        //return $http.get( window.location.origin + "/js/minified/test-data/test_candidate_application_questions.json" )
        return $http.get( window.location.origin + "/api/candidate/questions/"+ job_objId )
        .then(function(response) {
          //return response.data.data;
          return response.data;
        });
      },
      //postStandardQ : function (objId, applicationId, data) {
      postStandardQ : function (job_objId, application_objId, data) { 
        alert(9);
        //return $http.post(GlobalConstant.CandidateRootApi + '/application/' + objId + '/' + applicationId + '/application_questions', data)
        return $http.post( window.location.origin + "/api/candidate/questions/"+ job_objId +"/" + application_objId, data )
        .then(function(response) {
          //return response.data.data;
          return response.data;
        });
      },
      getCandidateProfile : function () {
      alert(10);
        //return $http.get(GlobalConstant.CandidateRootApi + '/profile')
        var pm_user_id = '2331';
        return $http.get( window.location.origin + "/api/candidate/profile/details/" + pm_user_id )
        .then(function(response) {
          //return response.data.data;
          return response.data;
        });
      },
      getEducationProvider : function (data) {
      alert(11);
        //return  $http.get(GlobalConstant.StaticOptionsAutoCompleteQualificationsApi + data )
        return $http.get( window.location.origin + "/api/qualification/auto-complete/" + data + "/10")
        .then(function(response) {
          //return response.data.data;
          return response.data;
        });
      },
      getEducationProvider_list : function (data) {
      alert(12);
        return $http.get( window.location.origin + "/api/qualification-provider/list")
        .then(function(response) {
          return response;
        });
      },
      postNewEducationHistory : function (data) {
      alert(13);
        console.log('svcshitg',data)
        //return $http.post(GlobalConstant.CandidateRootApi + '/education', data)
        return $http.post( window.location.origin + "/api/candidate/qualification/create", data)
        .then(function(response) {
          //return response.data.data;
          return response.data;
        })
      },
      putEducationHistory : function (data, id) {
      alert(14);
        //return $http.put(GlobalConstant.CandidateRootApi + '/education/' + id, data)
        return $http.put( window.location.origin + "/api/candidate/qualification/update/" + id, data)
        .then(function(response) {
          //return response.data.data;
          return response.data;
        })
      },
      delEducationHistory : function (id) {
      alert(15);
        //return $http.delete(GlobalConstant.CandidateRootApi + '/education/' + id)
        return $http.delete( window.location.origin + "/api/candidate/qualification/delete/" + id)
        .then(function(response) {
          //return response.data.data;
          return response.data;
        })
      },
      getWorkType : function (data) {
      alert(16);
        //return $http.get(GlobalConstant.StaticOptionWorkTypeApi)
        return $http.get( window.location.origin + "/api/work-types/list" )
        .then(function(response) {
          return response.data;
        });
      },
      getAllIndustries : function () {
      alert(17);
        //return $http.get( window.location.origin + "/js/minified/test-data/test_industries_with_sub_data.json" )
        return $http.get( window.location.origin + "/api/industries/list-parent-and-sub" )
        .then(function(response) {
          return response.data;
        });
      },
      postWorkHistory : function (data) {
      alert(18);  
        //return $http.post(GlobalConstant.CandidateRootApi+ '/workhistory', data)
        return $http.post( window.location.origin + "/api/candidate/work-history/create", data )
        .then(function(response) {
          //return response.data.data;
          return response.data;
        });
      },
      putUpdateWorkHistory : function (data, id) {
      alert(19);
        //return $http.put(GlobalConstant.CandidateRootApi+ '/workhistory/' + id, data)
        return $http.put( window.location.origin + "/api/candidate/work-history/update/" + id, data )
        .then(function(response) {
          //return response.data.data;
          return response.data;
        });
      },
      deleteWorkHistory : function (id) {
      alert(20);
        //return $http.delete(GlobalConstant.CandidateRootApi+ '/workhistory/' + id)
        return $http.delete( window.location.origin + "/api/candidate/work-history/delete/" + id )
        .then(function(response) {
          return response.data.data;
        });
      },
      putNewToWorkForce : function (formData) {
      alert(21);
        return $http.put(GlobalConstant.profileApi, formData)
        .then(function(response) {
          return response;
        });
      },

      postVideoAns : function (data) {
      alert(22);
        // // console.log(data);
        return $http.post(GlobalConstant.CandidateRootApi+ '/videodoc/application_question', data)
        .then(function(response) {
          return response.data.data;
        });
      },
      postCandidateInfo : function (data) {
      alert(23);
        //return $http.put(GlobalConstant.CandidateRootApi+ '/profile', data)
        var pm_user_id = 2331
        return $http.put( window.location.origin + "/api/candidate/profile/update-candidate/" + pm_user_id , data )
        .then(function(response) {
          //return response.data.data;
          return response.data;
        });
      },
      getWatch : function (jobObjectId) {
      alert(24);  
        return $http.get(GlobalConstant.CandidateJobWatchlistApi + '/' + jobObjectId )
        .then(function(response) {
          return response.data.data;
        });
      },
      postWatch : function (jobObjectId) {
      alert(25);
        return $http.post(GlobalConstant.CandidateJobWatchlistApi + '/' + jobObjectId )
        .then(function(response) {
          return response.data.data;
        });
      },
      postReference : function (data) {
      alert(26);
        return $http.post( GlobalConstant.ReferenceApi,  { data: data })
        .then(function(response) {
          return response.data.data;
        });
      },
      editReference : function (id, data) {
      alert(27);
        return $http.put(GlobalConstant.ReferenceApi + '/' + id, { data: data })
        .then(function(response) {
          return response.data.data;
        });
      },
      delReference : function (id) {
      alert(28);
        return $http.delete(GlobalConstant.ReferenceApi + '/' + id)
        .then(function(response) {
        });
      },
      getIceBreaker : function (data) {
      alert(29);
        return $http.get( GlobalConstant.CandidateRootApi + '/' + data + '/document/icebreaker_video')
        .then(function(response) {
          return response.data.data;
        });
      },
      getVideoProgress : function (data) {
      alert(30);
        return $http.get(GlobalConstant.APIRoot + 'video/' + data + '/status')
        .then(function(response) {
          return response.data.data;
        });
      },
      deleteVideo : function () {
      alert(31);
        return $http.delete(GlobalConstant.APIRoot + 'candidate/videodoc/icebreaker_video')
        .then(function(response) {
          return response.data.data;
        });
      }
    }
  }]);

}());

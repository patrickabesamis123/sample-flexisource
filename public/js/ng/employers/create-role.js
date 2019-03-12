/**
 * Created by domina on 10/27/2017.

 RCA-99: push to obj, changed from array to object. fixes issue on UI, when file is uploaded, no file name and link appears
 */

(function() {
  'use strict';
  var app = angular.module('app');
  var base_url = $('body').data('base_url');

  // app.service('scrollToTopService', function ($location, $anchorScroll) {
  //   "use strict";
  //   console.log("scrollToTopService");
  //   this.scrollToTop =  function () {
  //     $anchorScroll.yOffset = 80; //I want it top drop 80px from id. You can remove this.
  //     $location.hash("top-anchor");
  //     $anchorScroll();
  //   };
  // });


  app.controller('EmployerCreateRole', ['$scope', '$window', '$cookies', '$filter', '$timeout', '$compile', 'GlobalConstant', 'CreateRoleSvcs', 'fileUploadService', 'EmployerRoleHttpSvcs',
    function ($scope, $window, $cookies, $filter, $timeout, $compile, GlobalConstant, CreateRoleSvcs, fileUploadService, EmployerRoleHttpSvcs) {
      $scope.objURL = {};
      $scope.validateForm = false;
      $scope.disablePublish = true;
      $scope.appYes = true;
      $scope.singlesq_ref_docId = 0;
      $scope.isitPublic = false;
      $scope.gotIt = true;
      $scope.showAwesome = true;
      // form validation
      $scope.createBuildGenfrm = false;
      $scope.createBuildRespfrm = false;
      $scope.createBuildReqfrm = false;
      $scope.createBuildBenfrm = false;
      $scope.createBuildAppReqfrm = false;
      $scope.changeName = true;
      $scope.StandardQuestions = [];
      $scope.getSQ_docs = [];
      $scope.temp_scope = {};
      $scope.jobid_share = null;
      $scope.validated = true;
      $scope.showPrevBtn = false;

      $scope.currentForm = "createBuildGenfrm";
      var templateCookie = $cookies.get('loadTemplate');

      $scope.parseQueryString = function() {
        var str = window.location.search;

        // console.log("parseQueryString: ", str);
        str.replace(
          new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
          function( $0, $1, $2, $3 ){
            $scope.objURL[ $1 ] = $3;
          }
        );

      };
      $scope.parseQueryString();

      // Video upload BEGIN
      $scope.showSection1 = false;
      $scope.showSection2 = true;
      $scope.modal_percent = true;
      // Modal drag drop images
      $scope.ondragoverout_image = false;
      $scope.ondragover_image = true;
      // Init size on image cropping
      $scope.crop_data = {w: 240, h: 240, x: 80, y: 0};
      $scope.showVideo = true;
      $scope.record_btn = false;
      $scope.record_again_btn = true;
      $scope.stop_btn = true;
      $scope.save_btn = false;
      $scope.change_btn = false;
      // Modal drag drop images
      $scope.uploadmsg = false;
      $scope.showUploadingVideo = false
      //
      $scope.fieldIndex = 0;

      // upload document BEGIN, used by SQ
      $scope.file_save = function(e) {
        var job_id = $scope.objURL.id;
        if (!job_id) {
          job_id = $cookies.get('jobObjectId');
        }

        fileUploadService.save($scope);
        // RCA-99 BEGIN

        // console.log("return DATAAAA: ", $scope.return_data);
        $scope.StandardQuestions.question_document =
        {
          doc_file_type: "",
          doc_url: $scope.return_data.url,
          doc_filename: $scope.return_data.file_name
        };
        // RCA-99 END
        // console.log("file uploading from RC ", $scope.StandardQuestions);

        $scope.temp_scope = {data: $scope.StandardQuestions};

        // console.log('saving scope holy: ', $scope.temp_scope);
        CreateRoleSvcs.putAplicationQ(job_id, $scope.temp_scope, $scope.StandardQuestions.id).then(function (res){
        // CreateRoleSvcs.postAplicationQ(job_id, $scope.temp_scope, $scope.StandardQuestions.id).then(function (res){
          $scope.getSQ_docs = res;
          // console.log("PUT file_saved: ", $scope.getSQ_docs);
        });
      };

      $scope.file_change = function() {
        fileUploadService.fileChange($scope);
      };
      // upload document END

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

      $scope.sectionsHideShow = function(a, b) {
        $scope.showSection1 = a;
        $scope.showSection2 = b;
      };

      $scope.buttonsHideShow = function(a ,b, c, d, e) {
        $scope.record_btn = a;
        $scope.record_again_btn = b;
        $scope.stop_btn = c;
        $scope.save_btn = d;
        $scope.change_btn = e;
      };

      // video upload
      $scope.new_video_upload_modal = function(file_elm, evt) {
        var job_id = $scope.objURL.id;
        if (!job_id) {
          job_id = $cookies.get('jobObjectId');
        }

        var origin, data;
        if ($scope.whereAmI == 'Create Role Video') {
          origin = 'employer_jobs';
          data = job_id;
        } else if ($scope.whereAmI == 'Standard Questions') {
          origin = 'ref_document_standard_question';
          data = {
            question_id: $scope.singlesq_ref_docId,
            job_id: job_id
          }
        }

        if (origin) {
          fileUploadService.video_upload($scope, file_elm, evt, origin, data);
          // console.log("GUID: ", $scope.guid_response);
        } else {
          // console.log("no origin specified.");
        }
      };

      $scope.$watch('guid_response', function(newVal, oldVal){
        // console.log("guid new: ", newVal);
        // console.log("guid old: ", oldVal);
      });

      $('#video_upload_modal_new').change(function() {
        // console.log("FROM create-role.js modal video: ")
        $scope.new_video_upload_modal('video_upload_modal_new');
      });

      $("#file_upload").change(function() {
        // $scope.file_upload_modal(false,'Form_resume_upload_modal');
        var elemId = $(this).attr('id');
        var event = false;
        var docFileType = 'resume';
        var fileSizeLimit = 2;
        fileUploadService.uploadFile($scope, elemId, event, docFileType, fileSizeLimit, true);
      });

      // reset UI when closing
      $('#pmvCameraModalNew').on('hidden.bs.modal', function () {
        $('.successUpload').hide();
        $scope.uploadmsg = true;
      });


      // video record button controls BEGIN
      $scope.saveVideo = function() {
        var job_id = $scope.objURL.id;
        if (!job_id) {
          job_id = $cookies.get('jobObjectId');
        }

        var origin, data;
        if ($scope.whereAmI == 'Create Role Video') {
          origin = 'employer_jobs';
          data = job_id;
        } else if ($scope.whereAmI == 'Standard Questions') {
          origin = 'ref_document_standard_question';
          data = {
            question_id: $scope.singlesq_ref_docId,
            job_id: job_id
          }
        }

        if (origin) {
          fileUploadService.saveVideo($scope, origin, data);
        } else {
          // console.log("no origin specified.");
        }
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
      // video record button controls BEGIN

      // start recording video inside modal
      $scope.startVideo = function() {
        $scope.sectionsHideShow(1, 0); // show modal record video
        checkBrowsers();
        if($scope.isSafari || $scope.browserName == "Safari") {
          alert('Oh oh this feature is not yet supported by your browser. Drag and drop a video file instead, or use Chrome, Firefox or Microsoft Edge to record a video using your webcam.');
        } else {
          fileUploadService.startVideo($scope);
          // $scope.Init_jobdetails_get();
          // console.log("upload success!");
        }
      };
      // Video upload END

      // turn off webcam when modal closes  
      $('#pmvCameraModal, #pmvCameraModalNew, #pmvImageModalNew').on('hidden.bs.modal', function() {

        if (window.stream) {
            stream.stop();
            window.stream = "";
        }

        $scope.buttonsHideShow(false,false,false,false,false);
        $scope.sectionsHideShow(false,true);
        // hide percentage
        $scope.modal_percent = true;
        // reset preview video
        $('#preview_new').attr('src', '');
        $('#preview_img_new').attr('src', '');
      });

      CreateRoleSvcs.getGeneralInfo($scope.objURL.id).then(function(res) {
        $scope.empRoleMain = res;

        var r_start_date = new Date();
        var r_date = r_start_date.getDate();
        var r_month = r_start_date.getMonth();
        var r_year = r_start_date.getFullYear();

        r_start_date = r_date + '/' + r_month + '/' + r_year;
        $scope.empRoleMain.start_date = r_start_date;

        $scope.empRoleMainTeam = [];
        //$scope.roleName = $scope.empRoleMain.job_title;
        //$scope.roleName = $scope.empRoleMain.job_title ? $scope.roleName : 'No Role name specified';
        //console.log("from first load",$scope.empRoleMain);

        $scope.changeRoleTitle = function() {
          $scope.changeName = !$scope.changeName;
          $scope.reScopeMain($scope.objURL.id);
          CreateRoleSvcs.putGeneralInfo($scope.objURL.id, {data: $scope.empRoleMain}).then(function(res) {
            $scope.empRoleMain.job_title = res.job_title;
          });
          //console.log(34,$scope.empRoleMain);
        }
      });

      $scope.mobileNav = false;

      $scope.leftNav = function() {
        $scope.createBuild = false;
        $scope.createRoleVid = false;
        $scope.createPreApp = false;
        $scope.createStandard = false;
        $scope.createTeamMngt = false;
        $scope.createProcess = false;
        $scope.createEmailNot = false;
        $scope.createIntegration = false;
      }
      $scope.leftNavCall = function(li, subli, event) {
        // console.log("leftnavcall func", $scope.empRoleMain)
        //console.log("leftNavCall: ", li, subli);
        event.stopPropagation();

        $scope.leftNav();
        if (li == "build") {
          $scope.createBuild = true;

          if (subli == 'Gen Info') {
            $scope.createBuildGen = true;
            $scope.createBuildResp = false;
            $scope.createBuildReq = false;
            $scope.createBuildBen = false;
            $scope.createBuildAppReq = false;
            $scope.whereAmISub = "Gen Info";
            $scope.currentForm = "createBuildGenfrm";
          } else if (subli == 'Resp') {
            $scope.createBuildGen = false;
            $scope.createBuildResp = true;
            $scope.createBuildReq = false;
            $scope.createBuildBen = false;
            $scope.createBuildAppReq = false;
            $scope.whereAmISub = "Resp";
            $scope.currentForm = "createBuildRespfrm";//alert(54)
          } else if (subli == 'Req') {
            $scope.createBuildGen = false;
            $scope.createBuildResp = false;
            $scope.createBuildReq = true;
            $scope.createBuildBen = false;
            $scope.createBuildAppReq = false;
            $scope.whereAmISub = "Req";
            $scope.currentForm = "createBuildReqfrm";//alert(43)
          } else if (subli == 'Benefits') {
            $scope.createBuildGen = false;
            $scope.createBuildResp = false;
            $scope.createBuildReq = false;
            $scope.createBuildBen = true;
            $scope.createBuildAppReq = false;
            $scope.whereAmISub = "Benefits";
            $scope.currentForm = "createBuildBenfrm";
          } else if (subli == 'Application') {
            $scope.createBuildGen = false;
            $scope.createBuildResp = false;
            $scope.createBuildReq = false;
            $scope.createBuildBen = false;
            $scope.createBuildAppReq = true;
            $scope.whereAmISub = "Application";
            $scope.currentForm = "createBuildAppReqfrm";
          }
          $scope.createEmailNotCan = false;
          $scope.createEmailNotAdmin = false;

          $scope.whereAmI = "Build the role";
        } else if (li == "vid") {
          $scope.createRoleVid = true;
          $scope.whereAmI = "Create Role Video";
          $scope.fullPageRequired = true;
        } else if (li == "preapp") {
          $scope.createPreApp = true;
          $scope.whereAmI = "Pre-approval Questions";
          $scope.fullPageRequired = false;
        } else if (li == "stan") {
          $scope.createStandard = true;
          $scope.whereAmI = "Standard Questions";
          $scope.fullPageRequired = false;
        } else if (li == "team") {
          $scope.createTeamMngt = true;
          $scope.whereAmI = "Team Management";
          $scope.fullPageRequired = false;
        } else if (li == "process") {
          $scope.createProcess = true;
          $scope.whereAmI = "Process Customisation";
          $scope.fullPageRequired = false;
        } else if (li == "email") {
          $scope.createEmailNot = true;
          $scope.fullPageRequired = false;

          if (subli == 'Admin') {
            $scope.createEmailNotAdmin = true;
            $scope.createEmailNotCan = false;
            $scope.whereAmISub = "Admin";
          } else if (subli == 'Candidate') {
            $scope.createEmailNotCan = true;
            $scope.createEmailNotAdmin = false;
            $scope.whereAmISub = "Candidate";
          }
          
          $scope.whereAmI = "Emails and Notifications";
        } else if (li == "int") {
          $scope.createIntegration = true;
          $scope.whereAmI = "Integration";
          $scope.fullPageRequired = false;
        }
        $scope.mobileNav = false;
      }

      $scope.reScopeMain = function(job_id) {
        // console.log("just in",$scope.empRoleMain)

        CreateRoleSvcs.getGeneralInfo($scope.objURL.id).then(function (resp) {
          $scope.empRoleMain = resp;
          //console.log(99, $scope.empRoleMain);
        });
          //console.log(99, $scope.empRoleMain);

        if("location" in $scope.empRoleMain) {
          if(typeof($scope.empRoleMain.location) != 'number') {
            if ("data" in $scope.empRoleMain.location) {
              //console.log(456345674564)
              if ("id" in $scope.empRoleMain.location.data) {
                $scope.empRoleMain.location = $scope.empRoleMain.location.data.id
              } else {
                $scope.empRoleMain.location.country_id = $scope.empRoleMain.location.data.country.id;
                if ("display_name" in $scope.empRoleMain.location.data) {
                  $scope.empRoleMain.location.location = $scope.empRoleMain.location.data.display_name;
                } else {
                  $scope.empRoleMain.location.location = ""
                }
              }
            }
          }
        } else {
          $scope.empRoleMain.location.country_id = 0;
          $scope.empRoleMain.location.location = ""
        }
        if("application_requirements" in $scope.empRoleMain) {

          if($scope.empRoleMain.application_requirements.about_me == 'yes' || $scope.empRoleMain.application_requirements.work_experience == 'yes'
            || $scope.empRoleMain.application_requirements.education == 'yes' // || $scope.empRoleMain.application_requirements.language == 'yes' park for now
            || $scope.empRoleMain.application_requirements.references == 'yes' || $scope.empRoleMain.application_requirements.icebreaker_video == 'yes'
            || $scope.empRoleMain.application_requirements.resume == 'yes' || $scope.empRoleMain.application_requirements.cover_letter == 'yes'
            || $scope.empRoleMain.application_requirements.supp == 'yes' || $scope.empRoleMain.application_requirements.transcript == 'yes') {
            $scope.appYes = true;
          }

          var appReq = $scope.empRoleMain.application_requirements;
          var validate_appreq = [];

          angular.forEach($scope.empRoleMain.application_requirements, function(val, key){
            if (key != 'phone_number') {
              validate_appreq.push(val);
            }
          });

          if ($scope.empRoleMain.application_requirements.length == 0) {
            $scope.validated = false;
          } else {
            $scope.validated = validate_appreq.some(function(val){
              return val == 'yes';
            });
          }

          if($scope.whereAmI == "Build the role" && $scope.whereAmISub == 'Application') {
            if ($scope.validated) {
              CreateRoleSvcs.putRequirements(job_id, appReq).then(function (res){});
            }

          }
          //aybe
        }

        if("industry" in $scope.empRoleMain) {
          if(typeof($scope.empRoleMain.industry) != 'number') {
            if ("data" in $scope.empRoleMain.industry) {
              if ("sub" in $scope.empRoleMain.industry.data) {
                $scope.empRoleMain.industry = $scope.empRoleMain.industry.data.sub.id;
              } else if ("industry" in $scope.empRoleMain.industry.data) {
                $scope.empRoleMain.industry = $scope.empRoleMain.industry.data.industry.id;
              } else {
                $scope.empRoleMain.industry = 0;
              }
            }
          }
        }

        if("role_type" in $scope.empRoleMain) {
          if($scope.empRoleMain.role_type == null || $scope.empRoleMain.role_type == "") {
            $scope.empRoleMain.role_type = $scope.empRoleMain.role_type.id;
          }
        } else {
          $scope.empRoleMain.role_type = 0;
        }

        if("accountabilities" in $scope.empRoleMain) {
          angular.forEach($scope.empRoleMain.accountabilities, function(val, key) {
            $scope.empRoleMain.accountabilities[key].type = $scope.empRoleMain.accountabilities[key].type_display_name;
          });
        }

        if("lead_manage_team" in $scope.empRoleMain) {
          if($scope.empRoleMain.lead_manage_team == 1 || $scope.empRoleMain.lead_manage_team == '1' ) {
            $scope.empRoleMain.lead_manage_team == true;
          } else if($scope.empRoleMain.lead_manage_team == 0 || $scope.empRoleMain.lead_manage_team == '0' ) {
            $scope.empRoleMain.lead_manage_team == false;
          }
        }

        if("requirements" in $scope.empRoleMain) {
          angular.forEach($scope.empRoleMain.requirements, function(val, key) {
            $scope.empRoleMain.requirements[key].type = $scope.empRoleMain.requirements[key].type_display_name;
          });
        }

        if("objectives" in $scope.empRoleMain) {
          angular.forEach($scope.empRoleMain.objectives, function(val, key) {
            $scope.empRoleMain.objectives[key].type = $scope.empRoleMain.objectives[key].type_display_name;
          });
        }

        if("search_helpers" in $scope.empRoleMain) {
          if(typeof($scope.empRoleMain.search_helpers) == 'array') {
            angular.forEach($scope.empRoleMain.search_helpers, function (val, key) {
              $scope.empRoleMain.search_helpers[key].type = $scope.empRoleMain.search_helpers[key].type_display_name;
            });
          }
        }

        if("benefits" in $scope.empRoleMain) {
          angular.forEach($scope.empRoleMain.benefits, function(val, key) {
            $scope.empRoleMain.benefits[key].type = $scope.empRoleMain.benefits[key].type_display_name;
          });
        }


        if("questions" in $scope.empRoleMain) {
          // console.log($scope.whereAmI, 5765)
          if ($scope.whereAmI == "Standard Questions"){
            if($scope.empRoleMain.questions.application.length > 0) {
              angular.forEach($scope.empRoleMain.questions.application, function (val, key) {
                var questData = [];
                //console.log("val", $scope.empRoleMain.questions.application[key])
                if ($scope.empRoleMain.questions.application[key].answer_type.indexOf("file_upload") <= -1) {
                  if("question_type" in $scope.empRoleMain.questions.application[key]) {
                    questData = {
                      answer_choices: val.answer_choices,
                      answer_type: val.answer_type,
                      question: val.question,
                      question_type: val.question_type,
                      id: val.id
                    };
                  } else {
                    questData = {
                      answer_choices: val.answer_choices,
                      answer_type: val.answer_type,
                      question: val.question,
                      question_type: val.question_type,
                      id: val.id
                    };
                  }
                } else if ($scope.empRoleMain.questions.application[key].answer_type.indexOf("file_upload") > -1) {
                  questData = {
                    answer_choices: val.answer_choices,
                    answer_type: val.answer_type,
                    question: val.question,
                    question_document: val.question_document,
                    id: val.id,
                    question_type: ""
                  };
                } else if ($scope.empRoleMain.questions.application[key].answer_type.indexOf("video") > -1) {
                  questData = {
                    answer_choices: val.answer_choices,
                    answer_type: val.answer_type,
                    question: val.question,
                    video_document: val.video_document,
                    id: val.id,
                    question_type: ""
                  };
                }

                if ($scope.empRoleMain.questions.application[key].hasOwnProperty("id")) {
                  // console.log("iPUT ko lang: ", job_id, questData, questData.id);
                  CreateRoleSvcs.putAplicationQ(job_id, {data: questData}, questData.id).then(function (res){});
                } else {
                  delete questData['id'];

                  // console.log("isesave na: ", questData);
                  CreateRoleSvcs.postAplicationQ(job_id, {data: questData}).then(function (res) {
                    // console.log("SAVED na ung SQ: ", res);
                  });
                }
              });
            }
          }

          // console.log("eta!",$scope.empRoleMain.questions.pre_apply)
          //if($scope.empRoleMain.questions.pre_apply.length > 0) {

          if($scope.whereAmI == "Pre-approval Questions") {
            angular.forEach($scope.empRoleMain.questions.pre_apply, function(val, key) {
              var subQues = [];
              var qtype, subqtype;

              if("type" in $scope.empRoleMain.questions.pre_apply[key]) {
                qtype = $scope.empRoleMain.questions.pre_apply[key].type;
              } else if("answer_type" in $scope.empRoleMain.questions.pre_apply[key]) {
                qtype = $scope.empRoleMain.questions.pre_apply[key].answer_type;
              }

              angular.forEach($scope.empRoleMain.questions.pre_apply[key].sub_questions, function(val2, key2) {
                if("type" in $scope.empRoleMain.questions.pre_apply[key].sub_questions[key2]) {
                  subqtype = $scope.empRoleMain.questions.pre_apply[key].sub_questions[key2].type;
                } else if("answer_type" in $scope.empRoleMain.questions.pre_apply[key].sub_questions[key2]) {
                  subqtype = $scope.empRoleMain.questions.pre_apply[key].sub_questions[key2].answer_type;
                }

                var subQuesO = {
                  question : $scope.empRoleMain.questions.pre_apply[key].sub_questions[key2].question,
                  choices : $scope.empRoleMain.questions.pre_apply[key].sub_questions[key2].choices,
                  ideal_answer : $scope.empRoleMain.questions.pre_apply[key].sub_questions[key2].ideal_answer,
                  decides_outcome : $scope.empRoleMain.questions.pre_apply[key].sub_questions[key2].decides_outcome,
                  type : subqtype,
                }

                subQues.push(subQuesO)
              });
              // console.log("gpasubbefore",$scope.empRoleMain.questions.pre_apply[key])
              var noSub = {
                question : $scope.empRoleMain.questions.pre_apply[key].question,
                choices : $scope.empRoleMain.questions.pre_apply[key].choices,
                ideal_answer : $scope.empRoleMain.questions.pre_apply[key].ideal_answer,
                decides_outcome : $scope.empRoleMain.questions.pre_apply[key].decides_outcome,
                type : qtype
              }
              var withSub = {
                question : $scope.empRoleMain.questions.pre_apply[key].question,
                choices : $scope.empRoleMain.questions.pre_apply[key].choices,
                ideal_answer : $scope.empRoleMain.questions.pre_apply[key].ideal_answer,
                decides_outcome : $scope.empRoleMain.questions.pre_apply[key].decides_outcome,
                type : qtype,
                sub_questions: subQues
              }

              if("sub_questions" in $scope.empRoleMain.questions.pre_apply[key]) {

                if("GPAsub" in $scope.empRoleMain.questions.pre_apply[key]) {
                  if(!($scope.empRoleMain.questions.pre_apply[key].GPAsub)) {
                    $scope.empRoleMain.questions.pre_apply[key] = noSub;
                  } else {
                    $scope.empRoleMain.questions.pre_apply[key] = withSub;
                  }
                } else {
                  $scope.empRoleMain.questions.pre_apply[key] = noSub;
                }
              } else {
                $scope.empRoleMain.questions.pre_apply[key] = noSub;
              }

              // console.log("gpasub",$scope.empRoleMain.questions.pre_apply[key])
            });
             //console.log("main preapp",$scope.empRoleMain.questions.pre_apply)

            //CreateRoleSvcs.getGeneralInfo(job_id).then(function (resp) {
              if ($scope.empRoleMain.questions.pre_apply.length > 0) {
                var wData = false;
                //var wData = true;
              } else {
                var wData = true;
              }
              var ub = JSON.stringify($scope.empRoleMain.questions.pre_apply);
              ub = JSON.parse(ub);
              ub = {
                data: {
                  questions : ub
                }
              }

              CreateRoleSvcs.savePreApply(job_id, ub, wData).then(function (res) {});
            //});
          }
          //}
        }

        if("job_manager" in $scope.empRoleMain) {
          if($scope.empRoleMain.job_manager != null) {
            if(typeof($scope.empRoleMain.job_manager) == "object") {
              $scope.empRoleMain.job_manager = $scope.empRoleMain.job_manager.id;
            }
          }
        }

         //console.log("mainteam",$scope.empRoleMainTeam);
        if("template" in $scope.empRoleMainTeam) {
          if("job_manager" in $scope.empRoleMainTeam) {
            if($scope.empRoleMainTeam.job_manager != null) {
              if(typeof($scope.empRoleMainTeam.job_manager) == "object") {
                $scope.empRoleMainTeam.job_manager = $scope.empRoleMainTeam.job_manager.id;
              }
            }
          }
          if($scope.empRoleMainTeam.visibility_members) {
            $scope.empRoleMain.visibility_members = $scope.empRoleMainTeam.visibility_members;
          }
          if($scope.empRoleMainTeam.visibility_teams) {
            $scope.empRoleMain.visibility_teams = $scope.empRoleMainTeam.visibility_teams;
          }
          // console.log("mainteam after",$scope.empRoleMainTeam)

          $scope.empRoleMain.job_manager = $scope.empRoleMainTeam.job_manager;

          // console.log("main",$scope.empRoleMain);

          $scope.empRoleMain.workflow_steps = [];
          angular.forEach($scope.empRoleMainTeam.workflow_steps, function(val, key) {
            if(val.name != "Create new") {
              var data = {
                id: val.id,
                name: val.name
              }

              $scope.empRoleMain.workflow_steps.push(data);
            }
          });

          //$scope.empRoleMain.workflow_steps = $scope.empRoleMainTeam.workflow_steps
          // console.log("save na", $scope.empRoleMain)
          //CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMainTeam}).then(function(res) {});
        }
        //console.log("rescope", $scope.empRoleMain)
        if("visibility" in $scope.empRoleMain) {
          $scope.empRoleMain.visibility_members = $scope.empRoleMain.visibility.members;
          $scope.empRoleMain.visibility_teams = $scope.empRoleMain.visibility.teams;
        }

        // console.log("name",$scope.empRoleMain)
      }

      $scope.leftNavCallf = function(whereAmINow, whereAmISub) {

        CreateRoleSvcs.getGeneralInfo($scope.objURL.id).then(function (resp) {
          if($scope.empRoleMainTeam) {
            $scope.empRoleMainTeam.visibility_members = resp.visibility.members;
            $scope.empRoleMainTeam.visibility_teams = resp.visibility.teams;
          }

        });
          if($scope.whereAmISub == "Gen Info" && whereAmISub != "Resp") {
            if($scope.empRoleMain.accountabilities.length <= 0) {
              alert("Please go to Responsibilities tab first.");
              $scope.leftNavCall('build', $scope.whereAmISub, event);
            } else {
              $scope.leftNavCall(whereAmINow, whereAmISub, event);
            }
          } else if($scope.whereAmISub == "Resp" && (whereAmISub != "Req" && whereAmISub != "Gen Info")) {
            if($scope.empRoleMain.requirements.length <= 0) {
              alert("Please go to Skills Requirements tab first.");
              $scope.leftNavCall('build', $scope.whereAmISub, event);
            } else {
              $scope.leftNavCall(whereAmINow, whereAmISub, event);
            }
          } else if($scope.whereAmISub == "Req" && (whereAmISub != "Benefits" && whereAmISub != "Gen Info" && whereAmISub != "Resp")) {
            if($scope.empRoleMain.benefits.length <= 0) {
              alert("Please go to Considerations and Benefits tab first.");
              $scope.leftNavCall('build', $scope.whereAmISub, event);
            } else {
              $scope.leftNavCall(whereAmINow, whereAmISub, event);
            }
          } else if($scope.whereAmISub == "Benefits" && (whereAmISub != "Application" && whereAmISub != "Req" && whereAmISub != "Gen Info" && whereAmISub != "Resp")) {
            if($scope.empRoleMain.application_requirements.length <= 0) {
              alert("Please go to Application Requirements tab first.");
              $scope.leftNavCall('build', $scope.whereAmISub, event);
            } else {
              $scope.leftNavCall(whereAmINow, whereAmISub, event);
            }
          } else if ($scope.whereAmISub == "Application" && whereAmISub != "Application") {
            var validate_appreq = [];


            angular.forEach($scope.empRoleMain.application_requirements, function(val, key){
              if (key != 'phone_number') {
                validate_appreq.push(val);
              }
            });

            if ($scope.empRoleMain.application_requirements.length == 0) {
              $scope.validated = false;
              // console.log("truth");
            } else {
              $scope.validated = validate_appreq.some(function(val){
                return val == 'yes';
              });
              // console.log("falth");
            }

            //console.log("leftNavCallf validate? ", $scope.validated, $scope.empRoleMain.application_requirements);

            if($scope.validated) {
              $scope.leftNavCall(whereAmINow, whereAmISub, event);
               // $scope.leftNavCall('build', $scope.whereAmISub, event);
            }
          }
          else {
            //if($scope.empRoleMain.application_requirements) {
            // $scope.disablePublish = false;
            //}
            $scope.leftNavCall(whereAmINow, whereAmISub, event);
          }
        //$scope.leftNavCall(whereAmINow, whereAmISub, event);
      }

      $scope.leftNavCallf('build', 'Gen Info' , event);

      $scope.saveDraft = function() {
        var data = {data : $scope.empRoleMain};
        // console.log("saving and draft: ", data);
        var job_id = $scope.objURL.id;
        if (!job_id) {
          job_id = $cookies.get('jobObjectId');
        }
        $scope.reScopeMain(job_id);

        $timeout(function (){
          if(job_id) {
            alert("Your role has been saved as draft");
            window.location = GlobalConstant.EmployerDashboard;
            CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {
            });
          }
        }, 1000);
      }

      $scope.checkPrev = function () {
        var data = {data : $scope.empRoleMain};
        var job_id = $scope.objURL.id;

        if (!job_id) {
          job_id = $cookies.get('jobObjectId');
        }

        // console.log("$scope.objURL.id: ", job_id);

        if (job_id) {
          CreateRoleSvcs.getGeneralInfo($scope.objURL.id).then(function (result) {
            console.log("team",result.visibility)
            console.log("from team", $scope.empRoleMainTeam)

            $scope.reScopeMain(job_id);
            $scope.rescopejob = function() {
              if($scope.empRoleMain.job_manager != null) {
                if(typeof($scope.empRoleMain.job_manager) == "object") {
                  $scope.empRoleMain.job_manager = $scope.empRoleMain.job_manager.id;
                }
              }
            }

            var saveMyRole;
            saveMyRole = $scope.empRoleMain;
            console.log(saveMyRole)
            if($scope.empRoleMainTeam.visibility_members != result.visibility.members) {
              saveMyRole.visibility_members = $scope.empRoleMainTeam.visibility_members;
            } else {
              saveMyRole.visibility_members = result.visibility.members;
            }
            if($scope.empRoleMainTeam.visibility_teams != result.visibility.teams) {
              saveMyRole.visibility_teams = $scope.empRoleMainTeam.visibility_teams;
            } else {
              saveMyRole.visibility_teams = result.visibility.teams;
            }

            console.log(2,saveMyRole)
          
            if ($scope.whereAmI == "Build the role") {
              $scope.rescopejob();
              $scope.whereAmI = "Build the role";
              if ($scope.whereAmISub == "Gen Info") {
                if ($scope.createBuildGenfrm.$valid) {
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {});
                  // $scope.disablePublish = false;

                  $scope.leftNavCall('build', '', event);
                  $scope.whereAmI = "Build the role";
                }
                $scope.leftNavCall('build', '', event);
              } else if ($scope.whereAmISub == "Resp") {
                if ($scope.createBuildRespfrm.$valid) {
                  // console.log("resp",$scope.empRoleMain);
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {});
                  // $scope.disablePublish = false;

                  $scope.leftNavCall('build', 'Gen Info', event);
                  $scope.whereAmI = "Build the role";
                }
              } else if ($scope.whereAmISub == "Req") {
                if ($scope.createBuildReqfrm.$valid) {
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {});

                  $scope.leftNavCall('build', 'Resp', event);
                  $scope.whereAmI = "Build the role";
                }
              } else if ($scope.whereAmISub == "Benefits") {
                if ($scope.createBuildBenfrm.$valid) {
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {});

                  $scope.leftNavCall('build', 'Req', event);
                  $scope.whereAmI = "Build the role";
                }
              } else if ($scope.whereAmISub == "Application") {
                if ($scope.createBuildAppReqfrm.$valid) {
                  $scope.postdata = {};
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {});
                  // $scope.disablePublish = false;
                  $scope.appYes = true;

                  $scope.leftNavCall('build', 'Benefits', event);
                  $scope.whereAmI = "Build the role";
                }
              }
            } else if ($scope.whereAmI == "Create Role Video") {
              $scope.whereAmI = "Build the role";
              $scope.leftNavCall('build', 'Application', event);
            } else if ($scope.whereAmI == "Pre-approval Questions") {
              $scope.rescopejob();

              CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {});
              $scope.whereAmI = "Create Role Video";
              $scope.leftNavCall('vid', '', event);
            } else if ($scope.whereAmI == "Standard Questions") {
              $scope.rescopejob();
              $scope.whereAmI = "Pre-approval Questions";
              $scope.leftNavCall('preapp', '', event);
            } else if ($scope.whereAmI == "Team Management") {
              $scope.rescopejob();
              CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {});
              $scope.whereAmI = "Standard Questions";
              $scope.leftNavCall('stan', '', event);
            } else if ($scope.whereAmI == "Process Customisation") {
              $scope.rescopejob();
              CreateRoleSvcs.putGeneralInfo(job_id, {data: $scope.empRoleMain}).then(function(res) {});

              $scope.whereAmI = "Team Management";
              $scope.leftNavCall('team', '', event);
            } else if ($scope.whereAmI == "Emails and Notifications") {
              $scope.whereAmI = "Process Customisation";
              if ($scope.whereAmISub == "Admin") {
                $scope.leftNavCall('process', '', event);
              } else if ($scope.whereAmISub == "Candidate") {
                $scope.leftNavCall('email', 'Admin', event);
              }
            } else if ($scope.whereAmI == "Integration") {
              $scope.whereAmI = "Emails and Notifications";
              $scope.leftNavCall('email', 'Admin', event);
            }
          });
        }
      }

      $scope.$watch('whereAmISub', function (newVal, oldVal) {
        console.log(newVal, oldVal);
        if (newVal == 'Gen Info') {
          $scope.showPrevBtn = false;
        } else {
          $scope.showPrevBtn = true;
        }
      });

      $scope.checkNext = function () {
        // console.log("namebefore",$scope.empRoleMain)

        var data = {data : $scope.empRoleMain};
        var job_id = $scope.objURL.id;

        if (!job_id) {
          job_id = $cookies.get('jobObjectId');
        }

        console.log("$scope.objURL.id: ", job_id);

        if (job_id) {
          console.log("create role: role_type",$scope.empRoleMain.role_type);
          console.log("create role: accountabilities",$scope.empRoleMain.accountabilities);
          CreateRoleSvcs.getGeneralInfo($scope.objURL.id).then(function (result) {
            //console.log("team",result)
            //console.log("from team", $scope.empRoleMainTeam)
            $scope.reScopeMain(job_id);
            $scope.rescopejob = function() {
              if($scope.empRoleMain.job_manager != null) {
                if(typeof($scope.empRoleMain.job_manager) == "object") {
                  $scope.empRoleMain.job_manager = $scope.empRoleMain.job_manager.id;
                }
              } else {
              }
                // console.log(8989,$scope.empRoleMain)
            }
            var saveMyRole;
            saveMyRole = $scope.empRoleMain;
            //console.log("var",saveMyRole)
            if($scope.empRoleMainTeam.visibility_members != result.visibility.members) {
              saveMyRole.visibility_members = $scope.empRoleMainTeam.visibility_members;
            } else {
              saveMyRole.visibility_members = result.visibility.members;
            }
            if($scope.empRoleMainTeam.visibility_teams != result.visibility.teams) {
              saveMyRole.visibility_teams = $scope.empRoleMainTeam.visibility_teams;
            } else {
              saveMyRole.visibility_teams = result.visibility.teams;
            }

            //console.log(2,saveMyRole)

            if($scope.whereAmI == "Build the role") {
              //console.log("wheresub",$scope.whereAmISub)
              $scope.rescopejob();
              if($scope.whereAmISub == "Gen Info") {
                if ($scope.createBuildGenfrm.$valid) {
                  //console.log("build", $scope.empRoleMain)
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {
                    //$scope.empRoleMain = res;
                    console.log("create role: role_type saved",$scope.empRoleMain.role_type);
                  });
                  $scope.disablePublish = false;
                  $scope.appYes = true;

                  $scope.leftNavCall('build', 'Resp', event);
                  $scope.whereAmI = "Build the role";
                }
              } else if($scope.whereAmISub == "Resp") {
                if ($scope.createBuildRespfrm.$valid) { 
                  //console.log("darn you resp", $scope.empRoleMain);
            
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {
                    //$scope.empRoleMain = res;
                    console.log("create role: accountabilities saved",$scope.empRoleMain.accountabilities);
                  });
                  $scope.disablePublish = false;
                  $scope.appYes = true;

                  $scope.leftNavCall('build', 'Req', event);
                  $scope.whereAmI = "Build the role";
                }
              } else if($scope.whereAmISub == "Req") {
                if ($scope.createBuildReqfrm.$valid) {
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {});

                  $scope.leftNavCall('build', 'Benefits', event);
                  $scope.whereAmI = "Build the role";
                }
              } else if($scope.whereAmISub == "Benefits") {
                if ($scope.createBuildBenfrm.$valid) {
                  CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {});

                  $scope.leftNavCall('build', 'Application', event);
                  $scope.whereAmI = "Build the role";
                }
              } else if($scope.whereAmISub == "Application") {
                if ($scope.createBuildAppReqfrm.$valid) {
                  $scope.postdata = {};
                  var validate_appreq = [];
                  $scope.validated = '';

                  angular.forEach($scope.empRoleMain.application_requirements, function(val, key){
                    if (key != 'phone_number') {
                      validate_appreq.push(val);
                    }
                  });

                  if ($scope.empRoleMain.application_requirements.length == 0) {
                    $scope.validated = false;
                  } else {
                    $scope.validated = validate_appreq.some(function(val){
                      return val == 'yes';
                    });
                  }

                  //console.log('chkNext validated? ', $scope.validated);
                  if ($scope.validated) {
                    CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {});
                    $scope.disablePublish = false;
                    $scope.appYes = true;
                    $scope.leftNavCall('vid', '', event);
                    $scope.whereAmI = "Create Role Video";
                  }
                }
              }
            } else if($scope.whereAmI == "Create Role Video") {
              $scope.whereAmI = "Pre-approval Questions";
              $scope.leftNavCall('preapp', '', event);
            } else if($scope.whereAmI == "Pre-approval Questions") {
              $scope.rescopejob();
              CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {});

              $scope.whereAmI = "Standard Questions";
              $scope.leftNavCall('stan', '', event);
              // console.log("preapptab", $scope.empRoleMain)
            } else if($scope.whereAmI == "Standard Questions") {
              $scope.rescopejob();
              // console.log(5554,$scope.empRoleMain)
              CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {});

              $scope.whereAmI = "Team Management";
              $scope.leftNavCall('team', '', event);
            } else if($scope.whereAmI == "Team Management") {
              $scope.rescopejob();
                CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {});

                $scope.whereAmI = "Process Customisation";
                $scope.leftNavCall('process', '', event);
              //});
            } else if($scope.whereAmI == "Process Customisation") {
              $scope.rescopejob();
              CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {});

              $scope.whereAmI = "Emails and Notifications";
              $scope.leftNavCall('email', 'Admin', event);
            } else if($scope.whereAmI == "Emails and Notifications") {
              $scope.whereAmI = "Integration";
              $scope.leftNavCall('int', '', event);
              if($scope.whereAmISub == "Admin") {
                $scope.leftNavCall('email', 'Candidate', event);
              } else if($scope.whereAmISub == "Candidate") {
                $scope.leftNavCall('int', '', event);
              }

              CreateRoleSvcs.putGeneralInfo(job_id, {data: saveMyRole}).then(function(res) {});
            } else if($scope.whereAmI == "Integration") {
              $scope.whereAmI = "Integration";
              $scope.leftNavCall('int', '', event);
            }
          });

        } else { // should run only once
          EmployerRoleHttpSvcs.postRoleName(data).then(function(res) {
            // console.log("no job id (if you see this more than once, this is wrong!): ", res);
            $scope.objURL.id = res.id;
            $cookies.put('jobObjectId', res.id, {
              'path': '/'
            });
          });
        }


        CreateRoleSvcs.scrollToTop();

      };

      $scope.publishRole = function () {

        CreateRoleSvcs.getGeneralInfo($scope.objURL.id).then(function (resp) {
          if("visibility" in resp) {
            resp.visibility_members = resp.visibility.members;
            resp.visibility_teams = resp.visibility.teams;
          }
          $scope.empRoleMain = resp;
          $scope.reScopeMain($scope.objURL.id);
          if("visibility_members" in $scope.empRoleMainTeam) {
            if($scope.empRoleMainTeam.visibility_members.length > 0) {
              $scope.empRoleMain.visibility_members = $scope.empRoleMainTeam.visibility_members;
            }
          }
          if("visibility_teams" in $scope.empRoleMainTeam) {
            if($scope.empRoleMainTeam.visibility_teams.length > 0) {
              $scope.empRoleMain.visibility_teams = $scope.empRoleMainTeam.visibility_teams;
            }
          }

          // if (angular.isDate($scope.empRoleMain.start_date)) {
          //   console.log("IS NOT DATE!");
            var r_start_date = new Date();
            var r_date = r_start_date.getDate();
            var r_month = r_start_date.getMonth();
            var r_year = r_start_date.getFullYear();

            r_start_date = r_date + '/' + r_month + '/' + r_year;
            $scope.empRoleMain.start_date = r_start_date;
          // } else {
          //   console.log("IS DATE!");
          // }

          var data = {data : $scope.empRoleMain};
           // console.log("publish",$scope.empRoleMain);

          $scope.isitPublic = true;
          CreateRoleSvcs.putGeneralInfo($scope.objURL.id, data).then(function(res) {
             // console.log("okay!", data);

            CreateRoleSvcs.getEmployerProfile().then(function(res) {
              $scope.companyDetails = res;
            //console.log(3,$scope.companyDetails.company.company_name);
            });
            CreateRoleSvcs.postPublishRole($scope.objURL.id).then(function(res){
              $scope.jobid_share = res;
              return true;
            });
          });
        });

      };
  }]);


  app.factory('CreateRoleSvcs', ['GlobalConstant', '$http', '$anchorScroll', '$location', function(GlobalConstant, $http, $anchorScroll, $location){
    return {
      getGeneralInfo: function(data) {
        // return $http.get(GlobalConstant.EmployerRootApi + '/job/' + data) // Uncomment for live API call
        return $http.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_job_data.json')
        .then(function(response) {
          return response.data.data;
        });
      },
      putGeneralInfo: function(id, data) {
        return $http.put(GlobalConstant.EmployerRootApi + '/job/' + id, data)
        .then(function(response) {
          return response.data.data;
        });
      },
      putRequirements: function (id, data) {
        var tae = {data : data};
        // console.log("dfgarga",tae)
        return $http.put(GlobalConstant.EmployerRootApi + '/job/'+ id +'/application-requirements', tae)
        .then(function (response) {
          return response.data.data;
          // console.log("req res: ", response.data.data);
        });
      },
      postAplicationQ: function (id, data) {
        // console.log("create role: ", data);
        return $http.post(GlobalConstant.EmployerRootApi + '/job/'+ id +'/questions/application/single', data)
        .then(function (response) {
          return response.data.data;
        });
      },
      putAplicationQ: function (id, putdata, question_id) {
        var httpdata = putdata;
        // delete httpdata.data.video_document;
        delete httpdata.answer_choicesDisplay;
        // console.log("ETO NAAA put putAplicationQ: ", httpdata);

        return $http.put(GlobalConstant.EmployerRootApi + '/job/'+ id +'/questions/application/single/' + question_id, httpdata)
        .then(function (response) {
          // console.log("madafaka ", response);
          return response.data.data;
        });
      },
      getTemplate: function (data) {
        // return $http.get(GlobalConstant.EmployerRootApi + '/company/template/job/'+data) // 
        return $http.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_company_data.json')
        .then(function (response) {
          return response.data.data;
        });
      },
      postPublishRole: function (data) {
        return $http.put(GlobalConstant.EmployerRootApi + '/job/'+data+'/publish')
        .then(function (response) {
          return response.data.data;
        });
      },
      savePreApply: function (id, data, wData) {
        if(wData == true) {
          //return $http.post(GlobalConstant.EmployerRootApi + '/job/' + id + '/questions/pre-apply', data)
          return $http.post(window.location.origin + '/js/minified/test-data/test_emp_create_role_pre_application_data.json')
          .then(function (response) {
            return response.data.data;
          });
        } else {
          return $http.put(window.location.origin + '/js/minified/test-data/test_emp_create_role_pre_application_data.json')
          .then(function (response) {
            return response.data.data;
          });
        }
      },
      getEmployerProfile : function () {
        // return $http.get(GlobalConstant.EmployerProfileApi) // Uncomment for live API call
        return $http.get(window.location.origin + '/js/minified/test-data/test_emp_create_role_profile_data.json')
        .then(function (response) {
          return response.data.data;
        });
      },
      scrollToTop :  function () {
        $anchorScroll.yOffset = 80; //I want it top drop 80px from id. You can remove this.
        $location.hash("top_pane");
        $anchorScroll();
      }
      // ,
      // getJobTest :  function (data) {
      //   return $http.get(GlobalConstant.EmployerAddJob + '/' + data)
      //   .then(function (response) {
      //     return response.data.data;
      //   });
      // }
    }
  }]);
}());
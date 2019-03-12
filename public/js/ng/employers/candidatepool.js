(function() {
    'use strict';
    var appcandidatepool = angular.module('app');
    appcandidatepool.requires.push('rzModule', 'ngSanitize', 'ngCsv');
    // appcandidatepool.requires.push('ngSanitize');

    // autocomplete in progress
    // angular.module('app').directive('autoComplete', function($timeout) {
    //     return function(scope, iElement, iAttrs) {
    //             iElement.autocomplete({
    //                 source: scope[iAttrs.uiItems],
    //                 select: function() {
    //                     $timeout(function() {
    //                       iElement.trigger('input');
    //                     }, 0);
    //                 }
    //             });
    //     };
    // });

    appcandidatepool.controller('CandidatePoolCtrl', ['PoolSvcs', '$scope', '$timeout', '$rootScope', '$cookies', '$window', '$filter',
      function(PoolSvcs, $scope, $timeout, $rootScope, $cookies, $window, $filter) {
        var arrExport = [];
        $scope.master = {};
        $scope.allroles= {};
        $scope.showFilters = 0;
        $scope.filter = 2;
        $scope.scopedgrp_clicked = 0;
        $scope.exportCandidates = [];

        //Watch candidate
        $scope.watchCandidate = function (id) {
          // console.log("watch: ", id);
          PoolSvcs.postWatchCandidate(id).then(function(res) {
            // console.log("watch res: ",res);
          });
        }

        // $scope.watchCandidate(); // delete me later

        // init master filter
        $scope.selectedParams = {};
        $scope.selectedParams.q = '*';
        $scope.selectedParams.app = [];
        $scope.selectedParams.ind = []; // classification
        $scope.selectedParams.sub_ind = [];
        $scope.selectedParams.loc = [];
        $scope.selectedParams.esp = [];
        $scope.selectedParams.stat = [];
        $scope.selectedParams.tag = 2;
        $scope.selectedParams.exp = {
          from: 0,
          to: 10
        };
        // non reset params
        $scope.selectedParams.type = 'job';
        $scope.selectedParams.page = 0;
        $scope.selectedParams.sort = 'asc';
        $scope.selectedParams.sort_candidate_sort = 'asc';


        $scope.showMyProfile = false;
        //Expand Click
        $scope.expanded = false;
        $scope.isDetailOn = false;


        $scope.role_status = 1;
        var allroles = [];
        $scope.noCandidates = {
          ans: 1,
          title: "No candidates has been pulled"
        };

        //TEST ONLY
        $scope.csvHeaders = [
        "First Name",
        "Last Name",
        "Country",
        "Location",
        "Mobile Number",
        "Email Address",
        "Candidate Classification",
        "Candidate Sub-Classification",
        "Salary Range",
        "About Me",

        "Company Name (most recent)",
        "Job Title (most recent)",
        "Responsibiities (most recent)",
        "Job Description (most recent)",
        "Role Classification (most recent)",
        "Role Sub-classification (most recent)",

        "Company Name (former)",
        "Job Title (former)",
        "Responsibiities (former)",
        "Job Description (former)",
        "Role Classification (former)",
        "Role Sub-classification (former)",

        "Degree (most recent)",
        "Field of Study (most recent)",
        "Education Provider (most recent)",
        "Completed Date (most recent)",

        "Degree (former)",
        "Field of Study (former)",
        "Education Provider (former)",
        "Completed Date (former)",

        "Reference 1 Description",
        "Employer Name (Reference 1)",
        "Company Name (Reference 1)",
        "Email Address (Reference 1)",
        "Phone Number (Reference 1)",

        "Reference 2 Description",
        "Employer Name  (Reference 2)",
        "Company Name (Reference 2)",
        "Email Address (Reference 2)",
        "Phone Number (Reference 2)",
        "Resume",
        "Supporting Docs"];

        var fileNamedate = new Date();

        var fileNamedate = new Date();
        var dd = fileNamedate.getDate();
        var mm = fileNamedate.getMonth()+1; //January is 0!
        var hrs = fileNamedate.getHours();
        var mins = fileNamedate.getMinutes();
        var secs = fileNamedate.getSeconds();

        var yyyy = fileNamedate.getFullYear();
        if(dd<10){
          dd='0'+dd;
        }
        if(mm<10){
          mm='0'+mm;
        }
        var fileNamedate = dd.toString()+ mm.toString() + yyyy.toString() +'_'+hrs+'_'+mins;

        $scope.csvFilename = "PreviewMe_CandidatePool_" + fileNamedate + ".csv";

        // params BEGIN
        $scope.resetScope = function() {
          $scope.selectedParams.q = '';
          $scope.selectedParams.app = [];
          $scope.selectedParams.ind = []; // classification
          $scope.selectedParams.sub_ind = [];
          $scope.selectedParams.loc = [];
          $scope.selectedParams.esp = [];
          $scope.selectedParams.stat = [];
          $scope.selectedParams.tag = 2;
          $scope.selectedParams.exp = {
            from: 0,
            to: 10
          };
          $scope.selectedParams.appstatus = {};
          resetSlider();
        }
        // params END

        // API Request for pool
        $scope.ApplyThis = function () {
          var data = {data: {q:'*', type: 'job', page: 0}};

          if(!$scope.selectedParams.q) {
            $scope.selectedParams.q = "*";
          }

          PoolSvcs.getInitPool($scope.selectedParams).then(function(res){
            $scope.candidate_filtered = res.data;
            // console.log("res data: ", $scope.candidate_filtered);

            angular.forEach($scope.candidate_filtered.groups, function(value, key) {

              // console.log("object: ", value);
              angular.forEach(value.candidates, function (val, k) {
                var b;
                b = Math.floor(Math.random() * 5) + 1;

                $scope.F_initial_v = val.first_name;
                $scope.F_initial_v = $scope.F_initial_v.substr(0, 1);
                $scope.L_initial_v = val.last_name;
                $scope.L_initial_v = $scope.L_initial_v.substr(0, 1);
                val.initial = $scope.F_initial_v + $scope.L_initial_v;

                // change default photo's background color
                if(!val.profile_image) {

                  if (b == 1) {
                    val.profile_color = "member-initials--sky";
                  }
                  else if (b == 2) {
                    val.profile_color = "member-initials--pvm-purple";
                  }
                  else if (b == 3) {
                    val.profile_color = "member-initials--pvm-green";
                  }
                  else if (b == 4) {
                    val.profile_color = "member-initials--pvm-red";
                  }
                  else if (b == 5) {
                    val.profile_color = "member-initials--pvm-yellow";
                  }
                  b++;
                }

                $scope.exportCandidates.push({
                  id: val.id,
                  fname: val.first_name,
                  lname: val.last_name,
                  country: val.country_name ,
                  loc: val.location_name,
                  mobile: val.mobile_number,
                  email: val.email_address,
                  ind: val.industry,
                  sub_ind: "",
                  salary: val.salary_min + "-" + val.salary_max,
                  about: "",

                  compname_r: "",
                  job_r: "",
                  responsibility_r: "",
                  job_desc_r: "",
                  w_ind_r: "",
                  w_sub_ind_r: "",

                  compname_f: "",
                  job_f: "",
                  responsibility_f: "",
                  job_desc_f: "",
                  w_ind_f: "",
                  w_sub_ind_f: "",

                  degree_r: "",
                  fos_r: "",
                  esp_r: "",
                  comp_date_r: "",

                  degree_f: "",
                  fos_f: "",
                  esp_f: "",
                  comp_date_f: "",

                  ref_desc_1: "ref description here",
                  ref_emp_name_1: "Johnny Farquhar",
                  ref_comp_name_1: "Preview Me",
                  ref_email_1: "pvm@mail.com",
                  ref_phone_1: "098123456",

                  ref_desc_2: "ref description here",
                  ref_emp_name_2: "Johnny Farquhar",
                  ref_comp_name_2: "Preview Me",
                  ref_email_2: "pvm@mail.com",
                  ref_phone_2: "098123456",

                  resume: "",
                  support_doc: ""
                });

                //multiply records by ESP
                var qctr = 0, wctr = 0;
                angular.forEach(val.work_history, function (w_val, w_key){

                  angular.forEach($scope.exportCandidates, function(csv_val, csv_key){
                    if(csv_val.id == val.id) {
                      if (wctr == 0) {
                        csv_val.compname_r = w_val.company_name;
                        csv_val.job_r = w_val.job_title;
                        csv_val.responsibility_r = w_val.job_title;
                        csv_val.job_desc_r = w_val.description;
                        csv_val.w_ind_r = w_val.job_title;
                        csv_val.w_sub_ind_r = w_val.job_title;
                      }

                      if (wctr == 1) {
                        csv_val.compname_f = w_val.company_name;
                        csv_val.job_f = w_val.job_title;
                        csv_val.responsibility_f = w_val.job_title;
                        csv_val.job_desc_f = w_val.description;
                        csv_val.w_ind_f = w_val.job_title;
                        csv_val.w_sub_ind_f = w_val.job_title;
                      }
                    }
                  });
                  wctr++;

                });

                angular.forEach(val.qualifications, function(q_val, q_key){
                  angular.forEach($scope.exportCandidates, function(csv_val, csv_key){
                    if(csv_val.id == val.id) {
                      if (qctr == 0) {
                        csv_val.degree_r = q_val.degree;
                        csv_val.fos_r = q_val.name;
                        csv_val.esp_r = q_val.qualification_provider_name;
                        csv_val.comp_date_r = q_val.completed_date;
                      }

                      if (qctr == 1) {
                        csv_val.degree_f = q_val.degree;
                        csv_val.fos_f = q_val.name;
                        csv_val.esp_f = q_val.qualification_provider_name;
                        csv_val.comp_date_f = q_val.completed_date;
                      }
                    }
                  });
                  qctr++;
                });

                // get TMS app step position
                angular.forEach(val.tms_details, function(tms_val, tms_key){
                  if (tms_key == value.details.object_id) {
                    val.tms_app_position = tms_val.name;
                  }
                });

              });


            });

            if ($scope.exportCandidates) {
              $scope.noCandidates = {
                ans: 0,
                title: "Export to CSV is ready"
              };
            }

            angular.forEach($scope.exportCandidates, function(f_val, f_key){
              delete f_val.id; // the id value
            });

            // console.log("revised: ", $scope.candidate_filtered.groups);
          });
        };

        $scope.ApplyThis(); // initialize list

        // get more candidates by a group
        $scope.poolMoreCandidate = function (grp_id, grp_page, grp_limit) {
          var grpPage = parseInt(grp_page) + 1;

          $scope.poolMore = {
            q: $scope.selectedParams.q,
            type: $scope.selectedParams.type,
            page: grpPage,
            limit: grp_limit,
            app: grp_id,
            sort: $scope.selectedParams.sort,
            ind: $scope.selectedParams.ind,
            sub_ind: $scope.selectedParams.sub_ind,
            esp: $scope.selectedParams.esp,
            loc: $scope.selectedParams.loc,
            stat: $scope.selectedParams.stat,
            tag: $scope.selectedParams.tag,
            exp: $scope.selectedParams.exp
          };

          PoolSvcs.getMorePool($scope.poolMore).then(function (res) {
            // console.log('get more pool: ', res);
          });

          angular.forEach($scope.candidate_filtered.groups, function (value, key) {
            if (value.object_id == grp_id) {
              if (resData.data) {
                for (var a = 0; a < resData.data.length; a++) {
                  value.candidates.push(resData.data[a]);
                }
              }
              value.page = grpPage;
              // console.log("poolMore result: ", $scope.candidate_filtered);
            }
          });
        };

        // Initialize filters BEGIN
        PoolSvcs.getIndustries().then(function (res) {
          $scope.all_industries = res;
        });

        PoolSvcs.getLocations().then(function (res) {
          $scope.loc_test = res;
        });

        PoolSvcs.getEdProviders().then(function (res) {
          $scope.edproviders = res;
        });

        PoolSvcs.getActiveRoles().then(function (res) {
          $scope.activeroles = res;

          angular.forEach($scope.activeroles, function(val, key){
            allroles.push(val);
          });
        });

        PoolSvcs.getClosedRoles().then(function (res) {
          $scope.closedroles = res.jobs;

          angular.forEach($scope.closedroles, function(val, key){
            allroles.push(val);
          });
        });

        $scope.allroles = allroles;

        $scope.appstatus = [{
            name : "All application status",
            id: "allapp"
          }, {
            name : "All standard buckets",
            id: "allstandard",
            sub: [
              {name: "Long list", id: "longlist"},
              {name: "Short list", id: "shortlist"},
              {name: "Interview", id: "interview"},
              {name: "Hired", id: "hired"},
              {name: "Not successful", id:"notsuccesful"}
            ]
          }, {
            name : "All custom buckets",
            id: "custom"
          }
        ];
        // Initialize filters END

        // Classifications Control filter BEGIN
        $scope.sub_filter_selected = function(obj, type) {
          //force parent to check
          if (angular.element($('#all_industry_'+obj)).is(':checked')) {
            // $scope.selectedParams.ind.splice($scope.selectedParams.ind.indexOf(obj));
            $scope.selectedParams.ind.push(obj);
          }
        };

        $scope.onHoverSubIndustries = true;
        $scope.showSubIndustries = function(obj) {

          $scope.onHoverSubIndustries = true;
          if (obj) {
            angular.element(document.querySelector('.subindustry_multi_main')).removeClass('hide');
          }
        };

        $scope.hideSubIndustries = function(obj) {

          $scope.onHoverSubIndustries = false;
          setTimeout(function() {
            if ($scope.onHoverSubIndustries == false) {
              $('.togglethis').trigger('click');
            }
          }, 1500);
        };

        $scope.parentClassifications = null;
        $scope.hoverIndustry = function( data, parentClassifications ){
          $scope.sub_ind = data;
          $scope.parentClassifications = parentClassifications;
        };
        // Classifications Control filter END

        // ==========================

        // Locations Control filter BEGIN
        $scope.sub_location_selected = function(obj) {
          //force parent to check
          if (angular.element($('#all_location_'+obj)).is(':checked')) {
            $scope.selectedParams.loc.push(obj);
          }
        };

        $scope.onHoverSubLocations = true;
        $scope.showSubLocations = function(obj) {
          $scope.onHoverSubLocations = true;
          if (obj) {
            angular.element(document.querySelector('.sublocation_multi_main')).removeClass('hide');
          }
        };

        $scope.hideSubLocations = function(obj) {
          $scope.onHoverSubLocations = false;
          setTimeout(function() {
            if ($scope.onHoverSubLocations == false) {
              $('.togglethisLoc').trigger('click');
            }
          }, 1500);
        };

        $scope.parentLocations = null;
        $scope.hoverLocation = function( data, parentLocations ){
          $scope.SubsLocations = data;
          $scope.parentLocations = parentLocations;
        };
        // Locations Control filter END

        // ==========================

        // Education Providers Control filter BEGIN
        $scope.sub_education_selected = function(obj) {
          //force parent to check
          if (angular.element($('#all_education_'+obj)).is(':checked')) {
            $scope.selectedParams.esp.push(obj);
          }
        };

        $scope.onHoverSubEducation = true;
        $scope.showSubEducation = function(obj) {
          $scope.onHoverSubEducation = true;
          if (obj) {
            angular.element(document.querySelector('.sublocation_multi_main')).removeClass('hide');
          }
        };

        $scope.hideSubEducation = function(obj) {
          $scope.onHoverSubEducation = false;
          setTimeout(function() {
            if ($scope.onHoverSubEducation == false) {
              $('.togglethisEdu').trigger('click');
            }
          }, 1500);
        };

        $scope.parentEducation = null;
        $scope.hovereducation = function( data, parentEducation ){
          $scope.SubsEducation = data;
          $scope.parentEducation = parentEducation;
        };
        // Education Providers Control filter END

        // ==========================

        // All Roles Applied Control filter BEGIN
        $scope.sub_allroles_selected = function(obj) {
          //force parent to check
          if (angular.element($('#all_roles_'+obj)).is(':checked')) {
            $scope.selectedParams.app.push(obj);
          }
        };

        $scope.onHoverSubAllRoles = true;
        $scope.showSubAllRoles = function(obj) {
          $scope.onHoverSubAllRoles = true;
          if (obj) {
            angular.element(document.querySelector('.sublocation_multi_main')).removeClass('hide');
          }
        };

        $scope.hideSubAllRoles = function(obj) {
          $scope.onHoverSubAllRoles = false;
          setTimeout(function() {
            if ($scope.onHoverSubAllRoles == false) {
              $('.togglethisAllRoles').trigger('click');
            }
          }, 1500);
        };

        $scope.parentEducation = null;
        $scope.hovereducation = function( data, parentEducation ){
          $scope.SubsEducation = data;
          $scope.parentEducation = parentEducation;
        };
        // All Roles Applied Control filter END

        // ==========================

        // Application Status Control filter BEGIN
        $scope.sub_allapps_selected_parent = function(obj) {
          if (angular.element($('#all_appstat_'+obj)).is(':checked')) {
            angular.forEach($scope.appstatus, function(val, key){
              if (val.id == obj) {
                angular.forEach(val.sub, function(value, key){
                  $scope.selectedParams.appstatus.push(value.id);
                });
              }
            });
          }
        };

        $scope.sub_allapps_selected = function(obj) {
          $scope.selectedParams.appstatus.push(obj);
        };

        $scope.onHoverSubAllApp = true;
        $scope.showSubAllApp = function(obj) {

          $scope.onHoverSubAllApp = true;
          angular.element(document.querySelector('.suballapp_multi_main')).removeClass('hide');
        };

        $scope.hideSubAllApp = function(obj) {
          $scope.onHoverSubAllApp = false;
          setTimeout(function() {
            if ($scope.onHoverSubAllApp == false) {
              $('.togglethisAllApp').trigger('click');
            }
          }, 1500);
        };

        $scope.parentAllApp = null;
        $scope.hoverallapp = function(data, parentAllApp){
          // if (data) {
            $scope.SubsAllApp = data;
            $scope.parentAllApp = parentAllApp;
          // }
        };
        // Application Status Applied Control filter END


        $scope.refreshSlider = function () {
          $timeout(function () {
              $scope.$broadcast('rzSliderForceRender');
          });
        };

        $scope.changeListener = function (sliderID){
          $scope.selectedParams.exp.from = $scope.slider.min;
          $scope.selectedParams.exp.to = $scope.slider.max;
        }

        // Years of Experience slider filter BEGIN
        $scope.slider = {
          min: 0,
          max: 10,
          options: {
            floor: 0,
            ceil: 10,
            id: 'sliderA',
            onEnd: $scope.changeListener,
            translate: function(value) {
              var returnme;

              if(value == '10') {
                returnme = value.toString() + '+';
              } else {
                returnme = value;
              }
              return returnme;
            }
          }
        };

        function resetSlider () {
          $scope.slider.min = 0;
          $scope.slider.max = 10;
        };
        // Years of Experience slider filter END

        // Tags filter BEGIN
        $scope.$watch('filter', function (newVal, oldVal) {
          $scope.selectedParams.tag = newVal;
        });
        // Tags filter END

        $scope.ApplyFilter = function () {
          if ($scope.showFilters == 0) {
            $scope.showFilters = 1;
          } else {
            $scope.showFilters = 0;
          }
        };

        // TMS function BEGIN
        $scope.ProfileQuestions = function(jobId, jobObjectId, stepID) {
          PoolSvcs.getCandidateQandA(jobId, jobObjectId).then(function(response) {
            var data = response.data.data;
            $scope.questions = data;

            angular.forEach($scope.questions.application_questions, function(v,k) {
              if(v.answer_type == 'file_upload') {
                //ACP-75
                $scope.doc_url = v.answer.doc_url;
                $scope.pdfExtQue = $scope.doc_url.lastIndexOf('.');
                $scope.pdfExtQue = $scope.doc_url.substring($scope.pdfExtQue, $scope.doc_url.length);

                if($scope.pdfExtQue != ".pdf") {
                  v.answer.doc_url = 'https://view.officeapps.live.com/op/embed.aspx?src=' + v.answer.doc_url;
                }
                //v.answer.doc_url = 'https://view.officeapps.live.com/op/embed.aspx?src=' + v.answer.doc_url;
              } else if(v.answer_type == 'video') {
                v.video_id = $scope.makeRandomId();

                if(v.answer.doc_url == 'pending_doc_url') {
                  v.poster = true;
                } else {
                  $timeout(function(){
                    var expandedvid= 'video_answer_'+v.video_id+'_'+stepID;
                    var expandedvidcon = 'video_answer_con'+v.video_id+'_'+stepID;
                    var vid_test = '<video id="'+expandedvid+'" class="azuremediaplayer amp-default-skin amp-big-play-centered"  style="min-width:250px; min-height: 181px">\
                                      <p class="amp-no-js">\
                                        To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video\
                                      </p>\
                                    </video>';

                    $('#'+expandedvidcon).html(vid_test);

                    $scope.expvideoLoaded = false;
                    var myPlayer = amp(expandedvid, {
                      "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                      "nativeControlsForTouch": false,
                      autoplay: false,
                      controls: true,
                      width: "322",
                      height: "181",
                      logo: {
                        "enabled": false
                      },
                      poster: ""
                    }, function() {
                    });
                    myPlayer.src([{
                      src: v.answer.doc_url,
                      type: "application/vnd.ms-sstr+xml"
                    }]);
                  }, 3000)

                }
              }
            });
              return data;
          });
        };

        function getUrlParameter(param, dummyPath) {
          var sPageURL = dummyPath || window.location.search.substring(1),
          sURLVariables = sPageURL.split(/[&||?]/), res;
          for (var i = 0; i < sURLVariables.length; i += 1) {
            var paramName = sURLVariables[i],
            sParameterName = (paramName || '').split('=');
            if (sParameterName[0] === param) {
              res = sParameterName[1];
            }
          }
          return res;
        }

        $scope.getNotes = function(applicationId, jobId) {
          // var urlParam = getUrlParameter('id');
          var urlParam = jobId;
          urlParam = 1370;

          PoolSvcs.getCandidateNotes(urlParam, applicationId).then(function(response) {
            var data = response.data.data;
            $scope.appNotes.push({
                data: data
            });
          }, function(response) {
          })
        };

        $scope.makeRandomId = function() {
          var text = "";
          var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

          for( var i=0; i < 10; i++ ) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
          }
          return text;
        };


        $scope.getApplicantProfile = function(userId, stepID) {
          $scope.expandloader = true;
          $scope.testvidid = $scope.makeRandomId();
          $scope.testconid = $scope.makeRandomId();
          $scope.arrJobsApplied = [];

          //get applied jobs
          angular.forEach($scope.candidate_filtered.groups, function(value, key){
            if (value.details.id == stepID) {
              angular.forEach(value.candidates, function(val, kay){
                if(val.id == userId) {
                  // $scope.arrJobsApplied = val.jobs_applied;

                  angular.forEach(val.jobs_applied, function(v, k) {
                    $scope.arrJobsApplied.push({name: v});
                  });
                }
              });
            }
          });

          PoolSvcs.getCandidate(userId).then(function(response) {
            var data = response.data.data;
            $scope.userPublicProfile = [];
            $scope.userPublicProfile.push({
              data: data,
              id: userId
            });

            $scope.userPublicProfile[0].data.jobs_applied = $scope.arrJobsApplied;

            var work_history = $scope.userPublicProfile[0].data.work_history;
            //ACP-75 if (typeof $scope.tmsSteps.applicantlist[a].applicants[i] != 'undefined') {
            if ($scope.userPublicProfile[0].data.docs.resume.doc_url) {
              $scope.res_url = $scope.userPublicProfile[0].data.docs.resume.doc_url;
              $scope.pdfExtRes = $scope.res_url.lastIndexOf('.');
              $scope.pdfExtRes = $scope.res_url.substring($scope.pdfExtRes, $scope.res_url.length);

              if ($scope.pdfExtRes != ".pdf") {
                $scope.userPublicProfile[0].data.docs.resume.doc_url = 'https://view.officeapps.live.com/op/embed.aspx?src=' + $scope.userPublicProfile[0].data.docs.resume.doc_url;
              }
            }


            if ($scope.userPublicProfile[0].data.docs.portfolio.doc_url) {
              $scope.doc_url = $scope.userPublicProfile[0].data.docs.portfolio.doc_url;
              $scope.pdfExtDoc = $scope.doc_url.lastIndexOf('.');
              $scope.pdfExtDoc = $scope.doc_url.substring($scope.pdfExtDoc, $scope.doc_url.length);
              if ($scope.pdfExtDoc != ".pdf") {
                $scope.userPublicProfile[0].data.docs.portfolio.doc_url = 'https://view.officeapps.live.com/op/embed.aspx?src=' + $scope.userPublicProfile[0].data.docs.portfolio.doc_url;
              }
            }
            // Add initial to be used in default image
            var b;
            b = Math.floor(Math.random() * 5) + 1;

            $scope.F_initial = $scope.userPublicProfile[0].data.first_name;
            $scope.F_initial = $scope.F_initial.substr(0, 1);

            $scope.L_initial = $scope.userPublicProfile[0].data.last_name;
            $scope.L_initial = $scope.L_initial.substr(0, 1);
            $scope.userPublicProfile[0].data.initial = $scope.F_initial + $scope.L_initial;

            // change default photo's background color
            if(!$scope.userPublicProfile[0].data.docs.profile_image) {

              if (b == 1) {
                $scope.userPublicProfile[0].data.profile_color = "member-initials--sky";
              }
              else if (b == 2) {
                $scope.userPublicProfile[0].data.profile_color = "member-initials--pvm-purple";
              }
              else if (b == 3) {
                $scope.userPublicProfile[0].data.profile_color = "member-initials--pvm-green";
              }
              else if (b == 4) {
                $scope.userPublicProfile[0].data.profile_color = "member-initials--pvm-red";
              }
              else if (b == 5) {
                $scope.userPublicProfile[0].data.profile_color = "member-initials--pvm-yellow";
              }
              b++;
            }

            angular.forEach(work_history, function(v, k) {
              var olddate = v.start_date ;
              var exp_date = olddate.split('-');
              var newDate = exp_date[1]+'/'+exp_date[1]+'/'+exp_date[2];
              var setDate  = new Date(newDate);
              angular.extend(v, {filterdate: $filter('date')(setDate, 'longDate')});
            });

            if (angular.isDefined(data.docs.icebreaker_video)) {
              if(data.docs.icebreaker_video.doc_id != '' && data.docs.icebreaker_video.doc_url == '') {
                $scope.showVideoLoding = true;
                $scope.expvideoLoaded = true;
              } else {
                var docurl = data.docs.icebreaker_video.doc_url
                var docurlcount = docurl.split('/')

                if(docurlcount.length == 1) {
                  $scope.showVideoLoding = false;
                  $scope.ShowVideoError = true;
                  $scope.expvideoLoaded = false;
                  $scope.errorVideo = data.docs.icebreaker_video.doc_url;
                  $('#expandedvid_con_'+$scope.testconid+'_'+stepID).hide();
                } else {

                  $timeout(function() {
                    var expandedvid = 'expandedvid_'+$scope.testvidid+'_'+stepID;
                    var expandedvidcon = 'expandedvid_con_'+$scope.testconid+'_'+stepID;
                    var CandidateVideo = data.docs.icebreaker_video.doc_url;
                    var vid_test = '<video id="' + expandedvid + '" class="azuremediaplayer amp-default-skin amp-big-play-centered" style="min-width:220px"  >\
                                      <p class="amp-no-js">\
                                        To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video\
                                      </p>\
                                    </video>';

                    angular.element($('#'+expandedvidcon)).html(vid_test);
                    $scope.expvideoLoaded = false;
                    var myPlayer = amp(expandedvid, {
                      "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                      "nativeControlsForTouch": false,
                      autoplay: false,
                      controls: true,
                      width: "220",
                      height: '130',
                      logo: {
                        "enabled": false
                      },
                      poster: ""
                    }, function() {
                    });

                    myPlayer.src([{
                      src: data.docs.icebreaker_video.doc_url,
                      type: "application/vnd.ms-sstr+xml"
                    }]);
                  }, 3000);
                }
              }
            }

            //return data;
          }, function(response) {
          });
        }

        $scope.expandme = function(id, stepId, applicationId, printOption, $event, seeNotes) {
          $event.stopPropagation();
          $event.preventDefault();
          $scope.isDetailOn = true;
          var setTop;

          if (seeNotes) {
            setTop = 1220;
          } else {
            setTop = 520;
          }

          // console.log('applicationId: ', applicationId);

          $('#tabs-1, #tabs-2, #tabs-3, #tabs-4').TrackpadScrollEmulator();
          var JobId = getUrlParameter('id');

          // Test code only, delete later
          if (!JobId) {
            JobId = 1370;
          }

          // console.log("jobid: ", JobId);

          angular.element( $( "#app"+id+"" )).css( "visibility", "hidden" );

          $scope.userPublicProfile = [];
          $scope.appNotes = [];
          $scope.getApplicantProfile(id, stepId);
          // console.log("stepID: ", stepId);
          $scope.getNotes(applicationId, stepId);
          $scope.ProfileQuestions(JobId, applicationId, stepId);

          setTimeout(function () {
            $scope.showMyProfile = true;
            // $scope.showExpand = true;

            $scope.scopedgrp_clicked = stepId; // open grouped specific vcard, and closes other group vcards

            //ACP-75
            $scope.showPreviewDocs = function() {
              $scope.previewDocs = !$scope.previewDocs;
              $scope.previewRes = false;
            };

            $scope.showPreviewRes = function() {
              $scope.previewRes = !$scope.previewRes;
              $scope.previewDocs = false;
            };

            $scope.hidePreviews = function() {
              $scope.previewRes = false;
              $scope.previewDocs = false;
            };

            $scope.printMe = function(id) {
              var iFrameRes = document.getElementById('printRes'+id);
              iFrameRes.contentWindow.print();
              var iFrameDocs = document.getElementById('printDocs'+id);
              iFrameDocs.contentWindow.print(); //ACP-70
              window.print();
            };

            angular.element( $("#expandedSection"+stepId)).tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
            angular.element( $("#expandedSection"+stepId+" li")).removeClass("ui-corner-top" ).addClass("ui-corner-left");
            angular.element( $("#expandedSection"+stepId+" .dataContainer")).css( "height", "700px" );
            // angular.element( $("html, body")).animate({ scrollTop: setTop }, 1000);
            angular.element( $("#tmslist_" + stepId)).animate({ scrollTop: setTop }, 1000);
            angular.element($('.expander .profile_container')).css('display', 'block');
            angular.element($('.expander')).animate({
              opacity: 1,
              position: 'relative'
            }, function() {
              //add class after expands
              angular.element($(this)).addClass('expanded cloned');
              angular.element(  $('[data-toggle="tooltip"]')).tooltip();

              if(printOption == true) {
                angular.element($(this)).addClass("print-profile");
              }
              else {
                angular.element($(this)).removeClass("print-profile");
              }
            });
            if(printOption == true) {
              setTimeout(function () {
                $scope.isDetailOn = false;
                angular.element($('.expander .profile_container')).css('visibility', 'hidden');
                window.print();
              }, 1700);
            }
            else {
              $scope.isDetailOn = false;
              angular.element($('.expander .profile_container')).css('visibility', 'visible');
            }
          }, 1300);
        };

        //Unexpand button
        $scope.unexpandme = function(id, applicantId) {
          $scope.showMyProfile = false;
          $scope.scopedgrp_clicked = 0;
          $scope.userPublicProfile = [];
          $scope.expandloader = false;
          angular.element( $( "#app"+applicantId )).css( "visibility", "visible" );
          angular.element($('.expander .profile_container')).css('display', 'none');
          angular.element($('.expander')).animate({
            height: 0,
            opacity: 0
          }, function() {
            angular.element($(this)).removeClass('expanded');
            angular.element($(this)).removeClass('cloned');
            angular.element( $( "#expandedSection"+id+" .dataContainer" )).css( "height", "0" );
            angular.element( $( "#VideoContainer div" )).html( " " );
          });
        }
        // TMS function END

        $scope.loadVideo = function(candidate, $event) {
          $event.preventDefault();
          $event.stopPropagation();
          $scope.ModalCandidate = candidate;
          $scope.randomVidID = $scope.makeRandomId(); //Randomize string to reopen video
          var loadVideoModal = 'vid'+candidate.id+'_'+$scope.randomVidID;
          var modalVid = '<video id="'+loadVideoModal+'" class="azuremediaplayer amp-default-skin amp-big-play-centered"    >\
                            <p class="amp-no-js">\
                              To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video\
                            </p>\
                          </video>';
          if (candidate.icebreaker_video_url[0] != '' && !candidate.icebreaker_video_url[0]) {

            $scope.showVideoLoding = true;
            $scope.LoadingModalVid = false;
          } else {

            var docurl = candidate.icebreaker_video_url[0];
            var docurlcount = docurl.split('/')

            if ( docurlcount.length == 1 ) {

              $scope.ShowVideoError = true;
              $scope.LoadingModalVid = false
              $scope.errorVideo = candidate.icebreaker_video_url[0];
            } else {

              //Set timeout for bideo to reinsert video player
              $timeout(function() {
                //remove loader
                $scope.LoadingModalVid = false
                //Insert HTML
                angular.element('#vidModal .modal-body').html(modalVid);
                $scope.expvideoLoaded = false;
                // console.log("paker! ", modalVid);

                //attributes for video player
                var myPlayer = amp(loadVideoModal, {
                  "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                  "nativeControlsForTouch": false,
                  autoplay: true, // IB PLFE issue resolution
                  controls: true,
                  width: "100%",
                  height: '500px',
                  logo: {
                      "enabled": false
                  },
                  poster: ""
                }, function() {
                });

                // console.log("paker 2");


                //Process video manifest
                myPlayer.src([{
                  src:candidate.icebreaker_video_url[0],
                  type: "application/vnd.ms-sstr+xml"
                }]);
                $('#vidModal').modal();
              }, 2000);
            }

          }
        }


      }

    ]);


    // CP Http factory
    appcandidatepool.factory('PoolSvcs', ['$http', 'GlobalConstant', function ($http, GlobalConstant) {
      return {
        getIndustries: function () {
          return $http.get(GlobalConstant.APIRoot + 'static/options/industries/all' )
          .then(function(response) {
            return response.data.data;
          });
        },
        getLocations: function () {
          return $http.get(GlobalConstant.APIRoot + 'static/options/countries')
          .then(function(response) {
            return response.data.data;
          });
        },
        getEdProviders: function () {
          return $http.get(GlobalConstant.APIRoot + 'static/options/qualification_providers')
          .then(function(response) {
            return response.data.data;
          });
        },
        getActiveRoles: function () {
          return $http.get(GlobalConstant.EmployerRootApi + '/job/tms-data/active')
          .then(function(response) {
            return response.data.data;
          });
        },
        getClosedRoles: function () {
          return $http.get(GlobalConstant.EmployerRootApi + '/job/closed')
          .then(function(response) {
            return response.data.data;
          });
        },
        getCandidate: function (id) {
          return $http.get(GlobalConstant.CandidateRootApi + '/public/profile/' + id)
          .then(function(response) {
            return response;
          });
        },
        getCandidateNotes: function (urlId, appId) {
          return $http.get(GlobalConstant.APIRoot + 'employer/tms/' + urlId + '/' + appId + '/notes')
          .then(function(response) {
            return response;
          });
        },
        getCandidateQandA: function (jobId, jobObjectId) {
          return $http.get(GlobalConstant.EmployerRootApi + '/tms/' + jobId + '/' + jobObjectId + '/answers')
          .then(function(response) {
            return response;
          });
        },
        getInitPool: function (data) {
          var req = {data: data};
          // return $http.get('../themes/bbt/js/sample/candidate_pool/getcandidate_pool_v6.json')
          return $http.post(GlobalConstant.EmployerRootApi + '/candidate-pool/groups', req)
          .then(function(res) {
            return res.data;
          });
        },
        getMorePool: function (data) {
          var req = {data: data};
          // console.log("get more: ", req);

          return $http.post(GlobalConstant.EmployerRootApi + '/candidate-pool/group', req)
          .then(function(res) {
            return res.data;
          });
        },
        postWatchCandidate: function (data) {

          return $http.post(GlobalConstant.APIRoot + 'employer/candidate/watchlist/' + data)
          .then(function(response) {
            return response.data;
          });
        }
      }
    }]);

}());
$('#JobsAppliedListing').TrackpadScrollEmulator();

$('.sliderContainer').TrackpadScrollEmulator();
$('.togglethis').click(function(){
  $('#ClassificationMain').slideToggle(function(){
    if ($('#ClassificationMain').is(':visible')) {
      // console.log("hover in");
      $('.togglethis').addClass('focusthis')
    }else if ($('#ClassificationMain').is(':hidden')) {
      // console.log("hover out");
      $('.togglethis').removeClass('focusthis')
    }
  });
});

$('.sliderLocContainer').TrackpadScrollEmulator();
$('.togglethisLoc').click(function(){
  $('#LocationMain').slideToggle(function(){
    if ($('#LocationMain').is(':visible')) {
      $('.togglethisLoc').addClass('focusthis')

    }else if ($('#LocationMain').is(':hidden')) {

      $('.togglethisLoc').removeClass('focusthis')
    }
  });
});

$('.sliderEduontainer').TrackpadScrollEmulator();
$('.togglethisEdu').click(function(){
  $('#EducationMain').slideToggle(function(){
    if ($('#EducationMain').is(':visible')) {
      $('.togglethisEdu').addClass('focusthis')

    }else if ($('#EducationMain').is(':hidden')) {

      $('.togglethisEdu').removeClass('focusthis')
    }
  });
});

$('.sliderRolesContainer').TrackpadScrollEmulator();
$('.togglethisAllRoles').click(function(){
  $('#AllRolesMain').slideToggle(function(){
    if ($('#AllRolesMain').is(':visible')) {
      $('.togglethisAllRoles').addClass('focusthis')

    }else if ($('#AllRolesMain').is(':hidden')) {

      $('.togglethisAllRoles').removeClass('focusthis')
    }
  });
});

$('.sliderAllAppContainer').TrackpadScrollEmulator();
$('.togglethisAllApp').click(function(){
  $('#AppStatMain').slideToggle(function(){
    if ($('#AppStatMain').is(':visible')) {
      $('.togglethisAllApp').addClass('focusthis')

    }else if ($('#AppStatMain').is(':hidden')) {

      $('.togglethisAllApp').removeClass('focusthis')
    }
  });
});
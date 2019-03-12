(function () {
    'use strict';
    var app = angular.module('app');

    app.filter('trustAsResourceUrl', ['$sce', function ($sce) {
        return function (val) {
            return $sce.trustAsResourceUrl(val);
        };
    }])

    app.directive('autoResize', autoResize);
    autoResize.$inject = ['$timeout'];

    function autoResize($timeout) {
        var directive = {
            restrict: 'A',
            link: function autoResizeLink(scope, element, attributes, controller) {

                element.css({'height': 'auto', 'overflow-y': 'hidden'});
                $timeout(function () {
                    element.css('height', element[0].scrollHeight + 'px');
                }, 100);

                element.on('input', function () {
                    element.css({'height': 'auto', 'overflow-y': 'hidden'});
                    element.css('height', element[0].scrollHeight + 'px');
                });
            }
        };
        return directive;
    };


    var base_url = $('body').data('base_url');
    app.controller('EmployerManageTalent', ['GlobalConstant', 'EmployerService', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile', '$location', '$anchorScroll', '$q',
        function (GlobalConstant, EmployerService, $scope, $window, $http, $cookies, $filter, $timeout, $compile, $location, $anchorScroll, $q) {
            $scope.token = $cookies.get('token');
            $scope.preload = true;
            $scope.videoLoaded = true;
            $scope.tmsfilter = "";
            $scope.getApplicants_notloaded = true;
            $scope.candidatenoretrieved = false;
            $scope.tmscandidates = [];
            $scope.currentBucketId = 0;
            $scope.allVideoKill = false;


            $scope.ratings = [{
                class: 'starlabelhalf',
                // class: 'starhalf',
                value: '0.5'
            }, {
                class: 'starlabel1',
                // class: 'star1',
                value: '1.0'
            }, {
                class: 'starlabel1half',
                // class: 'star1half',
                value: '1.5'
            }, {
                class: 'starlabel2',
                // class: 'star2',
                value: '2.0'
            }, {
                class: 'starlabel2half',
                // class: 'star2half',
                value: '2.5'
            }, {
                class: 'starlabel3',
                // class: 'star3',
                value: '3.0'
            }, {
                class: 'starlabel3half',
                // class: 'star3half',
                value: '3.5'
            }, {
                class: 'starlabel4',
                // class: 'star4',
                value: '4.0'
            }, {
                class: 'starlabel4half',
                // class: 'star4half',
                value: '4.5'
            }, {
                class: 'starlabel5',
                // class: 'star5',
                value: '5.0'
            }];


            var color_bg_initial_set = [
                "member-initials--sky",
                "member-initials--pvm-purple",
                "member-initials--pvm-green",
                "member-initials--pvm-red",
                "member-initials--pvm-yellow"
            ];

            //get query string by key
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

            if (getUrlParameter('id') != null || getUrlParameter('id') != '') {
                //Get Job Details
                $scope.JobParams = 'access_token=' + $cookies.get('token');

                $scope.getJobData = function () {
                    // console.log('getJobData');
                    $.ajax({
                        // url: GlobalConstant.EmployerRootApi + '/job/' + getUrlParameter('id'), // Uncomment for live API call
                        url: window.location.origin + '/js/minified/test-data/test_emp_tms_id_data.json',
                        method: 'get',
                        headers: {
                            "Authorization": "Bearer " + $cookies.get('token')
                        },
                        async: false,
                        success: function (response) {
                            if (response) {
                                $scope.preload = false;
                            }
                            $scope.JobData = response.data;


                            // console.log("job: ",$scope.JobData);
                            if ($scope.JobData.job_status != 'active' && $scope.JobData.job_status != 'expired') {
                                $scope.draggableCan = false;
                            } else {
                                $scope.draggableCan = true;
                            }

                            var varClosedDate = $scope.JobData.closed_date ? $scope.JobData.closed_date : null;
                            var varClosingDate = $scope.JobData.closing_date ? $scope.JobData.closing_date : null;
                            var varExpiryDate = $scope.JobData.expiry_date ? $scope.JobData.expiry_date : null;
                            var closingLevel = 0;
                            $scope.isExpiredDate = 1;
                            $scope.isClosedDate = 1;
                            $scope.isExpiredNotice = 0;

                            if ($scope.JobData.job_status == 'expired') {
                                closingLevel = 1;
                            } else if ($scope.JobData.job_status == 'closed' || $scope.JobData.job_status == 'hired') {
                                closingLevel = 2;
                            }

                            // console.log(closingLevel);

                            if (varClosedDate) {
                                varClosedDate = new Date(varClosedDate);
                                // varClosedDate = varClosedDate.getDate() + '/' + varClosedDate.getMonth() + '/' + varClosedDate.getFullYear();
                            }

                            if (varClosingDate) {
                                varClosingDate = new Date(varClosingDate);
                            }

                            if (varExpiryDate) {
                                varExpiryDate = new Date(varExpiryDate);
                            }

                            var dDateToday = new Date();
                            if (varClosedDate != null) { // if not null

                                // console.log("manual");
                                $scope.JobData.closing_days_left = 0;

                                if (varExpiryDate < dDateToday) {
                                    $scope.isExpiredNotice = 1; // already expired before the closing date approaches
                                }

                                if (varExpiryDate >= varClosedDate) { // if manual closed
                                    $scope.isExpiredDate = 0; // Role closed before the expiration date
                                }


                                if (varClosedDate <= dDateToday) { // if already closed
                                    $scope.isClosedDate = 0; // hide
                                    $scope.isExpiredDate = 0;
                                    $scope.JobData.closing_date = $scope.JobData.closed_date; // if manually closed
                                }
                            } else { // if closed_date is null, base from other source

                                // console.log("auto");
                                if (varExpiryDate <= dDateToday) { // if auto closed
                                    $scope.isExpiredDate = 0; // just expired
                                    $scope.isExpiredNotice = 1;
                                    // console.log("auto1");
                                }

                                // if(varClosingDate < dDateToday) { // if already closed
                                //   $scope.isClosedDate = 0; // hide
                                //   console.log("auto2");
                                // }

                                if (closingLevel > 1) {
                                    $scope.isClosedDate = 0;
                                    // console.log("auto3");
                                }
                                // console.log(varClosingDate)
                            }

                            setTimeout(function () {
                                $('#TMS__Notification-head').fadeOut('fast');
                            }, 5000);
                        }
                    });
                }

                $scope.$watch('JobData.auto_close', function (newVal, oldVal) {
                    //console.log(oldVal + " " + newVal);
                    //console.log(GlobalConstant.EmployerRootApi + '/job/' + getUrlParameter('id') + '/closing');
                    $http.put(GlobalConstant.EmployerRootApi + '/job/' + getUrlParameter('id') + '/closing', {"auto-close": newVal})
                        .then(function (response) {

                        }, function (response) {
                        });

                });
                $scope.showExpand = "";
                $scope.closeJobReportNotice = false;

                var i = 0, text;
                $scope.RoleExt = [];

                while (i < 31) {
                    i++;
                    text = i == 1 ? i + " day" : i + " days";
                    var val = i;
                    $scope.RoleExt.push({text: text, value: val});
                }

                $scope.RoleExt.push(
                    {text: "45 days", value: 45},
                    {text: "60 days", value: 60},
                    {text: "90 days", value: 90}
                );

                $scope.expExtension = 1;
                $scope.closeExtension = 1;

                //Filter select options
                $scope.sortMyApplicants = "";
                $scope.sortMyApplicantsOpt = [
                    {"key": "", "value": "Sort by"},
                    {"key": "last_name=asc", "value": "Alphabetical [A-Z]"},
                    {"key": "last_name=desc", "value": "Alphabetical [Z-A]"},
                    {"key": "date_applied=asc", "value": "Date Applied [newest]"},
                    {"key": "date_applied=desc", "value": "Date Applied [oldest]"},
                    {"key": "location=asc", "value": "Location - City [A-Z]"},
                    {"key": "location=desc", "value": "Location - City [Z-A]"},
                    {"key": "esp=asc", "value": "Education Service Provider [A-Z]"},
                    {"key": "esp=desc", "value": "Education Service Provider [Z-A]"},
                    {"key": "work_experience=desc", "value": "Work Experience [most]"},
                    {"key": "work_experience=asc", "value": "Work Experience [least]"},
                    {"key": "date_added=asc", "value": "Date Added to Bucket [First- Last]"},
                    {"key": "date_added=desc", "value": "Date Added to Bucket [Last - First]"},
                    {"key": "gpa=desc", "value": "GPA [High - Low]"},
                    {"key": "gpa=asc", "value": "GPA [Low - High]"}
                ];

                $scope.sortMyApplicants = "last_name=asc";
                //$scope.sortMyApplicants = "?last_name=desc";
                $scope.searchApplicants = "";
                $scope.dataLoad = false;
                $scope.nextPrev = [];

                $scope.isSearchBlank = function (searchApplicants) {
                    if (searchApplicants == "") {
                        $scope.searchApplicants = "";
                        $scope.GetTMSSteps($scope.getMyBucketId);
                    }
                }

                $scope.toExtend = false;
                $scope.gpa_values = [
                    {value: 11, text: 'A+'},
                    {value: 10, text: 'A'},
                    {value: 9, text: 'A-'},
                    {value: 8, text: 'B+'},
                    {value: 7, text: 'B'},
                    {value: 6, text: 'B-'},
                    {value: 5, text: 'C+'},
                    {value: 4, text: 'C'},
                    {value: 3, text: 'C-'},
                    {value: 2, text: 'D'},
                    {value: 1, text: 'E'},
                    {value: 0, text: 'F'}
                ];

                $scope.TMSFiltered = function (value, data, type) {
                    // console.log("TMSFiltered ", type);
                    // console.log("filterssss length: ", $scope.tmsfilter.length);
                    $scope.candidatenoretrieved = false;
                    $scope.getApplicants_notloaded = true;
                    $scope.applyingFilters = true;

                    EmployerService.postGetTMSSteps(data, $scope.tmssubparams).then(function (response) {
                        // console.log("tmssteps: ", response);
                        if (response) {
                            $scope.getApplicants_notloaded = false;
                            $scope.applyingFilters = false;

                            // $scope.tmscandidates.push(response.data.candidates);
                            if ($scope.tmscandidates.length > 0 && type == 'filter_call') {
                                // console.log("condi 1");
                                angular.forEach(response.data.candidates, function (val, key) {
                                    $scope.tmscandidates.push(val);
                                });
                            } else if (type != 'filter_call') {
                                // console.log("condi 2");
                                $scope.tmscandidates = response.data.candidates;
                                $scope.tmsfilter = "";
                            } else {
                                // console.log("condi 3");
                                $scope.tmscandidates = response.data.candidates;
                            }

                            if (response.data.candidates.length == 0 && $scope.tmscandidates.length == 0) {
                                $scope.candidatenoretrieved = true;
                            }

                            var applicantdata = {
                                stepid: value.id,
                                applicantCount: value.counter,
                                applicants: $scope.tmscandidates,
                                scrolling: response.data.scrolling
                            };

                            // console.log("applicantdata ", applicantdata);

                            if ($scope.tmsfilter.length == 0) {
                                $scope.tmsfilter = response.data.filters;
                            }

                            if (applicantdata.filters) {
                                delete applicantdata.filters;
                            }

                            if ($scope.tmsfilter) {
                                if ($scope.tmsfilter.esp) {
                                    angular.forEach($scope.tmsfilter.esp, function (val, key) {
                                        if (!val.selected) {
                                            val.selected = false;
                                        }
                                    });
                                }

                                if ($scope.tmsfilter.locations) {
                                    angular.forEach($scope.tmsfilter.locations, function (val, key) {
                                        if (!val.selected) {
                                            val.selected = false;
                                        }
                                    });
                                }

                                if ($scope.tmsfilter.gpa_id) {
                                    angular.forEach($scope.tmsfilter.gpa_id, function (val, key) {
                                        if (!val.selected) {
                                            val.selected = false;
                                        }
                                    });
                                }

                                if ($scope.tmsfilter.work_experience_in_years) {
                                    angular.forEach($scope.tmsfilter.work_experience_in_years, function (val, key) {
                                        if (!val.selected) {
                                            val.selected = false;
                                        }
                                    });
                                }

                                if ($scope.tmsfilter.ratings) {
                                    angular.forEach($scope.tmsfilter.ratings, function (val, key) {
                                        // console.log("show ratings: ", val.name);
                                        // var floatRate = parseFloat(val.id);
                                        // floatRate = floatRate.toFixed(1);
                                        if (!val.selected) {
                                            val.selected = false;
                                        }
                                    });
                                }
                            }


                            $scope.gender = [
                                {id: 1, value: 'male', text: 'Male', selected: false},
                                {id: 2, value: 'female', text: 'Female', selected: false}
                            ];

                            // $scope.tmsSteps.applicantlist.push(applicantdata);
                            $scope.tmsSteps.applicantlist = applicantdata;
                            $scope.dataLoad = false; // hide spinner in buckets
                            // console.log("paking refresh ", $scope.tmsSteps.applicantlist);

                            for (var d = 0; d < $scope.tmsSteps.steps.length; d++) {
                                if ($scope.tmsSteps.steps[d].name != "Long List" && $scope.tmsSteps.steps[d].name != "Short List" && $scope.tmsSteps.steps[d].name != "Interview" && $scope.tmsSteps.steps[d].name != "Hired" && $scope.tmsSteps.steps[d].name != "Not Successful" && $scope.tmsSteps.steps[d].name != "Not Interested") {
                                    $scope.tmsSteps.steps[d].custom = "custom";
                                    $scope.tmsSteps.steps[d].customMsg = "Internal Custom Bucket - Bucket title is NOT visible in the Candidate dashboard";
                                } else {
                                    $scope.tmsSteps.steps[d].custom = "non-custom";
                                    $scope.tmsSteps.steps[d].customMsg = "Standard Bucket - Bucket title is visible in the Candidate dashboard";
                                }
                            }

                            // $scope.prev = 0;

                            // Add initial to be used in default image
                            var b = 1;
                            if ($scope.tmsSteps.applicantlist.applicants.length != 0) {
                                for (var i = 0; i < $scope.tmsSteps.applicantlist.applicants.length; i++) {
                                    if (b >= 5) {
                                        b = 1;
                                    }
                                    if (typeof $scope.tmsSteps.applicantlist.applicants != 'undefined') {
                                        // console.log('ikot: ', $scope.tmsSteps.applicantlist);
                                        $scope.F_initial = $scope.tmsSteps.applicantlist.applicants[i].first_name;
                                        if ($scope.F_initial.indexOf(' ') > 0 && $scope.F_initial.length > 12) {
                                            $scope.tmsSteps.applicantlist.applicants[i].nickname = $scope.F_initial.substr(0, ($scope.F_initial.indexOf(' ')));
                                        } else if ($scope.F_initial.indexOf(' ') <= 0 && $scope.F_initial.length > 12) {
                                            $scope.tmsSteps.applicantlist.applicants[i].nickname = $scope.F_initial.substr(0, 10) + "...";
                                        } else {
                                            $scope.tmsSteps.applicantlist.applicants[i].nickname = $scope.F_initial;
                                        }
                                        $scope.F_initial = $scope.F_initial.substr(0, 1);
                                        $scope.L_initial = $scope.tmsSteps.applicantlist.applicants[i].last_name;
                                        $scope.L_initial = $scope.L_initial.substr(0, 1);
                                        var starate_avg = Math.abs($scope.tmsSteps.applicantlist.applicants[i].ratings.average_rating);
                                        if (starate_avg % 1 == 0) {
                                            $scope.tmsSteps.applicantlist.applicants[i].ratings.average_rating = starate_avg.toFixed(1);
                                        }
                                        $scope.tmsSteps.applicantlist.applicants[i].ratings.star_shade_width = {width: $scope.tmsSteps.applicantlist.applicants[i].ratings.average_rating * 20 + '%'};
                                        ;

                                        //ACP-71
                                        if (i <= ((Object.keys($scope.tmsSteps.applicantlist.applicants).length) - 2)) {
                                            $scope.tmsSteps.applicantlist.applicants[i].next = $scope.tmsSteps.applicantlist.applicants[i + 1].id;
                                            $scope.next = $scope.tmsSteps.applicantlist.applicants[i + 1].id;
                                            $scope.next_obj = $scope.tmsSteps.applicantlist.applicants[i + 1].object_id;
                                        } else {
                                            $scope.tmsSteps.applicantlist.applicants[i].next = 0;
                                            $scope.next = 0;
                                            $scope.next_obj = 0;
                                        }

                                        if (i > 0) {
                                            $scope.tmsSteps.applicantlist.applicants[i].prev = $scope.tmsSteps.applicantlist.applicants[i - 1].id;
                                            $scope.prev = $scope.tmsSteps.applicantlist.applicants[i - 1].id;
                                            $scope.prev_obj = $scope.tmsSteps.applicantlist.applicants[i - 1].object_id;
                                        } else {
                                            $scope.tmsSteps.applicantlist.applicants[i].prev = 0;
                                            $scope.prev_obj = 0;
                                        }

                                        $scope.nextPrev.push({
                                            prev: $scope.prev,
                                            prev_obj: $scope.prev_obj,
                                            current: $scope.tmsSteps.applicantlist.applicants[i].id,
                                            next: $scope.next,
                                            next_obj: $scope.next_obj
                                        });
                                        // ACP-71
                                        //console.log("push: ", $scope.prev + " " + $scope.prev_obj + " " + $scope.tmsSteps.applicantlist[a].applicants[i].id + " " + $scope.next + " " + $scope.next_obj)

                                        $scope.tmsSteps.applicantlist.applicants[i].initial = $scope.F_initial + $scope.L_initial;

                                        // change default photo's background color

                                        if (!$scope.tmsSteps.applicantlist.applicants[i].profile_picture_url) {

                                            if (b == 1) {
                                                $scope.tmsSteps.applicantlist.applicants[i].profile_color = "member-initials--sky";
                                            }
                                            else if (b == 2) {
                                                $scope.tmsSteps.applicantlist.applicants[i].profile_color = "member-initials--pvm-purple";
                                            }
                                            else if (b == 3) {
                                                $scope.tmsSteps.applicantlist.applicants[i].profile_color = "member-initials--pvm-green";
                                            }
                                            else if (b == 4) {
                                                $scope.tmsSteps.applicantlist.applicants[i].profile_color = "member-initials--pvm-red";
                                            }
                                            b++;
                                        }

                                    } else {
                                        // console.log("andefayn");
                                    }
                                }
                                // console.log("ALL SPARK: ", $scope.tmsSteps);
                            } else {
                                // console.log("sero ang count")
                            }

                            // console.log('app list ', $scope.tmsSteps.applicantlist);
                            $scope.bucketStepId = $scope.tmsSteps.steps[0].id;
                            //POpulate Each Card's dropdow with their specific step value
                            if ($scope.tmsSteps.applicantlist.applicants) {
                                //each applicant
                                // console.log("herror app id ", v.applicants);
                                angular.forEach($scope.tmsSteps.applicantlist.applicants, function (val, key) {
                                    var temp_applicant_gpa = "";
                                    var CandidateId = val.id;
                                    if (angular.isDefined(val.docs.icebreaker_video)) {
                                        var CandidateVideo = val.docs.icebreaker_video.doc_url
                                    } else {
                                        var CandidateVideo = null
                                    }

                                    //populate dropdown
                                    var selected_Steps = $filter('filter')($scope.tmsSteps.steps, {id: $scope.tmsSteps.applicantlist.stepid}, true);
                                    angular.forEach(selected_Steps, function (val_index, key_index) {
                                        var index = $scope.tmsSteps.steps.indexOf(val_index);
                                        $scope.selectmove[CandidateId] = $scope.tmsSteps.steps[index];
                                    });

                                    var vidId = 'vid' + CandidateId;
                                    $timeout(function () {
                                        $scope.videoLoaded = false;
                                        if ($('#' + vidId).length) {
                                            var myPlayer = amp(vidId, {
                                                "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                                                "nativeControlsForTouch": false,
                                                autoplay: false,
                                                controls: true,
                                                width: "100%",
                                                height: '500px',
                                                logo: {"enabled": false},
                                                poster: ""
                                            }, function () {
                                                // open camera modal
                                                if ($scope.mobile_agent == false) {
                                                    this.addEventListener('click', function (elm) {
                                                        if (!$(elm.target).hasClass('vjs-control') && !$(elm.target).hasClass('vjs-big-play-button')) {
                                                            // $scope.open_camera();
                                                            $scope.open_camera_new();
                                                        }
                                                    })
                                                    // add an event listener
                                                    this.addEventListener('ended', function () {
                                                    });
                                                }
                                            });

                                            if (CandidateVideo) {
                                                myPlayer.src([{
                                                    src: CandidateVideo,
                                                    type: "application/vnd.ms-sstr+xml"
                                                }]);
                                            } else {
                                                $scope.preview_img = true;
                                            }
                                        }
                                    }, 5000)

                                    angular.forEach(val.answers.job_pre_apply_answer, function (value, key) {
                                        // console.log("faka");
                                        if (value.question.type == 'gpa') {
                                            temp_applicant_gpa = value.answer;
                                            return true;
                                        }
                                    });

                                    angular.forEach($scope.gpa_values, function (value, key) {
                                        if (temp_applicant_gpa != '') {
                                            if (temp_applicant_gpa == value.value) {
                                                var gpa_status = ((temp_applicant_gpa >= 5) ? 'high' : 'low');
                                                gpa_status = 'high';
                                                val.custom_gpa = {value: value.text, status: gpa_status};
                                                return true;
                                            }
                                        }
                                    });
                                });

                            }

                            // console.log('JEPE YAY ', $scope.tmsSteps.applicantlist);
                        } // end if response


                    }, function (error) {
                        $scope.tms_failedstatus = true;
                        $scope.getApplicants_notloaded = false;
                    });
                }

                $scope.GetTMSSteps = function (bucketId, offset, type) {
                    // console.log("GetTMSteps ", bucketId, offset);
                    $scope.tmsSteps = {};
                    $scope.tmsSteps.steps = [];
                    $scope.tmsSteps.applicantlist = '';
                    $scope.tms_failedstatus = false;

                    $.ajax({
                        // url: GlobalConstant.EmployerRootApi + '/tms/' + getUrlParameter('id') + '/steps',
                        url: window.location.origin + '/js/minified/test-data/test_emp_tms_steps_data.json',
                        method: 'get',
                        headers: {
                            "Authorization": "Bearer " + $cookies.get('token')
                        },

                        async: false,
                        success: function (response) {
                            $scope.tmsSteps.steps = response.data;

                            angular.forEach($scope.tmsSteps.steps, function (value, key) {

                                if (angular.isDefined(offset)) {
                                    $scope.offset = offset;
                                } else {
                                    $scope.offset = 0;
                                }
                                $scope.searchApplicants = !$scope.searchApplicants ? '' : $scope.searchApplicants;

                                if (bucketId == value.id) {
                                    if ($scope.currentBucketId != value.id) {
                                        $scope.currentBucketId = value.id;
                                        $scope.tmscandidates = [];
                                        $scope.tmsfilter = "";


                                    }

                                    var data = {
                                        "filters": {},
                                        "query": $scope.searchApplicants,
                                        "sortBy": "last_name",
                                        "sort": "desc",
                                        "offset": $scope.offset ? $scope.offset : 0
                                    };

                                    $scope.tmssubparams = {
                                        jobid: getUrlParameter('id'),
                                        offset: value.id
                                    };

                                    // console.log("TMS Filter params ", $scope.tmssubparams, data);

                                    $scope.filterBucketDtls = value;
                                    $scope.TMSFiltered(value, data, type);
                                }

                                $scope.filterTags = {
                                    Education: '',
                                    Gender: '',
                                    Languages: '',
                                    Experience: '',
                                    Star: ''
                                };
                            });
                        }
                    });
                }

                $scope.newOrder = function (sort) {
                    $scope.sortMyApplicants = sort;
                };

                $scope.getBucketId = function () {
                    $.ajax({
                        // url: GlobalConstant.EmployerRootApi + '/tms/' + getUrlParameter('id') + '/steps',
                        url: window.location.origin + '/js/minified/test-data/test_emp_tms_steps_data.json',
                        method: 'get',
                        headers: {
                            "Authorization": "Bearer " + $cookies.get('token')
                        },
                        async: false,
                        success: function (response) {
                            $scope.tmsBuckets = response.data;

                            for (var i = 0; i < $scope.tmsBuckets.length; i++) {
                                if ($scope.tmsBuckets[i].name == 'Long List') {
                                    $scope.getMyBucketId = $scope.tmsBuckets[i].id;
                                    $scope.GetTMSSteps($scope.getMyBucketId); //
                                    break;
                                }
                            }
                        }
                    });
                }
                $scope.getBucketId();

                // on change of sort dropdown
                // $scope.$watch('sortMyApplicants', function(newVal, oldVal) {
                //   $scope.GetTMSSteps($scope.getMyBucketId);
                //   //console.log($scope.getMyBucketId);
                // });

                // search in applicants
                $scope.findInApplicants = function (findInApplicantsText) {
                    // console.log("findInApplicants ", findInApplicantsText);
                    $scope.searchApplicants = findInApplicantsText;
                    $scope.GetTMSSteps($scope.getMyBucketId);
                }

                //Pagination Functions
                $scope.gotooffset = function (param, tabid) {
                    $scope.GetTMSSteps(param)
                    $timeout(function () {
                        //angular.element( $(".tabsAll") ).tab();
                        angular.element($("#tabnav" + tabid)).trigger("click");
                        // angular.element( $("html, body")).animate({ scrollTop: 0 }, 1000);
                    }, 500);
                    $scope.class = 'activepage'
                }

                // Loadmore Func still in progress
                $scope.LoadMore = function (offset, stepid) {
                    // console.log('LoadMore ', offset, stepid, $scope.applyfilters);
                    var appliedFilters = !$scope.applyfilters ? {} : $scope.applyfilters.filters;

                    var myURL = "";
                    if ($scope.tmsSteps.applicantlist.stepid == stepid) {
                        if (angular.isDefined(offset)) {
                            $scope.offset = offset;
                        } else {
                            $scope.offset = 0;
                        }

                        // =====================================
                        var data = {
                            "filters": appliedFilters,
                            "query": $scope.searchApplicants,
                            "sortBy": "last_name",
                            "sort": "desc",
                            "offset": $scope.offset
                        };

                        $scope.tmssubparams = {
                            jobid: getUrlParameter('id'),
                            offset: stepid
                        };

                        // console.log("TMS Filter params ", $scope.filterBucketDtls, data);

                        // $scope.filterBucketDtls = value;
                        $scope.TMSFiltered($scope.filterBucketDtls, data, 'filter_call');
                    }
                    return false;
                }

                //Drag and drop complete move applicant to step
                $scope.moving = true;
                $scope.onDropComplete = function (data, evt, drop) {
                    // console.log("onDropComplete");
                    //evt.stopPropagation();
                    $scope.showExpand = false;
                    var tabCount = parseInt($.trim($('#count' + drop).text())) + 1;
                    var currenttabCount = parseInt($.trim($('#count' + data[1]).text())) - 1;

                    //Check if being rop to same tab
                    if (data[1] == drop) {
                        alert('Cant move people at the same tab')
                        return false;
                    } else {
                        $("#tabnav" + data[1]).on("click", function () {
                            $(this).addClass('active in');
                        });

                        angular.element($("#expandedSection" + data[1])).tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
                        angular.element($("#expandedSection" + data[1] + " li")).removeClass("ui-corner-top").addClass("ui-corner-left");
                        //angular.element( $( "#expandedSection" )).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                        //angular.element( $( "#expandedSection li" ) ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

                        $scope.moving = false;
                        $http.get(GlobalConstant.EmployerRootApi + '/tms/' + getUrlParameter('id') + '/' + data[0] + '/move/' + drop).then(function (response) {
                            $scope.moving = true;
                            //Animate add count per move
                            $('#count' + drop).text(tabCount);
                            $('#count' + data[1]).text(currenttabCount);
                            //Animate card upon remove
                            $('#app' + data[2]).animate({
                                width: '0',
                                opacity: 0
                            }, function () {
                                $(this).remove();
                            });

                            $scope.tmscandidates = [];
                            // $scope.GetTMSSteps($scope.getMyBucketId);
                            //Go to dropped tab
                            $timeout(function () {
                                angular.element($(".tabsAll")).tab();
                                angular.element($("#tabnav" + data[1])).trigger("click");
                            }, 500);
                            // angular.element( $('.TMS-right-tab')).animate({  width: '90%'    }, 800);
                            // angular.element( $('.TMS-left-tab') ).animate({  width: '10%',  }, 800);
                            //$('#app'+data[2]).clone().insertAfter('#tab'+drop+' .expander');
                            //angular.element ( elem.querySelector('.tab-item:first-child') ).addClass('active in');
                        }, function (response) {
                        });
                    }
                }
                //Dropdown menu move applicant to step
                $scope.selectmove = [];

                $scope.stopExpand = function () {
                    //$event.stopPropagation();
                    $scope.showExpand = false;
                }

                $scope.update = function (ApplicationId, ApplicantId, currentStepId, name) {
                    // console.log("update candidate step");
                    $scope.showExpand = false;
                    var r = confirm("You are about to move this " + name[0] + " " + name[1] + "? Continue?");
                    if (r == true) {
                        var SelectedStepId = $scope.selectmove[ApplicantId].id;
                        //return false
                        var tabCount = parseInt($.trim($('#count' + SelectedStepId).text())) + 1;
                        var currenttabCount = parseInt($.trim($('#count' + currentStepId).text())) - 1;

                        $scope.moving = false;
                        $http.get(GlobalConstant.EmployerRootApi + '/tms/' + getUrlParameter('id') + '/' + ApplicationId + '/move/' + SelectedStepId).then(function (response) {
                            $scope.moving = true;

                            $('#count' + SelectedStepId).text(tabCount);
                            $('#count' + currentStepId).text(currenttabCount);
                            //Animate card upon remove
                            $('#app' + ApplicantId).animate({
                                width: '0',
                                opacity: 0
                            }, function () {
                                $(this).remove();
                            });

                            $scope.tmscandidates = []; // reset candidates collection, it will repopulated
                            // $scope.GetTMSSteps($scope.getMyBucketId);
                            $scope.unexpandme();

                            //Go to dropped tab
                            $timeout(function () {
                                angular.element($(".tabsAll")).tab();
                                angular.element($("#tabnav" + currentStepId)).trigger("click");
                            }, 500);

                        }, function (response) {
                        });
                    } else {
                        return false;
                    }
                };

                $scope.getJobData();
                //$scope.GetTMSSteps(4512);
                //Add notes on enter
                $scope.savenotes = [];
                $scope.publishing = false;

                $scope.notemsg = true;
                $scope.expandedNotes = function (id, applicationId, stepid) {
                    $scope.publishing = true;
                    $scope.datanote = {
                        data: {note: $scope.savenotes[id]}
                    }

                    $http.post(window.location.origin + '/js/minified/test-data/test_emp_tms_notes_data.json')
                        .then(function (response) {
                            $scope.appNotes.splice(0, 1)
                            $scope.getNotes(applicationId)
                            $scope.notemsg = false;
                            var index = $scope.functiontofindIndexByKeyValue($scope.tmsSteps.applicantlist, 'stepid', stepid)

                            angular.forEach($scope.tmsSteps.applicantlist[index].applicants, function (v, k) {
                                if (id == v.id) {
                                    $scope.applicantIndex = k;
                                }
                            });

                            var noteCount = $scope.tmsSteps.applicantlist[index].applicants[$scope.applicantIndex].notes_count;
                            $scope.tmsSteps.applicantlist[index].applicants[$scope.applicantIndex].notes_count = parseInt(noteCount) + 1;
                            $scope.savenotes[id] = '';

                        }, function (response) {
                            //Error Condition
                            //$scope.data = response;
                            $scope.ErrorMsgs = response.data.errors;
                            $scope.preload = true;
                        });
                }
                //Get user Public Profile
                $scope.userPublicProfile = [];
                $scope.appNotes = [];
                $scope.expandloader = false;
                $scope.expvideoLoaded = false;
                $scope.noVideoURL = false;
                $scope.previewDocs = false;
                $scope.previewRes = false;
                $scope.previewTrans = false;
                $scope.previewCover = false;

                //Get Applocant Profile
                $scope.getApplicantProfile = function (userId, stepID, candidateDocs) {
                    // console.log("getApplicantProfile ", userId, stepID, candidateDocs);


                    $scope.userPublicProfile = new Array();
                    $scope.testvidid = $scope.makeRandomId();
                    $scope.testconid = $scope.makeRandomId();

                    angular.forEach($scope.tmsSteps.applicantlist.applicants, function (val, key) { // get docs from updated API
                        if (val.id == userId) {
                            candidateDocs = val.docs;
                        }
                    });
                    // $http.get(GlobalConstant.APIRoot + 'candidate/public/profile/' + userId).then(function (response) { // Uncomment for live API call
                    $http.get(window.location.origin + '/js/minified/test-data/test_emp_tms_candidate_id_data.json').then(function (response) {
                        var data = response.data.data;
                        $scope.userPublicProfile.push({
                            data: data,
                            id: userId
                        });
                        // console.log('userProfile: ', $scope.userPublicProfile);

                        EmployerService.getCandidateRating(userId, $scope.JobData.object_id).then(function (res) {
                            $scope.candidate_rating = res;
                            $scope.candidate_rating.average_rating = res.average_rating.toFixed(1);

                            angular.forEach($scope.ratings, function (val, key) {
                                if (val.value <= $scope.candidate_rating.employer_rating) {
                                    angular.element(document.querySelector('#' + val.class)).css('color', '#ffd700');
                                }
                            });

                            var star_shade_width = $scope.candidate_rating.average_rating * 20;
                            $scope.average_rating_color = {width: star_shade_width + '%'};
                        });

                        if (candidateDocs) {
                            $scope.userPublicProfile[0].docs = candidateDocs;
                        } else {
                            $scope.userPublicProfile[0].docs = [];
                        }
                        // console.log(55,$scope.userPublicProfile[0])

                        var work_history = $scope.userPublicProfile[0].data.work_history;
                        // hide for a while 31618 issue when viewing docs - file not found - permision related
                        //ACP-75 if (typeof $scope.tmsSteps.applicantlist[a].applicants[i] != 'undefined') {

                        if ($scope.userPublicProfile[0].docs) {

                            if ($scope.userPublicProfile[0].docs.resume) {
                                $scope.res_url = $scope.userPublicProfile[0].docs.resume.doc_url ? $scope.userPublicProfile[0].docs.resume.doc_url : "";

                                if ($scope.res_url) {
                                    var temp_resume = '';
                                    $scope.pdfExtRes = $scope.res_url.lastIndexOf('.');
                                    $scope.pdfExtRes = $scope.res_url.substring($scope.pdfExtRes, $scope.res_url.length);
                                    $scope.applicant_resume_url = $scope.userPublicProfile[0].docs.resume.doc_url;

                                    if ($scope.pdfExtRes != ".pdf") {
                                        temp_resume = 'https://view.officeapps.live.com/op/embed.aspx?src=' + $scope.userPublicProfile[0].docs.resume.doc_url;
                                    } else {
                                        temp_resume = $scope.userPublicProfile[0].docs.resume.doc_url + "#zoom=80";
                                    }
                                    var res_str = '<iframe src="' + temp_resume + '" class="printRes" id="printRes' + $scope.userPublicProfile[0].id + '" frameborder="0" onLoad="top.scrollTo(0,0);">Resume</iframe>';
                                    $("#candidate_resume_div").remove('iframe');
                                    $timeout(function () {
                                        $("#candidate_resume_div").html(res_str);
                                    }, 1500);

                                }
                            }
                            if ($scope.userPublicProfile[0].docs.portfolio) {
                                $scope.doc_url = $scope.userPublicProfile[0].docs.portfolio.doc_url ? $scope.userPublicProfile[0].docs.portfolio.doc_url : "";

                                if ($scope.doc_url) {
                                    var temp_portfolio = "";
                                    $scope.pdfExtDoc = $scope.doc_url.lastIndexOf('.');
                                    $scope.pdfExtDoc = $scope.doc_url.substring($scope.pdfExtDoc, $scope.doc_url.length);
                                    $scope.applicant_portfolio_url = $scope.userPublicProfile[0].docs.portfolio.doc_url;

                                    if ($scope.pdfExtDoc != ".pdf") {
                                        temp_portfolio = 'https://view.officeapps.live.com/op/embed.aspx?src=' + $scope.userPublicProfile[0].docs.portfolio.doc_url;
                                    } else {
                                        temp_portfolio = $scope.userPublicProfile[0].docs.portfolio.doc_url + "#zoom=80"
                                    }
                                    var port_str = '<iframe src="' + temp_portfolio + '" class="printRes" id="printRes' + $scope.userPublicProfile[0].id + '" frameborder="0" onLoad="top.scrollTo(0,0);">Resume</iframe>';
                                    $timeout(function () {
                                        $("#candidate_portfolio_div").html(port_str);
                                    }, 1500);

                                }
                            }

                            if ($scope.userPublicProfile[0].docs.transcript) {
                                $scope.trans_url = $scope.userPublicProfile[0].docs.transcript.doc_url ? $scope.userPublicProfile[0].docs.transcript.doc_url : "";

                                if ($scope.trans_url) {
                                    var temp_transcript = "";
                                    $scope.pdfExtTrans = $scope.trans_url.lastIndexOf('.');
                                    $scope.pdfExtTrans = $scope.trans_url.substring($scope.pdfExtTrans, $scope.trans_url.length);
                                    $scope.applicant_transcript_url = $scope.userPublicProfile[0].docs.transcript.doc_url;

                                    if ($scope.pdfExtTrans != ".pdf") {
                                        temp_transcript = 'https://view.officeapps.live.com/op/embed.aspx?src=' + $scope.userPublicProfile[0].docs.transcript.doc_url;
                                    } else {
                                        temp_transcript = $scope.userPublicProfile[0].docs.transcript.doc_url + "#zoom=80"
                                    }
                                    var trans_str = '<iframe src="' + temp_transcript + '" class="printRes" id="printRes' + $scope.userPublicProfile[0].id + '" frameborder="0" onLoad="top.scrollTo(0,0);">Resume</iframe>';
                                    $timeout(function () {
                                        $("#candidate_transcript_div").html(trans_str);
                                    }, 1500);
                                }
                            }
                            // // console.log($scope.userPublicProfile[0].docs.transcript.doc_url,666666);

                            if ($scope.userPublicProfile[0].docs.cover_letter) {
                                $scope.cov_url = $scope.userPublicProfile[0].docs.cover_letter.doc_url ? $scope.userPublicProfile[0].docs.cover_letter.doc_url : "";

                                if ($scope.cov_url) {
                                    var temp_cover = "";
                                    $scope.pdfExtCov = $scope.cov_url.lastIndexOf('.');
                                    $scope.pdfExtCov = $scope.cov_url.substring($scope.pdfExtCov, $scope.cov_url.length);
                                    $scope.applicant_cover_letter_url = $scope.userPublicProfile[0].docs.cover_letter.doc_url;

                                    if ($scope.pdfExtCov != ".pdf") {
                                        temp_cover = 'https://view.officeapps.live.com/op/embed.aspx?src=' + $scope.userPublicProfile[0].docs.cover_letter.doc_url;
                                    } else {
                                        temp_cover = $scope.userPublicProfile[0].docs.cover_letter.doc_url + "#zoom=80"
                                    }
                                    var cover_str = '<iframe src="' + temp_cover + '" class="printRes" id="printRes' + $scope.userPublicProfile[0].id + '" frameborder="0" onLoad="top.scrollTo(0,0);">Resume</iframe>';
                                    $timeout(function () {
                                        $("#candidate_coverletter_div").html(cover_str);
                                    }, 1500);
                                }
                            }
                        }

                        // Add initial to be used in default image
                        var b;
                        b = Math.floor(Math.random() * 5) + 1;

                        $scope.F_initial = $scope.userPublicProfile[0].data.first_name;
                        $scope.F_initial = $scope.F_initial ? $scope.F_initial.substr(0, 1) : '';

                        $scope.L_initial = $scope.userPublicProfile[0].data.last_name;
                        $scope.L_initial = $scope.L_initial ? $scope.L_initial.substr(0, 1) : '';
                        $scope.userPublicProfile[0].data.initial = $scope.F_initial + $scope.L_initial;

                        // change default photo's background color
                        if (!$scope.userPublicProfile[0].data.docs.profile_image) {

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

                        angular.forEach(work_history, function (v, k) {
                            var olddate = v.start_date;
                            var exp_date = olddate.split('-');
                            var newDate = exp_date[1] + '/' + exp_date[1] + '/' + exp_date[2];
                            var setDate = new Date(newDate);
                            angular.extend(v, {filterdate: $filter('date')(setDate, 'longDate')});
                        });


                        if (angular.isDefined(data.docs.icebreaker_video)) {
                            $("#VideoContainer").html("");
                            // console.log("TMS candidate Video: ", data.docs.icebreaker_video);

                            if (data.docs.icebreaker_video.doc_url == '' || !data.docs.icebreaker_video.doc_url) {
                                $scope.noVideoURL = true;
                                $scope.expvideoLoaded = false;
                                $scope.showVideoLoding = false;
                                // console.log("dapat dito");
                            } else {
                                var docurl = data.docs.icebreaker_video.doc_url
                                var docurlcount = docurl.split('/')

                                if (docurlcount.length == 1) {
                                    $scope.showVideoLoding = false;
                                    $scope.ShowVideoError = true;
                                    $scope.expvideoLoaded = false;
                                    $scope.noVideoURL = false;
                                    $scope.errorVideo = data.docs.icebreaker_video.doc_url;
                                    $('#expandedvid_con_' + $scope.testconid + '_' + stepID).hide();
                                } else {
                                    $scope.noVideoURL = false;
                                    var expandedvidcon = 'VideoContainer';
                                    angular.element($('#' + expandedvidcon)).html('');

                                    // console.log(expandedvidcon, ' element has been reset');
                                    $timeout(function () {
                                        var expandedvid = 'expandedvid_' + $scope.testvidid + '_' + stepID;
                                        // var expandedvidcon = 'expandedvid_con_'+$scope.testconid+'_'+stepID;
                                        var CandidateVideo = data.docs.icebreaker_video.doc_url;
                                        var vid_test = '<video id="' + expandedvid + '" class="azuremediaplayer amp-default-skin amp-big-play-centered" style="min-width:220px"  >\
                                      <p class="amp-no-js">\
                                        To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video\
                                      </p>\
                                    </video>';


                                        angular.element($('#' + expandedvidcon)).html(vid_test);
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
                                        }, function () {
                                        });

                                        myPlayer.src([{
                                            src: data.docs.icebreaker_video.doc_url,
                                            type: "application/vnd.ms-sstr+xml"
                                        }]);

                                        // console.log("video container reloaded");
                                    }, 3000);
                                }
                            }
                        }

                        //return data;
                    }, function (response) {
                    });
                    $scope.expandloader = true;
                }

                $scope.updateCandidateRating = function (can_id) {
                    angular.forEach($scope.tmsSteps.applicantlist.applicants, function (val, key) {
                        if (val.id == can_id) {
                            val.ratings.average_rating = $scope.candidate_rating.average_rating;
                            val.ratings.star_shade_width = $scope.average_rating_color;
                            val.ratings.total_emp_rated = $scope.candidate_rating.total_emp_rated;
                        }
                    });
                };

                $scope.rate_candidate = function (d, can_id, jobobj_id) {
                    var arrPromise = [];
                    angular.element(document.querySelectorAll('.rating label')).css('color', '#ddd');

                    var your_rating = {
                        data: {
                            candidate_id: can_id,
                            job_object_id: jobobj_id,
                            rate: d.star
                        }
                    };

                    // console.log('rating candidate ', your_rating);
                    if ($scope.candidate_rating.employer_rating != 0 && d.star != 0) {
                        EmployerService.putCandidateRating(your_rating).then(function (res) {
                            angular.forEach($scope.ratings, function (val, key) {
                                if (val.value <= res.rate) {
                                    angular.element(document.querySelector('#' + val.class)).css('color', '#ffd700');
                                }
                            });
                            $scope.candidate_rating.employer_rating = res.rate;
                            $scope.candidate_rating.total_emp_rated = res.rated_count;
                            $scope.candidate_rating.average_rating = res.average_rating.toFixed(1);
                            var star_shade_width = $scope.candidate_rating.average_rating * 20;
                            $scope.average_rating_color = {width: star_shade_width + '%'};
                            $scope.updateCandidateRating(can_id);
                        });
                    } else {
                        EmployerService.postCandidateRating(your_rating).then(function (res) {
                            $scope.candidate_rating.employer_rating = res.rate;
                            $scope.candidate_rating.average_rating = res.average_rating.toFixed(1);
                            $scope.candidate_rating.total_emp_rated = res.rated_count;
                            var star_shade_width = $scope.candidate_rating.average_rating * 20;
                            $scope.average_rating_color = {width: star_shade_width + '%'};
                            $scope.updateCandidateRating(can_id);
                        });
                    }
                };

                $scope.functiontofindIndexByKeyValue = function (arraytosearch, key, valuetosearch) {
                    for (var i = 0; i < arraytosearch.length; i++) {
                        if (arraytosearch[i][key] == valuetosearch) {
                            return i;
                        }
                    }
                    return null;
                }

                //Get Notes
                $scope.getNotes = function (applicationId) {
                    $http.get(window.location.origin + '/js/minified/test-data/test_emp_tms_notes_data.json').then(function (response) {
                        var data = response.data.data;
                        $scope.appNotes.push({
                            data: data
                        });
                    }, function (response) {
                    })
                }

                //Delete Notes
                $scope.deleteNotes = function (jobObjectId, noteId) {
                    var jobId = getUrlParameter('id')

                    $http.delete(window.location.origin + '/js/minified/test-data/test_emp_tms_notes_data.json')
                        .then(function (response) {
                            var data = response.data.data;
                            var index = $scope.functiontofindIndexByKeyValue($scope.appNotes[0].data.notes, 'id', noteId);
                            $scope.appNotes[0].data.notes.splice(index, 1);
                            //return data;
                        }, function (response) {
                        });
                }

                $scope.cancelNote = function (id) {
                    $scope.savenotes[id] = ''
                }

                $scope.makeRandomId = function () {
                    var text = "";
                    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                    for (var i = 0; i < 10; i++) {
                        text += possible.charAt(Math.floor(Math.random() * possible.length));
                    }
                    return text;
                }


                $scope.questions = []
                //GetPre Application Questions and Standard Questions
                $scope.ProfileQuestions = function (jobId, jobObjectId, stepID) {
                    var myPlayer = "";
                    $scope.candidate_gpa = '';
                    $http.get(window.location.origin + '/js/minified/test-data/test_emp_tms_answers_data.json')
                        .then(function (response) {
                            var data = response.data.data;
                            $scope.questions = data;
                            // console.log("Profile Questions ", $scope.questions);

                            angular.forEach($scope.questions.application_questions, function (v, k) {
                                if (v.answer_type == 'file_upload') {
                                    //ACP-75
                                    $scope.doc_url = v.answer.doc_url;
                                    $scope.pdfExtQue = $scope.doc_url.lastIndexOf('.');
                                    $scope.pdfExtQue = $scope.doc_url.substring($scope.pdfExtQue, $scope.doc_url.length);

                                    if ($scope.pdfExtQue != ".pdf") {
                                        v.answer.doc_url = 'https://view.officeapps.live.com/op/embed.aspx?src=' + v.answer.doc_url;
                                    }

                                    //v.answer.doc_url = 'https://view.officeapps.live.com/op/embed.aspx?src=' + v.answer.doc_url;
                                } else if (v.answer_type == 'video') {
                                    v.video_id = $scope.makeRandomId();

                                    if (v.answer.doc_url == 'pending_doc_url') {
                                        v.poster = true;
                                    } else {
                                        $timeout(function () {
                                            var expandedvid = 'video_answer_' + v.video_id + '_' + stepID;
                                            var expandedvidcon = 'video_answer_con' + v.video_id + '_' + stepID;
                                            var vid_test = '<video id="' + expandedvid + '" class="azuremediaplayer amp-default-skin amp-big-play-centered"  style="min-width:250px; min-height: 181px">\
                                      <p class="amp-no-js">\
                                        To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video\
                                      </p>\
                                    </video>';

                                            $('#' + expandedvidcon).html(vid_test);

                                            $scope.expvideoLoaded = false;
                                            v.answer.doc_amp_instance = amp(expandedvid, {
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
                                            }, function () {
                                            });
                                            v.answer.doc_amp_instance.src([{
                                                src: v.answer.doc_url,
                                                type: "application/vnd.ms-sstr+xml"
                                            }]);
                                        }, 3000)

                                    }
                                } else if (v.answer_type == 'multiple_choice') {
                                    var temp_stringify = JSON.parse(v.answer);
                                    v.answer = temp_stringify[0];
                                    // console.log("medefeke: ",v);
                                }
                            });

                            angular.forEach($scope.questions.pre_apply_questions, function (val, key) {
                                // console.log(3333, val.type)
                                // console.log(val.answer == 10)
                                if (val.type == 'gpa') {
                                    switch (val.answer) {
                                        case '11':
                                            val.answer = 'A+';
                                            break;
                                        case '10':
                                            val.answer = 'A';
                                            break;
                                        case '9':
                                            val.answer = 'A-';
                                            break;
                                        case '8':
                                            val.answer = 'B+';
                                            break;
                                        case '7':
                                            val.answer = 'B';
                                            break;
                                        case '6':
                                            val.answer = 'B-';
                                            break;
                                        case '5':
                                            val.answer = 'C+';
                                            break;
                                        case '4':
                                            val.answer = 'C';
                                            break;
                                        case '3':
                                            val.answer = 'C-';
                                            break;
                                        case '2':
                                            val.answer = 'D';
                                            break;
                                        case '1':
                                            val.answer = 'E';
                                            break;
                                        case '0':
                                            val.answer = 'F';
                                            break;
                                        default:
                                            val.answer = 'Something is wrong with the data. Please contact PreviewMe.'
                                    }

                                    $scope.candidate_gpa = val.answer;
                                }
                                // console.log(val.answer)
                            });

                            $scope.$watch('allVideoKill', function (newVal, oldVal) { //dispose all sq videos when vcard is closed
                                if (newVal) {
                                    angular.forEach($scope.questions.application_questions, function (val, key) {
                                        if (val.answer_type == 'video') {
                                            if (val.answer.doc_amp_instance) {
                                                val.answer.doc_amp_instance.dispose();
                                            }
                                        }
                                    });
                                }
                            });
                        });
                };

                $scope.$watch('expandloader', function (newVal, oldVal) {
                    if (angular.isUndefined(newVal) == false) {
                        $scope.expandloader = newVal
                    }
                });

                $scope.showMyProfile = false;
                //Expand Click
                $scope.expanded = false;
                $scope.isDetailOn = false;
                $scope.expanded_appId = 0;
                $scope.docs_candidate = {
                    resume: "",
                    portfolio: "",
                    transcript: "",
                    cover: ""
                };

                $scope.expandme = function (candidate, stepId, applicationId, printOption, $event, seeNotes) {
                    // console.log("expand me: ", candidate, stepId, applicationId, printOption, $event, seeNotes);

                    $scope.expanded_appId = stepId;
                    // $scope.messageModalLarge = true; // activate vcard modal
                    // $scope.animateShowModal = true;
                    // $scope.docs_candidate = angular.copy($scope.orig_docs_candidate);
                    $scope.showFilter = false;
                    $scope.star = 0;
                    if (candidate.id) {
                        var id = candidate.id;
                    } else {
                        var id = candidate;
                    }
                    // console.log(44, candidate);

                    $event.stopPropagation();
                    $event.preventDefault();
                    $scope.isDetailOn = true;
                    $scope.activeCandidate = id;
                    var setTop;

                    if (seeNotes) {
                        setTop = 1220;
                    } else {
                        setTop = 520;
                    }

                    $('#tabs-1, #tabs-2, #tabs-3, #tabs-4, #prime_lang, #prime_loc, #prime_esp').TrackpadScrollEmulator();
                    var JobId = getUrlParameter('id');
                    //angular.element( $( "#app"+id+"" )).css( "visibility", "hidden" );
                    //Jquery Animation stuff
                    $scope.userPublicProfile = [];
                    $scope.appNotes = [];
                    $scope.getApplicantProfile(id, stepId, candidate.docs);
                    $scope.allVideoKill = false;
                    $scope.getNotes(applicationId);
                    $scope.ProfileQuestions(JobId, applicationId, stepId);

                    // console.log("work ekspee ", candidate);
                    if (candidate.application) $scope.candidate_workexp = candidate.application.work_exp.years;
                    setTimeout(function () {
                        $scope.showMyProfile = true;
                        $scope.showExpand = true;

                        //ACP-75
                        $scope.showPreviewDocs = function () {
                            $scope.previewDocs = !$scope.previewDocs;
                            $scope.previewRes = false;
                            $scope.previewTrans = false;
                            $scope.previewCover = false;
                        };

                        $scope.showPreviewRes = function () {
                            $scope.previewRes = !$scope.previewRes;
                            $scope.previewDocs = false;
                            $scope.previewTrans = false;
                            $scope.previewCover = false;
                        };

                        $scope.showPreviewTrans = function () {
                            $scope.previewTrans = !$scope.previewTrans;
                            $scope.previewRes = false;
                            $scope.previewDocs = false;
                            $scope.previewCover = false;
                        };

                        $scope.showPreviewCover = function () {
                            $scope.previewCover = !$scope.previewCover;
                            $scope.previewRes = false;
                            $scope.previewDocs = false;
                            $scope.previewTrans = false;
                        };

                        $scope.hidePreviews = function (show) {
                            if (show == false) {
                                $scope.previewRes = false;
                                $scope.previewDocs = false;
                                $scope.previewTrans = false;
                                $scope.previewCover = false;
                            } else if (show == true) {
                                $scope.previewRes = true;
                            }
                        };

                        $scope.printMe = function (id) {
                            /*var iFrameRes = document.getElementById('printRes'+id);
              iFrameRes.contentWindow.print();
              var iFrameDocs = document.getElementById('printDocs'+id);
              iFrameDocs.contentWindow.print();*/ //ACP-70
                            window.print();
                        };

                        // angular.element($("#expandedSection" + stepId)).tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
                        angular.element($("#expandedSection" + stepId)).addClass("ui-tabs-vertical ui-helper-clearfix");
                        angular.element($("#expandedSection" + stepId + " li")).removeClass("ui-corner-top").addClass("ui-corner-left");
                        angular.element($("#expandedSection" + stepId + " .dataContainer")).css("height", "700px");
                        // angular.element( $("html, body")).animate({ scrollTop: setTop }, 1000);
                        angular.element($('.expander .profile_container')).css('display', 'block');
                        angular.element($('.expander')).animate({
                            opacity: 1,
                            position: 'relative'
                        }, function () {
                            //add class after expands
                            angular.element($(this)).addClass('expanded cloned');
                            angular.element($('[data-toggle="tooltip"]')).tooltip();

                            if (printOption == true) {
                                angular.element($(this)).addClass("print-profile");
                            }
                            else {
                                angular.element($(this)).removeClass("print-profile");
                            }
                        });

                        $timeout(function () {
                            $('html, body').animate({
                                scrollTop: $("#TMS_expand_card").offset().top
                            }, 1500);
                        }, 50);

                        if (printOption == true) {
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
                }
                // $scope.see_notes = false;

                $scope.expandedData = [];
                $scope.$watch('userPublicProfile', function (newVal, oldVal) {
                    if (angular.isUndefined(newVal) == false) {
                        $scope.userPublicProfile = newVal
                    }
                });

                //Unexpand button
                $scope.unexpandme = function (id, applicantId) {
                    $scope.showMyProfile = false;
                    $scope.userPublicProfile = [];
                    $scope.expandloader = false;
                    angular.element($("#app" + applicantId)).css("visibility", "visible");
                    angular.element($('.expander .profile_container')).css('display', 'none');
                    angular.element($('.expander')).animate({
                        height: 0,
                        opacity: 0
                    }, function () {
                        angular.element($(this)).removeClass('expanded');
                        angular.element($(this)).removeClass('cloned');
                        angular.element($("#expandedSection" + id + " .dataContainer")).css("height", "0");
                        angular.element($("#VideoContainer")).html(" ");
                    });

                    $timeout(function () {
                        $('html, body').animate({
                            scrollTop: $("#app" + applicantId).offset().top
                        }, 100);
                    }, 50);

                    $scope.allVideoKill = true;
                }

                $scope.removeOpened = function (stepId) {
                    $scope.dataLoad = true;
                    $scope.unexpandme();
                    $scope.getMyBucketId = stepId;
                    setTimeout(function () {
                        $scope.GetTMSSteps($scope.getMyBucketId, '', 'step_call');
                        $scope.bucketStepId = stepId;
                        angular.element($('.TMS__email-button')).each(function () {
                            if (angular.element($(this)).hasClass('TMS__email-button' + stepId)) {
                                angular.element($(this)).show();
                            } else {
                                angular.element($(this)).hide()
                            }
                        });
                        $scope.sentmail = true;
                    }, 1000);
                    //console.log($scope.bucketStepId)
                    //Show email bulk button
                }

                $scope.bulkemail = {}
                $scope.bulkEmail = function (stepid, stepname) {
                    $scope.bulkemail.stepid = stepid;
                    $scope.bulkemail.stepname = stepname;
                }

                $scope.sentmail = true;
                $scope.SubmitBulkEmail = function (stepid, jobid) {
                    var data = {
                        data: {
                            email_subject: $scope.email_subject,
                            email_body: $scope.email_body
                        }
                    }

                    $http.post(GlobalConstant.APIRoot + 'employer/tms/' + getUrlParameter('id') + '/bulk-email/' + stepid, data, {headers: {'Content-Type': 'application/json'}})
                        .then(function (response) {
                            angular.element($("#BulkEmailModal")).modal("hide");
                            $scope.emptyBulkEmail();
                            $scope.sentmail = false;

                        }, function (response) {
                        });
                }

                $scope.hideAleart = function () {
                    $scope.sentmail = true
                }

                $scope.emptyBulkEmail = function () {
                    $scope.email_subject = "";
                    $scope.email_body = ""
                }

                //Top right section

                //Get Team Details
                // $http.get(GlobalConstant.APIRoot + 'employer/tms/' + getUrlParameter('id') + '/details') // Uncomment for live API call
                $http.get(window.location.origin + '/js/minified/test-data/test_emp_tms_details_data.json')
                    .then(function (response) {
                        $scope.teams = response.data.data.visibility;
                        $scope.JobCounts = response.data.data.analytics;

                        //console.log("teamyo: ", GlobalConstant.APIRoot + 'employer/tms/' + getUrlParameter('id') + '/details')
                        // Add initial to be used in default image
                        var b = 1;
                        for (var i = 0; i < $scope.teams.members.length; i++) {
                            if (b >= 6) {
                                b = 1;
                            }

                            $scope.F_initial = $scope.teams.members[i].first_name;
                            $scope.F_initial = $scope.F_initial.substr(0, 1);

                            $scope.L_initial = $scope.teams.members[i].last_name;
                            $scope.L_initial = $scope.L_initial.substr(0, 1);

                            $scope.teams.members[i].initial = $scope.F_initial + $scope.L_initial;

                            // change default photo's background color

                            if (!$scope.teams.members[i].profile_picture_url) {

                                if (b == 1) {
                                    $scope.teams.members[i].profile_color = "member-initials--sky";
                                }
                                else if (b == 2) {
                                    $scope.teams.members[i].profile_color = "member-initials--pvm-purple";
                                }
                                else if (b == 3) {
                                    $scope.teams.members[i].profile_color = "member-initials--pvm-green";
                                }
                                else if (b == 4) {
                                    $scope.teams.members[i].profile_color = "member-initials--pvm-red";
                                }
                                else if (b == 5) {
                                    $scope.teams.members[i].profile_color = "member-initials--pvm-yellow";
                                }
                                b++;
                            }
                        }

                        // Add Team initial
                        for (var o = 0; o < $scope.teams.teams.length; o++) {
                            for (var x = 0; x < $scope.teams.teams[o].members.length; x++) {
                                $scope.team_F_initial = $scope.teams.teams[o].members[x].employer.first_name;
                                $scope.team_F_initial = $scope.team_F_initial.substr(0, 1);

                                $scope.team_L_initial = $scope.teams.teams[o].members[x].employer.last_name;
                                $scope.team_L_initial = $scope.team_L_initial.substr(0, 1);

                                $scope.teams.teams[o].members[x].employer.initial = $scope.team_F_initial + $scope.team_L_initial;

                                var color_bg_initial = color_bg_initial_set[Math.floor(Math.random() * color_bg_initial_set.length)];
                                $scope.teams.teams[o].members[x].employer.profile_color = color_bg_initial;
                            }
                        }
                    }, function (response) {
                    });

                $scope.cdrop = true;
                $scope.CloseDrop = function () {
                    $scope.cdrop = $scope.cdrop ? false : true;
                }


                $scope.deleteRole = function (reason) {
                    // var data = {data:{ close_reason: reason }}
                    var data = {reason: reason};

                    $http.put(GlobalConstant.APIRoot + 'employer/job/' + getUrlParameter('id') + '/close', data)
                        .then(function (response) {
                            //alert('Job deleted because it was '+ data.data.close_reason)
                            $window.location.href = base_url + 'employer/company-roles';
                        }, function (response) {
                        });
                }

                $scope.EditRole = function (id) {
                    window.location.href = base_url + 'employer/job/add/employee?id=' + id + '&edit=1';
                }

                $scope.ModalCandidate = '';
                $scope.LoadingModalVid = true;
                $scope.ShowVideoError = false;

                $scope.loadVideo = function (candidate, $event) {
                    $event.preventDefault();
                    $event.stopPropagation();
                    $scope.ModalCandidate = candidate;
                    $scope.randomVidID = $scope.makeRandomId(); //Randomize string to reopen video
                    var loadVideoModal = 'vid' + id + '_' + $scope.randomVidID;
                    var modalVid = '<video id="' + loadVideoModal + '" class="azuremediaplayer amp-default-skin amp-big-play-centered"    >\
                          <p class="amp-no-js">\
                            To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video\
                          </p>\
                        </video>';
                    if (docs.icebreaker_video.doc_id != '' && docs.icebreaker_video.doc_url == '') {
                        $scope.showVideoLoding = true;
                        $scope.LoadingModalVid = false;
                    } else {
                        var docurl = docs.icebreaker_video.doc_url
                        var docurlcount = docurl.split('/')

                        if (docurlcount.length == 1) {
                            $scope.ShowVideoError = true;
                            $scope.LoadingModalVid = false
                            $scope.errorVideo = docs.icebreaker_video.doc_url
                        } else {
                            //Set timeout for bideo to reinsert video player
                            $timeout(function () {
                                //remove loader
                                $scope.LoadingModalVid = false
                                //Insert HTML
                                angular.element('#vidModal .modal-body').html(modalVid);
                                $scope.expvideoLoaded = false;

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
                                }, function () {
                                });

                                //Process video manifest
                                myPlayer.src([{
                                    src: docs.icebreaker_video.doc_url,
                                    type: "application/vnd.ms-sstr+xml"
                                }]);
                                $('#vidModal').modal();
                            }, 2000);
                        }

                    }
                }

                $scope.daysExtend = 1;
                $scope.daysClosing = 1;
                $scope.changeNumberOfDays = function (task, days) {
                    if (task == 'extend') {
                        $scope.daysExtend = days;
                    } else {
                        $scope.daysClosing = days;
                    }
                }

                $scope.extendDates = function (task) {
                    if (task == 'extend') {
                        $scope.expiryData = {
                            'task': task,
                            'days': $scope.daysExtend,
                            'jobid': $scope.JobData.id
                        }

                        EmployerService.putExtendExpiry($scope.expiryData)
                            .then(function (res) {
                                $scope.JobData.expiry_date = EmployerService.updateDate($scope.JobData.expiry_date, $scope.daysExtend);

                                var tmp_expirydays = $scope.JobData.expiry_days_left;
                                tmp_expirydays = parseInt(tmp_expirydays);
                                $scope.JobData.expiry_days_left = tmp_expirydays + $scope.daysExtend;
                            });
                    } else {
                        $scope.closingData = {
                            'task': task,
                            'days': $scope.daysClosing,
                            'jobid': $scope.JobData.id
                        }

                        EmployerService.putExtendClosing($scope.closingData)
                            .then(function (res) {
                                var tmp_closingdays = $scope.JobData.closing_days_left;
                                tmp_closingdays = parseInt(tmp_closingdays);
                                $scope.JobData.closing_days_left = tmp_closingdays + $scope.daysClosing;

                                $scope.JobData.closing_date = EmployerService.updateDate($scope.JobData.closing_date, $scope.daysClosing);
                            });
                    }
                }
            } else {
                alert('No job selected, you will be redirected back to role list page');
                $location.path(base_url + 'employer/company-roles');
            }

            // =====================================
            $scope.gender = [
                {id: 1, value: 'male', text: 'Male', selected: false},
                {id: 2, value: 'female', text: 'Female', selected: false}
            ];


            $scope.primary_lang = [
                {
                    "id": 1,
                    "text": "Afar",
                    "value": "aa",
                    selected: false
                },
                {
                    "id": 2,
                    "text": "Abkhazian",
                    "value": "ab",
                    selected: false
                },
                {
                    "id": 3,
                    "text": "Avestan",
                    "value": "ae",
                    selected: false
                },
                {
                    "id": 4,
                    "text": "Afrikaans",
                    "value": "af",
                    selected: false
                },
                {
                    "id": 5,
                    "text": "Akan",
                    "value": "ak",
                    selected: false
                },
                {
                    "id": 6,
                    "text": "Amharic",
                    "value": "am",
                    selected: false
                },
                {
                    "id": 7,
                    "text": "Aragonese",
                    "value": "an",
                    selected: false
                },
                {
                    "id": 8,
                    "text": "Arabic",
                    "value": "ar",
                    selected: false
                },
                {
                    "id": 9,
                    "text": "Assamese",
                    "value": "as",
                    selected: false
                },
                {
                    "id": 10,
                    "text": "Avaric",
                    "value": "av",
                    selected: false
                },
                {
                    "id": 11,
                    "text": "Aymara",
                    "value": "ay",
                    selected: false
                },
                {
                    "id": 12,
                    "text": "Azerbaijani",
                    "value": "az",
                    selected: false
                },
                {
                    "id": 13,
                    "text": "Bashkir",
                    "value": "ba",
                    selected: false
                },
                {
                    "id": 14,
                    "text": "Belarusian",
                    "value": "be",
                    selected: false
                },
                {
                    "id": 15,
                    "text": "Bulgarian",
                    "value": "bg",
                    selected: false
                },
                {
                    "id": 16,
                    "text": "Bihari languages",
                    "value": "bh",
                    selected: false
                },
                {
                    "id": 17,
                    "text": "Bislama",
                    "value": "bi",
                    selected: false
                },
                {
                    "id": 18,
                    "text": "Bambara",
                    "value": "bm",
                    selected: false
                },
                {
                    "id": 19,
                    "text": "Bengali",
                    "value": "bn",
                    selected: false
                },
                {
                    "id": 20,
                    "text": "Tibetan",
                    "value": "bo",
                    selected: false
                },
                {
                    "id": 21,
                    "text": "Breton",
                    "value": "br",
                    selected: false
                },
                {
                    "id": 22,
                    "text": "Bosnian",
                    "value": "bs",
                    selected: false
                },
                {
                    "id": 23,
                    "text": "Catalan; Valencian",
                    "value": "ca",
                    selected: false
                },
                {
                    "id": 24,
                    "text": "Chechen",
                    "value": "ce",
                    selected: false
                },
                {
                    "id": 25,
                    "text": "Chamorro",
                    "value": "ch",
                    selected: false
                },
                {
                    "id": 26,
                    "text": "Corsican",
                    "value": "co",
                    selected: false
                },
                {
                    "id": 27,
                    "text": "Cree",
                    "value": "cr",
                    selected: false
                },
                {
                    "id": 28,
                    "text": "Czech",
                    "value": "cs",
                    selected: false
                },
                {
                    "id": 29,
                    "text": "Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic",
                    "value": "cu",
                    selected: false
                },
                {
                    "id": 30,
                    "text": "Chuvash",
                    "value": "cv",
                    selected: false
                },
                {
                    "id": 31,
                    "text": "Welsh",
                    "value": "cy",
                    selected: false
                },
                {
                    "id": 32,
                    "text": "Danish",
                    "value": "da",
                    selected: false
                },
                {
                    "id": 33,
                    "text": "German",
                    "value": "de",
                    selected: false
                },
                {
                    "id": 34,
                    "text": "Divehi; Dhivehi; Maldivian",
                    "value": "dv",
                    selected: false
                },
                {
                    "id": 35,
                    "text": "Dzongkha",
                    "value": "dz",
                    selected: false
                },
                {
                    "id": 36,
                    "text": "Ewe",
                    "value": "ee",
                    selected: false
                },
                {
                    "id": 37,
                    "text": "Greek, Modern (1453-)",
                    "value": "el",
                    selected: false
                },
                {
                    "id": 38,
                    "text": "English",
                    "value": "en",
                    selected: false
                },
                {
                    "id": 39,
                    "text": "Esperanto",
                    "value": "eo",
                    selected: false
                },
                {
                    "id": 40,
                    "text": "Spanish; Castilian",
                    "value": "es",
                    selected: false
                },
                {
                    "id": 41,
                    "text": "Estonian",
                    "value": "et",
                    selected: false
                },
                {
                    "id": 42,
                    "text": "Basque",
                    "value": "eu",
                    selected: false
                },
                {
                    "id": 43,
                    "text": "Persian",
                    "value": "fa",
                    selected: false
                },
                {
                    "id": 44,
                    "text": "Fulah",
                    "value": "ff",
                    selected: false
                },
                {
                    "id": 45,
                    "text": "Finnish",
                    "value": "fi",
                    selected: false
                },
                {
                    "id": 46,
                    "text": "Fijian",
                    "value": "fj",
                    selected: false
                },
                {
                    "id": 47,
                    "text": "Faroese",
                    "value": "fo",
                    selected: false
                },
                {
                    "id": 48,
                    "text": "French",
                    "value": "fr",
                    selected: false
                },
                {
                    "id": 49,
                    "text": "Western Frisian",
                    "value": "fy",
                    selected: false
                },
                {
                    "id": 50,
                    "text": "Irish",
                    "value": "ga",
                    selected: false
                },
                {
                    "id": 51,
                    "text": "Gaelic; Scottish Gaelic",
                    "value": "gd",
                    selected: false
                },
                {
                    "id": 52,
                    "text": "Galician",
                    "value": "gl",
                    selected: false
                },
                {
                    "id": 53,
                    "text": "Guarani",
                    "value": "gn",
                    selected: false
                },
                {
                    "id": 54,
                    "text": "Gujarati",
                    "value": "gu",
                    selected: false
                },
                {
                    "id": 55,
                    "text": "Manx",
                    "value": "gv",
                    selected: false
                },
                {
                    "id": 56,
                    "text": "Hausa",
                    "value": "ha",
                    selected: false
                },
                {
                    "id": 57,
                    "text": "Hebrew",
                    "value": "he",
                    selected: false
                },
                {
                    "id": 58,
                    "text": "Hindi",
                    "value": "hi",
                    selected: false
                },
                {
                    "id": 59,
                    "text": "Hiri Motu",
                    "value": "ho",
                    selected: false
                },
                {
                    "id": 60,
                    "text": "Croatian",
                    "value": "hr",
                    selected: false
                },
                {
                    "id": 61,
                    "text": "Haitian; Haitian Creole",
                    "value": "ht",
                    selected: false
                },
                {
                    "id": 62,
                    "text": "Hungarian",
                    "value": "hu",
                    selected: false
                },
                {
                    "id": 63,
                    "text": "Armenian",
                    "value": "hy",
                    selected: false
                },
                {
                    "id": 64,
                    "text": "Herero",
                    "value": "hz",
                    selected: false
                },
                {
                    "id": 65,
                    "text": "Interlingua (International Auxiliary Language Association)",
                    "value": "ia",
                    selected: false
                },
                {
                    "id": 66,
                    "text": "Indonesian",
                    "value": "id",
                    selected: false
                },
                {
                    "id": 67,
                    "text": "Interlingue; Occidental",
                    "value": "ie",
                    selected: false
                },
                {
                    "id": 68,
                    "text": "Igbo",
                    "value": "ig",
                    selected: false
                },
                {
                    "id": 69,
                    "text": "Sichuan Yi; Nuosu",
                    "value": "ii",
                    selected: false
                },
                {
                    "id": 70,
                    "text": "Inupiaq",
                    "value": "ik",
                    selected: false
                },
                {
                    "id": 71,
                    "text": "Ido",
                    "value": "io",
                    selected: false
                }
            ];

            $scope.showFilter = false;
            $scope.filterTags = {
                Education: '',
                Gender: '',
                Languages: '',
                Experience: '',
                Star: ''
            };


            // console.log("genders: ", $scope.genderz);

            $scope.toggleFilter = function () {
                if ($scope.showFilter) {
                    $scope.showFilter = false;
                } else {
                    $scope.showFilter = true;
                }
            }

            $scope.checkChildren = function (category) {
                var arrChildESP = [], arrChildLoc = [], arrChildExp = [], arrChildGPA = [],
                    arrChildStar = [];
                if (category == 'esp') {
                    angular.forEach($scope.tmsfilter.esp, function (itm, key) {
                        itm.selected = $scope.isSelectedEsp;
                        arrChildESP.push(itm.name);
                    });
                    if (!$scope.isSelectedEsp) {
                        $scope.filterTags.Education = '';
                    } else {
                        $scope.filterTags.Education = arrChildESP;
                    }
                } else if (category == 'gen') {
                    angular.forEach($scope.tmsfilter.gender, function (itm) {
                        itm.selected = $scope.isSelectedGender;
                    });
                    if (!$scope.isSelectedGender) {
                        $scope.filterTags.Gender = 0;
                    } else {
                        $scope.filterTags.Gender = $scope.tmsfilter.gender.length;
                    }

                } else if (category == 'lang') {
                    angular.forEach($scope.primary_lang, function (itm) {
                        itm.selected = $scope.isSelectedLanguage;
                    });
                    if (!$scope.isSelectedLanguage) {
                        $scope.filterTags.Languages = 0;
                    } else {
                        $scope.filterTags.Languages = $scope.tmsfilter.primary_lang.length;
                    }
                } else if (category == 'gpa') {
                    angular.forEach($scope.tmsfilter.gpa_id, function (itm) {
                        itm.selected = $scope.isSelectedGPA;
                        arrChildGPA.push(itm.name);
                    });
                    if (!$scope.isSelectedGPA) {
                        $scope.filterTags.GPA = '';
                    } else {
                        $scope.filterTags.GPA = arrChildGPA;
                    }
                } else if (category == 'location') {
                    angular.forEach($scope.tmsfilter.locations, function (itm) {
                        itm.selected = $scope.isSelectedLocation;
                        arrChildLoc.push(itm.name);
                    });
                    if (!$scope.isSelectedLocation) {
                        $scope.filterTags.Locations = '';
                    } else {
                        $scope.filterTags.Locations = arrChildLoc;
                    }
                } else if (category == 'exp') {
                    angular.forEach($scope.tmsfilter.work_experience_in_years, function (itm) {
                        itm.selected = $scope.isSelectedExperience;
                        arrChildExp.push(itm.name);
                    });
                    if (!$scope.isSelectedExperience) {
                        $scope.filterTags.Experience = '';
                    } else {
                        $scope.filterTags.Experience = arrChildExp;
                    }
                } else if (category == 'star') {
                    angular.forEach($scope.tmsfilter.ratings, function (itm) {
                        itm.selected = $scope.isSelectedStar;
                        arrChildStar.push(itm.name);
                    });
                    if (!$scope.isSelectedStar) {
                        $scope.filterTags.Star = '';
                    } else {
                        $scope.filterTags.Star = arrChildStar;
                    }
                }
            };

            $scope.optionToggled = function (cat) {
                var chkCount = 0;
                var strFilteredESP = '', strFilteredLocs = '', strFilteredGPA = '';
                var arrFilteredESP = [], arrFilteredLocs = [], arrFilteredExp = [], arrFilteredGPA = [],
                    arrFilteredStar = [];

                if (cat == 'esp') {
                    if ($scope.tmsfilter.esp) {
                        $scope.isSelectedEsp = $scope.tmsfilter.esp.every(function (itm) {
                            return itm.selected;
                        });
                        angular.forEach($scope.tmsfilter.esp, function (val, key) {
                            if (val.selected) {
                                arrFilteredESP.push(val.name);
                            }
                        });
                        $scope.filterTags.Education = arrFilteredESP;
                    }
                } else if (cat == 'gen') {
                    if ($scope.tmsfilter.gender) {
                        $scope.isSelectedGender = $scope.tmsfilter.gender.every(function (itm) {
                            return itm.selected;
                        });
                        angular.forEach($scope.gender, function (val, key) {
                            if (val.selected) {
                                chkCount++;
                            }
                        });
                        $scope.filterTags.Gender = chkCount;
                    }
                } else if (cat == 'lang') {
                    $scope.isSelectedLanguage = $scope.primary_lang.every(function (itm) {
                        return itm.selected;
                    });
                    angular.forEach($scope.primary_lang, function (val, key) {
                        if (val.selected) {
                            chkCount++;
                        }
                    });
                    $scope.filterTags.Languages = chkCount;
                } else if (cat == 'gpa') {
                    if ($scope.tmsfilter.gpa_id) {
                        $scope.isSelectedGPA = $scope.tmsfilter.gpa_id.every(function (itm) {
                            return itm.selected;
                        });
                        angular.forEach($scope.tmsfilter.gpa_id, function (val, key) {
                            if (val.selected) {
                                arrFilteredGPA.push(val.name);
                            }
                        });
                        $scope.filterTags.GPA = arrFilteredGPA;
                    }
                } else if (cat == 'location') {
                    if ($scope.tmsfilter.locations) {
                        $scope.isSelectedLocation = $scope.tmsfilter.locations.every(function (itm) {
                            return itm.selected;
                        });
                        angular.forEach($scope.tmsfilter.locations, function (val, key) {
                            if (val.selected) {
                                arrFilteredLocs.push(val.name);
                            }
                        });
                        $scope.filterTags.Locations = arrFilteredLocs;
                    }
                } else if (cat == 'exp') {
                    if ($scope.tmsfilter.work_experience_in_years) {
                        $scope.isSelectedExperience = $scope.tmsfilter.work_experience_in_years.every(function (itm) {
                            return itm.selected;
                        });
                        angular.forEach($scope.tmsfilter.work_experience_in_years, function (val, key) {
                            if (val.selected) {
                                arrFilteredExp.push(val.name);
                            }
                        });
                        $scope.filterTags.Experience = arrFilteredExp;
                    }
                } else if (cat == 'star') {
                    if ($scope.tmsfilter.ratings) {
                        $scope.isSelectedStar = $scope.tmsfilter.ratings.every(function (itm) {
                            return itm.selected;
                        });
                        angular.forEach($scope.tmsfilter.ratings, function (val, key) {
                            if (val.selected) {
                                arrFilteredStar.push(val.name);
                            }
                        });
                        $scope.filterTags.Star = arrFilteredStar;
                    }
                }
            };

            $scope.removeFilteredItem = function (dict, itm, filterType) {
                var e = window.event;
                e.cancelBubble = true;
                if (e.stopPropagation) e.stopPropagation();

                var removeItem = dict.indexOf(itm);
                dict.splice(removeItem, 1);

                if (filterType == 'esp') {
                    angular.forEach($scope.tmsfilter.esp, function (val, key) {
                        if (val.name == itm) {
                            val.selected = false
                        }
                    });
                    $scope.isSelectedEsp = $scope.tmsfilter.esp.every(function (itm) {
                        return itm.selected;
                    });
                } else if (filterType == 'loc') {
                    angular.forEach($scope.tmsfilter.locations, function (val, key) {
                        if (val.name == itm) {
                            val.selected = false
                        }
                    });
                    $scope.isSelectedLocation = $scope.tmsfilter.locations.every(function (itm) {
                        return itm.selected;
                    });
                } else if (filterType == 'star') {
                    angular.forEach($scope.tmsfilter.ratings, function (val, key) {
                        if (val.name == itm) {
                            val.selected = false
                        }
                    });
                    $scope.isSelectedStar = $scope.tmsfilter.ratings.every(function (itm) {
                        return itm.selected;
                    });
                } else if (filterType == 'exp') {
                    angular.forEach($scope.tmsfilter.work_experience_in_years, function (val, key) {
                        if (val.name == itm) {
                            val.selected = false
                        }
                    });
                    $scope.isSelectedExperience = $scope.tmsfilter.work_experience_in_years.every(function (itm) {
                        return itm.selected;
                    });
                } else if (filterType == 'gpa') {
                    angular.forEach($scope.tmsfilter.gpa_id, function (val, key) {
                        if (val.name == itm) {
                            val.selected = false
                        }
                    });
                    $scope.isSelectedGPA = $scope.tmsfilter.gpa_id.every(function (itm) {
                        return itm.selected;
                    });
                }

            }

            $scope.ApplyFilter = function () {
                var e = window.event;
                e.cancelBubble = true;
                if (e.stopPropagation) e.stopPropagation();

                var temp_loc = [], temp_gpa = [], temp_esp = [], temp_exp = [], temp_star = [];
                var loopPromise = [];
                $scope.tmsSteps.applicantlist = [];
                $scope.tmscandidates = [];
                $scope.applyfilters = {
                    "query": "",
                    "sortBy": "last_name",
                    "sort": "desc",
                    "offset": "0",
                    "filters": {}
                };


                angular.forEach($scope.tmsfilter.locations, function (val, key) {
                    var deferred = $q.defer();
                    if (val.selected) {
                        temp_loc.push(val.id);
                        loopPromise.push(deferred.promise);
                        deferred.resolve();
                    }
                });

                angular.forEach($scope.tmsfilter.gpa_id, function (val, key) {
                    var deferred = $q.defer();
                    if (val.selected) {
                        temp_gpa.push(val.id);
                        loopPromise.push(deferred.promise);
                        deferred.resolve();
                    }
                });

                angular.forEach($scope.tmsfilter.esp, function (val, key) {
                    var deferred = $q.defer();
                    if (val.selected) {
                        temp_esp.push(val.id);
                        loopPromise.push(deferred.promise);
                        deferred.resolve();
                    }
                });

                angular.forEach($scope.tmsfilter.work_experience_in_years, function (val, key) {
                    var deferred = $q.defer();
                    if (val.selected) {
                        temp_exp.push(val.id);
                        loopPromise.push(deferred.promise);
                        deferred.resolve();
                    }
                });

                angular.forEach($scope.tmsfilter.ratings, function (val, key) {
                    var deferred = $q.defer();
                    if (val.selected) {
                        temp_star.push(parseFloat(val.id));
                        loopPromise.push(deferred.promise);
                        deferred.resolve();
                    }
                });


                if (temp_esp.length > 0) {
                    $scope.applyfilters.filters.esp_id = temp_esp;
                }

                if (temp_loc.length > 0) {
                    $scope.applyfilters.filters.location_id = temp_loc;
                }

                if (temp_gpa.length > 0) {
                    $scope.applyfilters.filters.gpa_id = temp_gpa;
                }

                if (temp_exp.length > 0) {
                    $scope.applyfilters.filters.work_experience_in_years = temp_exp;
                }

                if (temp_star.length > 0) {
                    $scope.applyfilters.filters.ratings = temp_star;
                }

                $q.all(loopPromise).then(function () {
                    $scope.TMSFiltered($scope.filterBucketDtls, $scope.applyfilters, 'filter_call');
                });

                $scope.showFilter = false;
                $scope.unexpandme();
            };

            $scope.filterClearAll = function () {
                angular.forEach($scope.tmsfilter.esp, function (v, k) {
                    v.selected = false;
                });
                angular.forEach($scope.tmsfilter.gpa_id, function (v, k) {
                    v.selected = false;
                });
                angular.forEach($scope.tmsfilter.locations, function (v, k) {
                    v.selected = false;
                });
                angular.forEach($scope.tmsfilter.work_experience_in_years, function (v, k) {
                    v.selected = false;
                });
                angular.forEach($scope.tmsfilter.ratings, function (v, k) {
                    v.selected = false;
                });
                $scope.optionToggled("location");
                $scope.optionToggled("esp");
                $scope.optionToggled("gpa");
                $scope.optionToggled("exp");
                $scope.optionToggled("star");
            };
        }]);

    app.factory('EmployerService', ['$http', 'GlobalConstant', function ($http, GlobalConstant) {
        return {
            postGetTMSSteps: function (data, tmsparams) {
                // var postdata = {data: data};
                // console.log("post tms ", data, tmsparams);
                // return $http.post(GlobalConstant.EmployerRootApi + '/tms/' + tmsparams.jobid + '/applicants/' + tmsparams.offset, data)
                return $http.post(window.location.origin + '/js/minified/test-data/test_emp_tms_applicant_data.json')
                    .then(function (res) {
                        return res.data;
                    });
            },
            putExtendExpiry: function (data) {
                return $http.put(GlobalConstant.EmployerRootApi + '/job/' + data.jobid + '/expiration/extend', {'days': data.days})
                    .then(function (res) {
                        return true;
                    });
            },
            putExtendClosing: function (data) {
                return $http.put(GlobalConstant.EmployerRootApi + '/job/' + data.jobid + '/closing/extend', {'days': data.days})
                    .then(function (res) {
                        return true;
                    });
            },
            updateDate: function (data, days) {
                var arrMonths = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'
                ];
                var arrDays = ['Sun.', 'Mon.', 'Tue.', 'Wed.', 'Thu.', 'Fri.', 'Sat.'];

                var tmp_expiryDate = new Date(data);
                tmp_expiryDate.setDate(tmp_expiryDate.getDate() + days);
                var tmp_expiryMonth = tmp_expiryDate.getMonth();
                var tmp_expiryYear = tmp_expiryDate.getFullYear();
                var tmp_expiryDay = tmp_expiryDate.getDay();
                tmp_expiryDate = tmp_expiryDate.getDate();

                var strDate = arrDays[tmp_expiryDay] + ' ' + tmp_expiryDate + ' ' + arrMonths[tmp_expiryMonth] + ' ' + tmp_expiryYear;
                return strDate;
            },
            getCandidateRating: function (candidateid, jobobj_id) {
                return $http.get(window.location.origin + '/js/minified/test-data/test_emp_tms_candidate_id_data.json')
                // return $http.get('../themes/bbt/js/ng/json/tms_rate_emp.json')
                    .then(function (res) {
                        return res.data.data;
                    });
            },
            postCandidateRating: function (data) {
                // console.log('ratae ', data);
                // return $http.post(GlobalConstant.EmployerRootApi + '/tms/rate/candidate', data) // Uncomment for live API call
                return $http.post(window.location.origin + '/js/minified/test-data/test_emp_tms_rating_data.json')
                // return $http.get('../themes/bbt/js/ng/json/tms_rate_emp.json')
                    .then(function (res) {
                        return res.data.data;
                    });
            },
            putCandidateRating: function (data) {
                // return $http.put(GlobalConstant.EmployerRootApi + '/tms/rate/candidate', data)
                return $http.put(window.location.origin + '/js/minified/test-data/test_emp_tms_rating_data.json')
                // return $http.get('../themes/bbt/js/ng/json/tms_rate_emp.json')
                    .then(function (res) {
                        return res.data.data;
                    });
            }
        }
    }]);
}());

$(document).ready(function () {
    $('.btn-toggle').click(function(){
        $('.tms-toggle__wrap').fadeToggle();
        var click = +$(this).data('clicks') || 0;
        if (click % 2 == 1) {
            $('.btn-toggle').text("- Hide");
        }else{
            $('.btn-toggle').text("+ Show");
        };
        $(this).data('clicks',click+1);
    });
    //  $( "#tabs" ).tabs();
    $('.tabsAll').tab('show');
    $('.sliderContainer, .TMS__applicant-note-scroll, #tabs-1, #tabs-2, #tabs-3, #tabs-4, #prime_lang, #prime_loc, #prime_esp').TrackpadScrollEmulator();
    $('[data-toggle="tooltip"]').tooltip();
    $('.tab-item:first-child').addClass('active in');

    $(".TMS__bucket-list .active .TMS__drop-section-link").attr('ng-drop', 'false');
    $(".tab-nav .active .dropsection").attr('ng-drop', 'false');

    $('.TMS__view-all-link').click(function () {
        var innerHeight = $('.TMS__team-list')[0].scrollHeight;
        // console.log("view all clicked ", innerHeight);
        // console.log($('.TMS__team-list').height());

        if ($('.TMS__team-list').height() <= 190) {
            $('.TMS__team-list').animate({
                height: innerHeight
            }, 1000);
        } else {
            $('.TMS__team-list').animate({
                height: '227px'
            }, 1000);
        }
    });
    $('#vidModal').on('hidden.bs.modal', function () {
        // console.log('closed')
        var vidLoader = '<div class="text-center" ng-show="LoadingModalVid"> \
                        <h3 >Loading Video</h3> \
                        <img src="https://previewme.co/themes/bbt/images/preloader.gif" ng-show="videoLoaded"  width="25px"> \
                      </div>';
        $('#vidModal .modal-body').html(vidLoader);
    });

    //Unsure Tab
    $("#UnsureTab").click(function () {
        if ($('.TMS-content-side').is(':visible')) {
            $(".TMS-content-side").hide('fast')
            $(".TMS-content-side").animate({opacity: 0});
            $('.TMS-left-tab').animate({
                width: '10%',
            }, 800);
            $('#UnsureTabContent').animate({
                left: '-274px',
            }, 800);
            // $('.TMS-right-tab').animate({
            //   width: '90%'
            // }, 800);
            $('.applicantList li.userlist').animate({
                width: '25%'
            }, 800);
            $('.TMS__draft-applicants').animate({
                margin: 'auto -98px auto auto'
            }, 800);
        } else {
            $(".TMS-content-side").show('fast');
            $(".TMS-content-side").animate({opacity: 1});
            $('.TMS-left-tab').animate({
                width: '30%',
            }, 800);
            $('#UnsureTabContent').animate({
                left: 0,
            }, 800);
            // $('.TMS-right-tab').animate({
            //   width: '70%'
            // }, 800);
            $('.applicantList li.userlist').animate({
                width: '33.333%'
            }, 800);
            $('.TMS__draft-applicants').animate({
                margin: 'auto -144px auto auto'
            }, 800);
        }
    });
});
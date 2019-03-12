(function() {
    'use strict';
    var analytics_mod = angular.module('app');
    var base_url = $('body').data('base_url');

    // Add module dependency
    analytics_mod.requires.push('chart.js');

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

    $('.experienceindustry__tripleboxes-boxcontent').TrackpadScrollEmulator();


    analytics_mod.controller('AnalyticsGeneralCtrl', ['GlobalConstant', 'RoleBridge', '$scope', '$timeout', '$rootScope', '$cookies', '$window', '$http', '$filter',
      function(GlobalConstant, RoleBridge, $scope, $timeout, $rootScope, $cookies, $window, $http, $filter) {
        var rolebox = [];
        var role_temp;

        var favoriteCookie = $cookies.getAll();
        // console.log('favoriteCookie: ', favoriteCookie);

        // Get Employer Closed and Expired Roles
        // $http.get('https://previewme.co/app_dev.php/api/v1/employer/analytics/overview/', data)
        $http.get(GlobalConstant.EmployerRootApi + '/analytics/roles/310')
        .then(function(response) {
          $scope.rolesdata = response.data.data;

          angular.forEach($scope.rolesdata, function(value, key) {
            rolebox.push({
              "object_id" : value.id,
              "job_title" : value.job_title,
              "job_status" : value.job_status
            });
          });
          $scope.employerroles = rolebox;
        });

        $scope.rolechange = function () { // root declaration
          $scope.selectedRole_obj = {};

          angular.forEach($scope.employerroles, function (value, key) {
            if (value.object_id == $scope.selectedRole) {
              $scope.selectedRole_obj = {
                "id" : value.object_id,
                "job_status" : value.job_status
              }
            }
          });

          RoleBridge.set($scope.selectedRole_obj);
          $rootScope.rolebridge = RoleBridge.get();
        }

        // $timeout(function () {
        //   $window.print();
        // });

        $scope.printFunc = function () {
          // console.log('printing');
          $window.print();
        }
      }
    ]);

    analytics_mod.controller('OverviewCtrl', ['GlobalConstant', 'RoleBridge', 'analyticsSvcs', '$scope', '$rootScope', '$cookies', '$window', '$http', '$filter', '$timeout', '$location',
      function(GlobalConstant, RoleBridge, analyticsSvcs, $scope, $rootScope, $cookies, $window, $http, $filter, $timeout, $location) {

        // root watcher
        $scope.$watch(function() {
          return $rootScope.rolebridge;
        }, function (newVal, oldVal) {
          if ($rootScope.rolebridge) {
            $scope.currentRole_overview = $rootScope.rolebridge.id;
            $scope.job_status = $rootScope.rolebridge.job_status;

            if ($scope.currentRole_overview != undefined ) {
              $scope.switch_overview = 1;
              analyticsSvcs.getOverview($scope.currentRole_overview).then(function(res) {
                $scope.overview_main = res;
              });
            } else {
              $scope.switch_overview = 0;
            }
          }
        }, true);

        // Watching main scope for this ctrl
        $scope.$watch('overview_main', function () {
          var temp_totalAppPie = [];

          if ($scope.job_status == 'expired') {
            $scope.job_show = 1;
          } else {
            $scope.job_show = 2;
          }

          if ($scope.overview_main != null) {
            $scope.bubble_datatest = {};
            // $scope.closed_reason = 'Role filled elsewhere';

            var tempbubble = [];
            var tempbubble_series = [];
            // console.log('$scope.overview_main: ',$scope.overview_main);

            $scope.overview_listedDtls = $scope.overview_main.overview_of_listed_role[0];
            $scope.overview_projtimeline = $scope.overview_main.project_timeline;

            var formatted_role_closed = new Date($scope.overview_projtimeline.formatted_role_closed);
            var formatted_role_expired = new Date($scope.overview_projtimeline.formatted_role_expiry);
            $scope.isClosedBeforeExpiry = formatted_role_closed <= formatted_role_expired ? 1 : 0;

            // Team Overview header ===============
            var team_arr = [];
            angular.forEach($scope.overview_listedDtls.team_members, function(value, key) {
              team_arr.push({"name" : value});
            });

            if (team_arr.length > 0) {
              $scope.teams = team_arr;
              $scope.prime_member = $scope.teams[0].name;
              $scope.teams.splice(0, 1);
              $scope.team_length = $scope.teams.length;
            }

            // source clicks ===============
            $scope.source_clicks = $scope.overview_main.source_clicks;

            // job list engagement ===============
            $scope.days = $scope.overview_main.job_listing_engagement.days;

            angular.forEach($scope.days, function(value, key) {
              tempbubble.push([{
                'x': value.day,
                'y': value.time,
                'r': value.qty
              }]);
              tempbubble_series.push([
                'Day ' + value.day + ', ' + value.time + value.meridian.toLowerCase() + ', Applications: ' + value.qty + ' '
              ]);
            });

            $scope.bubble_colors = [{
              backgroundColor: 'rgb(53, 204, 204)',
              pointBackgroundColor: 'rgb(53, 204, 204)',
              pointHoverBackgroundColor: 'rgb(53, 204, 204)',
              borderColor: 'rgb(53, 204, 204)',
              pointBorderColor: '#fff',
              pointHoverBorderColor: 'rgb(53, 204, 204)'
            }];

            $scope.bubble_series = tempbubble_series;
            $scope.bubble_datatest = tempbubble;

            $scope.bubble_options = {
              legend: {
                display: false
              },
              tooltips: {
                callbacks:{
                  label: function(x, tempbubble_series) {
                    var newTooltip = new Array();

                    for (var a = 0; a < tempbubble_series.datasets.length; a++) {
                      for (var b = 0; b < tempbubble_series.datasets[a].label.length; b++) {
                        newTooltip.push(tempbubble_series.datasets[a].label[b]);
                      }
                    }
                    return newTooltip;
                  }
                }
              },
              scales: {
                yAxes: [{
                  ticks: {
                    min: 0,
                    stepSize: 1,
                    callback: function (value, index, collection) {
                      if (value == 0) {
                        return value;
                      } else {
                        return value + " pm";
                      }
                    }
                  },
                  scaleLabel: {
                    display: true,
                    labelString: "Time"
                  }
                }],
                xAxes: [{
                  ticks: {
                    min: 0,
                    max: 31,
                    stepSize: 1
                  },
                  scaleLabel: {
                    display: true,
                    labelString: "Day"
                  }
                }]
              }
            };



            // Pie chart Applications ===============
            if (!$scope.overview_main.total_applications) {
              $scope.overview_main.total_applications = 0;
            }

            if (!$scope.overview_main.total_completed_applications) {
              $scope.overview_main.total_completed_applications = 0;
            }
            temp_totalAppPie.push($scope.overview_main.total_completed_applications);

            if (!$scope.overview_main.failed_pre_application_questions) {
              $scope.overview_main.failed_pre_application_questions = 0;
            }
            temp_totalAppPie.push($scope.overview_main.failed_pre_application_questions);

            if (!$scope.overview_main.incomplete_applications) {
              $scope.overview_main.incomplete_applications = 0;
            }
            temp_totalAppPie.push($scope.overview_main.incomplete_applications);
            $scope.totalapp_pie = temp_totalAppPie;

            // print all ===============
            $scope.printOverview = function () {
              $window.print();
            }

            // print per tab
            // $scope.printOverview = function() {
            //   var printHtml = '';
            //   var printContents = document.getElementById('AnalyticsOverviewInner').innerHTML;
            //   var popupWin = window.open('', '_blank', 'width=600,height=600');

            //   printHtml = '<html>';
            //   printHtml = printHtml + '<head>';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/minified/style.min.css?ver=3.2.1" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/minified/custom.min.css?ver=2.4" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/bootstrap.min.css?ver=3.3.6" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css?ver=1.11.4" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/css_loader.css" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/font-awesome.css?ver=4.6.1" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/keyFrameAnimation.css" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/homepage.css?ver=1.1" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/icomoon.css?ver=1" />';
            //   printHtml = printHtml + '<link rel="stylesheet" type="text/css" href="../../themes/bbt/css/media-queries.min.css?ver=1.0.9" />';
            //   printHtml = printHtml + '<link href="//amp.azure.net/libs/amp/latest/skins/amp-default/azuremediaplayer.min.css?ver=1" rel="stylesheet">';

            //   printHtml = printHtml + '</head>';
            //   printHtml = printHtml + '<body onload="window.print()">';
            //   printHtml = printHtml + printContents;
            //   printHtml = printHtml + '</body></html>';
            //   popupWin.document.open();
            //   popupWin.document.write(printHtml);
            //   // popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
            //   popupWin.document.close();
            // }
          }
        });

        // applications pie chart
        $scope.totalapp_labels = ["Completed Application", "Failed Pre-Application Questions", "Incomplete Applications"];
        $scope.colors = [
          {
            backgroundColor: 'rgb(53, 204, 204)',
            pointBackgroundColor: 'rgb(53, 204, 204)',
            pointHoverBackgroundColor: 'rgb(53, 204, 204)',
            borderColor: 'rgb(53, 204, 204)',
            pointBorderColor: '#fff',
            pointHoverBorderColor: 'rgb(53, 204, 204)'
          },
          {
            backgroundColor: 'rgb(205, 121, 255)',
            pointBackgroundColor: 'rgb(205, 121, 255)',
            pointHoverBackgroundColor: 'rgb(205, 121, 255)',
            borderColor: 'rgb(205, 121, 255)',
            pointBorderColor: '#fff',
            pointHoverBorderColor: 'rgb(205, 121, 255)'
          },{
            backgroundColor: 'rgba(255, 81, 89, 1)',
            pointBackgroundColor: 'rgba(255, 81, 89, 1)',
            pointHoverBackgroundColor: 'rgba(255, 81, 89, 1)',
            borderColor: 'rgba(255, 81, 89, 1)',
            pointBorderColor: '#fff',
            pointHoverBorderColor: 'rgba(255, 81, 89, 1)'
          }
        ];
      }
    ]);

    analytics_mod.controller('SourceEducationCtrl', ['GlobalConstant', 'RoleBridge', 'analyticsSvcs', '$scope', '$rootScope', '$cookies', '$window', '$http', '$filter', '$timeout', '$location',
    	function(GlobalConstant, RoleBridge, analyticsSvcs, $scope, $rootScope, $cookies, $window, $http, $filter, $timeout, $location) {
        var arrColors = [ "#EF5350", "#EC407A", "#AB47BC", "#7E57C2", "#5C6BC0", "#42A5F5", "#29B6F6", "#26C6DA", "#26A69A", "#66BB6A", "#9CCC65", '#D4E157',
          "#FFEE58", "#FFCA28", "#FFA726", "#FF7043", "#8D6E63", "#BDBDBD", "#78909C"
        ];


        $scope.$watch(function() {
          return $rootScope.rolebridge;
        }, function (newVal, oldVal) {
          // console.log('SourceEducation | being watched oldValue:', oldVal, 'newValue:', newVal);
          if ($rootScope.rolebridge) {
            $scope.currentRole_sourceed = $rootScope.rolebridge.id;
            $scope.job_status = $rootScope.rolebridge.job_status;

            if ($scope.currentRole_sourceed != undefined) {
              $scope.switch_sourceed = 1;
              analyticsSvcs.getSourceEd($scope.currentRole_sourceed).then(function(res) {
                $scope.sourceed_main = res;
              });
            } else {
              $scope.switch_sourceed = 0;
            }
          }

        }, true);

        $scope.$watch('sourceed_main', function () {
          if ($scope.sourceed_main != null) {
            $scope.allcandidatepie={};
            var pielabels = [];
            var piedata = [];
            var piecolors = [];

            if ($scope.job_status == 'expired') {
              $scope.job_show = 1;
            } else  {
              $scope.job_show = 2;
            }
            // console.log("$scope.job_show TAB2: ", $scope.job_show);

            // All Candidate Pie
            $scope.allcandidate_rec = $scope.sourceed_main.all_candidate_regions;
            if ($scope.allcandidate_rec ) {
              var colorCtr = 0;

              angular.forEach($scope.allcandidate_rec, function(value, key){
                pielabels.push(value.name);
                piedata.push(value.count);

                // construct hexes
                // var hexColor = getRandomColor();
                value.color = arrColors[colorCtr];
                piecolors.push(value.color);

                colorCtr += 1;
              });

              $scope.allcandidatepie={
                "labels":pielabels,
                "data":piedata,
                "colors":piecolors
              };
            } else {
              // do something later
            }

            $scope.education_service_providers = $scope.sourceed_main.education_service_providers;
            if ($scope.education_service_providers) {
              var school_labels = [];
              var completed = [];
              var failed = [];
              var incomplete = [];
              var totalapps_data = [];

              angular.forEach($scope.education_service_providers, function(value, key) {
                school_labels.push(value.school);
                completed.push(value.completed);
                failed.push(value.failed);
                incomplete.push(value.incomplete);
              });

              totalapps_data.push(completed);
              totalapps_data.push(failed);
              totalapps_data.push(incomplete);

              $scope.application_series = ['Completed', 'Failed', 'Incomplete'];

              $scope.totalapps = {
                'school_label': school_labels,
                'status_series': $scope.application_series,
                'app_data':totalapps_data
              }

            } else {
              // do something later
            }

            // key breakdown form tab
            // highest
            $scope.key_and_breakdown = $scope.sourceed_main.key_and_breakdown;
            if ($scope.key_and_breakdown) {
              $scope.highest_universities = $scope.key_and_breakdown.highest;
              $scope.lowest_universities = $scope.key_and_breakdown.lowest;

              angular.forEach($scope.highest_universities, function (value, key) {
               if (value.status == 'completed') {
                  $scope.high_completed_school = value.school;
                  $scope.high_completed_status = value.status;
                  $scope.high_completed_percentage = value.percent;
                }

                if (value.status == 'failed') {
                  $scope.high_failed_school = value.school;
                  $scope.high_failed_status = value.status;
                  $scope.high_failed_percentage = value.percent;
                }

                if (value.status == 'incomplete') {
                  $scope.high_incomplete_school = value.school;
                  $scope.high_incomplete_status = value.status;
                  $scope.high_incomplete_percentage = value.percent;
                }
              });

              // lowest
              angular.forEach($scope.lowest_universities, function(value, key) {
                if (value.status == 'completed') {
                  $scope.low_completed_school = value.school;
                  $scope.low_completed_status = value.status;
                  $scope.low_completed_percentage = value.percent;
                }

                if (value.status == 'failed') {
                  $scope.low_failed_school = value.school;
                  $scope.low_failed_status = value.status;
                  $scope.low_failed_percentage = value.percent;
                }

                if (value.status == 'incomplete') {
                  $scope.low_incomplete_school = value.school;
                  $scope.low_incomplete_status = value.status;
                  $scope.low_incomplete_percentage = value.percent;
                }
              });
            }
          }
        });

        function getRandomColor() {
          var letters = '0123456789ABCDEF';
          var color = '#';
          for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
          }
          return color;
        }

        // Total Applications Graph
			  $scope.colours = [
          {
  		      backgroundColor:"#35cccc",
  		      hoverBackgroundColor:"#35cccc",
  		      borderColor:"#35cccc",
  		      hoverBorderColor:"#35cccc"
  				},
          {
            backgroundColor:"#9755d4",
            hoverBackgroundColor:"#9755d4",
            borderColor:"#9755d4",
            hoverBorderColor:"#9755d4"
          },
          {
            backgroundColor:"#FF5159",
            hoverBackgroundColor:"#FF5159",
            borderColor:"#FF5159",
            hoverBorderColor:"#FF5159"
          }
        ];


    	}
    ]);

    analytics_mod.controller('ExpeienceClassificationCtrl', ['GlobalConstant', 'RoleBridge', 'analyticsSvcs', '$scope', '$rootScope', '$cookies', '$window', '$http', '$filter', '$timeout', '$location',
      function(GlobalConstant, RoleBridge, analyticsSvcs, $scope, $rootScope, $cookies, $window, $http, $filter, $timeout, $location) {

        $scope.$watch(function() {
          return $rootScope.rolebridge;
        }, function () {
          // console.log('$scope.currentRole: ', $scope.currentRole_expclassification);
          if ($rootScope.rolebridge) {
            $scope.currentRole_expclassification = $rootScope.rolebridge.id;
            $scope.job_status = $rootScope.rolebridge.job_status;

            if ($scope.currentRole_expclassification != undefined) {
              $scope.switch_expclassification = 1;
              analyticsSvcs.getExpIndustry($scope.currentRole_expclassification).then(function(res) {
                $scope.expclassification_main = res;
              });
            } else {
              $scope.switch_expclassification = 0;
            }
          }
        }, true);

        $scope.$watch('expclassification_main', function () {
          if ($scope.expclassification_main) {
            var pielabels = [];
            var piedata = [];
            var piecolors = [];
            var pieoptions = [];

            $scope.allcandidatepie = {
              "labels":"",
              "data":"",
              "colors":"",
              "options": ""
            };

            if ($scope.job_status == 'expired') {
              $scope.job_show = 1;
            } else {
              $scope.job_show = 2;
            }


            $scope.industries_that_featured_pie_chart = {};
            $scope.highestpercentage_pie = 0;

            $scope.expclassification = $scope.expclassification_main.experience_in_classifications;
            if (!$scope.expclassification.parent) {
              $scope.switch_classexp = 0;
            } else {
              $scope.switch_classexp = 1;
            }

            $scope.yrs = $scope.expclassification_main.years_exp_looking_for;

            // industries that featured
            $scope.industries_that_featured = $scope.expclassification_main.industries_that_featured;
            $scope.srate = $scope.expclassification_main.strike_rate;
            $scope.experiencedppl = $scope.expclassification_main.total_number_of_people_who_completed_an_application_with_experience_in_the_role_classification;
            $scope.experiencedppl_percent = $scope.expclassification_main.total_number_of_people_who_completed_an_application_with_experience_in_the_role_classification_percent
            $scope.otherindustries = $scope.expclassification_main.other_industries_that_featured;

            $scope.switch_otherindustries = 1;
            if (!$scope.otherindustries) {
              $scope.switch_otherindustries = 0;
            }

            // pie chart
            $scope.industries_that_featured_pie_chart = $scope.expclassification_main.industries_that_featured_pie_chart;

            angular.forEach($scope.industries_that_featured_pie_chart, function(value, key) {
              if (key == 0) {
                value.color = "#00aeed";
              } else if (key == 1) {
                value.color = "#aa58d4";
              } else if (key == 2) {
                value.color = "#ad7dc5";
              } else if (key == 3) {
                value.color = "#d2b7e0";
              }

              var tempPercentage = value.percentage;
              tempPercentage = tempPercentage.substr(0, tempPercentage.length - 1);

              if ($scope.highestpercentage_pie < tempPercentage) {
                $scope.highestpercentage_pie = tempPercentage;
                $scope.highestname_pie  = value.name;
              }
            });

            angular.forEach($scope.industries_that_featured_pie_chart, function(value, key){
              pielabels.push(value.name);
              piedata.push(value.percentage.substr(0, value.percentage.length - 1));
              piecolors.push(value.color);
            });

            $scope.pieoptions = {
              tooltipEvents: [],
              showTooltips: true,
              tooltipCaretSize: 0,
              onAnimationComplete: function () {
                  this.showTooltip(this.segments, true);
              },
            };

            $scope.allcandidatepie={
              "labels":pielabels,
              "data":piedata,
              "colors":piecolors,
              "options": $scope.pieoptions
            };

            // console.log('$scope.allcandidatepie: ', $scope.allcandidatepie);
          }
        });
      }
    ]);

    analytics_mod.controller('RoleAnswersCtrl', ['GlobalConstant', 'RoleBridge', 'analyticsSvcs', '$parse', '$scope', '$rootScope', '$cookies', '$window', '$http', '$filter', '$timeout', '$location',
      function(GlobalConstant, RoleBridge, analyticsSvcs, $parse, $scope, $rootScope, $cookies, $window, $http, $filter, $timeout, $location) {
        var arrColors = [ "#EF5350", "#EC407A", "#AB47BC", "#7E57C2", "#5C6BC0", "#42A5F5", "#29B6F6", "#26C6DA", "#26A69A", "#66BB6A", "#9CCC65", '#D4E157',
          "#FFEE58", "#FFCA28", "#FFA726", "#FF7043", "#8D6E63", "#BDBDBD", "#78909C"
        ];

        function getRandomColor() {
          var letters = '0123456789ABCDEF';
          var color = '#';
          for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
          }
          return color;
        }

        function convertToMins(data) {
          var videos_floating, videos = data;

          videos = parseInt(videos, 10);
          videos = videos / 60;
          videos_floating = videos % 1;
          videos = parseInt(videos, 10);
          videos_floating = videos_floating.toFixed(2);
          videos_floating = .6 * videos_floating;
          videos_floating = Math.round(videos_floating * 100) / 100;
          videos = videos + videos_floating;

          return videos;
        }

        $scope.$watch(function() {
          return $rootScope.rolebridge;
        }, function (newVal, oldVal) {
          // console.log('RoleAnswers | being watched oldValue:', oldVal, 'newValue:', newVal);
          if ($rootScope.rolebridge) {
            $scope.currentRole_roleanswers = $rootScope.rolebridge.id;
            $scope.job_status = $rootScope.rolebridge.job_status;

            if ($scope.currentRole_roleanswers) {
              $scope.switch_ra = 1;
              analyticsSvcs.getRoleAnswers($scope.currentRole_roleanswers).then(function(res) {
                $scope.ra_main = res.data;
              });
            } else {
              $scope.switch_ra = 0;
            }
          }
        }, true);

        $scope.$watch('ra_main', function() {
          if ($scope.ra_main) {

            var temp_yes = 0;
            var temp_no = 0;
            var temp_dev = 0;

            if ($scope.job_status == 'expired') {
              $scope.job_show = 1;
            } else {
              $scope.job_show = 2;
            }

            // pre approval questions
            $scope.pre_approval_questions = $scope.ra_main.pre_approval_questions;

            angular.forEach($scope.pre_approval_questions, function(value, key) {
              temp_yes = value.yes;
              temp_no = value.no;
              temp_dev = value.developing;

              if (temp_no < temp_dev) {
                value.highest_val = 'developing';
              } else {
                value.highest_val = 'no';
              }

              if (temp_yes < temp_no) {
                value.highest_val = 'no';
              }

              if (temp_yes < temp_dev) {
                value.highest_val = 'developing';
              }
            });

            // standard applications
            $scope.standard_questions_asked = $scope.ra_main.standard_questions_asked;
            // console.log('length: ', $scope.standard_questions_asked);

            angular.forEach($scope.standard_questions_asked, function(value, key) {
              var tmpType = value.type;

              if (tmpType == 1) {
                var tmpAnswer = value.answer;
                tmpAnswer = tmpAnswer.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                value.answer = tmpAnswer;
              }

              // pie chart question
              if (tmpType == 4) {
                var pielabels = [];
                var piedata = [];
                var piecolors = [];
                var tmpData = [];
                var pieCtr = 0;

                angular.forEach(value.answer, function(val, k) {
                  pielabels.push(val.name);
                  piedata.push(val.percentage);
                  // val.color = getRandomColor();
                  val.color = arrColors[pieCtr];
                  piecolors.push(val.color);
                  pieCtr += 1;
                });

                tmpData.push({
                  "data": piedata,
                  "labels": pielabels,
                  "color": piecolors
                });

                value.pie = tmpData;
              }
            });
            $scope.number_of_videos_received = $scope.ra_main.number_of_videos_received;
            // $scope.profile_videos = $scope.ra_main.profile;
            // console.log($scope.ra_main.profile);
            $scope.profile_videos = convertToMins($scope.ra_main.profile);
            $scope.sq_videos = convertToMins(10);
            $scope.total_mins_vids = $scope.sq_videos + $scope.profile_videos;
            $scope.sq_videos = $scope.sq_videos.toString().replace('.', ':');
            $scope.profile_videos = $scope.profile_videos.toString().replace('.', ':');
            $scope.total_mins_vids = $scope.total_mins_vids.toString().replace('.', ':');
          }
        });
      }
    ]);


    // Analytics Services
    analytics_mod.service('RoleBridge', function () {
      var role_obj;

      return {
        get: function () {
            return role_obj;
        },
        set: function (object) {
          console.log("status: ", object.job_status);
            role_obj = object;
        }
      };
    });

    // Analytics Http factory
    analytics_mod.factory('analyticsSvcs', ['$http', 'GlobalConstant', function ($http, GlobalConstant) {
      return {
        getOverview: function (data) {
          // console.log('GlobalConstant:', GlobalConstant.EmployerRootApi);
          // return $http.get('../themes/bbt/js/sample/analytics/overview-res.json')
          return $http.get(GlobalConstant.EmployerRootApi + '/analytics/overview/' + data)
          .then(function(res) {
            return res.data.data;
          });
        },
        getSourceEd: function (data) {
          // return $http.get('../themes/bbt/js/sample/analytics/sourceed-res.json')
          return $http.get(GlobalConstant.EmployerRootApi + '/analytics/source/' + data)
          .then(function(res) {
            return res.data.data;
          });
        },
        getExpIndustry: function (data) {
          // return $http.get('../themes/bbt/js/sample/analytics/expindustry.json')
          return $http.get(GlobalConstant.EmployerRootApi + '/analytics/experience/' + data)
          .then(function(res) {
            return res.data.data;
          });
        },
        getRoleAnswers: function (data) {
          // return $http.get('../themes/bbt/js/sample/analytics/roleanswer.json')
          return $http.get(GlobalConstant.EmployerRootApi + '/analytics/answers/' + data)
          .then(function(res) {
            return res.data;
          });
        },
      }
    }]);

}());
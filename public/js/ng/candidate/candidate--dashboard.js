/**
 * Created by domina on 05/30/2018.
 */

(function() {
  'use strict';
  var app = angular.module('app');

  app.filter('trustAsResourceUrl', ['$sce', function($sce) {
    return function(val) {
      return $sce.trustAsResourceUrl(val);
    };
  }])

  app.directive('onlyLettersInput', onlyLettersInput);
  
  function onlyLettersInput() {
    return {
      require: 'ngModel',
      link: function(scope, element, attr, ngModelCtrl) {
        function fromUser(text) {
          var transformedInput = text.replace(/[^a-zA-Z]/g, '');
          //console.log(transformedInput);
          if (transformedInput !== text) {
            ngModelCtrl.$setViewValue(transformedInput);
            ngModelCtrl.$render();
          }
          return transformedInput;
        }
        ngModelCtrl.$parsers.push(fromUser);
      }
    };
  };

  var base_url = $('body').data('base_url');

  app.controller('CandidateDashboard', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile', '$sce',
    function (GlobalConstant, $scope, $window, $http, $cookies, $filter, $timeout, $compile, $sce) {
      var color_bg_initial_set = [
        "member-initials--sky",
        "member-initials--pvm-purple",
        "member-initials--pvm-green",
        "member-initials--pvm-red",
        "member-initials--pvm-yellow"
      ];

      $scope.salutationShow = false;
      $scope.profileShow = false;
      $scope.jobsAppliedShow = false;
      $scope.watchlistShow = false;
      $scope.addedtoWatchList = false
      $scope.closeDeclineShow = false;
      $scope.closeDeclineNone = false;
      $scope.featuredShow = false;
      $scope.profileCompletionShow = false;
      $scope.followShow = false;
      $scope.followLogShow = false;
      $scope.suggestsShow = false;

      $scope.salutationFailed = false;
      $scope.requestFailed = false;
      $scope.appliedFailed = false;
      $scope.watchFailed = false;
      $scope.featuredFailed = false;
      $scope.completionFailed = false;
      $scope.followFailed = false;
      $scope.complogsFailed = false;
      $scope.suggestFailed = false;
      $scope.indusFailed = false;
      $scope.closeDeclinedFailed = false;

      $scope.tab1 = true;
      $scope.showJobType = false;
      $scope.showIndustry = false;
      $scope.searchKeywords = '';
      $scope.searchMinSal = '';
      $scope.searchMaxSal = '';

      if($scope.tab1) {
        $scope.tab2 = false;
        $scope.tab3 = false;
      }
      if($scope.tab2) {
        $scope.tab1 = false;
        $scope.tab3 = false;
      }

      $scope.compLogLink = true;
      $scope.compLogLoad = false;
      $scope.compFfLink = true;
      $scope.compFfLoad = false;
      $scope.compSuggLink = true;
      $scope.compSuggLoad = false;
      $scope.compFeatureLink = true;
      $scope.compFeatureLoad = false;

      $scope.industrySelectedFilters = [];
      $scope.subIndustrySelectedFilters = [];
      $scope.jobTypeSelectedFilters = [];
      $scope.countrySelectedFilters = [];
      $scope.locationSelectedFilters = [];
      $scope.subLocationSelectedFilters = [];

      $scope.industrySelectedParam = [];
      $scope.subIndustrySelectedParam = [];
      $scope.jobTypeSelectedParam = [];
      $scope.countrySelectedParam = [];
      $scope.locationSelectedParam = [];
      $scope.subLocationSelectedParam = [];

      $scope.industryAmIOn = false;
      $scope.jobTypeAmIOn = false;
      $scope.showLocAmIOn = false;
      $scope.urlParameters = [];
      $scope.followedCompanyLogs = [];
      $scope.suggests = [];
      $scope.features = [];
      $scope.appliedJobs = [];
      $scope.closeDeclineList = [];

      $scope.minJobLog = 1;
      $scope.minCompFollow = 1;
      $scope.minCompSugg = 1;
      $scope.minFeatured = 1;

      // Get Candidate Profile
      $http.get(GlobalConstant.profileApi)
      .then(function(response) {
        var data = response.data.data;
  
        // Add initial to be used in default image
        $scope.F_initial = data.first_name;
        $scope.F_initial = $scope.F_initial.substr(0, 1);

        $scope.L_initial = data.last_name;
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
        $scope.preview_img = true;
        $scope.profileShow = true;

      }, function(response) {
        $scope.error = response.data.error_description;
      });

      // Closed jobs start
        $http.get(GlobalConstant.APIRoot + 'candidate/job-application/applied')
        .then(function(response) {
          //$scope.appliedJobs = response.data.data.jobs;
          if(response.data.data.jobs) {
              //var element = document.getElementById("featureList");
              for(var k = 0; k < response.data.data.jobs.length; k++) {
                // Add initial to be used in default image
                if(response.data.data.jobs[k].job.company.company_name != null) {
                  response.data.data.jobs[k].job.company.initial = response.data.data.jobs[k].job.company.company_name;
                  response.data.data.jobs[k].initial = response.data.data.jobs[k].job.company.initial.replace(/[^A-Z]/g, "");
                  var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
                  response.data.data.jobs[k].job.company.profile_color = color_bg_initial;
                }
                $scope.appliedJobs.push(response.data.data.jobs[k]);
              }
              $scope.minFeatured = $scope.minFeatured + 4;
              //element.scrollTop = element.scrollHeight;
          }
          $scope.jobsAppliedShow = true;
        });
      // Closed jobs end

      // Salutation / message start
      $http.get(GlobalConstant.APIRoot + 'candidate/salutations')
      .then(function(response) {
        $scope.salutation = response.data.data;
        $scope.salutationShow = true;
      }, function errorCallback(response) {
        if(response.status == 500) {
          $scope.salutationFailed = true;
        }
      });
      // Salutation / message end

     /* $http.get( GlobalConstant.CandidateJobApplicationApi + '/active')
      .then(function(response) {
        $scope.appliedJobs = response.data.data.jobs;
        $scope.jobsAppliedShow = true;
        console.log(3,$scope.appliedJobs)
      });*/

      // Profile request start
      $http.get(GlobalConstant.APIRoot + 'candidate/settings/privacy/whitelist/requested?access_token=' + $cookies.get('token'))
      .then(function(response) {
        $scope.profileRequestList = response.data.data;
        //console.log(44444,$scope.closeDeclineList)
        $scope.profileRequestShow = true;
      });
      // Profile request end

      $http.get(GlobalConstant.CandidateJobWatchlistApi)
      .then(function(response) {
        $scope.watchList = response.data.data.jobs;

        for(var k = 0; k < response.data.data.jobs.length; k++) {
          // Add initial to be used in default image
          if(response.data.data.jobs[k].company_name != null) {
            response.data.data.jobs[k].company.initial = response.data.data.jobs[k].company_name;
            response.data.data.jobs[k].company.initial = response.data.data.jobs[k].company.initial.replace(/[^A-Z]/g, "");
            //response.data.data.results.jobs[k].company.initial = response.data.data.results.jobs[k].company.initial.substr(0, 1);
            var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
            response.data.data.jobs[k].profile_color = color_bg_initial;
          }
          $scope.watchList.push(response.data.data.jobs[k]);
        }

        $scope.watchlistShow = true;
      });

      // Featured for you start

      // Closed and Decline applications start
      $scope.closeDecline = function() {
        $http.get(GlobalConstant.APIRoot + 'candidate/job-application/closed-declined')
        .then(function(response) {
          //$scope.closeDeclineList = response.data.data;
          console.log(response)
          $scope.closeDeclineList = [];

          if(response.data.data.length > 0) {
            for(var k = 0; k < response.data.data.length; k++) {
              // Add initial to be used in default image
              if(response.data.data[k].company_name != null) {
                response.data.data[k].initial = response.data.data[k].company_name;
                response.data.data[k].initial = response.data.data[k].initial.replace(/[^A-Z]/g, "");
                var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
                response.data.data[k].profile_color = color_bg_initial;
              }
              $scope.closeDeclineList.push(response.data.data[k]);
            }
            $scope.closeDeclineShow = true;
          } else {
            $scope.closeDeclineNone = true;
          }

          console.log(5555,$scope.closeDeclineList)
        }, function errorCallback(response) {
          if(response.status == 500) {
            $scope.closeDeclinedFailed = true;
          }
        });
      }
      // Closed and Decline applications end

      $scope.featuredList = function() {
        $scope.compFeatureLoad = true;
        $http.get( GlobalConstant.APIRoot + 'candidate/jobs/featured?min=' + $scope.minFeatured + '&max=' + ($scope.minFeatured+3))
        .then(function(response) {

          if(response.data.data) {
            if(($scope.minFeatured + 3) <= response.data.data.records) {
              var element = document.getElementById("featureList");

              for(var k = 0; k < response.data.data.results.jobs.length; k++) {
                // Add initial to be used in default image
                if(response.data.data.results.jobs[k].company.name != null) {
                  response.data.data.results.jobs[k].company.initial = response.data.data.results.jobs[k].company.name;
                  response.data.data.results.jobs[k].company.initial = response.data.data.results.jobs[k].company.initial.replace(/[^A-Z]/g, "");
                  //response.data.data.jobs[k].company.initial = response.data.data.jobs[k].company.initial.substr(0, 1);
                  var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
                  response.data.data.results.jobs[k].profile_color = color_bg_initial;
                }
                $scope.features.push(response.data.data.results.jobs[k]);
                //console.log(343,$scope.features)
              }
              $scope.minFeatured = $scope.minFeatured + 4;
              element.scrollTop = element.scrollHeight;
              if(($scope.minFeatured) > response.data.data.records) {
                $scope.compFeatureLink = false;  
              }

              $scope.featuredShow = true;
            } else {
              $scope.compFeatureLink = false;
            }
            $scope.compFeatureLoad = false;

            //console.log($scope.suggests);
          }
        }, function errorCallback(response) {
          if(response.status == 500) {
            $scope.featuredFailed = true;
          }
        });
      }

      $scope.featuredList();
      // Featured for you end

      // Profile Completion start
        $http.get( GlobalConstant.APIRoot + 'candidate/profile-completion')
        .then(function(response) {
          $scope.completionList = response.data.data;
          $scope.profileCompletionShow = true;
        }, function errorCallback(response) {
          if(response.status == 500) {
            $scope.salutationFailed = true;
          }
        });

      // Profile Completion end

      // Companies that I follow start
      $http.get( GlobalConstant.APIRoot + 'candidate/company/follow')
      .then(function(response) {
        $scope.iFollowThem = response.data.data;

        if(response.data.data) {
          angular.forEach($scope.iFollowThem, function(v, k) {
            // Add initial to be used in default image
            //console.log($scope.iFollowThem[k])
            if($scope.iFollowThem[k].company.company_name != null) {
              $scope.iFollowThem[k].company.initial = $scope.iFollowThem[k].company.company_name;
              $scope.iFollowThem[k].company.initial = $scope.iFollowThem[k].company.initial.replace(/[^A-Z]/g, "");
              //$scope.iFollowThem[k].company.initial = $scope.iFollowThem[k].company.initial.substr(0, 1);
              var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
              $scope.iFollowThem[k].company.profile_color = color_bg_initial;
            }
          });
          //$scope.comp_initial = $scope.comp_initial.replace(/[^A-Z]/g, "");
        }
        $scope.followShow = true;
      }, function errorCallback(response) {
        if(response.status == 500) {
          $scope.followFailed = true;
        }
      });

      $scope.companyLogs = function() {
        //console.log('test page','candidate/company-log?min=' + $scope.minJobLog + '&max=' + ($scope.minJobLog+4));
          $scope.compLogLoad = true;
          $http.get(GlobalConstant.APIRoot + 'candidate/company/log?min=' + $scope.minJobLog + '&max=' + ($scope.minJobLog+9))
          .then(function(response) {
            if(($scope.minJobLog + 9) <= response.data.data.records) {
              var element = document.getElementById("companyLogs");

              for(var i = 0; i < response.data.data.jobs.length; i++) {
                $scope.followedCompanyLogs.push(response.data.data.jobs[i]);
              }
              $scope.minJobLog = $scope.minJobLog + 10;
              element.scrollTop = element.scrollHeight;
              if(($scope.minJobLog) > response.data.data.records) {
                $scope.compSuggLink = false;  
              }

              $scope.followLogShow = true;
            } else {
              $scope.compLogLink = false;
            }
            $scope.compLogLoad = false;
          }, function errorCallback(response) {
          if(response.status == 500) {
            $scope.complogsFailed = true;
          }
        });
      }

      $scope.companyLogs();
      // Companies that I follow end

      // Suggested Jobs start
      $scope.suggestsList = function() {
        $scope.compSuggLoad = true;
        $http.get( GlobalConstant.APIRoot + 'candidate/company/suggestions?min=' + $scope.minCompSugg + '&max=' + ($scope.minCompSugg+3))
        .then(function(response) {

          if(response.data.data) {
            if(($scope.minCompSugg + 3) <= response.data.data.records) {
              var element = document.getElementById("suggestsList");

              for(var k = 0; k < response.data.data.company.length; k++) {
                // Add initial to be used in default image
                if(response.data.data.company[k].name != null) {
                  response.data.data.company[k].initial = response.data.data.company[k].name;
                  response.data.data.company[k].initial = response.data.data.company[k].initial.replace(/[^A-Z]/g, "");
                  response.data.data.company[k].initial = response.data.data.company[k].initial.substr(0, 1);
                  var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
                  response.data.data.company[k].profile_color = color_bg_initial;
                }
                $scope.suggests.push(response.data.data.company[k]);
              }
              $scope.minCompSugg = $scope.minCompSugg + 4;
              element.scrollTop = element.scrollHeight;
              if(($scope.minCompSugg) > response.data.data.records) {
                $scope.compSuggLink = false;  
              }

              $scope.suggestsShow = true;
            } else {
              $scope.compSuggLink = false;
            }
            $scope.compSuggLoad = false;
          }
        }, function errorCallback(response) {
          if(response.status == 500) {
            $scope.suggestFailed = true;
          }
        });
      }

      $scope.suggestsList();
      // Suggested Jobs end

      // search section start
      $http.get(  GlobalConstant.APIRoot + 'static/options/industries/all' )
      .then(function(response) {
          var data = response.data.data;
          $scope.industries = data;
          //console.log("indus",$scope.industries)
      }, function errorCallback(response) {
        if(response.status == 500) {
          $scope.indusFailed = true;
        }
      });

      $scope.delayShowIndustry = function() {
        $timeout(function () {
          if(!$scope.industryAmIOn) {
            $scope.showIndustry = false;
          }
        }, 800);
      }

      $scope.delayShowJobType = function() {
        $timeout(function () {
          if(!$scope.jobTypeAmIOn) {
            $scope.showJobType = false;
          }
        }, 800);
      }

      $scope.delayShowLocation = function() {
        $timeout(function () {
          if(!$scope.showLocAmIOn) {
            $scope.showLocation = false;
          }
        }, 800);
      }

      $scope.industrySelected = function(industry) {
        if(industry.selected) {
          $scope.industrySelectedFilters.push({id: industry.id, display_name: industry.display_name});
          $scope.industrySelectedParam.push(industry.id);

          angular.forEach(industry.sub, function(val, key) {
            val.selected = true;

            angular.forEach($scope.subIndustrySelectedFilters, function(v, k) {
              if(val.id == v.id) {
                $scope.subIndustrySelectedFilters.splice(k, 1);
                var indexP = $scope.subIndustrySelectedParam.indexOf(v.id);
                if(indexP > -1) {
                  $scope.subIndustrySelectedParam.splice(indexP, 1);
                }
              }
            });
          });

        } else {
          angular.forEach(industry.sub, function(v, k) {
            v.selected = false;
          });

          angular.forEach($scope.industrySelectedFilters, function(v, k) {
            if(v.id == industry.id) {
              $scope.industrySelectedFilters.splice(k, 1);
              var indexP = $scope.industrySelectedParam.indexOf(industry.id);
              if(indexP > -1) {
                $scope.industrySelectedParam.splice(indexP, 1);
              }
            }
          });
        }
        $scope.industryAmIOn = true;
        $scope.searchJob();
      }

      $scope.subIndustrySelected = function(industry) {
        industry.selected = false;

        $scope.subIndustrySelectedFilters = [];
        $scope.subIndustrySelectedParam = [];
        angular.forEach($scope.industries, function(v, k) {
          if(!v.selected) {
            $scope.industrySelectedFilters.splice(k, 1);
            var indexP = $scope.industrySelectedParam.indexOf(v.id);
            if(indexP > -1) {
              $scope.industrySelectedParam.splice(indexP, 1);
            }
          }

          angular.forEach($scope.industries[k].sub, function(val, key) {
            if(!v.selected) {
              if(val.selected) {
                $scope.subIndustrySelectedFilters.push({id: val.id, display_name: val.display_name});
                $scope.subIndustrySelectedParam.push(val.id);
              }
            }
          });
        });

        $scope.industryAmIOn = true;
        $scope.searchJob();
      }

      $scope.industryDeselect = function(industry) {
        var indexInd = $scope.industrySelectedFilters.indexOf(industry);
        if(indexInd > -1) {
          $scope.industrySelectedFilters.splice(indexInd, 1);
        }

        angular.forEach($scope.industries, function(v, k) {
          if(v.id == industry.id) {
            v.selected = false;
          }
          angular.forEach(v.sub, function(val, key) {
            if(val.id == industry.id) {
              val.selected = false;
            }
          });
        });
        var indexP = $scope.industrySelectedParam.indexOf(industry.id);
        if(indexP > -1) {
          $scope.industrySelectedParam.splice(indexP, 1);
        }
        $scope.searchJob();
      }

      $scope.subIndustryDeselect = function(subIndustry) {
        var indexInd = $scope.subIndustrySelectedFilters.indexOf(subIndustry);
        if(indexInd > -1) {
          $scope.subIndustrySelectedFilters.splice(indexInd, 1);
        }

        angular.forEach($scope.industries, function(v, k) {
          angular.forEach(v.sub, function(val, key) {
            if(val.id == subIndustry.id) {
              val.selected = false;
            }
          });
        });
        var indexP = $scope.subIndustrySelectedParam.indexOf(subIndustry.id);
        if(indexP > -1) {
          $scope.subIndustrySelectedParam.splice(indexP, 1);
        }
        $scope.searchJob();
      }

      $http.get(GlobalConstant.StaticOptionWorkTypeApi).then(function(response) {
        $scope.job_types = response.data.data;
        //console.log(22,$scope.job_types);
      });

      $scope.jobTypeSelected = function(jobType) {
        if(jobType.selected) {
          $scope.jobTypeSelectedFilters.push({id: jobType.id, display_name: jobType.display_name});
          $scope.jobTypeSelectedParam.push(jobType.id);
        } else {
          angular.forEach($scope.jobTypeSelectedFilters, function(v, k) {
            if(v.id == jobType.id) {
              $scope.jobTypeSelectedFilters.splice(k, 1);
              var indexP = $scope.jobTypeSelectedParam.indexOf(jobType.id);
              if(indexP > -1) {
                $scope.jobTypeSelectedParam.splice(indexP, 1);
              }
            }
          });
        }
        $scope.jobTypeAmIOn = true;
        $scope.searchJob();
        //console.log($scope.jobTypeSelectedFilters)
      }

      $scope.jobTypeDeselect = function(jobType) {
        var indexInd = $scope.jobTypeSelectedFilters.indexOf(jobType);
        if(indexInd > -1) {
          $scope.jobTypeSelectedFilters.splice(indexInd, 1);
        }

        angular.forEach($scope.job_types, function(v, k) {
          if(v.id == jobType.id) {
            v.selected = false;
          }
        });
        var indexP = $scope.jobTypeSelectedParam.indexOf(jobType.id);
        if(indexP > -1) {
          $scope.jobTypeSelectedParam.splice(indexP, 1);
        }
        $scope.searchJob();
      }

      $http.get(GlobalConstant.StaticOptionsApi+'/countries')
      .then(function(response) {
        $scope.countries = response.data.data;

        angular.forEach($scope.countries, function(v, k) {
          if(v.code_slug_name == 'nz') {
            $http.get(GlobalConstant.APIRoot + 'static/options/locations/' + v.country_code + '/combined').then(function(response) {
              if(response.data.data) {
                $scope.countries[k].sub = response.data.data;
              } else {
                $scope.countries[k].sub = [];
              }
              //console.log(35, $scope.countries[k])
            });
          }
        });
        //console.log(34,$scope.countries);
      });

      $scope.countrySelected = function(country) {
        if(country.selected) {
          $scope.countrySelectedFilters.push({id: country.id, display_name: country.display_name, code_slug_name: country.code_slug_name});
          $scope.countrySelectedParam.push(country.code_slug_name);
        } else {
          angular.forEach($scope.countrySelectedFilters, function(v, k) {
            if(v.id == country.id) {
              $scope.countrySelectedFilters.splice(k, 1);
              var indexP = $scope.countrySelectedParam.indexOf(country.id);
              if(indexP > -1) {
                $scope.countrySelectedParam.splice(indexP, 1);
              }
            }
          });
        }
        $scope.jobTypeAmIOn = true;
        $scope.searchJob();
      }

      $scope.locationSelected = function(location) {
        if(location.selected) {
          $scope.locationSelectedFilters.push({id: location.id, display_name: location.display_name});
          $scope.locationSelectedParam.push(location.id);
        } else {
          angular.forEach($scope.locationSelectedFilters, function(v, k) {
            if(v.id == location.id) {
              $scope.locationSelectedFilters.splice(k, 1);
              var indexP = $scope.locationSelectedParam.indexOf(location.id);
              if(indexP > -1) {
                $scope.locationSelectedParam.splice(indexP, 1);
              }
            }
          });
        }
        $scope.showLocAmIOn = true;
        $scope.searchJob();
      }

      $scope.countryDeselect = function(country) {
        var indexInd = $scope.countrySelectedFilters.indexOf(country);
        if(indexInd > -1) {
          $scope.countrySelectedFilters.splice(indexInd, 1);
        }

        angular.forEach($scope.countries, function(v, k) {
          if(v.id == country.id) {
            v.selected = false;
          }
        });
        var indexP = $scope.countrySelectedParam.indexOf(country.code_slug_name);
        if(indexP > -1) {
          $scope.countrySelectedParam.splice(indexP, 1);
        }
        $scope.searchJob();
      }

      $scope.locationDeselect = function(location) {
        var indexInd = $scope.locationSelectedFilters.indexOf(location);
        if(indexInd > -1) {
          $scope.locationSelectedFilters.splice(indexInd, 1);
        }

        angular.forEach($scope.countries, function(v, k) {
          angular.forEach(v.sub, function(val, key) {
            if(val.id == location.id) {
              val.selected = false;
            }
          });
        });
        $scope.searchJob();
      }

      $scope.keyDeselect = function() {
        $scope.searchKeywords = ''
        $scope.searchJob();
      }

      $scope.minSalDeselect = function() {
        $scope.searchMinSal = ''
        $scope.searchJob();
      }

      $scope.maxSalDeselect = function() {
        $scope.searchMaxSal = ''
        $scope.searchJob();
      }

      $scope.searchJob = function() {
        var keywords, industries, subIndustries, jobTypes, countries, locations, subLocations, minSalary, maxSalary;

          keywords = "q=" + $scope.searchKeywords;
          industries = $scope.industrySelectedParam.toString();
          industries = "&industry=" + industries;
          subIndustries = $scope.subIndustrySelectedParam.toString();
          subIndustries = "&sub_industry=" + subIndustries;
          jobTypes = $scope.jobTypeSelectedParam.toString();
          jobTypes = "&role_type=" + jobTypes;
          countries = $scope.countrySelectedParam.toString();
          countries = "&Country=" + countries;
          locations = $scope.locationSelectedParam.toString();
          locations = "&state=" + locations
          minSalary = "&min_salary=" + $scope.searchMinSal;
          maxSalary = "&max_salary=" + $scope.searchMaxSal;
          //locations = "area=" + locations

          $scope.urlParameters = keywords + industries + subIndustries + jobTypes + countries + locations + minSalary + maxSalary;
      }

      $scope.searchJob();

      // search section end

      // Featured for you start

      $scope.addWatchList = function(id) {
        $http.post(GlobalConstant.CandidateJobWatchlistApi + '/' + id).then(function(response) {
          if (response.data.data.watchlist) {
            $scope.addedtoWatchList = true;
            if($scope.addedtoWatchList) {
              $timeout(function () {
                $scope.addedtoWatchList = false;
              }, 5000);
            }
          }
        });
      }

      // Featured for you end

      /* SET Video */
      $(".feature__video").each(function () {
        var id = this.id;
        var src = $("#" + id).attr('src');

        var myPlayer = amp(id, {
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


        $timeout(function () {
          myPlayer.src([{
            src: src,
            type: "application/vnd.ms-sstr+xml"
          }]);
        }, 3000);
      });
      $(".suggest__video").each(function () {
        var id = this.id;
        var src = $("#" + id).attr('src');

        var myPlayer = amp(id, {
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
        myPlayer.src([{
          src: src,
          type: "application/vnd.ms-sstr+xml"
        }]);
      });
    
    }]);
}());
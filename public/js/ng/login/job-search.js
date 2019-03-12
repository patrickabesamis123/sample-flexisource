(function() {
  'use strict';
  var app = angular.module('app');
  var base_url = $('body').data('base_url');

  app.filter('cuts', function (){
    return function(value, wordwise, max, tail){
      if (!value) return '';
      max = parseInt(max, 10);
      if (!max) return value;
      if (value.length <= max) return value;

      value = value.replace(/<br[^>]*>/gi, '\n');
      value = value.substr(0, max);

      if (wordwise){
        var lastspace = value.lastIndexOf(' ');

        if(lastspace !== -1){
          if (value.charAt(lastspace-1) === ',' || value.charAt(lastspace-1) === '.' ) {
            lastspace = lastspace - 1;
          }
          value = value.substr(0, lastspace);
        }
      }
      return value + (tail || ' ...');
    }
  })

   app.directive('shareCount', ['$http', 'GlobalConstant','$scope', function ($http, GlobalConstant,$scope) {
    return {
      restrict: 'EA',
      scope: {
        src : '=?bind'
      },
      replace: true,
      link: function ($scope, element, attrs) {
        element.bind('click', function () {
          var srcUrl;
          $scope.src = attrs.socialshareProvider;
          $scope.obj = attrs.id;
          alert('fffff');
          if ($scope.src == 'facebook') {
            srcUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(location.href);
          } else if ($scope.src == 'twitter') {
            srcUrl = "https://twitter.com/share?url=" + encodeURIComponent(location.href);
          } else if ($scope.src == 'linkedin') {
            srcUrl = "https://www.linkedin.com/cws/share?url=" + encodeURIComponent(location.href);
          }

          var data = {
            role_id: $scope.obj,
            type: $scope.src,
            source: srcUrl
          }
          // // console.log(data);
          if(data) {
            $http.post(GlobalConstant.EmployerRootApi + '/analytics/sourceclicks/', data).then(function (res) {
              return console.log('Share success');
            })
          }
        });
      }

    };
  }]);

  app.controller('JobSearchController', ['GlobalConstant', 'GlobalSearch', '$scope', '$window', '$http', '$cookies', '$timeout', '$location', '$filter',
    function(GlobalConstant, GlobalSearch, $scope, $window, $http, $cookies, $timeout, $location,$filter) {
      // $scope.jobSearchTemplate = 'themes/bbt/templates/Layout/Job_template_search.html';
      $scope.jobSearchTemplate = '/job-template';
      $scope.token = $cookies.get('token');
      $scope.ut = $cookies.get('ut');
      $scope.industries = [];

      var color_bg_initial_set = [];
      // random color set
      color_bg_initial_set = [
        "member-initials--sky",
        "member-initials--pvm-purple",
        "member-initials--pvm-green",
        "member-initials--pvm-red",
        "member-initials--pvm-yellow"
      ];

      // $http.get(GlobalConstant.APIRoot+"static/options/industries/all").then(function(response) { //Uncomment for live API call
        $http.get(window.location.origin + '/js/minified/test-data/test_classification_data.json').then(function(response) {
        $scope.industries = response.data.data;
      });

      $scope.locationCountry = [];
      $scope.locations = [];
      $scope.slug_loc = "";
      $scope.loadCountry = false;
      //ticket BED-29
      //$http.get(GlobalConstant.APIRoot + 'static/options/locations/nz/combined').then(function(response) {
      // $http.get('/api/countries').then(function(response) { //Uncomment for live API call
      $http.get(window.location.origin + '/js/minified/test-data/test_countries_data.json').then(function(response) {
        $scope.locationCountry = response.data.data;
      });

      $scope.filterCountry = function(slug_code) {
        $scope.loadCountry = true;
        $scope.slug_loc = slug_code;
        angular.extend($scope.searchDetails[0], {Country: slug_code});
        $location.search('Country', slug_code)
        //$http.get(GlobalConstant.APIRoot + 'static/options/locations/' + slug_code + '/combined').then(function(response) { 
        $http.get(window.location.origin + '/api/location/search-by-country/' + slug_code).then(function(response) {
          // $http.get(window.location.origin + '/js/minified/test-data/test_locations_data.json').then(function(response) {
          $scope.locations = response.data.data;
          $scope.loadCountry = false;
        });
        $scope.selectedSubFilter = !$scope.selectedSubFilter;
        // console.log("location",$scope.locations);
      }

      $scope.job_types = [];
      // $http.get(GlobalConstant.StaticOptionWorkTypeApi  ).then(function(response) { //Uncomment for live API call
        $http.get(window.location.origin + '/js/minified/test-data/test_work_type_data.json').then(function(response) {
          $scope.job_types = response.data.data;
      });

      $scope.hideme = true;
      var typingTimer; //timer identifier
      var doneTypingInterval = 10;

      $('#location').on('keyup', function() {
        $timeout.cancel(typingTimer);
        typingTimer = $timeout(doneTyping, doneTypingInterval);
      });

      //on keydown, clear the countdown
      $('#location').on('keydown', function() {
        $timeout.cancel(typingTimer);
      });
      $('#location').on('change', function() {
        $('#autoDataLocation .autodata').click(function() {
          $('#location:text').val($(this).data('value'));
            if (!$('#autoDataLocation').hasClass('ng-hide')) {
              $('#autoDataLocation').addClass('ng-hide');
          }
        });
      });

      //AutoComplete for Location
      //user is "finished typing," do something
      function doneTyping() {
        $scope.autoLocation = [];
        $http.get(GlobalConstant.APIRoot + 'static/autocomplete/location?q=' + $('#location').val()).then(function(response) {
          $scope.hideme = false;
          $scope.autoLocation = response.data.data;
          if (!$scope.autoLocation.length) {
            $('#autoDataLocation').addClass('ng-hide');
          } else {
            $('#autoDataLocation').removeClass('ng-hide');
          }
        });
      }

      $scope.seen = function(e, object_id) {
        var obj = $(e.target);
        var jobId = obj.attr('data-obj-id');
        $http.post(GlobalConstant.CandidateJobWatchlistApi + '/' + object_id  ).then(function(response) {
          if (response.data.data.watchlist) {
            if (!obj.hasClass('pvm-blue')) {
              obj.addClass('pvm-blue')
            }
          } else {
            obj.removeClass('pvm-blue');
          }

          $scope.GetJobs( {params: $scope.searchDetails[0] } )
        }, function errorCallback(response) {});
      }
      // $scope.ViewJobTemplate = true
      $scope.showDetail = function(e, object_id) {
        var obj = $(e.target);
        var jobId = obj.attr('data-obj-id');
        var jobClass = angular.element($(".job"+object_id))
        var partJob =  $(".partjob"+object_id)
        $scope.joblisting = []

        angular.element($('.partjob') ).each(function(){
          if(angular.element(this).is(':visible') )
          {
            if (angular.element(this).hasClass("partjob"+object_id) ) {
              angular.element(this).removeClass('hide')
            } else {
              angular.element(this).addClass('hide')
            }
          } else{

          }
        })

        if ( angular.element(partJob).hasClass('hide')) {
          angular.element(partJob).removeClass('hide');

          // $http.get(GlobalConstant.JobsApi + '/' + object_id) //Uncomment for live API call
          $http.get(window.location.origin + '/js/minified/test-data/test_job_listing_data.json')
          .then(function(response) {
            if (response.status == 200) {
              var data = response.data.data;
              $scope.joblisting = data;
              //Create Video player
              $timeout(function(){
                var vid =   'JobVideo_'+$scope.joblisting.object_id;
                
                if($('#'+vid).length){
                  var myPlayer = amp(vid, {
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
                    });
                  });

                  if($scope.joblisting.job_video_url){
                    myPlayer.src([{
                      src: $scope.joblisting.job_video_url,
                      type: "application/vnd.ms-sstr+xml"
                    }]);
                  }
                }
              }, 1000)

              jobClass.removeClass('glyphicon-menu-down');
              jobClass.addClass('glyphicon-menu-up');

              jobClass.attr('data-seen', 'true');
            }
          }, function errorCallback(response) {});

        } else {
          angular.element(partJob).addClass('hide')
          jobClass.removeClass('glyphicon-menu-up');
          jobClass.addClass('glyphicon-menu-down');
        }
      }

      $scope.checkedBox = function(e) {
        var obj = $(e.target);
        if (obj.hasClass('checkbox-checked')) {
          obj.removeClass('checkbox-checked');
          obj.addClass('checkbox-uncheck');
        } else {
          obj.addClass('checkbox-checked');
          obj.removeClass('checkbox-uncheck');
        }
      }

      //Compare 2 multidimentional array
      $scope.equalArray = function(a, b) {
          return JSON.stringify(a) == JSON.stringify(b);
      }

      $scope.searchDetails = [ $location.search() ] ;
      $scope.jobSearch = [];
      $scope.filter = {};
      $scope.selectedParams = {}

      //get decimal from fraction
      //Refresh salary slider
      function fract(n){ return Number(String(n).split('.')[1] || 0); }
      $scope.refreshslider = function(){
        setTimeout(function(){
          $scope.$broadcast('reCalcViewDimensions');
        },500)
      }

      $scope.GetJobs = function (paramsDetails) {
        
        paramsDetails.params.page = paramsDetails.params.offset;

        var SearchOption = {params: paramsDetails.params}
        if ($cookies.get('token')) {
          var token = $cookies.get('token');
          angular.extend(SearchOption, {headers: {'Authorization': 'Bearer ' + token}} )
        } else {
          var token = null
        }
        
        // $http.get(GlobalConstant.JobsApi + '/search', SearchOption) //Uncomment this line for the API call if one is already present then comment out the one below
        //$http.get(window.location.origin + '/js/minified/test-data/test_job_search_data.json')
        $http.get(window.location.origin + '/api/public/job-search?' + jQuery.param(paramsDetails.params))
        .then(function(response) { //Uncomment this and the one at the top for the API call
          $scope.jobSearch = response.data; //real line for ajax call

          $scope.request_params = $scope.jobSearch.request_params
          $scope.facets = $scope.jobSearch.facets
        
          //decode uri
          for (var i=0; i<$scope.jobSearch.results.companies.length; i++) {
            $scope.jobSearch.results.companies[i].encode_company_url = encodeURIComponent(($scope.jobSearch.results.companies[i].company_url));
          }

          // added Jobs comp initial name and bg color
          for (var a = 0; a < $scope.jobSearch.results.jobs.data.length; a++) {
            var comp_initialize = $scope.jobSearch.results.jobs.data[a].company_name;
            var comp_initial = comp_initialize.replace(/[^A-Z]/g, "");
            // var comp_initial;

            // If no cap letters detected on string, use other method BEGIN
            if (comp_initial.length < 1) {
              var space_count = comp_initialize.split(' ').length - 1;
              var indexed_char = comp_initialize;
              var tempinitial;

              if (space_count >= 1) {
                var rotator = 0;
                for (var spc_itr_jobs = 0; spc_itr_jobs <= space_count; spc_itr_jobs++) {
                  if (spc_itr_jobs == 0) {
                    tempinitial = (comp_initialize.substr(0, 1));
                    indexed_char = indexed_char.substr(indexed_char.indexOf(" ") + 1);
                  } else {
                    if (indexed_char != -1 && indexed_char.substr(0, indexed_char.indexOf(" ")) != "") {
                      tempinitial = indexed_char.substr(0, indexed_char.indexOf(" "));
                      indexed_char = indexed_char.substr(indexed_char.indexOf(" ") + 1);
                    } else {
                      tempinitial = indexed_char.substr(0, 1);
                    }
                  }
                  comp_initial = comp_initial + tempinitial.substr(0, 1).toUpperCase();
                }
              } else {
                comp_initial = comp_initialize.substr(0, 3);
              }
            }
            // If no cap letters detected on string, use other method END
            comp_initial = comp_initial.substr(0, 3);
            $scope.jobSearch.results.jobs.data[a].initial = comp_initial;

            // change default photo's background color
            var color_bg_initial = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
            $scope.jobSearch.results.jobs.data[a].profile_color = color_bg_initial;

            if ($scope.jobSearch.results.jobs.data[a].company_logo_url) {
              $scope.jobSearch.results.jobs.data[a].company_logo_url = $scope.jobSearch.results.jobs.data[a].company_logo_url.toString();
              // var tempvar = $scope.jobSearch.results.jobs.data[a].company_logo_url.toString();
              // tempvar = tempvar.constructor === Array ? tempvar.toString() : tempvar;
              // $scope.jobSearch.results.jobs.data[a].company_logo_url = tempvar;
            }
          }

          // added Jobs comp initial name and bg color
          for (var comptemp = 0; comptemp < $scope.jobSearch.results.companies.length; comptemp++) {
            var company_initialize = $scope.jobSearch.results.companies[comptemp].company_name;
            var company_initial = company_initialize.replace(/[^A-Z]/g, "");
            // var company_initial;

            // If no cap letters detected on string, use other method BEGIN
            if (company_initial.length < 1) {
              var space_count = company_initialize.split(' ').length - 1;
              var indexed_char = company_initialize;
              var tempinitial;

              if (space_count >= 1) {
                var rotator = 0;
                for (var spc_itr = 0; spc_itr <= space_count; spc_itr++) {
                  if (spc_itr == 0) {
                    tempinitial = (company_initialize.substr(0, 1));
                    indexed_char = indexed_char.substr(indexed_char.indexOf(" ") + 1);
                  } else {
                    if (indexed_char != -1 && indexed_char.substr(0, indexed_char.indexOf(" ")) != "") {
                      tempinitial = indexed_char.substr(0, indexed_char.indexOf(" "));
                      indexed_char = indexed_char.substr(indexed_char.indexOf(" ") + 1);
                    } else {
                      tempinitial = indexed_char.substr(0, 1);
                    }
                  }
                  company_initial = company_initial + tempinitial.substr(0, 1).toUpperCase();
                }
              } else {
                company_initial = company_initialize.substr(0, 3);
              }
            }
            // If no cap letters detected on string, use other method END
            company_initial = company_initial.substr(0, 3);
            $scope.jobSearch.results.companies[comptemp].initial = company_initial;

            // change default photo's background color
            var color_bg_initial_comp = color_bg_initial_set[Math.floor(Math.random()*color_bg_initial_set.length)];
            $scope.jobSearch.results.companies[comptemp].profile_color = color_bg_initial_comp;
          }

          $scope.selectedParams.industry = [];
          $scope.selectedParams.sub_industry = [];
          $scope.selectedParams.region = [];
          $scope.selectedParams.city = [];
          $scope.selectedParams.role_type = [];
          $scope.selectedParams.state = [];
          $scope.selectedParams.area = [];

          //BED-29
          /*$scope.iSindustry = [];
          $scope.iSsub_industry = [];
          $scope.iSrole_type = [];
          $scope.iSstate = [];
          $scope.iSCountry = [];*/

          $scope.filter.industry =  [];
          $scope.filter.sub_industry =  [];
          //$scope.filter.region = [];
          //$scope.filter.city = [];
          $scope.filter.role_type = [];
          $scope.filter.state = [];
          $scope.filter.area = [];
          $scope.selectedMainFilter = true;
          $scope.selectedMainFilter2 = true;
          $scope.selectedMainFilter3 = true;
          $scope.selectedMainFilter4 = true;
          $scope.selectedSubFilter = false;

          if ($scope.request_params.length != 0) {
            //Populate Filter checkboxes

            angular.forEach($scope.request_params, function(val, key) {
              //if(angular.isArray(val)) {
                //angular.forEach(val, function(valdata, keydata){

                  if(val != null) {
                    switch (key) {
                      case 'industry':
                        if(val.indexOf(",") >= 0) {
                          $scope.industryArray = val.split(",");
                          angular.forEach($scope.industryArray, function(val, key) {
                            $scope.selectedParams.industry.push(parseInt(val));
                          });
                        } else {
                          $scope.selectedParams.industry.push(parseInt(val));
                        }
                        break;  
                      case 'sub_industry':
                        if(val.indexOf(",") >= 0) {
                          $scope.subIndustryArray = val.split(",");
                          angular.forEach($scope.subIndustryArray, function(val, key) {
                            $scope.selectedParams.sub_industry.push(parseInt(val));
                          });
                        } else {
                          $scope.selectedParams.sub_industry.push(parseInt(val));
                        }
                        break;
                      case 'region':
                        if(val.indexOf(",") >= 0) {
                          $scope.regionArray = val.split(",");
                          angular.forEach($scope.regionArray, function(val, key) {
                            $scope.selectedParams.region.push( parseInt(val) )  ;
                          });
                        } else {
                          $scope.selectedParams.region.push(parseInt(val));
                        }
                         break;
                      case 'city':
                        if(val.indexOf(",") >= 0) {
                           $scope.cityArray = val.split(",");
                          angular.forEach($scope.cityArray, function(val, key) {
                            $scope.selectedParams.city.push( parseInt(val) )  ;
                          });
                        } else {
                          $scope.selectedParams.city.push(parseInt(val));
                        }
                       
                        break;
                      case 'state':
                        if(val.indexOf(",") >= 0) {
                           $scope.stateArray = val.split(",");
                          angular.forEach($scope.stateArray, function(val, key) {
                            $scope.selectedParams.state.push( parseInt(val) )  ;
                          });
                        } else {
                          $scope.selectedParams.state.push(parseInt(val));
                        }
                        break;
                      case 'area':
                        if(val.indexOf(",") >= 0) {
                           $scope.areaArray = val.split(",");
                          angular.forEach($scope.areaArray, function(val, key) {
                            $scope.selectedParams.area.push( parseInt(val) )  ;
                          });
                        } else {
                          $scope.selectedParams.area.push(parseInt(val));
                        }
                          
                          break;
                      case 'role_type':
                        if(val.indexOf(",") >= 0) {
                          $scope.roleTypeArray = val.split(",");
                          angular.forEach($scope.roleTypeArray, function(val, key) {
                            $scope.selectedParams.role_type.push( parseInt(val) )  ;
                          });
                        } else {
                          $scope.selectedParams.role_type.push(parseInt(val));
                        }
                        break;
                      case 'min_salary':
                      $scope.selectedParams.min_salary = val   ;
                      break;
                     case 'max_salary':
                      $scope.selectedParams.max_salary = val ;
                      break;
                      default:
                      
                      break;
                    }
                  }
                //})
              //} 
            });

            if (angular.isDefined($scope.selectedParams.min_salary) && angular.isDefined($scope.selectedParams.max_salary) ){
              var init_min_salary = $scope.selectedParams.min_salary
              var init_max_salary = $scope.selectedParams.max_salary
            } else {
              var init_min_salary = 0
              var init_max_salary = 200000
            }

          } else {
            //assign value to salary slider
            var init_min_salary = 0
            var init_max_salary = 200000
          }
          //Populate count
          angular.forEach($scope.facets, function(val, key){
            angular.forEach(val.values, function(dataval, datakey){
              switch (key ) {
                case 'industry':
                  $scope.filter.industry.push( { parent_id:parseInt( datakey ),count:dataval })
                  break;
                case 'sub_industry':
                  $scope.filter.sub_industry.push( { sub_id:parseInt( datakey ),count:dataval })
                  break;
                // case 'region':
                //         $scope.filter.region.push( { parent_id:parseInt( datakey ),count:dataval })
                //    break;
                // case 'city':
                //     $scope.filter.city.push( { parent_id:parseInt( datakey ),count:dataval })
                //     break;
                case 'state':
                  $scope.filter.state.push( { parent_id:parseInt( datakey ),count:dataval })
                  break;
                case 'area':
                  $scope.filter.area.push( { parent_id:parseInt( datakey ),count:dataval })
                  break;
                default:
              }
            })
          });
          //create pagination

          //var total = $scope.jobSearch.num_found;
          if ( angular.isDefined( $scope.jobSearch.pagination.limit )) {
            var total = $scope.jobSearch.num_found / $scope.jobSearch.pagination.limit;
            var newTotal = Math.round( total * 10 ) / 10
            var decimal = fract(newTotal)
            if (decimal <= 4) {
              $scope.pagenationLength = Math.round( newTotal );
            } else {
              $scope.pagenationLength = Math.round( newTotal ) ;
            }

            $scope.paginatelength = []
            var i = 0;
            while(i < $scope.pagenationLength){
              $scope.paginatelength.push(i)
              i++
            }
          }
              //assign data to slider
          $scope.slider = {
            minValue: init_min_salary,
            maxValue: init_max_salary,
            options: {
              floor: 0,
              ceil: 200000,
              step: 1000,
              translate: function(value) {
                var minstr = value.toString() ;
                switch(minstr.length) {
                  case 4:
                    var returnme =  minstr   ;
                    break;
                  case 5:
                    var returnme =  minstr.substring(0, 2)+'K'  ;
                    break;
                  case 6:
                    var returnme =  minstr.substring(0, 3)+'K'  ;
                    break;
                  default:
                    var returnme =  0  ;
                }

                if(returnme == '200K') {
                  returnme = returnme + '+';
                }
                return '$' + returnme;
              }
            }
          };

          //BED-29
          if(!$scope.selectedParams.state) {
            $scope.loadcity = true;
          }
          //BED-29
          /*if($scope.selectedParams.industry.length > 0 || $scope.selectedParams.sub_industry.length > 0) {
            $scope.selectedMainFilter = true;
          } else {
            $scope.selectedMainFilter = false;
          }*/

          /*if($scope.selectedParams.role_type.length > 0) {
            $scope.selectedMainFilter2 = true;
          } else {
            $scope.selectedMainFilter2 = false;
          }*/

          $scope.iSCountry = [];

          if($scope.selectedParams.state.length > 0) {
            //$scope.selectedMainFilter3 = true;
            $scope.selectedSubFilter = true;
          } else {
            //$scope.selectedMainFilter3 = false;
          }

          /*if($scope.selectedParams.max_salary > 0) {
            $scope.selectedMainFilter4 = true;
           } else {
            $scope.selectedMainFilter4 = false;
           }*/

          //console.log("salary: " +$scope.selectedParams.max_salary)
              //fix for slider positioning
          $scope.followedText = '+ Follow us';
          if ($cookies.get('token') && $scope.ut == 'candidate') {
            angular.forEach($scope.jobSearch.results.companies, function(val, key) {
              $http.get(GlobalConstant.APIRoot + 'candidate/company/follow/'+val.id)
              .then(function(response) {
                if(response.data.data.followed){
                  $scope.following = true
                  angular.element($('.f_'+val.id)).show()
                  angular.element($('.uf_'+val.id)).hide()
                  angular.element($('#comp_'+val.id).addClass('following') )
                } else {
                  $scope.following = false
                  angular.element($('.f_'+val.id)).hide()
                  angular.element($('.uf_'+val.id)).show()
                  angular.element($('#comp_'+val.id).removeClass('following') )
                }
              });
            });
          }
          //Check All button
          $scope.checkAll = function( parentid ) {
            var selectAll = angular.element($('.selectAll_'+parentid+':checkbox:checked')).length ;
            if (selectAll == 1) {
              $http.get(GlobalConstant.APIRoot + 'static/options/locations/cities/'+parentid)
              .then(function(response) {
                var cities = response.data.data
                $scope.childrencity = []
                angular.forEach(cities, function(v, k) {
                  $scope.childrencity.push(v.id)
                })
                $scope.selectedParams.city = angular.copy($scope.childrencity);
              });
            } else {
              $scope.selectedParams.city = angular.copy([])
            }
          };
            //Uncheck all
          $scope.unCheckAll = function( parentid, type ) {
            var selectAll = angular.element($('.selectAll_'+parentid+':checkbox:checked')).length ;
            ////console.log(selectAll)
            if (selectAll == 1) {
              if (type == 'industry') {
                $scope.selectedParams.sub_industry = [];
              }else if(type == 'location'){
                $scope.selectedParams.area = [];
              }
            } else {
            }
          };
          $scope.refreshslider();
        }) //uncomment this line for the API call
      }

      $scope.UpdateSalary = function () {
           angular.extend($scope.searchDetails[0], {min_salary: $scope.slider.minValue})
           angular.extend($scope.searchDetails[0], {max_salary: $scope.slider.maxValue})
           $location.search('min_salary', $scope.slider.minValue )
           $location.search('max_salary', $scope.slider.maxValue)

           ////console.log($scope.searchDetails[0]);
           $scope.GetJobs({params: $scope.searchDetails[0] })
        }
      $scope.clearFilter = function() {
            ////console.log($scope.searchDetails[0])
            angular.forEach($scope.searchDetails[0], function(val, key){
              var obj = "{"+key+": ''}";
              var objson = angular.toJson(obj, true);
              angular.extend($scope.searchDetails[0], objson);
            })
            $scope.GetJobs( {params: $scope.searchDetails[0]});
          }

      //Pagination buttons
      $scope.first = function( limit ){
        $location.search('offset', 0);
        delete $scope.searchDetails[0]['offset'];
        $scope.searchDetails[0].offset = 1;
        $scope.GetJobs( {params: $scope.searchDetails[0]}  );
        angular.element( $("html, body")).animate({ scrollTop: 0}, 1000);
      }
      $scope.activeClass = function ( offsetVal ) {
        if (offsetVal == $scope.searchDetails[0].offset) {
          return 'activepage'
        }
      }
      $scope.last = function( last, limit ){
        var newTotal = Math.round( last * 10 ) / 10;
        var  decimal =  fract(newTotal);
        if (decimal <= 4) {
          var lastItem = Math.round( newTotal ) + 1;
        } else {
          var lastItem = Math.round(newTotal);
        }
        var lastoffset =   (lastItem - 1) * limit;
        $location.search('offset', lastoffset);
        delete $scope.searchDetails[0]['offset'];
        $scope.searchDetails[0].offset = parseInt(lastoffset);
        $scope.GetJobs( {params: $scope.searchDetails[0]});
        angular.element( $("html, body")).animate({ scrollTop: 0}, 1000);
      }
      $scope.prev = function( limit ) {
        var prevpage = parseInt($scope.searchDetails[0].offset) - parseInt(limit);
        $location.search('offset', prevpage)

        delete $scope.searchDetails[0]['offset']
        $scope.searchDetails[0].offset = parseInt(prevpage)

        $scope.GetJobs( {params: $scope.searchDetails[0]});
        angular.element( $("html, body")).animate({ scrollTop:0}, 1000);
      }
      $scope.gotooffset = function( param ) {
            $location.search('offset', param);
            delete $scope.searchDetails[0]['offset'];
            $scope.searchDetails[0].offset = parseInt(param);
            $scope.GetJobs( {params: $scope.searchDetails[0]});
            angular.element( $("html, body")).animate({ scrollTop: 0}, 1000);
          }
      $scope.next = function( limit ){
            var nextpage = parseInt($scope.searchDetails[0].offset) + parseInt( limit );

            $location.search('offset', nextpage.toString() )
            delete $scope.searchDetails[0]['offset']
            $scope.searchDetails[0].offset = parseInt(nextpage)

            $scope.GetJobs( {params: $scope.searchDetails[0]}  );
            angular.element( $("html, body")).animate({ scrollTop: 0 }, 1000);
          }
      $scope.follow = function(company_id) {
            var token = $cookies.get('token')
            $http.post(GlobalConstant.CandidateRootApi + '/company/follow/' + company_id  )
            .then(function(response) {
              if(response.data.data.followed){
                angular.element($('.f_'+company_id)).show()
                angular.element($('.uf_'+company_id)).hide()
                angular.element($('#comp_'+val.id).addClass('following') )
              } else {
                angular.element($('.f_'+company_id)).hide()
                angular.element($('.uf_'+company_id)).show()
                angular.element($('#comp_'+val.id).removeClass('following') )
              }
            }, function errorCallback(response) {});
          }

      //Search if has query strings
      if ( angular.isDefined($scope.searchDetails[0]) )  {

              $scope.GetJobs({params: $scope.searchDetails[0]});
              $scope.refreshslider();
          }

      //Watch Global searchbar
      $scope.$watch(function () { return GlobalSearch.getSearchVal(); }, function (newValue, oldValue) {
        if (newValue !== oldValue){
          angular.extend($scope.searchDetails[0], {q: newValue});
          $scope.GetJobs( {params: $scope.searchDetails[0]});
          $location.search('q', newValue);
        }
      });
      $scope.searchJob = function () {
            //Check if has token
            if ( angular.isUndefined($scope.searchJobId)) {
              return false;
            }
            var location = $location.search( )

            if (location.offset != "0"   ) {
              $location.search('offset',0);
              delete $scope.searchDetails[0]['offset'];
              $scope.searchDetails[0].offset = 0
            }

            angular.extend($scope.searchDetails[0], {q: $scope.searchJobId});

            $scope.GetJobs( {params: $scope.searchDetails[0] } );

            angular.forEach($scope.searchDetails[0], function(val, key){

                if(angular.isArray(val)){
                    //updating data to be submitted
                    if (val.length !== 0) {

                        $location.search(key, val.toString());

                    }else if (val.length === 0) {}{

                        $location.search(key, null);
                    }
                } else {

                    if (val.length !== 0 ) {
                        $location.search([key], val.toString());
                    } else {
                        $location.search(key, null);
                    }
                }
            })
          }
      $scope.removeTag = function(parent, id) {
            if (angular.isArray(parent) ) {
              angular.forEach(parent, function(val, key){
                angular.forEach($scope.selectedParams, function( v, k){
                  if (k == val) {
                    delete $scope.selectedParams[k];
                    delete $scope.searchDetails[0][k];

                    var obj = "{"+key+": null}";
                    var objson = angular.toJson(obj, true);
                    $location.search(objson);
                  }
                });
              });
            } else {
              if (parent == 'q') {
                //delete $scope.searchDetails[0]['q'];
                $location.search('q', '');
                $scope.GetJobs({params: $scope.searchDetails[0]});
                $scope.refreshslider();
                
              }
              else if(parent == 'company_name') {
                delete $scope.searchDetails[0]['company_name'];
                $scope.GetJobs( {params: $scope.searchDetails[0]});
                $scope.refreshslider();
                $location.search('company_name', null);

              } else {
                angular.forEach($scope.selectedParams, function( val, key) {
                  if (key == parent) {
                    var index = val.indexOf(id);
                    val.splice(index,1)
                  }
                });
              }
            }
          }

      //Auto select Parent when child is selected
      $scope.FindParent = function( parentid, type ){
        if (type == 'industry') {
          var index =  $scope.selectedParams.industry.indexOf(parentid)
        }else if (type == 'location') {
          var index =  $scope.selectedParams.state.indexOf(parentid)
        }

        if ( angular.element($('.selectAll_'+parentid)).is(':checked') )
        { angular.element($('.selectAll_'+parentid)).attr('checked', false) }

        if (index == -1) {
          var concatme =  parentid.toString();
          if (type == 'industry') {
            //Assign value to parent
            if ($scope.selectedParams.industry.length != 0) {
              delete $scope.searchDetails[0].industry
              angular.extend($scope.searchDetails[0], {industry: $scope.selectedParams.industry+ ','+concatme })
            } else {
              delete $scope.searchDetails[0].industry
              angular.extend($scope.searchDetails[0], {industry: concatme })
            }
          } else if (type == 'location') {
            //Assign value to parent
            if ($scope.selectedParams.state.length != 0) {
              delete $scope.searchDetails[0].state
              angular.extend($scope.searchDetails[0], {state: $scope.selectedParams.region+ ','+concatme })

            } else {
              delete $scope.searchDetails[0].state;
              angular.extend($scope.searchDetails[0], {state: concatme});
            }
          }
          $scope.GetJobs({params: $scope.searchDetails[0]});
        }
        return false
      }
      $scope.uncheckSubs = function(parentid, type, country) {
            //select industry that was unchecked

            /*angular.extend($scope.searchDetails[0], {Country: country});
            $location.search('Country', country)
            console.log('hello', $scope.searchDetails[0]);*/
            $scope.findsubs = []
            if (type == 'industry') {
              var selected = $filter('filter')($scope.industries, {id: parentid}, true);
              //if uncheck triggered
              if( !angular.element($("#industry_"+parentid.toString() ) ).is(":checked") ){
                //select only id for selected parent id
                angular.forEach(selected, function(v, k){
                  angular.forEach($scope.selectedParams.sub_industry, function(selected_val, selected_key){
                    var selectedsub = $filter('filter')(v.sub, {id: selected_val}, true);
                    if (selectedsub.length != 0) {
                      $scope.findsubs.push(selectedsub[0].id)
                    }
                  });
                })

                var foundsubs = $scope.findsubs;
                var subind = $scope.searchDetails[0].sub_industry.split(',')

                angular.forEach(foundsubs, function(val, key) {
                  //var findsub = $filter('filter')(subind,  val.toString()  , true);
                  var index = subind.indexOf(val.toString());
                  subind.splice(index, 1);
                });

                delete $scope.searchDetails[0].sub_industry;
                angular.extend($scope.searchDetails[0], {sub_industry: subind.toString() })
                //Uncheck All Industry checkbox
                angular.element($('.selectAll_'+parentid )).attr('checked', false)
                //$scope.ShowAll = false

                //get new sets of searched items
                $scope.GetJobs( {params: $scope.searchDetails[0]});
                return false;
              }
            } else if (type == 'location') {
              var selected = $filter('filter')($scope.locations, {id: parentid}, true);
              if(!angular.element($("#region_"+parentid.toString())).is(":checked") ){
                //select only id for selected parent id
                angular.forEach(selected, function(v, k) {
                  //get sub location of each selected state
                  angular.forEach(v.location, function(location_v, location_k) {
                    angular.forEach($scope.selectedParams.area, function(selected_val, selected_key){
                      var selectedsub = $filter('filter')(location_v.area, {id: selected_val}, true);
                      if (selectedsub.length != 0) {
                        $scope.findsubs.push(selectedsub[0].id);
                      }
                    });
                  })
                  //For each selected areas
                })
                var foundsubs = $scope.findsubs;
                var subind = $scope.searchDetails[0].area.split(',')

                angular.forEach(foundsubs, function(val, key){
                  //var findsub = $filter('filter')(subind,  val.toString()  , true);
                  var index = subind.indexOf( val.toString() )
                  subind.splice(index, 1)
                })
                delete $scope.searchDetails[0].area;
                angular.extend($scope.searchDetails[0], {area: subind.toString()});
                //Uncheck All Industry checkbox
                angular.element($('.selectAll_'+parentid )).attr('checked', false)
                //$scope.ShowAll = false

                //get new sets of searched items
                $scope.GetJobs({params: $scope.searchDetails[0]});
                return false;
              }
            }
          }

      //Watch Checked checkbox
      $scope.$watch('selectedParams', function(newVal, oldVal ){
        //Add access token if logged in
        if ( $scope.equalArray(oldVal, newVal ) == false && angular.isDefined(oldVal) ) {
          //Add offset default
          var location = $location.search();
          if(angular.isUndefined(location.offset)  ){
            $location.search('offset',0);
            delete $scope.searchDetails[0]['offset'];
            $scope.searchDetails[0].offset = 0
          }

          angular.forEach(newVal, function(val, key){
            if(angular.isArray(val)){
              //updating data to be submitted
              if (val.length != 0) {
                $location.search(key, val.toString());
                var test =  JSON.parse('{ }');
                test[key] = val.toString();
                var obj = angular.toJson( test, true)
                angular.extend($scope.searchDetails[0], JSON.parse(obj));
              } else {
                $location.search([key], null);
                var test =  JSON.parse('{ }');
                test[key] = val.toString();
                var obj = angular.toJson( test, true);
                angular.extend($scope.searchDetails[0], JSON.parse(obj));
              }
            } else {
              if (val.length != 0 ) {
                $location.search([key], val.toString());

                var test =  JSON.parse('{ }');
                test[key] = val.toString();
                //var ob = angular.fromJson({ [key] : parseInt ( val) } )
                var obj = angular.toJson( test, true);
                angular.extend($scope.searchDetails[0], JSON.parse(obj));
              }
            }
          });

          $scope.refreshslider();
          $scope.GetJobs( {params: $scope.searchDetails[0]});
          return false;
        }
      }, true);

      //Load cities when region is cliked
      $scope.loadcity = true;
      $scope.filterRegion = function(parentid, slug) {
          $scope.filteredlocations = [];
           $scope.loadcity = false;
           angular.element($('.locationFilterContainer')).css('right','-620px')
           //$http.get(GlobalConstant.APIRoot + 'static/options/locations/' + slug + '/combined').then(function(response) {
            $http.get(window.location.origin + '/api/locations').then(function(response) {
              var locations =  response.data.data;
              var selected = $filter('filter')(locations, {
                  id: parentid
              }, true);


              $scope.filteredlocations = selected
              $scope.activeLocation = selected[0].id;
              $scope.loadcity = true;
          });
      }
      $scope.filterIndustries = function(parentid) {
              $scope.filteredindutries = [];
              $scope.loadsubind = false;
              $scope.activeItem = parentid;
              angular.element($('.IndustryFilterContainer')).css('right','-610px')
              // $http.get(GlobalConstant.APIRoot + 'static/options/industries/all').then(function(response) { //Uncomment for the live API call
              $http.get(window.location.origin + '/js/minified/test-data/test_classification_data.json').then(function(response) {

                  var industries =  response.data.data;
                  var selected = $filter('filter')(industries, {
                      id: parentid
                  }, true);

                  $scope.filteredindutries = selected

                  $scope.loadsubind = true;

              });


          }
      $scope.SortJobSearch = function(type) {


          if (type == 'job') {
              $scope.jobstyle = {'order':1};
              $scope.comapnystyle = {'order':2};
          }else if(type == 'company'){
              $scope.jobstyle = {'order':2};
              $scope.comapnystyle = {'order':1};

          }
      }
    }
  ]);
}());

$(document).ready(function() {
  $('.listcontainer, .job-filter__scroll').TrackpadScrollEmulator();
  $('#min').text($("#min_salary2").val())
  $('#max').text($("#max_salary2").val() + 'k')
  $('#min_year').text($("#min_y").val())
  $('#max_year').text($("#max_y").val() + 'y+')
  $("#min_salary2").on('change', function(e) {
    e.preventDefault();
    var val = $(this).val();
    val = (val > 0) ? val + 'k' : val;
    $('#min').text(val);
  });

  $("#max_salary2").on('change', function(e) {
    e.preventDefault();
    var val = $(this).val();
    val = (val > 0) ? val + 'k' : val;
    $('#max').text(val);
  });

  $("#min_y").on('change', function(e) {
    e.preventDefault();
    var val = $(this).val();
    val = (val > 0) ? (val == 10) ? val + 'y+' : val + 'y' : val;
    $('#min_year').text(val);
  });

  $("#max_y").on('change', function(e) {
    e.preventDefault();
    var val = $(this).val();
    val = (val > 0) ? (val == 10) ? val + 'y+' : val + 'y' : val;
    $('#max_year').text(val);
  });

  $('.openFilter').click(function() {
    $(".FilterContent").slideToggle("slow", function() {
      // Animation complete.
      if ($('#right-container').length) {
        if ($(".FilterContent").is(':visible')) {
          $(".FilterContent").attr('data-is_visible', 'true')
        } else {
          $(".FilterContent").attr('data-is_visible', 'false')
        }
      }
    });

    if ($('#right-container').length) {
      if ($(".FilterContent").attr('data-is_visible') == 'false') {
        $('#right-container .ui-rangeslider').css('visibility', 'hidden')
      } else {
        $('#right-container .ui-rangeslider').css('visibility', '')
      }
    }
  });

  //Sort Job Results
  $('#job-search-container #filter_by').click(function(){
    $('.filterOption').slideToggle('slow')
  });

  $('.filterOption').mouseleave(function (){
    if ( $(this).is(':visible') ){
      $(this).slideUp('slow')
    }
  });

  if ($('#job-search-filter-content').length) {
    var min = $("#min_salary3").val();
    var max = $("#max_salary3").val();
    $('#slider-range .ui-slider-handle:first').addClass('min').html('<div class="valueslider">$' + min + '</div>');
    $('#slider-range .ui-slider-handle:last').addClass('max').html('<div class="valueslider">$' + max.toString().substring(0, 3) + 'K' + '</div>');
    $("#min_salary3").on('change', function() {
      var minValNow = $('#slider-range .ui-slider-handle:first').attr('aria-valuenow');
      var minstr = minValNow.toString();

      switch (minstr.length) {
          case 4:
            var minval = minstr;
            break;
          case 5:
            var minval = minstr.substring(0, 2) + 'K';
            break;
          case 6:
            var minval = minstr.substring(0, 3) + 'K';
            break;
          default:
            var minval = 0;
        }

      $('#slider-range .ui-slider-handle:first').html('<div class="valueslider">$' + minval + '</div>');
      $("#min_salary3").val(minValNow);
    });

    $("#max_salary3").on('change', function() {
        var maxValNow = $('#slider-range .ui-slider-handle:last').attr('aria-valuenow');
        var maxstr = maxValNow.toString();
        switch (maxstr.length) {
          case 4:
            var maxval = maxstr.substring(0, 1) + 'K';
            break;
          case 5:
            var maxval = maxstr.substring(0, 2) + 'K';
            break;
          case 6:
            var maxval = maxstr.substring(0, 3) + 'K';
            break;
          default:
            var maxval = '500K';
        }

        $('#slider-range .ui-slider-handle:last').html('<div class="valueslider">$' + maxval + '</div>');
        $("#max_salary3").val(maxValNow);
      });
  }
});
//# sourceMappingURL=job-search.min.js.map

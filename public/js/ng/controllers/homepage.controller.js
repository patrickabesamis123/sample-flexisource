(function() {
  'use strict';
  var app = angular.module('app');
  var base_url = $('body').data('base_url');

  app.controller('HomeController', [
    'GlobalConstant',
    '$scope',
    '$cookies',
    '$window',
    '$http',
    '$filter',
    '$timeout',
    '$location',
    function(GlobalConstant, $scope, $cookies, $window, $http, $filter, $timeout, $location) {
      //Deprecated
      //{imgpath: "", title: "", width: "", height: ""}
      $scope.EmployerSlider = [
        {
          imgpath: '/images/homepage/iconset/icon1-new.png',
          title:
            'Promote your brand and online presence with a customised profile and company page',
          width: '35',
          height: '54',
        },
        {
          imgpath: '/images/homepage/iconset/icon2-new.png',
          title:
            'Ask video and text questions to understand candidate’s skills, capability and cultural fit',
          width: '48',
          height: '49',
        },
        {
          imgpath: '/images/homepage/iconset/icon3-new.png',
          title:
            'Save time processing applicants with pre-application questions from your minimum requirements',
          width: '41',
          height: '46',
        },
        {
          imgpath: '/images/homepage/iconset/icon4-new.png',
          title: 'Our service is free',
          width: '49',
          height: '42',
        },
        {
          imgpath: '/images/homepage/iconset/icon5-new.png',
          title: 'Reports and analytics will allow you to recruit through data driven insights',
          width: '53',
          height: '36',
        },
        {
          imgpath: '/images/homepage/iconset/emp-icon6@2x.png',
          title: 'Track and manage applicants with the easy drag and drop system',
          width: '56',
          height: '54',
        },
        {
          imgpath: '/images/homepage/iconset/emp-icon2@2x.png',
          title: 'Dashboards to have complete transparency over the response to your listings',
          width: '44',
          height: '42',
        },
        {
          imgpath: '/images/homepage/iconset/emp-icon3.png',
          title: 'Keep updated with notifications and trackable conversations',
          width: '39',
          height: '49',
        },
        {
          imgpath: '/images/homepage/iconset/emp-icon4.png',
          title: 'Distribute roles using social media',
          width: '40',
          height: '33',
        },
        {
          imgpath: '/images/homepage/iconset/icon1-new.png',
          title:
            'Promote your brand and online presence with a customised profile and company page',
          width: '35',
          height: '54',
        },
      ];

      var color_bg_initial_set = [
        'member-initials--sky',
        'member-initials--pvm-purple',
        'member-initials--pvm-green',
        'member-initials--pvm-red',
        'member-initials--pvm-yellow',
      ];

      $scope.batchEmployer = Math.ceil($scope.EmployerSlider.length / 5);
      $scope.employerby5items = [];
      var x = 0;
      while (x < $scope.batchEmployer) {
        if (x != 0) {
          var startthis = x * 5;
        } else {
          var startthis = x;
        }
        $scope.employerby5items.push({ start: startthis, end: (x + 1) * 5 });

        x++;
      }

      $scope.CandidateSlider = [
        {
          imgpath: '/images/homepage/iconset/cand-icon1@2x.png',
          title: 'Video feature to showcase your personality, skills and experience',
          width: '53',
          height: '51',
        },
        {
          imgpath: '/images/homepage/iconset/cand-icon2@2x.png',
          title: 'Receive feedback on all your applications',
          width: '45',
          height: '37',
        },
        {
          imgpath: '/images/homepage/iconset/cand-icon3@2x.png',
          title: 'The dashboard allows you to track and manage all your applications',
          width: '44',
          height: '42',
        },
        {
          imgpath: '/images/homepage/iconset/cand-icon4@2x.png',
          title: 'Intelligent algorithms to match and notify you so you never miss an opportunity',
          width: '64',
          height: '54',
        },
        {
          imgpath: '/images/homepage/iconset/cand-icon5@2x.png',
          title: 'Faster to apply - one profile for all jobs',
          width: '73',
          height: '26',
        },

        {
          imgpath: '/images/homepage/iconset/cand-icon6@2x.png',
          title: 'View employer profiles before you apply',
          width: '43',
          height: '48',
        },
        {
          imgpath: '/images/homepage/iconset/cand-icon7@2x.png',
          title: 'Our service is completely free',
          width: '49',
          height: '42',
        },
        {
          imgpath: '/images/homepage/iconset/cand-icon1@2x.png',
          title: 'Video feature to showcase your personality, skills and experience',
          width: '53',
          height: '51',
        },
        {
          imgpath: '/images/homepage/iconset/cand-icon2@2x.png',
          title: 'Receive feedback on all your applications',
          width: '45',
          height: '37',
        },
        {
          imgpath: '/images/homepage/iconset/cand-icon3@2x.png',
          title: 'The dashboard allows you to track and manage all your applications',
          width: '44',
          height: '42',
        },
      ];

      $scope.batchCandidate = Math.ceil($scope.CandidateSlider.length / 5);
      $scope.candidateby5items = [];
      var x = 0;
      while (x < $scope.batchCandidate) {
        if (x != 0) {
          var startthis = x * 5;
        } else {
          var startthis = x;
        }
        $scope.candidateby5items.push({ start: startthis, end: (x + 1) * 5 });
        x++;
      }

      //Change banner bg on reload
      if ($cookies.get('home') == '1') {
        $cookies.put('home', '2', { path: '/' });
        $scope.GBClass = 'alternate2';
      } else {
        $cookies.put('home', '1', { path: '/' });
        $scope.GBClass = 'alternate1';
      }

      $scope.hideme = true;
      $scope.locations = [];
      $http.get(GlobalConstant.StaticOptionLocationsApi + '/regions').then(function(response) {
        $scope.locations = response.data.data;
      });

      var typingTimer; //timer identifier
      var doneTypingInterval = 10;
      var idx = 0;
      $('#locationSearch').on('keyup', function(e) {

        if ((e.which >= 37 && e.which <= 40) || e.which == 13) {
          var li = $('#autoDataLocation li');
          if (li.length) {
            if (e.which == 40) {
              if (!li.hasClass('selected_filter')) {
                li.removeClass('selected_filter');
                $('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter');
              } else {
                idx = $('#autoDataLocation li.selected_filter').prevAll().length + 1;
                $('#autoDataLocation li').removeClass('selected_filter');

                if ($('#autoDataLocation li:eq(' + idx + ')').nextAll().length == 0) {
                  idx = li.length - 1;
                }

                $('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter');
              }
            } else if (e.which == 38) {
              if (li.hasClass('selected_filter')) {
                idx--;
                idx = idx <= 0 ? 0 : idx;
                //console.log(idx)
                li.removeClass('selected_filter');
                $('#autoDataLocation li:eq(' + idx + ')').addClass('selected_filter');
              }
            } else if (e.which == 13) {
              var userOption = $('#autoDataLocation li:eq(' + idx + ')')
                .find('a')
                .text();
              $('#locationSearch').val(userOption);
              $('#autoDataContainer').addClass('ng-hide');
              idx = 0;
            }
          }
          return false;
        }
        $timeout.cancel(typingTimer);
        typingTimer = $timeout(doneTyping, doneTypingInterval);
      });

      $('#locationSearch').change(function() {
        $('#autoDataLocation').on('click', 'li', function() {
          $('#locationSearch').val(
            $(this)
              .find('a')
              .text(),
          );
          if (!$('#autoDataContainer').hasClass('ng-hide')) {
            $('#autoDataContainer').addClass('ng-hide');
          }
          idx = 0;
        });
      });

      $scope.filterbutton = true;
      $scope.selectedParams = {};
      $scope.selectedParams.keyword = '';
      $scope.selectedParams.role_type = [];
      $scope.selectedParams.classification = [];
      $scope.selectedParams.subclassification = [];
      $scope.selectedParams.location = [];

      function getClassifications() {
        
        $scope.classifications = [];
        $http
          .get(window.location.origin  + '/api/industries/list-parent-and-sub')
          .then(function(response) {
            $scope.classifications = response.data;
          });
      }
      getClassifications();
      $scope.getAutoCompleteData = function(data) {
        //console.log(data)
        //$scope.location.data.display_name = data.display_name;
        //$scope.location.data.id = data.id;
        angular.element($('input[name=areaid]')).val(data.id);
        angular.element($('input[name=area]')).val(data.display_name);
        $scope.selectedParams.location.push({ display_name: data.display_name, area_id: data.id });
        angular.element($('#autoDataContainer')).hide();
      };

      //user is "finished typing," do something
      function doneTyping() {
        $scope.autoLocation = [];
        $http
          .get(window.location.origin  + '/api/location/auto-complete-search/'+$scope.searchLocation)
          .then(function(response) {
            $scope.autoLocation = response.data;
            if ($scope.autoLocation.length >= 1) {
              //$('#autoDataContainer').addClass('ng-hide');
              $('#autoDataContainer').removeClass('ng-hide');
              $('#autoDataContainer').show();
              $('#autoDataLocation').removeClass('ng-hide');
              $('#autoDataLocation').show();
            } else {
              //console.log('has result')
              //$('#autoDataContainer').removeClass('ng-hide');
              $('#autoDataContainer').addClass('ng-hide');
              $('#autoDataContainer').hide();
              $('#autoDataLocation').addClass('ng-hide');
              $('#autoDataLocation').hide();
            }
            // console.log($scope.autoLocation.length);
            // console.log($scope.autoLocation);
          });
      }

      //$scope.newLocation = ""
      // $scope.$watch('searchLocation', function(newVal, oldVal){
      //  $scope.newLocation = newVal
      // })
      $scope.selectedParams.classification = [];
      $scope.selectedParams.subclassification = [];
      $scope.selectClassification = function(industry) {
        
        
        if($scope.selectedParams.classification.indexOf(industry) !== -1) {
          var index = $scope.selectedParams.classification.indexOf(industry);
          $scope.selectedParams.classification.splice(index, 1);     
        } else {
          $scope.selectedParams.classification.push(industry);
        }
      };
      $scope.selectSubClassification = function(sub_industry) {
        
        if($scope.selectedParams.subclassification.indexOf(sub_industry) !== -1) {
          var index = $scope.selectedParams.subclassification.indexOf(sub_industry);
          $scope.selectedParams.subclassification.splice(index, 1);     
        } else {
          $scope.selectedParams.subclassification.push(sub_industry);
        }
      };

      $scope.selectRoleType = function(role_type) {
        
        if($scope.selectedParams.role_type.indexOf(role_type) !== -1) {
          var index = $scope.selectedParams.role_type.indexOf(role_type);
          $scope.selectedParams.role_type.splice(index, 1);
          $('.role_type_' + role_type).removeClass('ui-checkbox-on');
          $('.role_type_' + role_type).addClass('ui-checkbox-off');
        } else {
          $scope.selectedParams.role_type.push(role_type);
          $('.role_type_' + role_type).removeClass('ui-checkbox-off');
          $('.role_type_' + role_type).addClass('ui-checkbox-on');
        }
      };

      $scope.SeachJob = function() {
        var message = "";
        $scope.min_salary = $('#min_salary').val();
        $scope.max_salary = $('#max_salary').val();
        
        var search_type='&search_type=job';
        var role_type='&role_type=';
        if ($scope.selectedParams.role_type.length != 0) {
          var role_type = '&role_type=' + $scope.selectedParams.role_type.toString();
        } 

        if ($scope.min_salary == '0' && $scope.max_salary == '200000') {
          var range = '&min_salary=0&max_salary=200000';
        } else {
          var range = '&min_salary=' + $scope.min_salary + '&max_salary=' + $scope.max_salary;
        }

        var country = '&country=';

        var searchLocation = '&state=&area=';
        if ($scope.selectedParams.location.length != 0) {
          searchLocation = '&state=1&area=' + $scope.selectedParams.location[0].area_id;
        }

        var location = '&location=';
        $scope.max_salary = $('#locationSearch').val();

        if ($scope.max_salary  != '' ) {
          var location = location + $scope.max_salary;
        }

        var searchitem = '';

        if (angular.isDefined($scope.selectedParams.keyword)) {
          var searchitem = $scope.selectedParams.keyword;
        }
        var industry = '&industry=';

        if ($scope.selectedParams.classification.length != 0) {
          console.log($scope.selectedParams.classification.toString());
          var industry = '&industry=' + $scope.selectedParams.classification.toString();
        } 

        var sub_industry = '&sub_industry=';

        if ($scope.selectedParams.subclassification.length != 0) {
          var sub_industry = '&sub_industry=' + $scope.selectedParams.subclassification.toString();
        } 
        var offset = '&offset=0';
        var searchUrl = 'q=' + searchitem + industry + sub_industry + range + searchLocation + role_type + country + offset + location + search_type;
        console.log(searchUrl);
        $window.location.href = '/job-search/#?' + searchUrl;
      };

      //New Homepage Start
      if ($('#about_video').length) {
        var vidDuration = 0,
          intWhole,
          intFloating;
        var myPlayer = amp(
          'about_video',
          {
            techOrder: ['azureHtml5JS', 'flashSS', 'silverlightSS', 'html5'],
            nativeControlsForTouch: false,
            autoplay: true,
            controls: true,
            width: '503',
            height: '230',
            logo: {
              enabled: false,
            },
            poster: '',
          },
          function() {
            // console.log('Good to go!');
            // add an event listener
            this.addEventListener('ended', function() {
              // console.log("where you at playing boye (ended): ", this.currentTime());
              // alert("DONE!");
            });

            this.addEventListener('play', function() {
              // console.log("play shet!");
              // console.log("where you at: ", this.currentTime());
              // alert("ya boye");
            });

            this.addEventListener('start', function() {
              // console.log("start shet!", $scope.shite);

              vidDuration = this.duration();
              intWhole = parseInt(vidDuration, 10);
              intWhole = intWhole / 60;
              intFloating = intWhole % 1;
              intWhole = parseInt(intWhole, 10);
              intFloating = intFloating.toFixed(2);
              intFloating = 0.6 * intFloating;
              intFloating = Math.round(intFloating * 100) / 100;
              vidDuration = intWhole + intFloating;
              // console.log("total duration: ", vidDuration);
            });

            // this.addEventListener('timeupdate', function () {
            //  console.log("where you at playing boye: ", this.currentTime());
            // });

            this.addEventListener('midpoint', function() {
              // console.log("where you at playing boye (midpoint): ", this.currentTime());
            });

            this.addEventListener('firstquartile', function() {
              // console.log("where you at playing boye (firstquartile): ", this.currentTime());
            });
          },
        );

        myPlayer.src([
          {
            // src: 'https://pvmlive.streaming.mediaservices.windows.net/e58e3f83-0904-4886-836e-ac28303831fe/INTRO VID.ism/manifest',
            src:
              'https://518761399c1a4eb19173af408d10c8d6.azureedge.net/d094ce61-de38-4620-89bf-146d79233936/Preview Me_FINAL.ism/manifest',
            type: 'application/vnd.ms-sstr+xml',
          },
        ]);
      }

      $scope.ShowHide = function() {
        $scope.filterbutton = $scope.filterbutton ? false : true;
      };

      angular.element($('#moreFilter'), $('#hideFilter')).click(function() {
        angular.element($('#toggleFilter')).slideToggle('slow', function() {});
      });

      $scope.job_types = [];
      $http.get(window.location.origin + '/api/work-types').then(function(response) {
        $scope.job_types = response.data;
      });

      //Get All indsutries
      // $http.get(  GlobalConstant.APIRoot + 'static/options/industries/all' ) //Uncomment for live API call
      $http
        .get(window.location.origin + '/js/minified/test-data/test_job_listing_data.json')
        .then(function(response) {
          var data = response.data.data;
          $scope.all_industries = data;
          //console.log($scope.all_industries)
        });

      $scope.parentClassifications = null;
      $scope.hoverIndustry = function(data, parentClassifications) {
        $scope.SubsClassifications = data;
        $scope.parentClassifications = parentClassifications;
      };

      $scope.sub_industry_selected = function(obj) {
        //force parent to check
        if (!angular.element($('#all_industry_' + obj)).is(':checked')) {
          $scope.selectedParams.classification.push(obj);
        }
      };

      $scope.RemoveChild = function(subdata) {
        //console.log(subdata);
        angular.forEach(subdata, function(val, key) {
          if ($.inArray(val.id, $scope.selectedParams.subclassification, 0) != -1) {
            $scope.selectedParams.subclassification.splice(
              $.inArray(val.id, $scope.selectedParams.subclassification, 0),
            );
          }
        });
        //console.log($scope.selectedParams.subclassification)
      };

      $scope.checkAll = function(parent) {
        // console.log(parent)
      };

      $scope.onHoverSubIndustries = true;

      document.showSubIndustries = function(obj) {
        $scope.onHoverSubIndustries = true;
        if (obj) {
          angular
            .element($(obj))
            .parent()
            .find('.subindustry_multi_main')
            .removeClass('hide');
        }
      };

      document.hideSubIndustries = function(obj) {
        $scope.onHoverSubIndustries = false;
        setTimeout(function() {
          if ($scope.onHoverSubIndustries == false) {
            $('.togglethis').trigger('click');
            //$(obj).find('.subindustry_multi_main').addClass('hide');
            //$(obj).find('.industry_multi_main').addClass('hide');
          }
        }, 1500);
      };
      //Get Featured jobs
      $http.get(GlobalConstant.APIRoot + 'jobs/featured').then(function(response) {
        var data = response.data.data;
        $scope.featuredJobs = data.results.jobs;

        // Add initials
        for (var a = 0; a < $scope.featuredJobs.length; a++) {
          var featured_initialize = $scope.featuredJobs[a].company_name;
          var featured_initial = featured_initialize.replace(/[^A-Z]/g, '');
          // var featured_initial;

          // If no cap letters detected on string, use other method BEGIN
          if (featured_initial.length < 1) {
            var space_count = featured_initialize.split(' ').length - 1;
            var indexed_char = featured_initialize;
            var tempinitial;

            if (space_count >= 1) {
              var rotator = 0;
              for (var spc_itr_jobs = 0; spc_itr_jobs <= space_count; spc_itr_jobs++) {
                if (spc_itr_jobs == 0) {
                  tempinitial = featured_initialize.substr(0, 1);
                  indexed_char = indexed_char.substr(indexed_char.indexOf(' ') + 1);
                } else {
                  if (
                    indexed_char != -1 &&
                    indexed_char.substr(0, indexed_char.indexOf(' ')) != ''
                  ) {
                    tempinitial = indexed_char.substr(0, indexed_char.indexOf(' '));
                    indexed_char = indexed_char.substr(indexed_char.indexOf(' ') + 1);
                  } else {
                    tempinitial = indexed_char.substr(0, 1);
                  }
                }
                featured_initial = featured_initial + tempinitial.substr(0, 1).toUpperCase();
              }
            } else {
              featured_initial = featured_initialize.substr(0, 3);
            }
          }
          // If no cap letters detected on string, use other method END
          featured_initial = featured_initial.substr(0, 3);
          $scope.featuredJobs[a].initial = featured_initial;

          // change default photo's background color
          var color_bg_initial =
            color_bg_initial_set[Math.floor(Math.random() * color_bg_initial_set.length)];
          $scope.featuredJobs[a].featured_color = color_bg_initial;
        }

        // console.log("featured jobs: ", $scope.featuredJobs);
        $scope.batchJobs = Math.ceil($scope.featuredJobs.length / 5);
        $scope.jobsby5items = [];
        var x = 0;
        while (x < $scope.batchJobs) {
          if (x != 0) {
            var startthis = x * 5;
          } else {
            var startthis = x;
          }
          $scope.jobsby5items.push({ start: startthis, end: (x + 1) * 5 });

          x++;
        }
      });
    },
  ]);
})();

$(document).ready(function() {
  var min = $('#min_salary').val();
  var max = $('#max_salary').val();

  $('#slider-range .ui-slider-handle:first')
    .addClass('min')
    .html('<div class="valueslider">$' + min + '</div>');
  $('#slider-range .ui-slider-handle:last')
    .addClass('max')
    .html('<div class="valueslider">$' + max.toString().substring(0, 3) + 'K+' + '</div>');

  $('#min_salary').on('change', function() {
    var minValNow = $('#slider-range .ui-slider-handle:first').attr('aria-valuenow');
    var minstr = minValNow.toString();
    //console.log(minstr.length)
    switch (minstr.length) {
      case 4:
        var minval = minstr.substring(0, 1) + 'K';
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

    $('#slider-range .ui-slider-handle:first').html(
      '<div class="valueslider">$' + minval + '</div>',
    );
    $('#min_salary').val(minValNow);
  });

  $('#max_salary').on('change', function() {
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

    $('#slider-range .ui-slider-handle:last').html(
      '<div class="valueslider">$' + maxval + '</div>',
    );
    if (maxval == '200K') {
      $('#slider-range .ui-slider-handle:last').html(
        '<div class="valueslider">$' + maxval + '+</div>',
      );
    }

    if (maxValNow < 180000) {
      $('.ui-slider-bg.ui-btn-active').html('<div class="maxValue">$200K+</div>');
    } else {
      $('.ui-slider-bg.ui-btn-active').html('');
    }

    $('#max_salary').val(maxValNow);
  });

  $('input[type=radio][name=user_type]').change(function() {
    if (this.value == 'candidate') {
      $('#HomeContact .action').val('Sign up as a candidate');
      $('#HomeContact .action').removeClass('submitblue whitetext');
      $('#HomeContact .action').addClass('submityellow');
    } else if (this.value == 'employer') {
      $('#HomeContact .action').val('Sign up as an employer');
      $('#HomeContact .action').addClass('submitblue whitetext');
      $('#HomeContact .action').removeClass('submityellow');
    }
  });

  $('#Tab1 a').click(function(e) {
    e.preventDefault();
    $(this).tab('show');
  });

  $('.sliderContainer').TrackpadScrollEmulator();
  $('.togglethis').click(function() {
    $('#ClassificationMain').slideToggle(function() {
      if ($('#ClassificationMain').is(':visible')) {
        $('.togglethis').addClass('focusthis');
        // console.log('vs')
      } else if ($('#ClassificationMain').is(':hidden')) {
        // console.log('hidden')
        $('.togglethis').removeClass('focusthis');
      }
    });
  });

  //Bootstrap Carousel Next Previous custom fix
  var handle_nav = function(e) {
    e.preventDefault();
    var target = $(this).data('target');

    if ($(this).hasClass('left')) {
      $(target).carousel('next');
    }

    if ($(this).hasClass('right')) {
      $(target).carousel('next');
    }
  };

  $('.carouselthis')
    .carousel({
      interval: false,
      wrap: false,
    })
    .on('click', '.carousel-control', handle_nav)
    .on('slid.bs.carousel', function(e) {
      var $this = $(this);
      var getitems = $this.find('.item');
      // console.log( getitems.last().hasClass('active') )

      if (getitems.last().hasClass('active')) {
        var right = $this.find('.right');
        right.bind('click', function() {
          //getitems.last().removeClass('active');
          //getitems.first().addClass('active');
          // console.log($(this).parent() )
          $(this)
            .parent()
            .carousel(0);
        });
        return false;
      } else {
        var right = $this.find('.right');
        right.unbind('click');
      }
    })
    .swiperight(function(e) {
      e.preventDefault();
      var target = $(this).data('target');
      $(this).carousel('prev');
    })
    .swipeleft(function(e) {
      e.preventDefault();
      var target = $(this).data('target');
      $(this).carousel('next');
    });
});

//# sourceMappingURL=homepage.controller.min.js.map

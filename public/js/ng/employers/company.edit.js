(function() {
  'use strict';
  var app = angular.module('app');
  var base_url = $('body').data('base_url');

  app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(false);
  }]);

  app.controller('EmployerCompany', ['GlobalConstant', 'fileUploadService', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile', 'employerFactory',
  function(GlobalConstant, fileUploadService, $scope, $window, $http, $cookies, $filter, $timeout, $compile, employerFactory) {
    $scope.token = $cookies.get('token');
     // Video/Image Modal buttons
    $scope.record_btn = false;
    $scope.record_again_btn = false;
    $scope.stop_btn = false;
    $scope.save_btn = false;
    $scope.change_btn = false;
    // Video/Image Modal Sections
    $scope.showSection1 = false;
    $scope.showSection2 = true;
    $scope.modal_percent = true;
    // Modal drag drop images
    $scope.ondragoverout_image = false;
    $scope.ondragover_image = true;
    // Init size on image cropping
    $scope.crop_data = {w: 240, h: 240, x: 80, y: 0};
    $scope.number_of_employees = [
      '1 - 5', '6 - 19', '20 - 49', '50 - 99', '100 - 499', '500 - 999', '1000 - 2999', '3000 - 4999',' 5000 - 9999', '10000 +'
    ];

    // Detect mobile agent
    $scope.mobile_agent = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
    $scope.isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    // Company video initialy hide
    $scope.showVideo = false;

    $scope.open_camera_new = function() {
      $('#pmvCameraModalNew').modal('show');
      $('#pmvCameraModalNew').on('shown.bs.modal', function() {
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
      });
    }

    document.dropVideoModalNew = function(ev) {
      ev.preventDefault();
      $scope.ondragoverout_image = false;
      $scope.ondragover_image = true;
      $scope.new_video_upload_modal('', ev);
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

    $scope.preload = true
    // Employer company
    // $http.get(GlobalConstant.EmployerRootApi  +'/company') //Uncomment for live API call
    $http.get(window.location.origin + '/js/minified/test-data/test_edit_company_data.json')
    .then(function(response) {
      response = response.data[0];
      $scope.employer_company = response;
      $scope.preload = false
      angular.forEach(response, function(v,k) {
        $scope[k] = v;
      });
      // Get Company Api
      // $http.get(GlobalConstant.CompanyApi + '/' + response.company_url).then(function(response) {//Uncomment for live API call
        $http.get(window.location.origin + '/js/minified/test-data/test_edit_company_other_details_data.json').then(function(response) {
        if(response.status == 200) {
          var data = response.data[0];
          ////console.log(data)

          $scope.company = data.company;
          $scope.extra_data = data.extra_data;
          $scope.follower_text = $scope.extra_data.followers == 0 ||
          $scope.extra_data.followers > 1 ? 'Followers' : 'Follower';
        }
      });

      $scope.$watch('rowform3.$visible', function() {
        if(this.last) {
          $('#multi_location_holder').html("");
          if($scope.company_branch_locations.length) {
            angular.forEach($scope.company_branch_locations, function(v,k) {
              var strElement = '<div class="provider_container_con">\
              <div class="col-md-10" class="">\
                <input type="text" name="location[]" placeholder="Enter location" value="'+v.address+'" class="filterQualification" rows="3">\
                <input type="text" name="phone[]" placeholder="Enter Phone number" value="'+v.phone_number+'" class="filterQualification" rows="3">\
              </div>\
              <div class="col-md-2 row plus-minus-wrapper">\
              <a class="add addNewProvider col-md-6 pvm-green"><span>+</span></a>';
              if(k > 0) {
                strElement += '<a class="add removeNewProvider col-md-6"><span>-</span></a>';
              }
              strElement += '</div></div>';

              $('#multi_location_holder').append(strElement);
            });
          } else {
            var strElement = '<div class="provider_container_con">\
              <div class="col-md-10" class="">\
                <input type="text" name="location[]" placeholder="Enter location" class="filterQualification" rows="3">\
                <input type="text" name="phone[]" placeholder="Enter Phone number"  class="filterQualification" rows="3">\
              </div>\
              <div class="col-md-2 row plus-minus-wrapper">\
                <a class="add addNewProvider col-md-6 pvm-green"><span>+</span></a>\
              </div>\
            </div>';

            $('#multi_location_holder').html(strElement);
          }
        }
      });

      $(document).on("click", ".addNewProvider", function(event) {
        var strElement = '<div class="provider_container_con">\
        <div class="col-md-10" class="">\
          <input type="text" name="location[]" placeholder="Enter location" class="filterQualification" rows="3">\
          <input type="text" name="phone[]" placeholder="Enter Phone number" class="filterQualification" rows="3">\
        </div>\
        <div class="col-md-2 row plus-minus-wrapper">\
          <a class="add addNewProvider col-md-6 pvm-green"><span>+</span></a>\
          <a class="add removeNewProvider col-md-6"><span>-</span></a>\
        </div>\
        </div>';

        $(this).parents('#multi_location_holder').append(strElement);
      });

      $(document).on("click", ".removeNewProvider", function(event) {
        $(this).parents('.provider_container_con').remove();
      });

      $scope.updateBranches = function() {
        var locations_array = [];
        var form = $('#branch_form').serializeArray();
        var data = {};
        angular.forEach(form, function(v,k) {
          if(v.name == 'location[]') {
            data.address = v.value;
          } else {
            data.phone_number = v.value;
            if(data.address != "" && data.phone_number != "") {
              locations_array.push(data);
            }
            data = {};
          }
        });

        var formData = {data : {"company_branch_locations":locations_array}};
        $scope.company_branch_locations = locations_array;
        UpdateCompany(formData);
      }
      $scope.showVideo = false;
      $scope.videobuttom = false;
      if($scope.company_video) {
        $scope.showVideo = true;
        var myPlayer = amp('vid1', {
          "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
          "nativeControlsForTouch": false,
          autoplay: false,
          controls: true,
          width: "275",
          logo: {"enabled": false},
          poster: ""
        }, function() {});

        if($scope.company_video.doc_url != '') {
          var docurl = $scope.company_video.doc_url;
          var docurlcount = docurl.split('/');
          //console.log( docurlcount )

          if (docurlcount.length == 1) {
            //console.log('aa')
            $scope.showVideo = false;
            $scope.showError = true;
            $scope.ErrorVideo = $scope.company_video.doc_url;
          } else {
            $scope.showVideo = true;
            $scope.showError = false

            myPlayer.src([{
            src: $scope.company_video.doc_url,
            type: "application/vnd.ms-sstr+xml"
            }]);
          }

        } else {
          $scope.showVideoLoding = true;
        }
      }

      $('.vid_holder').mouseover(function() {
         $scope.videobuttom = true;
      });
      $('.vid_holder').mouseleave(function() {
        $scope.videobuttom = false;
      })
    },
    function (response) {});

    $scope.industries = []
    $scope.loadIndustries = function() {
      $http.get(GlobalConstant.StaticOptionIndustryApi).then(function(response) {
      $scope.industries = response.data.data;
      });
    }

    $scope.$watch('industry.data.industry.id', function(newVal, oldVal) {
      if (typeof newVal != 'undefined' && newVal.id !== oldVal) {
        var selected = $filter('filter')($scope.industries, {
          id: newVal
        });

        if (angular.isUndefined(selected[0]) == false) {
          $scope.industry.data.industry.display_name = selected[0].display_name;
          $scope.industry.data.industry.id = newVal;
          // $scope.loadSubIndustries();
        }
      }
    });

    $scope.subIndustries = [];
    $scope.loadSubIndustries = function() {
      $http.get(GlobalConstant.StaticOptionSubIndustryApi + '/'+ $scope.industry.id)
      .then(function(response) {
        $scope.subIndustries = response.data.data;
      });
    }

    $scope.$watch('industry.sub_industry.id', function(newVal, oldVal) {
      if (typeof newVal != 'undefined' && newVal !== oldVal) {
        var selected = $filter('filter')($scope.subIndustries, {id: newVal});

        if (angular.isUndefined(selected[0]) == false) {
          $scope.industry.sub_industry.display_name = selected[0].display_name;
        }
      }
    });

    /*
       //Preferred location
    $scope.suburbs = [];
    $scope.loadSuburbs = function(getCityId) {
      var id = getCityId;
       if(!id) return false;

      $http.get(GlobalConstant.StaticOptionLocationsApi + '/suburbs/' + id).then(function(response) {
      $scope.suburbs = response.data.data;
      });
    }


    $scope.regions = [];
    $scope.loadRegions = function() {
      $http.get(GlobalConstant.StaticOptionLocationsApi + '/regions').then(function(response) {
      $scope.regions = response.data.data;

      //get dropdown values on load
      if ($scope.location.data.region.id !== null || $scope.location.data.city.id !== null) {

        $scope.loadCities($scope.location.data.region.id);
        $scope.loadSuburbs($scope.location.data.city.id);
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


    $scope.cities = [];
    $scope.loadCities = function(getRegionId) {
      var id = getRegionId;
      if(!id) return false;

      $http.get(GlobalConstant.StaticOptionLocationsApi + '/cities/' + id).then(function(response) {
      $scope.cities = response.data.data;


        $('select[name=city]').change(function() {
        var str = $(this).val();
        var nstr = parseInt(str.replace('number:', ''));

        $scope.loadSuburbs(nstr);
      });



      });
    }


    $scope.$watch('location.data.region.id', function(newVal, oldVal) {

      if (newVal !== oldVal) {
      var selected = $filter('filter')($scope.regions, {
        id: newVal
      });
      if (angular.isUndefined(selected[0]) == false) {
        $scope.location.data.region.display_name = selected[0].display_name;
         $scope.location.data.region.id = selected[0].id;
      }
      }
    });



    $scope.$watch('location.data.city.id', function(newVal, oldVal) {

      if (newVal !== oldVal) {

      var selected = $filter('filter')($scope.cities, {
        id: newVal
      });
      if (angular.isUndefined(selected[0]) == false) {
        $scope.location.data.city.display_name = selected[0].display_name;
        $scope.location.data.city.id = selected[0].id;
      }
      }
    });


    $scope.$watch('location.data.suburb.id', function(newVal, oldVal) {

      if (newVal !== oldVal) {
      var selected = $filter('filter')($scope.suburbs, {
        id: newVal
      });

      $scope.location.data.suburb.display_name = selected[0].display_name;
      $scope.location.data.suburb.id = selected[0].id;
      }
    });*/

    /**Location Start**/
    $scope.location = {}
    $scope.countries = [];
    $scope.alldata = []
    $scope.LoadCountries = function() {
      $http.get(GlobalConstant.StaticOptionsApi+'/countries')
      .then(function(response) {
        $scope.countries = response.data.data;
        $('select[name=country]').change(function() {
          var country = angular.element($(this) ).val()
          var nstr = parseInt(country.replace('number:', ''));
          angular.element($('input[name=areaid]') ).val(null);
          angular.element($('input[name=area]') ).val(null);
          $scope.location.data.display_name = null;
          $scope.location.data.id = null;
          $scope.location.data.country.id = nstr;
           // $scope.LoadAreas( parseInt(nstr) ) ;
        });
      });
    }

    $scope.$watch('location.data.country.id', function(newval, oldval) {
      if (newval !== oldval) {
        var selected = $filter('filter')($scope.countries, {
          id: newval
        });
        if (selected.length != 0) {
          $scope.location.data.country.display_name = selected[0].display_name;
          $scope.location.data.country.id = selected[0].id;
          $scope.location.data.display_name = null;
          $scope.location.data.id = null;
        }
        else {
          if ($scope.location.data.display_name == '' && $scope.location.data.id == '') {
          angular.element($('input[name=areaid]') ).val(null);
          angular.element($('input[name=area]') ).val(null);

          $scope.location.data.display_name = '';
          $scope.location.data.id = '';
          }
        }
      } else {
      }
    }, true);

    $scope.$watch('location.data.id', function(newval, oldval) {
      if (newval !== oldval) {
        var selected = $filter('filter')($scope.areas, {
          id: newval
        }, true);

        if (selected) {
          $scope.location.data.display_name = selected[0].display_name;
          $scope.location.data.id = selected[0].id;
        }
      } else {
        if (angular.isDefined($scope.location.data)) {
        $scope.location.data.id = '';
        }
      }
    }, true);

    angular.element($('body')).click(function() {
      if (angular.element($('#autoDataLocation')).is(':visible')) {
        angular.element($('#autoDataLocation') ).hide()
      }
    });

    $scope.GetAreas = function(data, country_id) {
      angular.element($('#autoDataLocation') ).show();
      angular.element($('input[name=areaid]') ).val('');
      $scope.location.data.id = null;
      $http.get(GlobalConstant.APIRoot+'static/autocomplete/location?q='+ data +'&country_id='+country_id)
      .then(function(response) {
        $scope.areas = response.data.data;
      });
    }

    $scope.getAutoCompleteData = function(data) {
      //$scope.location.data.display_name = data.display_name;
      //$scope.location.data.id = data.id;
      angular.element($('input[name=areaid]') ).val(data.id);
      angular.element($('input[name=area]') ).val(data.display_name);
      $scope.alldata = [];
      $scope.alldata.push({display_name: data.display_name, area_id: data.id});
      angular.element($('#autoDataLocation') ).hide();
    }
    /**Location End**/
    var UpdateCompany = function(formData) {
      // $http.put(GlobalConstant.EmployerRootApi +'/company', formData) //Uncomment for live API call
      $http.get(window.location.origin + '/js/minified/test-data/test_edit_company_company_data.json')
      .then(function(response) {
        return true;
        // alert('update success')
        //$('#Form_my_file').attr('data-ob_key', response.data.data.ob_key);
      }, function(response) {
        //Error Condition
        alert('some error');
      });
    }

    // $scope.updateLocation = function(data) {
    $scope.updateHeadquarters = function(data) {
      // If data came from auto complete
      if ($scope.alldata[0]) {
        $scope.location.data.display_name = $scope.alldata[0].display_name;
        $scope.location.data.id =  $scope.alldata[0].area_id;
        if ( angular.isDefined($scope.location.data.id)  ) {
          var location = $scope.location.data.id;
        }
      } else {
        if (  data.area != null ) {
          var location = {country_id: data.country, location: data.area};
        } else {
          var location = data.country;
        }
      }

      var formData = {"data": {street_address : data.street_address, location: location}};
      UpdateCompany(formData);
    }

    $scope.updateAbout = function($data) {
      var formData = {data : $data};
      UpdateCompany(formData);
    }

    $scope.updateCompany = function() {
      var name = this.$editable.name;
      var value = this.$data;
      var data = '{"data":{"'+name+'" : "'+value+'"}}';
      UpdateCompany(JSON.parse(data));
    }

    $scope.numbersOnly = function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if(isNaN(String.fromCharCode(charCode))) {
        evt.preventDefault();
      }
    }

    $scope.updateIndustry = function(data) {
      // If data came from auto complete
      // if ($scope.alldata[0]) {
      //   $scope.location.data.display_name = $scope.alldata[0].display_name;
      //   $scope.location.data.id =  $scope.alldata[0].area_id;
      //   if ( angular.isDefined($scope.location.data.id)  ) {
      //   var location = $scope.location.data.id
      //   }
      // } else {

      //  if (  data.area != null ) {
      //   var location = {country_id: data.country, location: data.area }
      //   } else {
      //   var location = data.country
      //   }
      // }
      // //console.log(data)
      var formData = {"data": {industry : data.industry}};
      UpdateCompany(formData);
    }

    $scope.buttonsHideShow = function(a ,b, c, d, e) {
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

    $('#image_upload_modal_new').change(function() {
      fileUploadService.new_image_upload_modal($scope);
    });

    $('#image_upload_modal_new_safari').change(function() {
      fileUploadService.new_image_upload_modal($scope);
    });

    // camera modal on close event, force webcam to close if open
    $('#pmvCameraModal, #pmvCameraModalNew, #pmvImageModalNew, #companyBannerModal').on('hidden.bs.modal', function() {
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

    var preview_img_new = document.getElementById('preview_img_new');
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
    $scope.startVideoImage = function() {
      checkBrowsers();
      if($scope.isSafari || $scope.browserName == "Safari") {
        // alert('Oh oh looks like your\'re using Safari! Use Chrome or Firefox to capture image using your webcam.')
        alert('Oh oh this feature is not yet supported by your browser. Drag and drop an image instead, or use Chrome, Firefox or Microsoft Edge to capture an image using your webcam.');
      } else {
        $scope.sectionsHideShow(true,false);
        $scope.buttonsHideShow(false,true,true,true,true)

        if ($('#preview_img_new').attr('src')) {
          $('#preview_img_new').attr('src', '');
          window.stream = '';
        }

        !window.stream && navigator.getUserMedia({
          audio: false,
          video: true
        }, function(stream) {
          window.stream = stream;

          preview_img_new.src = window.URL.createObjectURL(stream);
          preview_img_new.play();
        }, function(error) {
          alert(JSON.stringify(error, null, '\t'));
        });
      }
    }

    $scope.take_photo = function() {
     fileUploadService.take_photo($scope);
    }

    $scope.take_photo_again = function() {
      window.stream = '';
      $scope.startVideoImage();
    }

    $scope.change = function() {
      // $scope.hidePreview();
      $scope.sectionsHideShow(false,true);
      $scope.buttonsHideShow(false,false,false,false,false);

      if ($('#preview_new').attr('data-old_file')) {
        var filename = $('#preview_new').attr('data-old_file');
        var folder = $('#preview_new').attr('data-file_folder');
        $scope.delete_old_file(filename, folder);
      } else if ($('#preview_img_new').attr('data-old_file')) {
        var filename = $('#preview_img_new').attr('data-old_file');
        var folder = $('#preview_img_new').attr('data-file_folder');
        $scope.delete_old_file(filename, folder);
      }
    }

    var selectAreaToCrop = function(c) {
    $scope.crop_data = c;
    }

    $scope.save_photo = function() {
      $scope.url_type = 'logo_url';
      fileUploadService.save_photo($scope);
    }

    $scope.$watch('employer_company_logo', function(newVal, oldVal){
      console.log('logo_url ', newVal, oldVal);
    });


    $scope.$watch('logo_url', function(newVal, oldVal){
      console.log('emp logo_url ', newVal, oldVal);
      var data = {data:{logo_url: newVal}};

      if (newVal) {
        employerFactory.putEmployerPhotoBanner(data).then(function(res){
          console.log('emp photo uploaded');
        });
      }
    });

    $scope.$watch('company_banner_url', function(newVal, oldVal){
      console.log('emp company_banner_url ', newVal, oldVal);
      var data = {data:{company_banner_url: newVal}};

      if (newVal) {
        employerFactory.putEmployerPhotoBanner(data).then(function(res){
          console.log('emp banner uploaded');
        });
      }
    });

    $scope.startVideo = function() {
      checkBrowsers();
      if($scope.isSafari || $scope.browserName == "Safari") {
        // alert('Oh oh looks like your\'re using Safari! Use Chrome or Firefox to record a video using your webcam.');
        alert('Oh oh this feature is not yet supported by your browser. Drag and drop a video file instead, or use Chrome, Firefox or Microsoft Edge to record a video using your webcam.');
      } else {
        fileUploadService.startVideo($scope);
      }
    }

    $scope.recordVideo = function() {
      fileUploadService.recordVideo($scope);
    }

    $scope.stopVideo = function() {
      fileUploadService.stopVideo($scope);
    }

    // var data = {
    //   "data": {
    //     'profile_video' : {
    //     // "doc_url": "",
    //     "doc_url": "https://previewmedev.streaming.mediaservices.windows.net/e93c89e2-5cd7-4f33-afed-fd0199ba64b6/camera_112254282.ism/manifest",
    //     "doc_file_type": "video",
    //     "doc_filename": "dummy file",
    //     "extra_data" : []
    //     }
    //   }
    // }

    // $http({
    //   url: 'https://api.previewme.com/api/v1/employer/company?access_token=' + $cookies.get('token'),
    //   method: 'put',
    //   data: data,
    //   headers : { 'Content-Type': 'application/json'}
    // }).then(function(response) {

    // }, function(response) {
    //   alert('error')

    // });

    //Check Modal if there is a successful upload
    $('#pmvCameraModalNew').on('hidden.bs.modal', function() {
      var response = localStorage.getItem('VideoUploadResponseData');
      if (angular.isDefined(response) && response != null ) {
        $scope.showVideoLoding = true;
        $scope.showVideo = false;
        localStorage.removeItem('VideoUploadResponseData');
      }
      $('.successUpload').hide();
    });

    $scope.saveVideo = function() {
      fileUploadService.saveVideo($scope, 'company_profile_edit');
    }

    $scope.recordVideoAgain = function() {
      $scope.buttonsHideShow(false, true, true, true, true);
      //$scope.buttonsHideShow(true,true,false,true,true)
      //$scope.recordVideo();
    }

    $scope.changeVideo = function() {
      fileUploadService.changeVideo($scope);
    }

    $scope.file_change = function() {
      fileUploadService.fileChange($scope);
    }

    $scope.saveBanner = function() {
      $scope.url_type = 'company_banner_url';
      fileUploadService.saveBanner($scope);
    }

    $('#video_upload_modal_new').change(function() {
      $scope.new_video_upload_modal('video_upload_modal_new');
    });

    $('#banner_image_upload').change(function() {
      $scope.file_input_id = 'banner_image_upload';
      fileUploadService.banner_image_upload($scope);
    });

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
          $('#resume_save').attr('data-folder','');
          $('#resume_save').attr('data-filename','');
          $('#image_save').attr('data-folder','');
          $('#image_save').attr('data-filename','');
          $('#portfolio_save').attr('data-folder','');
          $('#portfolio_save').attr('data-filename','');
        }
      });
    }

     // Image upload
    $scope.new_image_upload_modal = function(evt) {
      fileUploadService.new_image_upload_modal($scope, evt);
    }

    $scope.new_video_upload_modal = function(file_elm, evt) {
      fileUploadService.video_upload($scope, file_elm, evt, 'company_profile_edit');
    }

    $scope.new_video_upload_modal_back = function(file_elm, evt) {
      var fileField = document.getElementById(file_elm);
      $scope.modal_percent_value = 0;
      // Drag/Drop upload
      if (evt) {
        fileField = evt.dataTransfer;
      }
      // delete old upload video
      if ($('#preview_new').attr('data-old_file')) {
        var filename = $('#preview_new').attr('data-old_file');
        var folder = $('#preview_new').attr('data-file_folder');
        $scope.delete_old_file(filename, folder);
      }
      var fileToUpload = fileField.files[0];
      var ob_key = $cookies.get('obkey');
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

      var allowed_files = ['mp4', 'wma', 'mpg', 'mpeg', 'wmv', 'avi', 'mov'];
      var last_dot = filename.lastIndexOf('.');
      var ext = filename.substr(last_dot + 1).toLowerCase();
      if (allowed_files.indexOf(ext) == -1) {
        alert("Invalid Video file must be 'mp4','wma','mpg','mpeg','wav','avi' extension");
        return false;
      }

      var oneMb = 1048576;
      var videoSizeLimit = 150;
      if(Math.ceil(fileToUpload.size / oneMb) > videoSizeLimit) {
        alert('Max video limit must be '+videoSizeLimit+'mb in size.');
         return false;
      }

      var chunksize = 1000000; // 1MB
      var chunks = Math.ceil(chunksize / fileToUpload.size);
      chunks = chunks > 1 ? 1 : chunks;
      preview_new.src = '';
      preview_new.poster = '';
      // show percent;
      $scope.modal_percent = false;

      if ($('#modal_percent').hasClass('hidden')) {
        $('#modal_percent').removeClass('hidden');
      }

      var uploadChunk = function(fileToUpload, chunk) {
        var xhr = new XMLHttpRequest();
        var uploadStatus = xhr.upload;

        uploadStatus.addEventListener("progress", function(ev) {
          if (ev.lengthComputable) {
            // Percent progress
            $scope.modal_percent_value = Math.ceil((ev.loaded / ev.total) * 100);
          }
        }, false);
        xhr.addEventListener('readystatechange', function(e) {
          if (this.readyState === 4) {
            var rewrite_filename = filename.split(' ');
            rewrite_filename = rewrite_filename.join('_');
            preview_new.src = 'assets/Uploads/' + upload_folder + '/' + rewrite_filename;
            if($scope.isSafari == false) {
              preview_new.play();
              preview_new.muted = false;
            }
            $('#save_btn').attr('data-save_type', 'video');
            $('#preview_new').attr('data-old_file', rewrite_filename);
            $('#preview_new').attr('data-file_folder', upload_folder);

            if($scope.isSafari == false) {
              $scope.sectionsHideShow(true, false);
              $scope.buttonsHideShow(true, true, true, false, false);
            } else {
              $scope.video_source = preview_new.src;
              $scope.saveVideo();
            }
            // hide percent
            $scope.modal_percent = true;
          }
        });

        var start = chunksize * chunk;
        var end = start + (chunksize - 1)
        if (end >= fileToUpload.size) {
          end = fileToUpload.size - 1;
        }
        var params = '?file_folder=' + upload_folder;
        // xhr.open("POST", GlobalConstant.accountPage + "/video_upload_submit" + params, true);
        xhr.open("POST", GlobalConstant.FileUploadUrl + "/video_upload_submit" + params, true);
        xhr.setRequestHeader("Cache-Control", "no-cache");
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
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

    document.updateCompanyUrl = function() {
      var company_url = $.trim($('#company_url').val());
      if(!company_url) return false;
      var formData = {data : {company_url : company_url}};

      $http.put(GlobalConstant.EmployerRootApi +'/company/change-profile-url',  formData)
      .then(function(response) {
        $scope.company_url = company_url;
        $('#company_url').val("");
      }, function(response) {
        //Error Condition
        // ////console.log(response);
        alert('Company url is already taken. Try another one!');
      });
    }

    document.cancelCompanyUrl = function() {
      $('#company_url').val("");
    }
  }]);

  app.factory('employerFactory', ['GlobalConstant','$cookies', '$http', function(GlobalConstant, $cookies, $http) {
    return {
      putEmployerPhotoBanner : function(putdata) {
        // return $http.put(GlobalConstant.APIRoot+'employer/company', putdata).then(function(response) { //Uncomment for live API call
          return $http.get(window.location.origin + '/js/minified/test-data/test_edit_company_company_data.json', putdata).then(function(response) {
          return response.data.data;
        });
      }
    }
  }]);
}());

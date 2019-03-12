(function () {

    'use strict';
    var app = angular.module('app');
    var base_url = $('body').data('base_url');
    var slug_id = $('#slug-id').val();

    $('.offices_wrapper').TrackpadScrollEmulator();
    $(".company-about-us").TrackpadScrollEmulator();

    app.controller('CompanyController', ['GlobalConstant', '$scope', '$window', '$http', '$cookies', '$templateCache', function (GlobalConstant, $scope, $window, $http, $cookies, $templateCache) {

        var encodeCompany = window.location.pathname.split('/').filter(function (el) {
            return !!el;
        }).pop();
        var decodeCompany = decodeURIComponent(encodeCompany);
        decodeCompany = decodeURIComponent(decodeCompany);
        $scope.jobSearchTemplate = '/job-template';
        var userType = '';

        $scope.token = $cookies.get('api_token');

        if ($scope.token != '') {
            var headerData = {
                headers: {
                    'Authorization': 'Bearer ' + $scope.token
                }
            };

            $http.get(window.location.origin + '/api/user-auth-data', headerData).then(response => {
                if (response.status === 200) {
                    var userType = response.data.data.user_type;
                    $scope.follow_link = (userType === 'employer') ? true : userType === 'candidate' ? false : true;
                    $scope.edit_company_profile = (userType === 'employer') ? true : userType === 'candidate' ? false : true;

                    $scope.userId = response.data.data.id;
                    $scope.ut = userType;
                }
            }, (response) => {
                if (response.status === 401) {
                    $scope.follow_link = true;
                    console.log('Token not valid');
                }
            });
        }

        var color_bg_initial_set = [
            "member-initials--sky",
            "member-initials--pvm-purple",
            "member-initials--pvm-green",
            "member-initials--pvm-red",
            "member-initials--pvm-yellow"
        ];

        /* follow link button
         * employer : disabled
         * candidate : enabled
         * logout : disabled
         */

        $scope.followedText = 'Follow';
        //$scope.paginateJobs = []

        // Basic Company Information
        $http.get(window.location.origin + '/api/company/' + decodeCompany).then(response => {
            if (response.status === 200) {
                if (response.data.length > 0) {

                    // Add Company Class on the body tag to fix 
                    $('body').addClass('Company');

                    let data = response.data[0];

                    let companyData = {
                        id: data.id,
                        company_name: data.company_name,
                        status: data.status,
                        num_of_employees: data.num_of_employees,
                        num_of_employees_text: (data.num_of_employees === 1) ? 'employee' : 'employees',
                        logo_url: data.logo_url,
                        website_url: (data.website_url) ? data.website_url.replace(/^https?:\/\//, '') : '',
                        company_phone: data.company_phone,
                        company_fax: data.company_fax,
                        industry: {
                            id: data.industry_id,
                            display_name: data.industry.display_name
                        },
                        street_address: data.street_address,
                        street_address_2: data.street_address_2,
                        location: {
                            display_name: data.location.display_name,
                            slug_name: data.location.slug_name,
                            country: {
                                id: data.country_id,
                                display_name: data.country_display_name,
                                short_name: data.country_short_name
                            }
                        },
                        nz_business_num: data.nz_business_num,
                        company_url: data.company_url,
                        company_banner_url: data.company_banner_url,
                        company_description: data.company_description,
                        company_video: {
                            doc_url: (data.hasOwnProperty('docs')) ? (data.docs != null) ? data.docs.doc_url : '' : '',
                            doc_filename: (data.hasOwnProperty('docs')) ? (data.docs != null) ? data.docs.doc_filename : '' : ''
                        },
                        company_branch_locations: JSON.parse(data.company_branch_locations),
                        helper_text: data.helper_text,
                        jobs: data.job_postings
                    }

                    $scope.showVideo = false;
                    $scope.company = companyData;

                    // Add initials as default image for Company
                    $scope.company.initial = $scope.company.company_name.replace(/[^A-Z]/g, "");

                    // change default photo's background color
                    $scope.company.profile_color = color_bg_initial_set[Math.floor(Math.random() * color_bg_initial_set.length)];

                    // Job Postings
                    $scope.extra_data = {
                        jobs: data.jobs
                    };

                    // Add initial to be used in default image
                    var b = 1;
                    for (let i = 0; i < $scope.extra_data.jobs.length; i++) {

                        $scope.extra_data.jobs[i].job_video_url = '';

                        // Format Job Posting Date
                        $scope.extra_data.jobs[i].published_date = new Date($scope.extra_data.jobs[i].published_date);

                        b = (b >= 6) ? 1 : b;

                        $scope.initial = $scope.extra_data.jobs[i].company.company_name;
                        var comp_initial = $scope.initial.replace(/[^A-Z]/g, "");
                        $scope.extra_data.jobs[i].initial = comp_initial;

                        // change default photo's background color
                        if (!$scope.extra_data.jobs[i].company.logo_url) {

                            switch (b) {
                                case 1:
                                    $scope.extra_data.jobs[i].profile_color = "member-initials--sky";
                                    break;
                                case 2:
                                    $scope.extra_data.jobs[i].profile_color = "member-initials--pvm-purple";
                                    break;
                                case 3:
                                    $scope.extra_data.jobs[i].profile_color = "member-initials--pvm-green";
                                    break;
                                case 4:
                                    $scope.extra_data.jobs[i].profile_color = "member-initials--pvm-red";
                                    break;
                                case 5:
                                    $scope.extra_data.jobs[i].profile_color = "member-initials--pvm-yellow";
                                    break;
                            }

                            b++;

                        } else {
                            var temp_var_logo = $scope.extra_data.jobs[i].company.logo_url;
                            temp_var_logo = (temp_var_logo.constructor === Array) ? temp_var_logo.toString() : temp_var_logo;
                            $scope.extra_data.jobs[i].company.logo_url = temp_var_logo;
                        }

                    }

                    // Company Followers
                    $scope.followers = data.followers;
                    $scope.follower_text = parseInt(data.followers) > 1 ? 'Followers' : 'Follower';

                    // Company Video
                    if ($scope.company.company_video) {

                        if ($scope.company.company_video.doc_id != '' && $scope.company.company_video.doc_url == '') {
                            $scope.showVideoLoading = false;
                            $scope.showError = false

                            return false;
                        }

                        var docurl = $scope.company.company_video.doc_url
                        var docurlcount = docurl.split('/')

                        if (docurlcount.length === 1) {
                            $scope.showError = true;
                            $scope.ErrorVideo = $scope.company.company_video.doc_url

                            return false;
                        }

                        if ($('#vid1').length) {
                            var myPlayer = amp('vid1', {
                                "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                                "nativeControlsForTouch": false,
                                autoplay: false,
                                controls: true,
                                width: "275",
                                logo: {
                                    "enabled": false
                                },
                                poster: ""
                            }, () => {
                                // open camera modal
                                if ($scope.mobile_agent == false) {
                                    this.addEventListener('click', (elm) => {
                                        if (!$(elm.target).hasClass('vjs-control') && !$(elm.target).hasClass('vjs-big-play-button')) {
                                            $scope.open_camera_new();
                                        }
                                    })

                                    // add an event listener
                                    this.addEventListener('ended', () => {
                                        //console.log('Finished!');
                                    });

                                }

                            });

                            $scope.showVideo = true;
                            if ($scope.company.company_video.doc_url) {
                                myPlayer.src([{
                                    src: $scope.company.company_video.doc_url,
                                    type: "application/vnd.ms-sstr+xml"
                                }]);

                                return false;
                            }

                            // show video loading and hide azure video player
                            $scope.showVideoLoading = true;
                            $scope.showVideo = false;
                        }
                    }

                }
            }
        }, (response) => {
            if (response.status === 404) {
                window.location = base_url + 404;
            }
        });

        // Company Job Details
        $scope.showDetail = (e, object_id) => {

            $templateCache.removeAll();

            var obj = $(e.target);
            var jobId = obj.attr('data-obj-id');
            var jobClass = angular.element($(".job" + object_id))
            var partJob = $(".partjob" + object_id)

            angular.element($('.partjob')).each(() => {

                if (angular.element(this).is(':visible')) {
                    if (angular.element(this).hasClass("partjob" + object_id)) {
                        angular.element(this).removeClass('hide')
                    } else {
                        angular.element(this).addClass('hide')
                    }
                } else {
                    //console.log('visible')
                }
            })

            if (angular.element(partJob).hasClass('hide')) {
                angular.element(partJob).removeClass('hide');

                $http.get(window.location.origin + '/api/job/details/' + object_id)
                    .then(function (response) {
                        if (response.status === 200) {
                            var data = response.data.data;
                            if (data != null) {
                                $scope.joblisting = data;

                                var vid = 'JobVideo_' + $scope.joblisting.object_id;

                                if ($('#' + vid).length) {
                                    var myPlayer = amp(vid, {
                                        "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                                        "nativeControlsForTouch": false,
                                        autoplay: false,
                                        controls: true,
                                        width: "100%",
                                        logo: {
                                            "enabled": false
                                        },
                                        poster: ""
                                    }, function () {
                                        this.addEventListener('ended', function () {
                                            //console.log('Finished!');
                                        });
                                    });
                                    // Company Job Video
                                    if ($scope.joblisting.job_video_url) {
                                        myPlayer.src([{
                                            src: $scope.joblisting.job_video_url,
                                            type: "application/vnd.ms-sstr+xml"
                                        }]);
                                    }
                                }

                                jobClass.removeClass('glyphicon-menu-down');
                                jobClass.addClass('glyphicon-menu-up');

                                jobClass.attr('data-seen', 'true');
                            }
                        }
                    }, function errorCallback(response) {});
            } else {
                angular.element(partJob).addClass('hide')
                jobClass.removeClass('glyphicon-menu-up');
                jobClass.addClass('glyphicon-menu-down');
            }
        }

        // Add Company Followers
        $scope.follow = function (company_id) {
            if ($scope.token && $scope.ut === 'candidate') {
                $http.post(GlobalConstant.CandidateRootApi + '/company/follow/' + company_id)
                    .then(function (response) {

                        var followers = parseInt($scope.extra_data.followers);

                        if (response.data.data.followed) {
                            $scope.extra_data.followers = followers + 1;
                            $scope.followedText = 'Unfollow';
                        } else {
                            $scope.extra_data.followers = followers - 1;
                            $scope.followedText = 'Follow';
                        }

                    }, function errorCallback(response) {});

            }
        }


        $scope.seen = function (e, object_id) {
            var obj = $(e.target);
            var jobId = obj.attr('data-obj-id');
            $http.post(GlobalConstant.CandidateJobWatchlistApi + '/' + object_id).then(function (response) {
                if (response.data.data.watchlist) {
                    if (!obj.hasClass('pvm-blue')) {
                        obj.addClass('pvm-blue')
                    }
                    //console.log('cool')
                } else {
                    //console.log('rempved')
                    obj.removeClass('pvm-blue');
                }
            }, function errorCallback(response) {});
        }
    }]);

    app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(false);
    }]);

    app.controller('EmployerCompany', ['GlobalConstant', 'fileUploadService', '$scope', '$window', '$http', '$cookies', '$filter', '$timeout', '$compile',
        function (GlobalConstant, fileUploadService, $scope, $window, $http, $cookies, $filter, $timeout, $compile) {
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
            $scope.crop_data = {
                w: 240,
                h: 240,
                x: 80,
                y: 0
            };

            // Detect mobile agent
            $scope.mobile_agent = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
            var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;

            // Company video initialy hide
            $scope.showVideo = false;

            $scope.open_camera_new = function () {
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
                    $('#pmvCameraModalNew').modal('show');
                }
            }

            // Employer company
            // $http.get(GlobalConstant.EmployerRootApi  +'/company'+ '?access_token=' + $scope.token)
            // $http.get(GlobalConstant.CompanyApi + '/' + slug_id) //Uncomment for live API call
            $http.get(window.location.origin + '/js/minified/test-data/test_employer_profile_data.json')
                .then(function (response) {
                        //console.log('admin')
                        //console.log(response.data.data)
                        response = response.data.data.company;
                        $scope.employer_company = response;
                        angular.forEach(response, function (v, k) {
                            $scope[k] = v;
                        })

                        // alert($scope.company_name)
                        // Get Company Api
                        // $http.get(GlobalConstant.CompanyApi + '/' + response.company_url).then(function(response) { //Uncomment for live API call
                        $http.get(window.location.origin + '/js/minified/test-data/test_employer_profile_data.json').then(function (response) {
                            if (response.status == 200) {
                                var data = response.data.data;
                                //console.log(data)
                                $scope.company = data.company;
                                $scope.extra_data = data.extra_data;
                                $scope.follower_text = $scope.extra_data.followers == 0 ||
                                    $scope.extra_data.followers > 1 ? 'Followers' : 'Follower';
                            }
                        });

                        if ($scope.company_video != '') {
                            var myPlayer = amp('vid1', {
                                "techOrder": ["azureHtml5JS", "flashSS", "silverlightSS", "html5"],
                                "nativeControlsForTouch": false,
                                autoplay: false,
                                controls: true,
                                width: "275",
                                logo: {
                                    "enabled": false
                                },
                                poster: ""
                            }, function () {
                                if ($scope.mobile_agent == false) {
                                    this.addEventListener('click', function (elm) {
                                        if (!$(elm.target).hasClass('vjs-control') && !$(elm.target).hasClass('vjs-big-play-button')) {
                                            $scope.open_camera_new();
                                        }
                                    })
                                    // add an event listener
                                    // this.addEventListener('ended', function() {
                                    //     //console.log('Finished!');
                                    // });
                                }
                            });

                            if ($scope.company_video) {
                                $scope.showVideo = true;
                                myPlayer.src([{
                                    src: $scope.company_video.doc_url,
                                    type: "application/vnd.ms-sstr+xml"
                                }]);
                            }
                        }
                    },

                    function (response) {});

            $scope.industries = []
            $scope.loadIndustries = function () {
                $http.get(GlobalConstant.StaticOptionIndustryApi).then(function (response) {
                    $scope.industries = response.data.data;
                });
            }

            $scope.$watch('industry.data.industry.id', function (newVal, oldVal) {
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

            $scope.subIndustries = []
            $scope.loadSubIndustries = function () {
                $http.get(GlobalConstant.StaticOptionSubIndustryApi + '/' + $scope.industry.id)
                    .then(function (response) {
                        $scope.subIndustries = response.data.data;
                    });
            }

            $scope.$watch('industry.sub_industry.id', function (newVal, oldVal) {
                if (typeof newVal != 'undefined' && newVal !== oldVal) {
                    var selected = $filter('filter')($scope.subIndustries, {
                        id: newVal
                    });

                    if (angular.isUndefined(selected[0]) == false) {
                        $scope.industry.sub_industry.display_name = selected[0].display_name;
                    }
                }
            })

            //Preferred location
            $scope.suburbs = [];
            $scope.loadSuburbs = function (getCityId) {
                var id = getCityId;
                if (!id) return false;

                $http.get(GlobalConstant.StaticOptionLocationsApi + '/suburbs/' + id).then(function (response) {
                    $scope.suburbs = response.data.data;
                });
            }

            $scope.regions = [];
            $scope.loadRegions = function () {
                $http.get(GlobalConstant.StaticOptionLocationsApi + '/regions').then(function (response) {
                    $scope.regions = response.data.data;
                    //get dropdown values on load
                    if ($scope.location.data.region.id !== null || $scope.location.data.city.id !== null) {
                        $scope.loadCities($scope.location.data.region.id);
                        $scope.loadSuburbs($scope.location.data.city.id);
                    }
                    //Change dropdown value on change
                    $('select[name=region]').change(function () {
                        var str = $(this).val();
                        var nstr = parseInt(str.replace('number:', ''));

                        $scope.loadCities(nstr);
                        $scope.loadSuburbs(nstr);
                    });
                });
            }

            $scope.cities = [];
            $scope.loadCities = function (getRegionId) {
                var id = getRegionId;
                if (!id) return false;

                $http.get(GlobalConstant.StaticOptionLocationsApi + '/cities/' + id).then(function (response) {
                    $scope.cities = response.data.data;
                    $('select[name=city]').change(function () {
                        var str = $(this).val();
                        var nstr = parseInt(str.replace('number:', ''));
                        $scope.loadSuburbs(nstr);
                    });
                });
            }

            $scope.$watch('location.data.region.id', function (newVal, oldVal) {
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

            $scope.$watch('location.data.city.id', function (newVal, oldVal) {
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

            $scope.$watch('location.data.suburb.id', function (newVal, oldVal) {
                if (newVal !== oldVal) {
                    var selected = $filter('filter')($scope.suburbs, {
                        id: newVal
                    });

                    $scope.location.data.suburb.display_name = selected[0].display_name;
                    $scope.location.data.suburb.id = selected[0].id;
                }
            });

            var UpdateCompany = function (formData) {
                $http.put(GlobalConstant.EmployerRootApi + '/company', formData)
                    .then(function (response) {
                        //console.log(response)
                        // alert('update success')
                        //$('#Form_my_file').attr('data-ob_key', response.data.data.ob_key);
                    }, function (response) {
                        //Error Condition
                        // //console.log(response);
                        alert('some error');
                    });
            }

            $scope.updateLocation = function ($data) {
                var location_id = '';
                if ($data.suburb) {
                    location_id = $data.suburb;
                } else if ($data.city) {
                    location_id = $data.city;
                    $scope.location.data.suburb.display_name = '';
                } else {
                    location_id = $data.region;
                    $scope.location.data.city.display_name = '';
                }
                var formData = {
                    "data": {
                        location: location_id
                    }
                };

                UpdateCompany(formData);
            }

            $scope.updateAbout = function ($data) {
                var formData = {
                    data: $data
                };
                UpdateCompany(formData)
            }

            $scope.updateCompany = function () {
                var name = this.$editable.name;
                var value = this.$data
                //console.log(this.$editable)
                var data = '{"data":{"' + name + '" : "' + value + '"}}';
                UpdateCompany(JSON.parse(data))
            }

            $scope.numbersOnly = function (evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (isNaN(String.fromCharCode(charCode))) {
                    evt.preventDefault();
                }
            }

            $scope.updateIndustry = function ($data) {
                var formData = {
                    "data": $data
                };
                UpdateCompany(formData)
            }

            $scope.buttonsHideShow = function (a, b, c, d, e) {
                $scope.record_btn = a;
                $scope.record_again_btn = b;
                $scope.stop_btn = c;
                $scope.save_btn = d;
                $scope.change_btn = e;
            }

            $scope.sectionsHideShow = function (a, b) {
                $scope.showSection1 = a;
                $scope.showSection2 = b;
            }

            $('#image_upload_modal_new').change(function () {
                fileUploadService.new_image_upload_modal($scope);
            });

            // camera modal on close event, force webcam to close if open
            $('#pmvCameraModal, #pmvCameraModalNew, #pmvImageModalNew').on('hidden.bs.modal', function () {
                if (window.stream) {
                    stream.stop();
                    window.stream = "";
                }

                $scope.buttonsHideShow(false, false, false, false, false);
                $scope.sectionsHideShow(false, true);
                // hide percentage
                $scope.modal_percent = true;
                // reset preview video
                $('#preview_new').attr('src', '');
                $('#preview_img_new').attr('src', '');
            });

            var preview_img_new = document.getElementById('preview_img_new');
            $scope.startVideoImage = function () {
                $scope.sectionsHideShow(true, false);
                // $scope.buttonsHideShow(true,true,true,false,false);
                $scope.buttonsHideShow(false, true, true, true, true)

                if ($('#preview_img_new').attr('src')) {
                    $('#preview_img_new').attr('src', '');
                    window.stream = '';
                }

                !window.stream && navigator.getUserMedia({
                    audio: false,
                    video: true
                }, function (stream) {
                    window.stream = stream;

                    preview_img_new.src = window.URL.createObjectURL(stream);
                    preview_img_new.play();

                }, function (error) {
                    alert(JSON.stringify(error, null, '\t'));
                });
            }

            $scope.take_photo = function () {
                fileUploadService.take_photo($scope);
            }

            $scope.take_photo_again = function () {
                window.stream = '';
                $scope.startVideoImage();
            }

            $scope.change = function () {
                // $scope.hidePreview();
                $scope.sectionsHideShow(false, true);
                $scope.buttonsHideShow(false, false, false, false, false);

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

            var selectAreaToCrop = function (c) {
                $scope.crop_data = c;
            }

            $scope.save_photo = function () {
                $scope.url_type = 'logo_url';
                fileUploadService.save_photo($scope);
            }


            $scope.startVideo = function () {
                fileUploadService.startVideo($scope);
            }

            $scope.recordVideo = function () {
                fileUploadService.recordVideo($scope);
            }

            $scope.stopVideo = function () {
                fileUploadService.stopVideo($scope);
            }

            $scope.saveVideo = function () {
                $scope.doc_type = 'company_video';
                fileUploadService.saveVideo($scope);
            }

            $scope.recordVideoAgain = function () {
                $scope.buttonsHideShow(true, true, false, true, true)
                $scope.recordVideo();
            }


            $scope.changeVideo = function () {
                fileUploadService.changeVideo($scope);
            }

            $scope.file_change = function () {
                fileUploadService.fileChange($scope);
            }

            $scope.saveBanner = function () {
                $scope.url_type = 'company_banner_url';
                fileUploadService.saveBanner($scope);
            }


            $('#video_upload_modal_new').change(function () {
                $scope.new_video_upload_modal('video_upload_modal_new');
            });

            $('#banner_image_upload').change(function () {
                $scope.file_input_id = 'banner_image_upload';
                fileUploadService.banner_image_upload($scope);
            });

            $scope.delete_old_file = function (file, folder) {

                $.ajax({
                    url: GlobalConstant.accountPage + "/delete_recorded_video",
                    method: 'post',
                    data: {
                        filename: file,
                        file_folder: folder
                    },
                    success: function (data) {
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

            $scope.new_video_upload_modal = function (file_elm, evt) {
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
                if (Math.ceil(fileToUpload.size / oneMb) > videoSizeLimit) {
                    alert('Max video limit must be ' + videoSizeLimit + 'mb in size.');
                    return false;
                }


                var chunksize = 1000000 // 1MB
                var chunks = Math.ceil(chunksize / fileToUpload.size);
                chunks = chunks > 1 ? 1 : chunks;
                preview_new.src = '';
                preview_new.poster = '';
                // show percent;
                $scope.modal_percent = false;


                if ($('#modal_percent').hasClass('hidden')) {
                    $('#modal_percent').removeClass('hidden');
                }

                var uploadChunk = function (fileToUpload, chunk) {
                    var xhr = new XMLHttpRequest();
                    var uploadStatus = xhr.upload;

                    uploadStatus.addEventListener("progress", function (ev) {
                        if (ev.lengthComputable) {
                            // Percent progress
                            $scope.modal_percent_value = Math.ceil((ev.loaded / ev.total) * 100);
                        }
                    }, false);

                    xhr.addEventListener('readystatechange', function (e) {
                        if (this.readyState === 4) {
                            var rewrite_filename = filename.split(' ');
                            rewrite_filename = rewrite_filename.join('_');
                            preview_new.src = 'assets/Uploads/' + upload_folder + '/' + rewrite_filename;
                            preview_new.play();
                            preview_new.muted = false;

                            $('#save_btn').attr('data-save_type', 'video');
                            $('#preview_new').attr('data-old_file', rewrite_filename);
                            $('#preview_new').attr('data-file_folder', upload_folder);

                            $scope.sectionsHideShow(true, false);
                            $scope.buttonsHideShow(true, true, true, false, false);
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

            document.updateCompanyUrl = function () {
                var company_url = $.trim($('#company_url').val());
                if (!company_url) return false;
                var formData = {
                    data: {
                        company_url: company_url
                    }
                };

                $http(GlobalConstant.EmployerRootApi + '/company/change-profile-url', formData)
                    .then(function (response) {
                        $scope.company_url = company_url;
                        $('#company_url').val("");
                    }, function (response) {
                        //Error Condition
                        // //console.log(response);
                        alert('Company url is already taken. Try another one!');
                    });
            }

            document.cancelCompanyUrl = function () {
                $('#company_url').val("");
            }
        }
    ]);
}());

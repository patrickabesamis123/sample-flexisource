(function () {
    'use strict';

    var app = angular.module('app');
    var base_url = $('body').data('base_url');

    app.controller('EmployerSettings', ['GlobalConstant', 'fileUploadService', '$scope', '$cookies', '$window', '$http', '$filter', '$timeout', '$location', 'OAuth', 'OAuthToken', '$rootScope', '$modal', '$log',
        function (GlobalConstant, fileUploadService, $scope, $cookies, $window, $http, $filter, $timeout, $location, OAuth, OAuthToken, $rootScope, $modal, $log) {
            $scope.params = {
                'access_token': $cookies.get('token')
            }
            var TokenData = OAuthToken.getToken();

            $scope.TeamAdminPermission = false
            $scope.TeamAdmins = [];
            $scope.TeamMembers = []

            $scope.token = $cookies.get('api_token');

            if ($scope.token != '') {
                var headerData = {
                    headers: {
                        'Authorization': 'Bearer ' + $scope.token
                    }
                };

                $http.get(window.location.origin + '/api/user-auth-data', headerData).then(response => {
                    if (response.status === 200) {
                        var user_data = response.data.data;
                        if (user_data.length > 0) {
                            let user_id = user_data[0].id;
                            let user_type = user_data[0].user_type;

                            $scope.user_id = user_id;

                            if (user_type === 'employer') {

                                let employer_id = user_data[0].employer.id;
                                let company_id = user_data[0].employer.company.id;

                                $scope.employer_id = employer_id;
                                $scope.company_id = company_id;

                                // Get employer data
                                $http.get(window.location.origin + '/api/employer/settings/' + employer_id).then(response => {
                                    if (response.status === 200) {
                                        var employer_data = response.data;

                                        if (employer_data.length > 0) {

                                            // Set Permission to TRUE if the logged in user is Company Admin
                                            $scope.TeamAdminPermission = (employer_data[0].account_type.id === 5) ? true : false;

                                            switch (employer_data[0].account_type.id) {
                                                case 5:
                                                    $scope.account_type_string = 'Company Admin';
                                                    break;
                                                case 6:
                                                    $scope.account_type_string = 'Company Member';
                                                    break;
                                                default:
                                                    $scope.account_type_string = 'Company Job Manager';
                                            }

                                            $scope.id = employer_data[0].id;
                                            $scope.first_name = employer_data[0].user.first_name;
                                            $scope.last_name = employer_data[0].user.last_name;
                                            $scope.email = employer_data[0].user.email;

                                            $scope.company = {
                                                id: employer_data[0].company.id,
                                                company_name: employer_data[0].company.company_name,
                                                status: employer_data[0].company.status,
                                                num_of_employees: employer_data[0].company.num_of_employees,
                                                logo_url: employer_data[0].company.logo_url,
                                                website_url: employer_data[0].company.website_url,
                                                company_phone: employer_data[0].company.company_phone,
                                                company_fax: employer_data[0].company.company_fax,
                                                industry: {
                                                    data: {
                                                        industry: {
                                                            id: employer_data[0].company.industry.id,
                                                            display_name: employer_data[0].company.industry.display_name
                                                        }
                                                    }
                                                },
                                                street_address: employer_data[0].company.street_address,
                                                street_address_2: employer_data[0].company.street_address_2,
                                                location: {
                                                    data: {
                                                        location: {
                                                            id: employer_data[0].company.location.id,
                                                            display_name: employer_data[0].company.location.display_name,
                                                            slug_name: employer_data[0].company.location.slug_name,
                                                            type: employer_data[0].company.location.type,
                                                            country: {
                                                                id: (employer_data[0].company.location.country.count > 0) ? employer_data[0].company.location.country[0].id : '',
                                                                display_name: (employer_data[0].company.location.country.count > 0) ? employer_data[0].company.location.country[0].display_name : '',
                                                                short_name: (employer_data[0].company.location.country.count > 0) ? employer_data[0].company.location.country[0].codeDisplayName : ''
                                                            }
                                                        }
                                                    }
                                                },
                                                nz_business_num: employer_data[0].company.nz_business_num,
                                                company_url: employer_data[0].company.company_url,
                                                company_banner_url: employer_data[0].company.company_banner_url,
                                                company_description: employer_data[0].company.company_description,
                                                company_video: {
                                                    doc_file_type: (employer_data[0].company.hasOwnProperty('docs')) ? (employer_data[0].company.docs != null) ? employer_data[0].company.docs.doc_file_type : '' : '',
                                                    doc_url: (employer_data[0].company.hasOwnProperty('docs')) ? (employer_data[0].company.docs != null) ? employer_data[0].company.docs.doc_url : '' : '',
                                                    doc_filename: (employer_data[0].company.hasOwnProperty('docs')) ? (employer_data[0].company.docs != null) ? employer_data[0].company.docs.doc_filename : '' : ''
                                                }
                                            };

                                            $scope.nickname = employer_data[0].nickname;
                                            $scope.phone_number = employer_data[0].phone_number;
                                            $scope.phone_extension = employer_data[0].phone_extension;
                                            $scope.mobile_number = employer_data[0].mobile_number;
                                            $scope.work_title = employer_data[0].work_title;
                                            $scope.work_dept = employer_data[0].work_dept;
                                            $scope.profile_picture_url = employer_data[0].profile_picture_url;
                                            $scope.azure_container_key = employer_data[0].company.ob_key + '/' + employer_data[0].user.ob_key;

                                            $scope.initial = $scope.first_name.substr(0, 1) + $scope.last_name.substr(0, 1);
                                            $scope.profile_defualtphoto_color = color_bg_initial_set[Math.floor(Math.random() * color_bg_initial_set.length)];

                                        }

                                    }
                                }, (response) => {
                                    if (response.status === 500) {
                                        console.log('Server Error');
                                    }
                                });

                                // Get All Team Members
                                $http.get(window.location.origin + '/api/company/employers/' + company_id).then(response => {
                                    if (response.status === 200) {
                                        if (response.data.length > 0) {
                                            if (response.data[0].hasOwnProperty('employers')) {
                                                if (response.data[0].employers.length > 0) {

                                                    var company_data = response.data[0];
                                                    var employers_data = response.data[0].employers;
                                                    let employers = [];
                                                    var acct_type = '';

                                                    employers_data.forEach(edata => {

                                                        switch (edata.account_type.id) {
                                                            case 5:
                                                                acct_type = 'Company Admin';
                                                                break;
                                                            case 6:
                                                                acct_type = 'Company Member';
                                                                break;
                                                            default:
                                                                acct_type = 'Company Job Manager';
                                                        }

                                                        employers.push({
                                                            account_type_string: acct_type,
                                                            id: edata.id,
                                                            first_name: edata.user.first_name,
                                                            last_name: edata.user.last_name,
                                                            email: edata.user.email,
                                                            nickname: edata.nickname,
                                                            phone_number: edata.phone_number,
                                                            phone_extension: edata.phone_extension,
                                                            mobile_number: edata.mobile_number,
                                                            work_title: edata.work_title,
                                                            work_dept: edata.work_dept,
                                                            profile_picture_url: edata.profile_picture_url,
                                                            azure_container_key: company_data.ob_key + '/' + edata.user.ob_key
                                                        });
                                                    });

                                                    $scope.GetMembers = employers;

                                                    angular.forEach($scope.GetMembers, (val, key) => {
                                                        if (val.account_type_string === 'Company Member') {
                                                            $scope.TeamMembers.push(val)
                                                        } else if (val.account_type_string === 'Company Admin') {
                                                            $scope.TeamAdmins.push(val)
                                                        }
                                                    });

                                                    function profile_color(list) {
                                                        // Add initial to be used in default image
                                                        var b = 1;
                                                        for (var i = 0; i < list.length; i++) {
                                                            if (b >= 6) {
                                                                b = 1;
                                                            }
                                                            list[i].full_name = list[i].first_name + " " + list[i].last_name;
                                                            $scope.F_initial = list[i].first_name;
                                                            $scope.F_initial = $scope.F_initial.substr(0, 1);

                                                            $scope.L_initial = list[i].last_name;
                                                            $scope.L_initial = $scope.L_initial.substr(0, 1);

                                                            list[i].initial = $scope.F_initial + $scope.L_initial;

                                                            // change default photo's background color
                                                            if (!list[i].profile_picture_url) {
                                                                if (b == 1) {
                                                                    list[i].profile_color = "member-initials--sky";
                                                                } else if (b == 2) {
                                                                    list[i].profile_color = "member-initials--pvm-purple";
                                                                } else if (b == 3) {
                                                                    list[i].profile_color = "member-initials--pvm-green";
                                                                } else if (b == 4) {
                                                                    list[i].profile_color = "member-initials--pvm-red";
                                                                } else if (b == 5) {
                                                                    list[i].profile_color = "member-initials--pvm-yellow";
                                                                }
                                                                b++;
                                                            }
                                                        }
                                                    }

                                                    profile_color($scope.TeamAdmins);
                                                    profile_color($scope.TeamMembers);

                                                }
                                            }
                                        }
                                    }
                                }, (response) => {
                                    $scope.requirements_mgs = false;
                                    $scope.ErrorMsgs = response.data.errors;
                                });

                            }

                        }
                    }
                }, (response) => {
                    if (response.status === 401) {
                        // $http.get( GlobalConstant.APIRoot + 'employer/profile' ) // Uncomment for live API call
                        $http.get(window.location.origin + '/js/minified/test-data/test_employer_setting_data.json').then(response => {
                            var data = response.data.data;

                            angular.forEach(data, (v, k) => {
                                $scope[k] = v;
                            });
                            // PLFE-135 BEGIN
                            $scope.initial = $scope.first_name.substr(0, 1) + $scope.last_name.substr(0, 1);
                            $scope.profile_defualtphoto_color = color_bg_initial_set[Math.floor(Math.random() * color_bg_initial_set.length)];
                            // PLFE-135 END
                        });

                        //Get Permission
                        $http.get(window.location.origin + '/js/minified/test-data/test_employer_setting_permission_data.json').then(function (response) {
                            // console.log(response.data.data)
                            $scope.TeamAdminPermission = response.data.data.modify_company_member_account_type;
                        }, function (response) {});

                        //Get All Team members
                        $http.get(window.location.origin + '/js/minified/test-data/test_members_data.json')
                            .then(function (response) {
                                $scope.GetMembers = response.data.data;
                                //console.log ( $scope.GetMembers )
                                angular.forEach($scope.GetMembers, function (val, key) {
                                    if (val.account_type_string == 'Company Member') {
                                        $scope.TeamMembers.push(val)
                                    } else if (val.account_type_string == 'Company Admin') {
                                        $scope.TeamAdmins.push(val)
                                    }
                                });

                                function profile_color(list) {
                                    // Add initial to be used in default image
                                    var b = 1;
                                    for (var i = 0; i < list.length; i++) {
                                        if (b >= 6) {
                                            b = 1;
                                        }
                                        list[i].full_name = list[i].first_name + " " + list[i].last_name;
                                        $scope.F_initial = list[i].first_name;
                                        $scope.F_initial = $scope.F_initial.substr(0, 1);

                                        $scope.L_initial = list[i].last_name;
                                        $scope.L_initial = $scope.L_initial.substr(0, 1);

                                        list[i].initial = $scope.F_initial + $scope.L_initial;

                                        // change default photo's background color
                                        if (!list[i].profile_picture_url) {
                                            if (b == 1) {
                                                list[i].profile_color = "member-initials--sky";
                                            } else if (b == 2) {
                                                list[i].profile_color = "member-initials--pvm-purple";
                                            } else if (b == 3) {
                                                list[i].profile_color = "member-initials--pvm-green";
                                            } else if (b == 4) {
                                                list[i].profile_color = "member-initials--pvm-red";
                                            } else if (b == 5) {
                                                list[i].profile_color = "member-initials--pvm-yellow";
                                            }
                                            b++;
                                        }
                                    }
                                }

                                profile_color($scope.TeamAdmins);
                                profile_color($scope.TeamMembers);
                            }, function (response) {
                                $scope.requirements_mgs = false;
                                $scope.ErrorMsgs = response.data.errors;
                            });


                    }
                });
            }

            $scope.contentloader = true;
            $scope.base_url = base_url;
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

            // $scope.crop_data = {w : 150, h: 150, x : 116, y : 41};
            $scope.crop_data = {
                w: 240,
                h: 240,
                x: 80,
                y: 0
            };

            // PLFE-135 BEGIN
            // random color set
            var color_bg_initial_set = [
                "member-initials--sky",
                "member-initials--pvm-purple",
                "member-initials--pvm-green",
                "member-initials--pvm-red",
                "member-initials--pvm-yellow"
            ];
            var F_initial, L_initial;
            // PLFE-135 END

            $scope.preload = true;
            $scope.referrer = null;

            //Relogin function
            $scope.validatelogin = function () {
                $scope.preload = false;
                $scope.data = {
                    username: $scope.emailfield,
                    password: $scope.pass
                }

                var login = OAuth.getAccessToken($scope.data, {
                    method: 'GET'
                })
                login.then(function (result) {
                    $scope.validated = true;
                    $scope.preload = true;
                    $scope.access_token = result.data;
                    //Check user type
                    $http.get(GlobalConstant.CheckUserType1)
                        .then(function (response) {
                            var userType = response.data.data;
                            OAuthToken.setToken($scope.access_token);
                            var token_data = OAuthToken.getToken();
                            //For Old Login data
                            var expire = parseInt(token_data.expires_in);
                            // var expire = parseInt ( OAuthToken.getToken().expires_in )  - 3500;
                            var SetDateforLogin = new Date();
                            var LoginTime = parseInt(SetDateforLogin.getTime() / 1000);
                            var ExpireTime = parseInt(SetDateforLogin.getTime() / 1000) + expire;
                            var ExpireTimetoDate = new Date(ExpireTime * 1000);
                            //Store all data needed to cookies
                            $cookies.put('token', token_data.access_token, {
                                'path': '/'
                            });
                            $cookies.put('LoginTime', LoginTime, {
                                'path': '/'
                            });
                            // $cookies.put('IdleTime', ExpireTime, {'path':'/' } );
                            $cookies.put('exp', expire, {
                                'path': '/'
                            });
                            //need for refresher

                            $cookies.put('email', $scope.emailfield, {
                                'path': '/'
                            });
                            if (userType == 'employer') {
                                //Store user type cookie
                                $cookies.put('ut', userType, {
                                    'path': '/'
                                });

                                $.ajax({
                                    url: GlobalConstant.tokenstorage,
                                    type: 'post',
                                    data: {
                                        token_refresh: token_data.refresh_token,
                                        token_access: token_data.access_token,
                                        username: $scope.emailfield
                                    },
                                    success: function (token_id) {
                                        $cookies.put('token_id', token_id, {
                                            'path': '/'
                                        });
                                    }
                                }).done(function () {
                                    $scope.preload = true;
                                });
                            }
                        });
                    //Trigger form function
                    switch ($scope.referrer) {
                        case 'changePassword':
                            $scope.changePassword();
                            break;
                        case 'updateProfile':
                            $scope.updateProfile();
                            break;
                        case 'changeEmail':
                            $scope.changeEmail()
                        default:
                    }
                    return true
                }, function (response) {
                    $scope.preload = true;
                    alert('You are trying to edit an account that is not yours!!! you will now been logged out')
                    $.ajax({
                        url: GlobalConstant.logoutPage,
                        type: 'get',
                        'success': function (data) {
                            if (data == 200) {
                                $window.location.href = base_url;
                            }
                        }
                    });
                })
            }

            //Open modal and validate fields
            $scope.OpenSecurityModal = function (referrer) {
                $scope.referrer = referrer
                switch ($scope.referrer) {
                    case 'changePassword':
                        $('#changePassordForm').serializeArray().map(function (item) {
                            items[item.name] = item.value;
                        });

                        if (items.password != items.confirm_password) {
                            $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                            $('#changePassordForm').prev().addClass('pvm-red').html('Password and confirm password not match!').fadeIn();
                            return false;
                        } else {
                            angular.element($('#Securitymodal')).modal('show')
                        }
                        break;
                    case 'changeEmail':
                        $('#changeEmailForm').serializeArray().map(function (item) {
                            items[item.name] = item.value;
                        });
                        if (items.email != items.email_confirm) {
                            $('#changeEmailForm').prev().removeClass('pvm-red pvm-green');
                            $('#changeEmailForm').prev().addClass('pvm-red').html('Email and confirm email not match!').fadeIn();
                            return false;
                        } else {
                            angular.element($('#Securitymodal')).modal('show')
                        }
                    default:
                        angular.element($('#Securitymodal')).modal('show')
                }
            }

            $scope.$watch('profile_picture_url', function (newVal, oldVal) {
                var formData = {
                    "data": {
                        "logo_url": newVal
                    }
                };

                $http.put(GlobalConstant.APIRoot + 'employer/profile', formData).then(function (response) {
                    console.log('profile photo emp ', response);
                }, function (response) {
                })
            });

            // Update Employers Basic Information
            $scope.updateProfile = () => {
                var formData = {
                    "first_name": $scope.first_name,
                    "last_name": $scope.last_name,
                    "nickname": $scope.nickname,
                    "phone_number": $scope.phone_number,
                    "mobile_number": $scope.mobile_number,
                    "work_title": $scope.work_title,
                    "work_dept": $scope.work_dept
                }

                var employer_id = $scope.employer_id;

                $http({
                        method: "POST",
                        url: window.location.origin + '/api/employer/change-basic-info/' + employer_id,
                        data: formData
                    })
                    .then(response => {
                        if (response.status === 200) {
                            $('#employer_setting_msg').text('Updated.').addClass('pvm-green').css('display', 'block');
                            angular.element($('#dismissSecurity')).trigger('click');
                        }
                    }, response => {
                        if (response.status === 400) {
                            $('#employer_setting_msg').text('Error Updating').addClass('pvm-red').css('display', 'block');
                        }
                    })
            }

            // Update Email Address
            var email_items = {}
            $scope.changeEmail = () => {
                $('#changeEmailForm').serializeArray().map(item => {
                    email_items[item.name] = item.value;
                });

                if (email_items.email === email_items.email_confirm) {
                    var csrf_token = $('meta[name=csrf-token]').attr('content');
                    var employer_id = $scope.employer_id;

                    // $http.post(GlobalConstant.APIRoot + 'change-email', email_items)
                    $http({
                        method: 'POST',
                        url: window.location.origin + '/api/employer/change-email-address/' + employer_id,
                        data: email_items
                    }).then(response => {
                        angular.element($('#dismissSecurity')).trigger('click')
                        $('#changeEmailForm').prev().removeClass('pvm-red pvm-green');
                        $('#changeEmailForm').prev().addClass('pvm-green').html('Email updated.').fadeIn();
                        $('#changeEmailForm').find('input').not(':submit').val("");
                        $scope.email = email_items.email;
                        $cookies.put('email', $scope.email, {
                            'path': '/'
                        });
                    }, response => {
                        if (response.status === 409) {
                            $('#changeEmailForm').prev().addClass('pvm-red').html(response.data.message).fadeIn();
                        }
                    })

                } else {
                    angular.element($('#dismissSecurity')).trigger('click')
                    $('#changeEmailForm').prev().removeClass('pvm-red pvm-green');
                    $('#changeEmailForm').prev().addClass('pvm-red').html('Email and confirm email not match!').fadeIn();
                }
            }

            // Update Password
            var items = {}
            $scope.changePassword = () => {
                $('#changePassordForm').serializeArray().map(item => {
                    items[item.name] = item.value;
                });

                if (items.password === items.confirm_password) {

                    if (items.current_password === items.password) {
                        $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                        $('#changePassordForm').prev().addClass('pvm-red').html('The Current Password is the same with the New Password').fadeIn();

                        return false;
                    }

                    let employer_id = $scope.employer_id;
                    let user_id = $scope.user_id;

                    var data = {
                        user_id: user_id,
                        current_password: items.current_password,
                        password: items.password
                    }

                    $http({
                        method: 'POST',
                        url: window.location.origin + '/api/employer/change-password/' + employer_id,
                        data: data
                    }).then(response => {
                        if (response.status === 200) {
                            angular.element($('#dismissSecurity')).trigger('click')
                            $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                            $('#changePassordForm').prev().addClass('pvm-green').html('Password updated.').fadeIn();
                            $('#changePassordForm').find('input').not(':submit').val("");
                        }
                    }, response => {
                        if (response.status === 409) {
                            $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                            $('#changePassordForm').prev().addClass('pvm-red').html('Current Password does not match!').fadeIn();
                        }
                    });
                    return false;
                }

                $('#changePassordForm').prev().removeClass('pvm-red pvm-green');
                $('#changePassordForm').prev().addClass('pvm-red').html('Password and confirm password not match!').fadeIn();
            }

            document.cancelSettings = function (obj) {
                $(obj).parents('form').find('input').not(':submit').val("")
                $(obj).parents('form').prev('#msg').html("").css('display', 'none');
            }

            document.cancelSettings2 = function (obj) {
                $('#employer_setting_msg').html("").css('display', 'none');
            }

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

            /* Image Uploading and Capture */
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
                // //console.log(c);
                $scope.crop_data = c;
            }

            $scope.save_photo = function () {
                $scope.url_type = 'profile_picture_url';
                fileUploadService.save_photo($scope);
            }

            $scope.new_image_upload_modal = function (evt) {

                var fileField = document.getElementById("image_upload_modal_new");
                var file_data = fileField.files[0];
                // drag drop
                if (evt) {
                    file_data = evt.dataTransfer.files[0];
                }

                // delete old file if exists
                if ($('#image_save').attr('data-filename')) {
                    var filename = $('#image_save').attr('data-filename');
                    var folder = $('#image_save').attr('data-folder');
                    $scope.delete_old_file(filename, folder);
                }

                var allowed_files = ['png', 'jpg', 'gif'];
                var filename = file_data.name;
                var last_dot = filename.lastIndexOf('.');
                var file_folder = 'image';
                var ext = filename.substr(last_dot + 1).toLowerCase();
                if (allowed_files.indexOf(ext) == -1) {
                    alert('Invalid file must be .png, jpg. .gif extension');
                    return false;
                }
                var ob_key = $scope.azure_container_key;
                var form_data = new FormData();
                form_data.append('file', file_data);
                var params = '?ob_key=' + ob_key + '&file_folder=' + file_folder;
                $scope.modal_file_percent_value = 0;

                $.ajax({
                    // url: GlobalConstant.EmployerController + '/upload_image_submit' + params,
                    url: GlobalConstant.FileUploadUrl + '/upload_submit' + params,
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (res) {
                        res = JSON.parse(res);
                        //console.log(res);
                        if (res.response == 200) {

                            fileField.value = '';
                            // hide percent image
                            $scope.modal_percent = true;

                            $('#preview_img_new').attr('poster', 'assets/Uploads/Image/' + res.filename)
                            $('#preview_img_new').attr('data-old_file', res.filename);
                            $('#preview_img_new').attr('data-file_folder', 'image');

                            $scope.sectionsHideShow(true, false);
                            $scope.buttonsHideShow(true, true, true, false, false);

                            $('#preview_img_new').Jcrop({
                                aspectRatio: 1 / 1,
                                setSelected: [20, 20, 250, 220],
                                onChange: selectAreaToCrop,
                                minSize: [150, 150]
                            });

                            $('#preview_img_newRE').Jcrop({
                                aspectRatio: 1 / 1,
                                setSelected: [20, 20, 250, 220],
                                onChange: selectAreaToCrop,
                                minSize: [150, 150]
                            });
                        }
                    },
                    beforeSend: function () {
                        $scope.modal_percent_value = 0;
                        // show percent image
                        $scope.modal_percent = false;
                    },
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                $scope.modal_percent_value = Math.ceil((evt.loaded / evt.total) * 100);
                            }
                        }, false);

                        return xhr;
                    },
                });
            }

            $('#image_upload_modal_new').change(function () {
                $scope.new_image_upload_modal();
            });

            document.dropImageModalNew = function (ev) {
                ev.preventDefault();
                $scope.new_image_upload_modal(ev);
            }
            $scope.selectedmember = [];

            $scope.savechanges = false
            $scope.successsavechanges = false

            $scope.functiontofindIndexByKeyValue = function (arraytosearch, key, valuetosearch) {
                for (var i = 0; i < arraytosearch.length; i++) {
                    if (arraytosearch[i][key] == valuetosearch) {
                        return i + 1;
                    }
                }
                return null;
            }

            $scope.$watchCollection('selectedmember', function (newVal, oldVal) {
                if (newVal.length != 0) {
                    angular.element($('#SubmitMemberAsAdmin')).removeAttr('disabled');
                    $scope.savechanges = true;
                    $scope.searchmember = "";
                    angular.forEach(newVal, function (val, key) {
                        var index = $scope.functiontofindIndexByKeyValue($scope.TeamAdmins, 'id', val.id);

                        if (index == null) {
                            $scope.TeamAdmins.push(val);
                        } else {
                            $scope.TeamAdmins.splice(index)
                        }
                    });

                } else {
                    angular.element($('#SubmitMemberAsAdmin')).attr('disabled', 'disabled');

                    $scope.savechanges = false
                    angular.forEach($scope.TeamAdmins, function (val, key) {
                        if (val.account_type_string != "Company Admin") {
                            $scope.TeamAdmins.splice(key)
                        }
                    });
                }
            })

            $scope.showInviteModal = function () {
                var modalInstance = $modal.open({
                    templateUrl: 'inviteMember',
                    controller: 'MemberModalInstanceCtrl',
                    resolve: {
                        data: function () {
                            return $scope.data;
                        }
                    }
                });

                //Process Modal Result
                modalInstance.result.then(function (data) {
                    $scope.user = data;

                    if ($scope.user != null) {
                        $scope.TeamMembers.push($scope.user);
                    }
                }, function () {
                    $log.info('Modal dismissed at: ' + new Date());
                });
                //$('#InviteTeamMember').modal('show');
            }

            // Remove Team Member
            $scope.RemoveTeamMember = (id, member_type) => {
                var company_id = $scope.company_id;
                if (member_type === 'Company Member') {
                    var index = $scope.selectedmember.indexOf(id)
                    $scope.selectedmember.splice(index, 1)
                } else if (member_type === 'Company Admin') {
                    var r = confirm("You are about to remove this member as admin. You want to continue?");
                    if (r) {
                        let data = {
                            account_type: 6
                        }; // Sets to Company Member
                        // $http.put(GlobalConstant.APIRoot + 'employer/company/member/' + id + '/member')
                        $http.put(window.location.origin + '/api/employer/change-account-type/' + id, data)
                            .then(response => {
                                $scope.TeamMembers = [];
                                $scope.TeamAdmins = [];

                                // Get All Team Members
                                $http.get(window.location.origin + '/api/company/employers/' + company_id).then(response => {
                                    if (response.status === 200) {
                                        if (response.data.length > 0) {
                                            if (response.data[0].hasOwnProperty('employers')) {
                                                if (response.data[0].employers.length > 0) {

                                                    var company_data = response.data[0];
                                                    var employers_data = response.data[0].employers;
                                                    let employers = [];
                                                    var acct_type = '';

                                                    employers_data.forEach(edata => {

                                                        switch (edata.account_type.id) {
                                                            case 5:
                                                                acct_type = 'Company Admin';
                                                                break;
                                                            case 6:
                                                                acct_type = 'Company Member';
                                                                break;
                                                            default:
                                                                acct_type = 'Company Job Manager';
                                                        }

                                                        employers.push({
                                                            account_type_string: acct_type,
                                                            id: edata.id,
                                                            first_name: edata.user.first_name,
                                                            last_name: edata.user.last_name,
                                                            email: edata.user.email,
                                                            nickname: edata.nickname,
                                                            phone_number: edata.phone_number,
                                                            phone_extension: edata.phone_extension,
                                                            mobile_number: edata.mobile_number,
                                                            work_title: edata.work_title,
                                                            work_dept: edata.work_dept,
                                                            profile_picture_url: edata.profile_picture_url,
                                                            azure_container_key: company_data.ob_key + '/' + edata.user.ob_key
                                                        });
                                                    });

                                                    $scope.GetMembers = employers;

                                                    angular.forEach($scope.GetMembers, (val, key) => {
                                                        if (val.account_type_string == 'Company Member') {
                                                            $scope.TeamMembers.push(val)
                                                        } else if (val.account_type_string == 'Company Admin') {
                                                            $scope.TeamAdmins.push(val)
                                                        }
                                                    });

                                                    function profile_color(list) {
                                                        // Add initial to be used in default image
                                                        var b = 1;
                                                        for (var i = 0; i < list.length; i++) {
                                                            if (b >= 6) {
                                                                b = 1;
                                                            }
                                                            list[i].full_name = list[i].first_name + " " + list[i].last_name;
                                                            $scope.F_initial = list[i].first_name;
                                                            $scope.F_initial = $scope.F_initial.substr(0, 1);

                                                            $scope.L_initial = list[i].last_name;
                                                            $scope.L_initial = $scope.L_initial.substr(0, 1);

                                                            list[i].initial = $scope.F_initial + $scope.L_initial;

                                                            // change default photo's background color
                                                            if (!list[i].profile_picture_url) {
                                                                if (b == 1) {
                                                                    list[i].profile_color = "member-initials--sky";
                                                                } else if (b == 2) {
                                                                    list[i].profile_color = "member-initials--pvm-purple";
                                                                } else if (b == 3) {
                                                                    list[i].profile_color = "member-initials--pvm-green";
                                                                } else if (b == 4) {
                                                                    list[i].profile_color = "member-initials--pvm-red";
                                                                } else if (b == 5) {
                                                                    list[i].profile_color = "member-initials--pvm-yellow";
                                                                }
                                                                b++;
                                                            }
                                                        }
                                                    }

                                                    profile_color($scope.TeamAdmins);
                                                    profile_color($scope.TeamMembers);

                                                }
                                            }
                                        }
                                    }
                                }, (response) => {
                                    $scope.requirements_mgs = false;
                                    $scope.ErrorMsgs = response.data.errors;
                                });
                            }, (response) => {
                                //console.log(response)
                            });

                        var index = $scope.functiontofindIndexByKeyValue($scope.TeamAdmins, 'id', id)
                        $scope.TeamAdmins.splice(index - 1, 1)
                    }
                    return false;
                }
            }

            // Add Member As Admin
            $scope.SubmitMemberAsAdmin = () => {
                $scope.data = [];
                let data = {
                    account_type: 5
                };
                angular.forEach($scope.selectedmember, (val, key) => {
                    $scope.data.push(val.id);
                    $http.put(window.location.origin + '/api/employer/change-account-type/' + val.id, data)
                        .then((response) => {
                            $scope.savechanges = false
                            $scope.successsavechanges = true
                        }, (response) => {});
                });
            }

            // Cancel Member as Admin
            $scope.CancelMemberAsAdmin = () => {
                $scope.selectedmember = []
            }

            // Disable Employers Account
            $scope.disableAccount = () => {
                var employer_id = $scope.employer_id;
                var token = $scope.token;

                // $http.post( GlobalConstant.APIRoot+'disable'  )
                $http.put(window.location.origin + '/api/employer/change-account-status/' + employer_id)
                    .then(response => {
                        if (response.status === 200) {
                            alert('Account is disabled.');
                            $.ajax({
                                url: window.location.origin + '/api/logout',
                                headers: {
                                    'Authorization': 'Bearer ' + token
                                },
                                data: {
                                    token: token
                                },
                                method: 'GET',
                                success: (response) => {
                                    if (response.success) {
                                        $window.location.href = window.location.origin + '/login';
                                    }
                                },
                            });
                        }
                    });
            }


        }
    ]);

    app.controller('MemberModalInstanceCtrl', ['GlobalConstant', '$scope', '$cookies', '$http', '$modalInstance', '$location', 'data', 'OAuth', 'OAuthToken', '$rootScope',
        function (GlobalConstant, $scope, $cookies, $http, $modalInstance, $location, data, OAuth, OAuthToken, $rootScope) {
            $scope.user = {
                first_name: '',
                last_name: '',
                email: '',
                account_type: 6
            };

            var TokenData = OAuthToken.getToken();
            $scope.submitting = false;
            $scope.query_str = $location.search();

            function reassignData() {
                angular.forEach($scope.query_str, function (v, k) {
                    $location.search(k, v)
                });
            }

            $scope.ok = function () {
                $scope.submitting = true;
                //Submit invite for member
                $http.post(GlobalConstant.EmployerRegisterMember, {
                        data: $scope.user
                    })
                    .then(function (response) {
                        $scope.submitting = false;
                        if (response.data.data != null) {
                            reassignData();
                            $modalInstance.close(response.data.data);
                            //PLFE-105 start
                            $scope.TeamMembers = [];
                            $scope.TeamMembers.push(response.data.data);

                            // Add initial to be used in default image
                            var b = 1;
                            for (var i = 0; i < $scope.TeamMembers.length; i++) {
                                $scope.TeamMembers[i].full_name = "";
                                $scope.TeamMembers[i].profile_color = "";
                                if (b >= 6) {
                                    b = 1;
                                }
                                $scope.TeamMembers[i].full_name = $scope.TeamMembers[i].first_name + " " + $scope.TeamMembers[i].last_name;
                                $scope.F_initial = $scope.TeamMembers[i].first_name;
                                $scope.F_initial = $scope.F_initial.substr(0, 1);

                                $scope.L_initial = $scope.TeamMembers[i].last_name;
                                $scope.L_initial = $scope.L_initial.substr(0, 1);

                                $scope.TeamMembers[i].initial = $scope.F_initial + $scope.L_initial;

                                // change default photo's background color

                                if (!$scope.TeamMembers[i].profile_picture_url) {
                                    if (b == 1) {
                                        $scope.TeamMembers[i].profile_color = "member-initials--sky";
                                    } else if (b == 2) {
                                        $scope.TeamMembers[i].profile_color = "member-initials--pvm-purple";
                                    } else if (b == 3) {
                                        $scope.TeamMembers[i].profile_color = "member-initials--pvm-green";
                                    } else if (b == 4) {
                                        $scope.TeamMembers[i].profile_color = "member-initials--pvm-red";
                                    } else if (b == 5) {
                                        $scope.TeamMembers[i].profile_color = "member-initials--pvm-yellow";
                                    }
                                    b++;
                                }
                            }
                            //PLFE-105 end
                        } else {
                            reassignData();
                            $modalInstance.close(response.data.errors);
                        }
                    }, function (response) {
                        $scope.submitting = false;
                        alert('some error');
                    });
            };

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
                reassignData()
            };
        }
    ]);

}());


$(document).ready(function () {
    function MemberDropdowFilter(field_element, display_element) {
        $(field_element).focusin(function () {

            $(this).keypress(function () {
                if ($(display_element).is(":hidden")) {
                    $(display_element).slideToggle("slow");
                }
            })

        });

        $(field_element).focusout(function () {
            setTimeout(function () {
                $(display_element).slideToggle("slow");
            }, 1000);
        });
    }
    MemberDropdowFilter('#SearchMemberField', '#SearchMember');
});